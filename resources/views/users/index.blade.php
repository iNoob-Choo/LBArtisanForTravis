@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<div class="container">
    <div class="row">
        <div class="col-md-10">
          <h1>All Users</h1>
        </div>
        <div class="col-md-2">
          <a href={{route('users.create')}} class="btn btn-lg btn-block btn-primary">Create New User</a>
          <a href={{route('admin.dashboard')}} class="btn btn-lg btn-block btn-primary">Back</a>
        </div>
        <hr>

    </div><!-- end of row -->

    <div class="row">
      <div class="col-md-12">
        <table class="table">
            <thead>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th></th>
            </thead>
            <tbody>
              @foreach ($users as $user)
                <tr>
                  <td>{{$user->id}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>
                  <a href="{{route('users.show',$user->id)}}" class="btn btn-default">View</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>
    </div>
    @include('partials._messages');
</div>
@endsection
