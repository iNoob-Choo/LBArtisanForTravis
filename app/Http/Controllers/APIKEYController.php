<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\APIKEY;
use Auth;
use Session;

class APIKEYController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $id = Auth::user()->id;
      $keys = APIKEY::where('user_id','LIKE',$id)->get();
      return view('keys.index')->withKeys($keys);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keys.create');
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
              'providername'    => 'required',
              'apikey'          => 'required',
          ));
      // store in the database
      $api_key = new APIKEY;
      $api_key->provider = $request->providername;
      $api_key->API_KEY = $request->apikey;
      $api_key->user_id = $request->user_id;


      $api_key->save();
      //flash a message after save
      Session::flash('success','API Key is successfully saved!');
      return redirect()->route('user.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $key = APIKEY::find($id);
      $key->delete();
        Session::flash('success_delete','API Key is successfully deleted!');
      return redirect()->route('APIKEY.index');
    }
}
