@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Frontend Server</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('Frontend.store') }}">
                        {{ csrf_field() }}
                        <div>
                          {{ Form::hidden('user_id', Auth::user()->id, array('id' => 'user_id')) }}
                          {{ Form::hidden('lb_id',$lb_id)}}
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
                        <div class="form-group{{ $errors->has('protocol') ? ' has-error' : '' }}">
                            <label for="protocol" class="col-md-4 control-label">Protocol: </label>

                            <div class="col-md-6">
                              <select name="protocol" id="protocol" class="form-control">
                                <option value="HTTP">HTTP</option>
                                <option value="TCP">TCP</option>
                              </select>
                                @if ($errors->has('protocol'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('protocol') }}</strong>
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
