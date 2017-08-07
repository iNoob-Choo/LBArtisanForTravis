@extends('layouts.app')


@section('content')

	<div class="row">
		<div class="col-md-4">
			<div class="well">
				Name: {{$user->name}}<br>
				Emai: {{$user->email}}<br>
				<hr>
				<div class="row">
					<div class="col-sm-6">
						{!! Html::linkRoute('users.edit', 'Edit', array($user->id), array('class' => 'btn btn-primary btn-block')) !!}
					</div>
					<div class="col-sm-6">
						{!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) !!}

						{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}

						{!! Form::close() !!}
					</div>
					<div class="col-sm-6">
						  <a href={{route('users.index')}} class="btn btn-block btn-primary">Back</a>
					</div>
				</div>

			</div>
		</div>
	</div>

@endsection
