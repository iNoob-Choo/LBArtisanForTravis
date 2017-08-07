@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">API KEY</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('APIKEY.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('providername') ? ' has-error' : '' }}">
                            <label for="providername" class="col-md-4 control-label">Name of Provider: </label>

                            <div class="col-md-6">
                              <select name="providername" id="providername" class="form-control">
                                <option value="Linode Manager">Linode Manager</option>
                                <option value="AWS">Amazon Web Service</option>
                                <option value="Deep Ocean">Deep Ocean</option>
                              </select>
                                  @if ($errors->has('providername'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('providername') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('apikey') ? ' has-error' : '' }}">
                            <label for="apikey" class="col-md-4 control-label">API KEY: </label>

                            <div class="col-md-6">
                                <input id="apikey" type="text" class="form-control" name="apikey" value="{{ old('apikey') }}" required autofocus>

                                @if ($errors->has('apikey'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('apikey') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div>
                              {{ Form::hidden('user_id', Auth::user()->id, array('id' => 'user_id')) }}
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
