@extends('master')

@section('title')
	Add a new recipe
@stop

@section('content')
	<h1>Add a new recipe</h1>

	{{ Form::open(array('url' => '/recipe/create')) }}

		{{ Form::label('title','Title') }}
		{{ Form::text('title'); }}

		{{ Form::label('food_id', 'Food') }}
		{{ Form::select('food_id', $foods); }}

		{{ Form::label('created','Created Year (YYYY)') }}
		{{ Form::text('created'); }}

		{{ Form::label('image',' Image URL') }}
		{{ Form::text('image'); }}

		{{ Form::label('site_link','Purchase Link URL') }}
		{{ Form::text('site_link'); }}

		@foreach($tags as $id => $tag)
					{{ Form::checkbox('tags[]', $id); }} {{ $tag }}
		@endforeach

		{{ Form::submit('Add'); }}

	{{ Form::close() }}

@stop