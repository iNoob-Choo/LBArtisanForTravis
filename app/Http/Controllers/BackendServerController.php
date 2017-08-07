<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BackendServer;
use Session;

class BackendServerController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backendserver.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // validate the data
      $this->validate($request, array(
              'labelname'    => 'required',
              'port_no'      => 'required|numeric',
              'ip_address'   => 'required',
          ));
      // store in the database
      $back_end_server = new BackendServer;
      $back_end_server->server_label_name = $request->labelname;
      $back_end_server->port_no = $request->port_no;
      $back_end_server->ip_address = $request->ip_address;
      $back_end_server->user_id = $request->user_id;
      $back_end_server->frontend_id = $request->frontend_id;

      $back_end_server->save();
      Session::flash('success','Backend Server is successfully created!');
      return redirect()->route('LoadBalancers.index');
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
     $back_end_server = BackendServer::find($id);
     // return the view and pass in the var we previously created
      return view('backendserver.edit')->withBack_end_server($back_end_server);
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
      // validate the data
      $this->validate($request, array(
              'labelname'    => 'required',
              'port_no'      => 'required|numeric',
              'ip_address'   => 'required',
          ));
          // Save the data to the database
          $back_end_server = BackendServer::find($id);
          $back_end_server->server_label_name = $request->input('labelname');
          $back_end_server->port_no    = $request->input('port_no');
          $back_end_server->ip_address = $request->input('ip_address');
          $back_end_server->save();
          // set flash data with success message
          Session::flash('success','Backend Server  is successfully updated!');
          // redirect with flash data to posts.show

          return redirect()->route('LoadBalancers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $back_end_server = BackendServer::find($id);
      $back_end_server->delete();
      Session::flash('success_delete','Backend Server is successfully deleted!');
      return redirect()->route('LoadBalancers.index');
    }
}
