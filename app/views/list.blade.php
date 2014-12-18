@extends('master')

@section('title')
	List all the recipes
@stop

@section('content')
	<h1>List all recipes</h1>
	<div>
	View as:
	<a href='/list/json' target='_blank'>JSON</a>  
	<a href='/list/pdf' target='_blank'>PDF</a>
	</div>
	
	<h2>You searched for {{{ $query }}}</h2>
	
	@foreach($recipes as $title => $recipe)
		<section class='recipe'>
			<h2>{{ $title }}</h2>
			{{ $recipe['food'] }} ({{$recipe['created']}})

			<div class='tags'>
				@foreach($recipe['tags'] as $tag)
					{{ $tag }}
				@endforeach
			</div>
			<img src='{{ $recipe['image'] }}'>
			<br>
			<a href='{{ $recipe['site_link'] }}'>Recipe...</a>
		</section>
	@endforeach
	

@stop