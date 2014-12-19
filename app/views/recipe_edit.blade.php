@extends('master')

@section('title')
	Edit
@stop

@section('head')

@stop

@section('content')

	<h1>Edit</h1>
	<h2>{{{ $recipe['title'] }}}</h2>

	{{---- EDIT -----}}
	{{ Form::open(array('url' => '/recipe/edit')) }}

		{{ Form::hidden('id',$recipe['id']); }}

		<div class='form-group'>
		{{ Form::label('title','Title') }}
		{{ Form::text('title',$recipe['title']); }}
		</div>

		<div class='form-group'>
		{{ Form::label('created','Created Year (YYYY)') }}
		{{ Form::text('created',$recipe['created']); }}
		</div>

		<div class='form-group'>
		{{ Form::label('image',' Image URL') }}
		{{ Form::text('image',$recipe['image']); }}
		</div>

		<div class='form-group'>
		{{ Form::label('site_link','Site Link URL') }}
		{{ Form::text('site_link',$recipe['site_link']); }}
		</div>

		<div class='form-group'>
					@foreach($tags as $id => $tag)
						{{ Form::checkbox('tags[]', $id, $recipe->tags->contains($id)); }} {{ $tag }}
						&nbsp;&nbsp;&nbsp;
					@endforeach
		</div>

		{{ Form::submit('Save'); }}

	{{ Form::close() }}

	<div>
			{{---- DELETE -----}}
			{{ Form::open(array('url' => '/recipe/delete')) }}
				{{ Form::hidden('id',$recipe['id']); }}
				<button onClick='parentNode.submit();return false;'>Delete</button>
			{{ Form::close() }}
	</div>

@stop