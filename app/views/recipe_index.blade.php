@extends('master')

@section('title')
	List all the recipes
@stop

@section('content')
	<h1>List all recipes</h1>

	<div>
	View as:
	<a href='/recipe/?format=json' target='_blank'>JSON</a>
	<a href='/recipe/?format=pdf' target='_blank'>PDF</a>
	</div>

	@if($query)
	<h2>You searched for {{{ $query }}}</h2>
	@endif

	@if(sizeof($recipes) == 0)
			No results
	@else

	@foreach($recipes as  $recipe)

		<section class='recipe'>

		<h2>{{ $recipe['title'] }}</h2>


			<p>
				<a href='/recipe/edit/{{$recipe['id']}}'>Edit</a>
			</p>

			<p>
			{{ $recipe['food']['name'] }} ({{$recipe['created']}})
			</p>

			<p>
								@foreach($recipe['tags'] as $tag)
									<span class='tag'>{{{ $tag->name }}}</span>
								@endforeach
				</p>

			<img src='{{ $recipe['image'] }}'>
			<br>
			<a href='{{ $recipe['site_link'] }}'>Recipe...</a>
		</section>
	@endforeach
@endif


@stop