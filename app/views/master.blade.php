<!DOCTYPE html>
<html>
<head>

    <title>@yield('title', 'Food Recipes')</title>
	<meta charset='utf-8'>
	
	
	
    <link rel='stylesheet' href='/css/recipes.css' type='text/css'>

	
    @yield('head')

</head>
<body>
	
	@if(Session::get('flash_message'))
		<div class='flash-message'>{{ Session::get('flash_message') }}</div>
	@endif
	
	<a href='/'><img class='logo' src='/images/recipes.jpg' alt='foodrecipes'></a>
	
	<nav>
		<ul>
		@if(Auth::check())
			<li><a href='/logout'>Log out  {{ Auth::user()->email; }}</a></li>
			<li><a href='/recipe'>View all Recipes</a></li>
			<li><a href='/tag'>All Tags</a></li>
			<li><a href='/recipe/create'>+ Add Recipe</a></li>
		@else
			<li><a href='/signup'>Sign up</a> or <a href='/login'>Log in</a></li>
		@endif
		</ul>
	</nav>
	
	
	
    @yield('content')

    

    @yield('body')

</body>
</html>