@extends('layouts.app')

@section('content')

	<div class="row">
		{!! Form::model($lb, ['route' => ['LoadBalancers.update', $lb->id], 'method' => 'PUT']) !!}
		<div class="col-md-8">
			{{ Form::label('labelname', 'Label Name:') }}
			{{ Form::text('labelname', null, ["class" => 'form-control input-lg']) }}
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
