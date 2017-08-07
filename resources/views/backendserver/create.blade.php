@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Backend Server</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('Backend.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('labelname') ? ' has-error' : '' }}">
                            <label for="labelname" class="col-md-4 control-label">Backend Name: </label>

                            <div class="col-md-6">
                                <input id="labelname" type="text" class="form-control" name="labelname" value="{{ old('labelname') }}" required autofocus>

                                @if ($errors->has('labelname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('labelname') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div>
                              {{ Form::hidden('user_id', Auth::user()->id, array('id' => 'user_id')) }}
                              {{ Form::hidden('frontend_id',$front_id)}}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('port_no') ? ' has-error' : '' }}">
                            <label for="port_no" class="col-md-4 control-label">Port: </label>

                            <div class="col-md-6">
                                <input id="port_no" type="text" class="form-control" name="port_no" value="{{ old('port_no') }}" required autofocus>

                                @if ($errors->has('port_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('port_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('ip_address') ? ' has-error' : '' }}">
                            <label for="ip_address" class="col-md-4 control-label">Backend IP Address: </label>

                            <div class="col-md-6">
                                <input id="ip_address" type="text" class="form-control" name="ip_address" value="{{ old('ip_address') }}" required autofocus>

                                @if ($errors->has('ip_address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ip_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                                {!! Html::linkRoute('user.dashboard' ,'Back', array('class' => 'btn btn-primary btn-block')) !!}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
