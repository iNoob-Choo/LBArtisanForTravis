@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">USER Dashboard</div>
                  <div class="panel-body">
                    <a href="{{route('APIKEY.create')}}" class="btn btn-block btn-primary">Add API KEY</a>
                    <a href="{{route('APIKEY.index')}}" class="btn btn-block btn-primary">View API KEY</a>
                    <a href="{{route('LoadBalancers.create')}}" class="btn btn-block btn-primary">Add Load Balancer</a>
                    <a href="{{route('LoadBalancers.index')}}" class="btn btn-block btn-primary">View LB</a>
                  </div>
            </div>
        </div>
    </div>
</div>
@include('partials._messages');
@endsection
