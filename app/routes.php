<?php

# Homepage
Route::get('/', function() {

    return View::make('index');
});

// List all books / search
Route::get('/list/{format?}', function($format = 'html') {

	$query = Input::get('query');
	
   $library = new Library();
    $library->setPath(app_path().'/database/recipes.json');
    
    $recipes = $library->getRecipes();
	
	 if($query) {
        $recipes = $library->search($query);
    }
	
    if($format == 'json') {
        return 'JSON Version';
    }
    elseif($format == 'pdf') {
        return 'PDF Version;';
    }
    else {
        return View::make('list')
            ->with('name','Amritha')
			->with('recipes', $recipes)
			->with('query',$query);
    }

});

// Display the form for a new book
Route::get('/add', function() {
	return View::make('add');
});

// Process form for a new book
Route::post('/add', function() {
});

// Display the form to edit a book
Route::get('/edit/{title}', function() {
});

// Process form for a edit book
Route::post('/edit/', function() {
});

Route::get('/info', function() {

	
	$library = new Library();
    
	$library->setPath(app_path().'/database/recipes.json');
    
    $recipes = $library->getRecipes();
    
	// Return the file
    echo Pre::render($recipes);

});

Route::get('/practice-creating', function() {
    # Instantiate a new Book model class
    $recipe = new Recipe();
    # Set 
    $recipe->title = 'Apple popcorn ball';
    $recipe->food = 'Apple';
    $recipe->created = 2014;
    $recipe->image = 'http://www.efoodsdirect.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/a/p/apples2.jpg';
    $recipe->site_link = 'http://www.foodnetwork.com/recipes/articles/50-things-to-make-with-apples/things-to-make-with-apples.html';
    # This is where the Eloquent ORM magic happens
    $recipe->save();
    return 'A new recipe has been added! Check your database to see...';
});


Route::get('/practice-reading', function() {
    
	# The all() method will fetch all the rows from a Model/table
    $recipes = Recipe::all();
    
	# Make sure we have results before trying to print them...
    if($recipes->isEmpty() != TRUE) {
        # Typically we'd pass $books to a View, but for quick and dirty demonstration, let's just output here...
        foreach($recipes as $recipe) {
            echo $recipe->title.'<br>';
        }
    }
    else {
        return 'No recipes found';
    }
});


Route::get('/practice-updating', function() {

    # First get a recipe to update
    $recipe = Recipe::where('food', 'LIKE', '%Apple%')->first();
    
	# If we found the recipe, update it
    if($recipe) {
    
    # Give it a different title
        $recipe->title = 'Apple corn ball';
        # Save the changes
        $recipe->save();
        return "Update complete; check the database to see if your update worked...";
    }
    else {
        return "Recipe not found, can't update.";
    }
});

Route::get('/practice-deleting', function() {

    # First get a recipe to delete
    $recipe = Recipe::where('food', 'LIKE', '%Apple%')->first();
    # If we found the recipe, delete it
    if($recipe) {
        # Goodbye!
        $recipe->delete();
        return "Deletion complete; check the database to see if it worked...";
    }
    else {
        return "Can't delete - Recipe not found.";
    }
});


Route::get('/get-environment',function() {

    echo "Environment: ".App::environment();

});

Route::get('/trigger-error',function() {

    # Class Foobar should not exist, so this should create an error
    $foo = new Foobar;

});

Route::get('mysql-test', function() {

    # Print environment
    echo 'Environment: '.App::environment().'<br>';

    # Use the DB component to select all the databases
    $results = DB::select('SHOW DATABASES;');

    # If the "Pre" package is not installed, you should output using print_r instead
    echo Pre::render($results);

});

Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>environment.php</h1>';
    $path   = base_path().'/environment.php';

    try {
        $contents = 'Contents: '.File::getRequire($path);
        $exists = 'Yes';
    }
    catch (Exception $e) {
        $exists = 'No. Defaulting to `production`';
        $contents = '';
    }

    echo "Checking for: ".$path.'<br>';
    echo 'Exists: '.$exists.'<br>';
    echo $contents;
    echo '<br>';

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(Config::get('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    print_r(Config::get('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
    try {
        $results = DB::select('SHOW DATABASES;');
        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
        echo "<br><br>Your Databases:<br><br>";
        print_r($results);
    } 
    catch (Exception $e) {
        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
    }

    echo '</pre>';

});

/*
Print all available routes
*/
Route::get('/routes', function() {
    
    $routeCollection = Route::getRoutes();
    foreach($routeCollection as $value) {
        echo "<a href='/".$value->getPath()."' target='_blank'>".$value->getPath()."</a><br>";
    }
});
