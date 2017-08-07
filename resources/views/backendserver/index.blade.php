@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-10">
            <h1>Backend Server</h1>
          </div>
          <div class="col-md-2">
            <a href={{route('user.dashboard')}} class="btn btn-lg btn-block btn-primary">Back</a>
            <a href={{route('Backend.create',$front_id)}} class="btn btn-lg btn-block btn-primary">Add</a>
          </div>
          <hr>
      </div><!-- end of row -->
      <div class="row">
        <div class="col-md-12">
          <table class="table">
              <thead>
                <th>Label Name</th>
                <th>Port No</th>
                <th>IP Address</th>
                <th></th>
              </thead>
              <tbody>
                @foreach ($backendservers as $back)
                  <tr>
                    <td>{{$back->server_label_name}}</td>
                    <td>{{$back->port_no}}</td>
                    <td>{{$back->ip_address}}</td>
                    <td>{!! Html::linkRoute('Backend.edit', 'Edit', array($back->id), array('class' => 'btn btn-primary btn-block')) !!}</td>
                    <td>
                      {!! Form::open(['route' => ['Backend.destroy', $back->id], 'method' => 'DELETE']) !!}

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

@endsection
