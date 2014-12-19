<?php

class RecipeController extends \BaseController {
	/**
	*
	*/
	public function __construct() {

		# Make sure BaseController construct gets called
		parent::__construct();

		# Only logged in users should have access to this controller
		$this->beforeFilter('auth', array('except' => 'getIndex'));
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
			return View::make('recipe_index')
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

    	$tags = Tag::getIdNamePair();

    	return View::make('recipe_add')
    	->with('foods',$foods)
    	->with('tags',$tags);
	}

	/**
	* Process the "Add a book form"
	* @return Redirect
	*/

	public function postCreate() {

	# Instantiate the book model
		$recipe = new Recipe();

		$recipe->fill(Input::except('tags'));
		$recipe->save();

		foreach(Input::get('tags') as $tag) {

					# This enters a new row in the book_tag table
					$recipe->tags()->save(Tag::find($tag));
		}

		return Redirect::action('RecipeController@getIndex')->with('flash_message','Your recipe has been added.');
	}
	/**
	* Show the "Edit a book form"
	* @return View
	*/

	public function getEdit($id) {
		try {

		    $foods = Food::getIdNamePair();

		    # Get this book and all of its associated tags
		    $recipe    = Recipe::with('tags')->findOrFail($id);

		    # Get all the tags (not just the ones associated with this book)
			$tags    = Tag::getIdNamePair();
		}

		}
		catch(exception $e) {
		    return Redirect::to('/recipe')->with('flash_message', 'Recipe not found');
		}
    	return View::make('recipe_edit')
    		->with('recipe', $recipe)
    		->with('foods', $foods)
    		->with('tags', $tags);
	}

	/**
	* Process the "Edit a book form"
	* @return Redirect
	*/

	public function postEdit() {
		try {
	        $recipe = Recipe::with('tags')->findOrFail(Input::get('id'));
	    }
	    catch(exception $e) {
	        return Redirect::to('/recipe')->with('flash_message', 'Recipe not found');
	    }
	    # http://laravel.com/docs/4.2/eloquent#mass-assignment
	    $recipe->fill(Input::except('tags'));
	    $recipe->save();

	   	# Update tags associated with this book
		    if(!isset($_POST['tags'])) $_POST['tags'] = array();
		    $recipe->updateTags($_POST['tags']);

	   	return Redirect::action('RecipeController@getIndex')->with('flash_message','Your changes have been saved.');
	}

	catch(exception $e) {
		        return Redirect::to('/recipe')->with('flash_message', 'Error saving changes.');
		    }
	}

	/**
	* Process book deletion
	*
	* @return Redirect
	*/
	public function postDelete() {
		try {
	        $book = Book::findOrFail(Input::get('id'));
	    }
	    catch(exception $e) {
	        return Redirect::to('/recipe/')->with('flash_message', 'Could not delete recipe - not found.');
	    }

		Recipe::destroy(Input::get('id'));

		return Redirect::to('/recipe/')->with('flash_message', 'Recipe deleted.');
	}


}