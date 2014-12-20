<?php
class DemoController extends BaseController {

	public function __construct() {

		# Make sure BaseController construct gets called
		parent::__construct();
	}

	public function crudCreate() {

	# Instantiate a new Recipe model class
    $recipe = new Recipe();

   # Set
    $recipe->title = 'Apple popcorn ball';
    $recipe->food = 'Apple';
    $recipe->created = 2014;
    $recipe->image = 'http://www.efoodsdirect.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/a/p/apples2.jpg';
    $recipe->site_link = 'http://www.foodnetwork.com/recipes/articles/50-things-to-make-with-apples/things-to-make-with-apples.html';


    $recipe->save();
    return "A new recipe has been added!";

		}

	public function crudRead() {

		# Magic: Eloquent
		$recipes = Recipe::all();

		# Debugging
		foreach($recipes as $recipe) {
			echo $recipe->title."<br>";
		}
	}

	public function crudUpdate() {

 	    # Get a recipe to update
		$recipe = Recipe::first();

		# Update the food
		$recipe->food = 'Foodrecipe';

		# Save the changes
		$recipe->save();

		echo "This recipe has been updated";

	}

	public function crudDelete() {

		# Get a recipe to delete
		$recipe = Recipe::first();

		# Delete the recipe
		$recipe->delete;

		echo "This recipe has been deleted";

	}

	public function collections() {

		$collection = Recipe::all();

		echo $collection;

	}

	public function queryWithoutConstraints() {
		$recipes = Recipe::find(1);

		Recipe::pretty_debug($recipes);

	}

	public function queryWithConstraints() {
		$recipes = Recipe::where('created','>',1960)->first();

		Recipe::pretty_debug($recipes);
	}

	public function queryResponsibility() {


		$recipes = Recipe::orderBy('title')->get();


		$first_recipe = Recipe::orderBy('title')->first();

		echo $first_recipe['title'];
	}

	public function queryWithOrder() {

		$recipes = Recipe::where('created', '>', 1950)->
		orderBy('title','desc')
		->get();

		Recipe::pretty_debug($recipes);
	}

	public function queryRelationshipsFood() {

		# Get the first recipe
		$recipe = Recipe::orderBy('title')->first();


		$food = $recipe['food'];


		echo $recipe['title']." is a recipe of ".$food['name']."<br>";


	}

	public function queryRelationsipsTags() {


		$recipe = Recipe::orderBy('title')->first();

		$tags = $recipe->tags;


		echo "The tags for <strong>".$recipe->title."</strong> are: <br>";
		foreach($tags as $tag) {
		echo $tag->name."<br>";

		}

	}

	public function queryEagerLoadingFoods() {


		$recipes = Recipe::orderBy('title')->get();


		foreach($recipes as $recipe) {
			echo $recipe->food->name.' is  used for '.$recipe->title.'<br>';
		}

	}

	public function queryEagerLoadingTagsAndFoods() {


		$recipes = Recipe::orderBy('title')->get();




		foreach($recipes as $recipe) {
			echo $recipe->title.' is cooked by '.$recipe->food->name.'<br>';
		foreach($recipe->tags as $tag) echo $tag->name.", ";
			echo "<br><br>";
		}

	}

}