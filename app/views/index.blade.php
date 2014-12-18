@extends('master')

@section('title')
	Welcome to Foodrecipes
@stop

@section('head')
	
@stop

@section('content')
	
	{{ Form::open(array('url' => '/list', 'method' => 'GET')) }}

		{{ Form::label('query','Search') }}
	
		{{ Form::text('query'); }}

		{{ Form::submit('Search'); }}

	{{ Form::close() }}
	
@stop