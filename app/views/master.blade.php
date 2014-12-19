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
			<li><a href='/list'>List All</a></li>
			<li><a href='/add'>+ Add Recipe</a></li>
		</ul>
	</nav>
	
    @yield('content')

    

    @yield('body')

</body>
</html>