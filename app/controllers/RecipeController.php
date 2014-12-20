<?php

class RecipeController extends \BaseController {

	public function __construct() {


		parent::__construct();


		$this->beforeFilter('auth', array('except' => 'getIndex'));
	}


	public function getSearch() {
		return View::make('recipe_search');
	}

	public function getIndex() {


		$format = Input::get('format', 'html');

		$query  = Input::get('query');

		$recipes = Recipe::search($query);


		if($format == 'html') {
			return View::make('recipe_index')
				->with('recipes', $recipes)
				->with('query', $query);
		}

		# JSON
		elseif($format == 'json') {
			return Response::json($recipes);
		}

		elseif($format == 'pdf') {
			return "This is the pdf (Coming soon).";
		}
	}


	public function getCreate() {
		$foods = Food::getIdNamePair();

    	$tags = Tag::getIdNamePair();

    	return View::make('recipe_add')
    	->with('foods',$foods)
    	->with('tags',$tags);
	}



	public function postCreate() {


		$recipe = new Recipe();

		$recipe->fill(Input::except('tags'));
		$recipe->save();

		foreach(Input::get('tags') as $tag) {


					$recipe->tags()->save(Tag::find($tag));
		}

		return Redirect::action('RecipeController@getIndex')->with('flash_message','Your recipe has been added.');
	}


	public function getEdit($id) {
		try {

		    $foods = Food::getIdNamePair();


		    $recipe    = Recipe::with('tags')->findOrFail($id);


			$tags    = Tag::getIdNamePair();
		}


		catch(exception $e) {
		    return Redirect::to('/recipe')->with('flash_message', 'Recipe not found');
		}

    	return View::make('recipe_edit')
    		->with('recipe', $recipe)
    		->with('foods', $foods)
    		->with('tags', $tags);
	}



	public function postEdit() {
		try {
	        $recipe = Recipe::with('tags')->findOrFail(Input::get('id'));
	    }
	    catch(exception $e) {
	        return Redirect::to('/recipe')->with('flash_message', 'Recipe not found');
	    }

		try {

		    $recipe->fill(Input::except('tags'));
		    $recipe->save();

		    if(!isset($_POST['tags'])) $_POST['tags'] = array();
		    $recipe->updateTags($_POST['tags']);

	   	return Redirect::action('RecipeController@getIndex')->with('flash_message','Your changes have been saved.');
	}

	catch(exception $e) {
		 return Redirect::to('/recipe')->with('flash_message', 'Error saving changes.');
		 }
	}


	public function postDelete() {

		try {
	        $recipe = Recipe::findOrFail(Input::get('id'));
	    }
	    catch(exception $e) {
	        return Redirect::to('/recipe/')->with('flash_message', 'Could not delete recipe - not found.');
	    }

		Recipe::destroy(Input::get('id'));

		return Redirect::to('/recipe/')->with('flash_message', 'Recipe deleted.');
	}


}