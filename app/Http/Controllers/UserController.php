<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
      $user = User::find($id);

      return view('users.show')->withUser($user);
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
       $user = User::find($id);
       // return the view and pass in the var we previously created
       return view('users.edit')->withUser($user);
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
              'name' => 'required|max:255',
              'email'  => 'required'
          ));
      // Save the data to the database
      $user = User::find($id);
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->save();
      // set flash data with success message

      // redirect with flash data to posts.show
      if(Auth::guard('admin')->check()){
        return redirect()->route('users.show', $user->id);
      }else{
          return view('home');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::find($id);
      $user->delete();
      Session::flash('info','User is deleted!');
      return redirect()->route('users.index');
    }
}
