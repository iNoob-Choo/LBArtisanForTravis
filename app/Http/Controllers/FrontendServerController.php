<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FrontendServer;
use App\BackendServer;
use Session;

class FrontendServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('lb.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('frontendserver.create');
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
              'port_no'      => 'required|numeric',
              'protocol'   => 'required',
          ));
      // store in the database
      $front_end_server = new FrontendServer;
      $front_end_server->port_no = $request->port_no;
      $front_end_server->protocol = $request->protocol;
      $front_end_server->user_id = $request->user_id;
      $front_end_server->lb_id = $request->lb_id;

      $front_end_server->save();
      Session::flash('success','Port Number and Protocol for front end is saved!');
      return redirect()->route('LoadBalancers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $backendservers = BackendServer::where('frontend_id','=',$id)->get();
      $front_id = $id;
      return view('backendserver.index')->withBackendservers($backendservers)->withFront_id($front_id);
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
     $front_end_server = FrontendServer::find($id);
     // return the view and pass in the var we previously created
      return view('frontendserver.edit')->withFront_end_server($front_end_server);
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
              'protocol'    => 'required',
              'port_no'      => 'required|numeric',
          ));
          // Save the data to the database
          $front_end_server = FrontendServer::find($id);
          $front_end_server->port_no    = $request->input('port_no');
          $front_end_server->protocol = $request->input('protocol');
          $front_end_server->save();
          // set flash data with success message
          Session::flash('success','Port Number and Protocol is updated!');
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
      $front_end_server = FrontendServer::find($id);
      $front_end_server->delete();
      Session::flash('success_delete','Port Number and Protocol is removed!');
      return redirect()->route('LoadBalancers.index');
    }
}
