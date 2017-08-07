@extends('layouts.app')

@section('content')
	<h1>Editing Frontend</h1>
	<div class="row">
		{!! Form::model($front_end_server, ['route' => ['Frontend.update', $front_end_server->id], 'method' => 'PUT']) !!}
		<div class="col-md-8">
			{{ Form::label('protocol', 'New Protocol:') }}
			{{ Form::select('protocol', array('Http' => 'Http', 'TCP' => 'TCP'),["class" => 'form-control input'])}}
		</div>
		<div class="col-md-8">
			{{ Form::label('port_no', "Port No:") }}
			{{ Form::text('port_no', null, ['class' => 'form-control']) }}
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
