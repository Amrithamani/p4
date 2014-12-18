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
