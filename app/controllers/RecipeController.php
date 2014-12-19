<?php
class RecipeController extends \BaseController {
	/**
	*
	*/
	public function __construct() {
		
		# Make sure BaseController construct gets called
		parent::__construct();
		
		# Only logged in users should have access to this controller
		$this->beforeFilter('auth');
	}
	/**
	* Process the searchform
	* @return View
	*/
	
	public function getSearch() {
		return View::make('recipe_search');
	}
	/**
	* Display all books
	* @return View
	*/
	public function getIndex() {
		# Format and Query are passed as Query Strings
		$format = Input::get('format', 'html');
		$query  = Input::get('query');
		$recipes = Recipe::search($query);
		
		# Decide on output method...
		
		# Default - HTML
		if($format == 'html') {
			return View::make('recipe')
				->with('recipes', $recipes)
				->with('query', $query);
		}
		
		# JSON
		elseif($format == 'json') {
			return Response::json($recipes);
		}
		# PDF (Coming soon)
		elseif($format == 'pdf') {
			return "This is the pdf (Coming soon).";
		}
	}
	
	/**
	* Show the "Add a book form"
	* @return View
	*/
	public function getCreate() {
		$foods = Food::getIdNamePair();
    	return View::make('add')->with('foods',$foods);
	}
	
	/**
	* Process the "Add a book form"
	* @return Redirect
	*/
	
	public function postCreate() {
	
	# Instantiate the book model
		$recipe = new Recipe();
		$recipe->fill(Input::all());
		$recipe->save();
		
		# Magic: Eloquent
		$recipe->save();
		return Redirect::action('RecipeController@getIndex')->with('flash_message','Your recipe has been added.');
	}
	/**
	* Show the "Edit a book form"
	* @return View
	*/
	
	public function getEdit($id) {
		try {
		    $recipe    = Recipe::findOrFail($id);
		    $foods = Food::getIdNamePair();
		}
		catch(exception $e) {
		    return Redirect::to('/list')->with('flash_message', 'Book not found');
		}
    	return View::make('edit')
    		->with('recipe', $recipe)
    		->with('foods', $foods);
	}
	
	/**
	* Process the "Edit a book form"
	* @return Redirect
	*/
	
	public function postEdit() {
		try {
	        $recipe = Recipe::findOrFail(Input::get('id'));
	    }
	    catch(exception $e) {
	        return Redirect::to('/list')->with('flash_message', 'Recipe not found');
	    }
	    # http://laravel.com/docs/4.2/eloquent#mass-assignment
	    $recipe->fill(Input::all());
	    $recipe->save();
	   	return Redirect::action('RecipeController@getIndex')->with('flash_message','Your changes have been saved.');
	}
}