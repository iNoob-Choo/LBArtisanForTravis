@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-10">
            <h1>API KEYS</h1>
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
                <th>API KEY</th>
                <th></th>
              </thead>
              <tbody>
                @foreach ($keys as $key)
                  <tr>
                    <td>{{$key->provider}}</td>
                    <td>{{$key->API_key}}</td>
                    <td>
                      {!! Form::open(['route' => ['APIKEY.destroy', $key->id], 'method' => 'DELETE']) !!}

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
