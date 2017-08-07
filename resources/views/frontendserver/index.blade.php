@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-10">
            <h1>Frontend Details</h1>
          </div>
          <div class="col-md-2">
            <a href={{route('user.dashboard')}} class="btn btn-lg btn-block btn-primary">Back</a>
            <a href={{route('Frontend.create',$lb_id)}} class="btn btn-lg btn-block btn-primary">Add</a>
          </div>
          <hr>
      </div><!-- end of row -->
      <div class="row">
        <div class="col-md-12">
          <table class="table">
              <thead>
                <th>Port No</th>
                <th>Protocol</th>
                <th></th>
              </thead>
              <tbody>
                @foreach ($frontendservers as $front)
                  <tr>
                    <td>{{$front->port_no}}</td>
                    <td>{{$front->protocol}}</td>
                    <td><a href="{{route('Frontend.show',$front->id)}}">View Backend</a></td>
                    <td>{!! Html::linkRoute('Frontend.edit', 'Edit', array($front->id), array('class' => 'btn btn-primary btn-block')) !!}</td>
                    <td>
                      {!! Form::open(['route' => ['Frontend.destroy', $front->id], 'method' => 'DELETE']) !!}

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
