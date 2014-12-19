@extends('master')

@section('title')
	Edit
@stop

@section('head')

@stop

@section('content')

	<h1>Edit</h1>
	<h2>{{{ $recipe['title'] }}}</h2>

	{{ Form::open(array('url' => '/edit')) }}

		{{ Form::hidden('id',$recipe['id']); }}

		{{ Form::label('title','Title') }}
		{{ Form::text('title',$recipe['title']); }}

		{{ Form::label('created','Created Year (YYYY)') }}
		{{ Form::text('created',$recipe['published']); }}

		{{ Form::label('image',' Image URL') }}
		{{ Form::text('image',$recipe['image']); }}

		{{ Form::label('site_link','Site Link URL') }}
		{{ Form::text('site_link',$recipe['site_link']); }}

		{{ Form::submit('Save'); }}

	{{ Form::close() }}

@stop