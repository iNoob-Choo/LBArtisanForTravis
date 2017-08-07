@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-10">
            <h1>Load Balancers</h1>
          </div>
          <div class="col-md-2">
            <a href={{route('user.dashboard')}} class="btn btn-lg btn-block btn-primary">Back</a>
          </div>
          <hr>

      </div><!-- end of row -->

      <div class="row">
        <div class="col-md-12">
          <table class="table">
              <thead>

                <th>Provider Name</th>
                <th>Label Name</th>
                <th>Location</th>
                <th>IP Address</th>
                <th></th>
              </thead>
              <tbody>
                @foreach ($lbs as $lb)
                  <tr>
                    <td>{{$lb->provider}}</td>
                    <td><a href="{{route('LoadBalancers.show',$lb->id)}}">{{$lb->label_name}}</a></td>
                    <td>{{$lb->location}}</td>
                    <td>{{$lb->ip_address}}</td>
                    <td>{!! Html::linkRoute('LoadBalancers.edit', 'Edit', array($lb->id), array('class' => 'btn btn-primary btn-block')) !!}</td>
                    <td>{!! Html::linkRoute('LoadBalancers.boot', 'Boot', array($lb->id), array('class' => 'btn btn-primary btn-block')) !!}</td>
                    <td>{!! Html::linkRoute('LoadBalancers.deploy', 'Deploy', array($lb->id), array('class' => 'btn btn-primary btn-block')) !!}</td>
                    <td>{!! Html::linkRoute('LoadBalancers.shutdown', 'Shutdown', array($lb->id), array('class' => 'btn btn-primary btn-block')) !!}</td>
                    <td>
                      {!! Form::open(['route' => ['LoadBalancers.destroy', $lb->id], 'method' => 'DELETE']) !!}

          						{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}

          						{!! Form::close() !!}
                    </td>
                  </tr>
                @endforeach

              </tbody>
          </table>
        </div>
      </div>
  </div>
@include('partials._messages');
@endsection
