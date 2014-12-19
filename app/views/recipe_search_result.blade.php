<section>
	<img class='image' src='{{ $recipe['image'] }}'>

	<h2>{{ $recipe['title'] }}</h2>

	<p>
	{{ $recipe['food']->name }} {{ $recipe['created'] }}
	</p>

	<p>
		@foreach($recipe['tags'] as $tag)
			{{ $tag->name }}
		@endforeach
	</p>

	<a href='{{ $recipe['image'] }}'>View this recipe...</a>
	<br>
	<a href='/recipe/edit/{{ $recipe->id }}'>Edit</a>
</section>