<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BackendServer;
use App\FrontendServer;
use App\LB;
use Auth;
use Config;
use SSH;
use Session;

class SSHController extends Controller
{

    /**
     * This is to run the commands in the vm.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lb_id)
    {
      $user_id = Auth::user()->id;
      $lb_object = LB::where('id','=',$lb_id)->first();
      $public_ip = $lb_object['attributes']['ip_address'];
      $front_end_object = $this->getFrontendObject($user_id,$lb_id);
      if($front_end_object['PORT']==null || $front_end_object['ID']==null || $front_end_object['PROTOCOL']==null )
      {
        Session::flash('info','Front end details for '.$lb_object['attributes']['label_name'].' is not set up!');
        return redirect()->route('user.dashboard');
      }else
      {
        $front_end_port = $front_end_object['PORT'];
        $protocol = $front_end_object['PROTOCOL'];
        //haproxy is case sensitive, only lowercases is acceptable
        $protocol_lower=strtolower($protocol);
        $back_end_object = $this->getBackendObject($user_id,$front_end_object['ID']);
        if(count($back_end_object)==0)
        {
          Session::flash('info','Back end details for '.$lb_object['attributes']['label_name'].' is not set up!');
          return redirect()->route('user.dashboard');
        }else
        {
          $back_end_ip = $this->getBackendIPAddress($back_end_object);
          $back_end_port =$this->getBackendPort($back_end_object);
          $bool_write = $this->writeToFile($back_end_ip,$back_end_port,$front_end_port,$public_ip,$user_id,$protocol_lower);
          $bool_rename = $this ->rename_func($user_id);
          $file_to_upload =$_SERVER['DOCUMENT_ROOT'] ."\\download\\haproxy.cfg";
          Config::set('remote.connections.production.host', $public_ip);
          Config::set('remote.connections.production.username', 'root');
          Config::set('remote.connections.production.password', 'Ja1k310a1!21H');
          $remotepath="/etc/haproxy/haproxy.cfg";
          SSH::into('production')->put($file_to_upload,$remotepath);
          SSH::run([
          ' service haproxy start'
          ], function($line){echo $line.PHP_EOL;});
          if($bool_write)
          {
              unlink($_SERVER['DOCUMENT_ROOT'] ."\\download\\haproxy.cfg");
          }
          Session::flash('success','Load Balancer is deployed and running!');
          return redirect()->route('user.dashboard');
        }
      }
    }

    public function rename_func($user_id){
      rename ($_SERVER['DOCUMENT_ROOT'] . '/download/haproxy'.$user_id.'.txt',$_SERVER['DOCUMENT_ROOT'] ."\\download\\haproxy.cfg");
      return true;
    }
    public function writeToFile($ip,$backend_port,$port_frontend,$ip_frontned,$user_id,$protocol)
    {

       $newfile = $_SERVER['DOCUMENT_ROOT'] . '/download/haproxy'.$user_id.'.txt';
       $url = "C:\wamp\www\LBWebPortal\public\haproxy.txt";
       copy($url, $newfile);
       $filename =$_SERVER['DOCUMENT_ROOT'] ."\\download\\haproxy".$user_id.".txt";
       $file = fopen($filename, "r") or exit("Unable to open file!");
       $string = '#backend';
       $string_1 = '#frontend';
       $string_2 = '#protocol';
       $contents = file_get_contents($filename);
       $contents = str_replace($string_1,$ip_frontned.":".$port_frontend,$contents,$count);
       $contents = str_replace($string_2,$protocol,$contents,$count);
       $new_string = " server "." Name"."0"." ".$ip[0].":".$backend_port[0]." check "."\n\t\t";
       if(count($ip)>1){
         for ($i=1; $i < count($ip) ; $i++) {
           $temp = $new_string;
           $new_string = $temp." server "." Name".$i." ".$ip[$i].":".$backend_port[$i]." check\n\t";
         }
       }
       $contents = str_replace($string, $new_string, $contents,$count);
       if($count>0)
       {
        file_put_contents($filename,$contents);
        return true;
       }
       else
       {
        echo "Error";
        return false;
       }
     }

    public function getBackendObject($user_id,$frontend_id)
    {
    $back_end = BackendServer::where('user_id','=',$user_id)
                              ->where('frontend_id','=',$frontend_id)
                              ->get();
    $back_end_array=[];
    $i=0;
    foreach ($back_end as $backend) {
      $back_end_array[$i]=[
        'IP'=>$backend['attributes']['ip_address'],
        'PORT'=>$backend['attributes']['port_no'],
      ];
      $i++;
    }
      return $back_end_array;
    }
    public function getBackendIPAddress($back_end_object)
    {

      $ip_array =[];
      for ($i=0; $i < count($back_end_object) ; $i++) {
        $ip_array[$i]= $back_end_object[$i]['IP'];
      }
      return $ip_array;
    }
    public function getBackendPort($back_end_object)
    {

      $port_array =[];
      for ($i=0; $i < count($back_end_object) ; $i++) {
        $port_array[$i]= $back_end_object[$i]['PORT'];
      }
      return $port_array;
    }

    public function getFrontendObject($user_id,$lb_id)
    {

      $front_end = FrontendServer::where('user_id','=',$user_id)
                                  ->where('lb_id','=',$lb_id)
                                  ->first();
      $front_end_array =[
        'ID'  => $front_end['id'],
        'PORT'=> $front_end['port_no'],
        'PROTOCOL'=>$front_end['protocol'],
      ];

      return $front_end_array;
    }

}
