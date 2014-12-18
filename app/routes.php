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
