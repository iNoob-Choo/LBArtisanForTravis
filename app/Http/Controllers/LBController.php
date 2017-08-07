<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\APIKEY;
use Auth;
use App\LB;
use App\FrontendServer;
use Session;


class LBController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $id = Auth::user()->id;
      $lbs =LB::where('user_id','LIKE',$id)->get();
      return view('lb.index')->withLbs($lbs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $api_key = $this->getAPIKEY();
      if($api_key==null){
        Session::flash('info','You need to have an API KEY first!');
        return redirect()->route('user.dashboard');
      }
      $locations = $this->getDataCenterIDList($api_key);
      return view('lb.create')->withLocations($locations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //fixed image id to be distributed
      $image_id = "2151414";
      //validate
      $this->validate($request, array(
            'labelname'    => 'required',
            'providername' => 'required',
            'location'     => 'required',

          ));
      //create object based on LB model
      $lb = new LB;
      $lb->label_name = $request->labelname;
      $lb->provider   = $request->providername;
      $user_id = $request->user_id;
      $lb->user_id = $user_id;
      $api_key = $this->getAPIKEY();
      //location
      $location_id = $request->location;
      $location_array =$this->getDataCenterIDList($api_key);
      $location = $this->getSpecificLocation($location_id,$location_array);
      $lb->location=$location;
      $vm_id   = $this->createLB($api_key,$location_id);
      $lb->vm_id =$vm_id;
      $ip_address = $this->getPublicIP($api_key,$vm_id);
      $lb->ip_address = $ip_address;
      $lb->save();
      $boolean_created = $this->createLBWithImage($api_key,$image_id,$vm_id);
      $boolean_create_256 = $this->create256Disk($api_key,$vm_id);
      //check if the image is created
      if($boolean_created&& $boolean_create_256){
        Session::flash('success','Load Balancer is created!');
        return redirect()->route('LoadBalancers.index');
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $frontendservers = FrontendServer::where('lb_id','=',$id)->get();
      $lb_id = $id;
      return view('frontendserver.index')->withFrontendservers($frontendservers)->withLb_id($lb_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      // find the post in the database and save as a var
     $lb = LB::find($id);
     // return the view and pass in the var we previously created
     return view('lb.edit')->withLb($lb);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // Validate the data
      $this->validate($request, array(
              'labelname' => 'required',
          ));
      // Save the data to the database
      $lb = LB::find($id);
      $lb->label_name = $request->input('labelname');
      $lb->save();
      // set flash data with success message
      Session::flash('success','Load Balancer is updated!');
      // redirect with flash data to posts.show
      return redirect()->route('LoadBalancers.index', $lb->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $lb = LB::find($id);
      $api_key = $this->getAPIKEY();
      $boolean = $this->deleteLB($api_key,$lb->vm_id);
      $lb->delete();
      Session::flash('success_delete','Load Balancer is deleted!');
      return redirect()->route('LoadBalancers.index');
    }

    public function getDataCenterIDList($api_key)
    {
        $url = "https://api.linode.com/?api_key=$api_key&api_action=avail.datacenters";
        $obj=  $this->getJSONObject($url);
        $locations = $this->getLocations($obj);
        return $locations;
    }

    public function getLocations($locationObject)
    {
      $locations=[];
      for ($i=0; $i < count($locationObject['DATA']); $i++) {
          $locations[$i]=[
            'DatacenterID'=>$locationObject['DATA'][$i]['DATACENTERID'],
            'Location'    =>$locationObject['DATA'][$i]['LOCATION'],
          ];

      }
      return $locations;
    }

    public function getSpecificLocation($center_id,$location_array)
    {
      $location_string="";
      for ($i=0; $i < count($location_array); $i++) {
          if($location_array[$i]['DatacenterID']==$center_id){
            $location_string = $location_array[$i]['Location'];
          }

      }
      return $location_string;
    }


    public function createLB($api_key,$centerid)
    {
      $url =   $url = "https://api.linode.com/?api_key=$api_key&api_action=linode.create&DatacenterID=$centerid&PlanID=1";;
      $obj =  $this->getJSONObject($url);
      $vm_id = $obj['DATA']['LinodeID'];
      return $vm_id;
    }

    public function getPublicIP($api_key,$vm_id)
    {
      $url = "https://api.linode.com/?api_key=$api_key&api_action=linode.ip.list&LinodeID=$vm_id";

      $obj = $this->getJSONObject($url);
      $public_ip =$obj["DATA"][0]["IPADDRESS"];

      return $public_ip;
    }

    public function getDISKID($api_key,$vm_id)
    {
      $url = "https://api.linode.com/?api_key=$api_key&api_action=linode.disk.list&LinodeID=$vm_id";
      $disk_id = [];
      $obj = $this->getJSONObject($url);
        if(count($obj['DATA'])>0)
        {
          for ($i=0; $i <count($obj['DATA']) ; $i++)
          {
            $disk_id[$i] = $obj['DATA'][$i]['DISKID'];
          }
        }

      return $disk_id;
    }

    public function createConfig($api_key,$vm_id)
    {
      $disk_id_array=$this->getDISKID($api_key,$vm_id);
      $disk_id_string=$this->writeIDString($disk_id_array);
      $url = "https://api.linode.com/?api_key=$api_key".
      "&api_action=linode.config.create".
      "&LinodeID=$vm_id".
      "&KernelID=138".
      "&Label=FirstConfig".
      "&DiskList=$disk_id_string".
      "&RAMLimit=0";
      var_dump($disk_id_string);
      $obj=$this->getJSONObject($url);
      $config_id = $obj['DATA']['ConfigID'];
      return $config_id;
    }

    public function writeIDString($disk_id_array)
    {
      $disk_id_string="";
      for ($i=0; $i <count($disk_id_array) ; $i++) {
          $temp=$disk_id_string;
          $disk_id_string=$temp.$disk_id_array[$i].",";
      }
      return $disk_id_string;
    }

    public function deleteDisk($api_key,$disk_id,$vm_id)
    {
      //no disk inside
      if($disk_id==null){
        return true;
      }
      for ($i=0; $i <count($disk_id) ; $i++) {
        $disk = $disk_id[$i];
        $url_delete = "https://api.linode.com/?api_key=$api_key&api_action=linode.disk.delete&DiskID=$disk&LinodeID=$vm_id";
        $obj = $this->getJSONObject($url_delete);

      }
      return true;
    }

    public function deleteLB($api_key,$vm_id)
    {
      //to delete need to delete the disks first
      //step 1 : Getting the list of disks
        $disk_id = $this->getDISKID($api_key,$vm_id);
      //step 1.1 : Deleteing disks
        $bool_delete_disk = $this->deleteDisk($api_key,$disk_id,$vm_id);
      //Step 2 : Removing the LB
      if($bool_delete_disk){
        $url = "https://api.linode.com/?api_key=$api_key&api_action=linode.delete&LinodeID=$vm_id";
        $obj = $this ->getJSONObject($url);
        return true;
      }else {
        return false;
      }
    }

    public function getJSONObject($url)
    {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_URL,$url);
      $result = curl_exec($curl);
      $obj = json_decode($result,true);
      return $obj;
    }

    public function createLBWithImage($api_key,$image_id,$vm_id)
    {
      $url = "https://api.linode.com/?api_key=$api_key&api_action=linode.disk.createfromimage&ImageID=$image_id&LinodeID=$vm_id";
      $obj = $this ->getJSONObject($url);
      return true;
    }

    public function create256Disk($api_key,$vm_id)
    {
      $url = "https://api.linode.com/?api_key=$api_key&api_action=linode.disk.create".
      "&LinodeID=$vm_id".
      "&Label=256MB".
      "&Type=swap".
      "&Size=256";
      $obj =$this->getJSONObject($url);
      return true;
    }

    public function bootLB($lb_id)
    {

      $api_key = $this->getAPIKEY();
      $vm_id =$this->getVMID($lb_id);
      $config_id=$this->getConfigID($api_key,$vm_id);
      //config_id is null when is it first time booting up
      if($config_id==null){
        $config_id =$this->createConfig($api_key,$vm_id);
      }
      $url = "https://api.linode.com/?api_key=$api_key&api_action=linode.boot&ConfigID=$config_id&LinodeID=$vm_id";
      $obj = $this ->getJSONObject($url);
      Session::flash('success','Load Balancer is booted, please wait 2 minutes before deploying!');
      return redirect()->route('LoadBalancers.index');
    }

    public function shutDownLB($lb_id)
    {

      $api_key = $this->getAPIKEY();
      $vm_id=$this->getVMID($lb_id);
      $url = "https://api.linode.com/?api_key=$api_key&api_action=linode.shutdown&LinodeID=$vm_id";
      $obj = $this ->getJSONObject($url);
      Session::flash('success_delete','Load Balancer is shutting down!');
      return redirect()->route('LoadBalancers.index');
    }

    public function getAPIKEY()
    {
      $user_id = Auth::user()->id;
      $api_key_object = APIKEY::where('user_id',"=",$user_id)->first();
      if(count($api_key_object)==0){
        return null;
      }else{
        $api_key = $api_key_object ->API_key;
        return $api_key;
      }
    }

    public function getVMID($lb_id)
    {
      $lb_object = LB::where('id','=',$lb_id)->first();
      $vm_id=$lb_object['attributes']['vm_id'];
      return $vm_id;
    }

    public function getConfigID($api_key,$vm_id)
    {
      $url = "https://api.linode.com/?api_key=$api_key&api_action=linode.config.list&LinodeID=$vm_id";
      $obj = $this->getJSONObject($url);
      if(count($obj['DATA'])==0){
        return null;
      }else{
        $config_id =$obj['DATA'][0]['ConfigID'];
        return $config_id;
      }
    }



}
