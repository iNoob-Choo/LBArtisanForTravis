@extends('layouts.app')

@section('content')
	<h1>Editing Backend</h1>
	<div class="row">
		{!! Form::model($back_end_server, ['route' => ['Backend.update', $back_end_server->id], 'method' => 'PUT']) !!}
		<div class="col-md-8">
			{{ Form::label('labelname', 'Label Name:') }}
			{{ Form::text('labelname', null, ["class" => 'form-control input-lg']) }}

			{{ Form::label('port_no', "Port No:", ['class' => 'form-spacing-top']) }}
			{{ Form::text('port_no', null, ['class' => 'form-control']) }}

      {{ Form::label('ip_address', "IP Address:", ['class' => 'form-spacing-top']) }}
			{{ Form::text('ip_address', null, ['class' => 'form-control']) }}
		</div>

		<div class="col-md-4">
				<div class="row">
					<div class="col-sm-6">
						{!! Html::linkRoute('LoadBalancers.index', 'Cancel', array(), array('class' => 'btn btn-danger btn-block')) !!}
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
