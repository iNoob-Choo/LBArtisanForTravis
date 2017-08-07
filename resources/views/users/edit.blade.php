@extends('layouts.app')

@section('content')

	<div class="row">
		@if (Auth::guard('web')->check())
		{!! Form::model($user, ['route' => ['User.update', $user->id], 'method' => 'PUT']) !!}
		@endif

		@if (Auth::guard('admin')->check())
		{!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
		@endif

		{!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
		<div class="col-md-8">
			{{ Form::label('name', 'Name:') }}
			{{ Form::text('name', null, ["class" => 'form-control input-lg']) }}

			{{ Form::label('email', "Email:", ['class' => 'form-spacing-top']) }}
			{{ Form::text('email', null, ['class' => 'form-control']) }}
		</div>
		<?php
		if(Auth::guard('admin')->check()){
			$route ='users.show';
		}else{
			$route ='user.dashboard';
		}
		 ?>
		<div class="col-md-4">
				<div class="row">
					<div class="col-sm-6">
						{!! Html::linkRoute($route, 'Cancel', array($user->id), array('class' => 'btn btn-danger btn-block')) !!}
					</div>
					<div class="col-sm-6">
						{{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) }}
					</div>
				</div>

			</div>
		</div>
		{!! Form::close() !!}
	</div>	<!-- end of .row (form) -->

@stop
