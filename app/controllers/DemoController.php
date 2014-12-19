<?php
class DemoController extends BaseController {

	public function __construct() {

		# Make sure BaseController construct gets called
		parent::__construct();
	}

	/**
	* CSRF Example
	* @return View
	*/




	public function crudCreate() {

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

 	    # Get a book to update
		$recipe = Recipe::first();

		# Update the author
		$recipe->food = 'Foodrecipe';

		# Save the changes
		$recipe->save();

		echo "This recipe has been updated";

	}

	public function crudDelete() {

		# Get a book to delete
		$recipe = Recipe::first();

		# Delete the book
		$recipe->delete;

		echo "This recipe has been deleted";

	}

	public function collections() {

		$collection = Recipe::all();

		//echo Pre::render($collection);
		# The many faces of a Eloquent Collection object...

		# Treat it like a string:
		echo $collection;

		# Treat it like an array:
		//foreach($collection as $book) {
		//	echo $book['title']."<br>";
		//}

		# Treat it like an object:
		//foreach($collection as $book) {
		// echo $book->title."<br>";
		//}
	}

	public function queryWithoutConstraints() {
		$recipes = Recipe::find(1);

		//$books = Book::first();
		//$books = Book::all();
		Recipe::pretty_debug($recipes);

	}

	public function queryWithConstraints() {
		$recipes = Recipe::where('created','>',1960)->first();
		//$books = Book::where('published','>',1960)->get();
		//$books = Book::where('published','>',1960)->orWhere('title', 'LIKE', '%gatsby')->get();
		//$books = Book::whereRaw('title LIKE "%gatsby" OR title LIKE "%bell%"')->get();
		Recipe::pretty_debug($recipes);
	}

	public function queryResponsibility() {

		# Scenario: You have a view that needs to display a table of all the books, so you run this query:
		$recipes = Recipe::orderBy('title')->get();

		# Then, you need to display the first book that was added to the table
		# There are two ways you can do this...
		# Query the database again

		$first_recipe = Recipe::orderBy('title')->first();
		# Or query the existing collection
		//$first_book = $books->first();

		echo $first_recipe['title'];
	}

	public function queryWithOrder() {

		$recipes = Recipe::where('created', '>', 1950)->
		orderBy('title','desc')
		->get();

		Recipe::pretty_debug($recipes);
	}

	public function queryRelationshipsFood() {

		# Get the first book as an example
		$recipe = Recipe::orderBy('title')->first();

		# Get the author from this book using the "author" dynamic property
		# "author" corresponds to the the relationship method defined in the Book model
		$food = $recipe['food'];

		# Print book info
		echo $recipe['title']." is a recipe of ".$food['name']."<br>";


	}

	public function queryRelationsipsTags() {

		# Get the first book as an example
		$recipe = Recipe::orderBy('title')->first();

		# Get the tags from this book using the "tags" dynamic property
		# "tags" corresponds to the the relationship method defined in the Book model
		$tags = $recipe->tags;

		# Print results
		echo "The tags for <strong>".$recipe->title."</strong> are: <br>";
		foreach($tags as $tag) {
		echo $tag->name."<br>";
		}

	}

	public function queryEagerLoadingFoods() {

		# Without eager loading (4 queries)
		$recipes = Recipe::orderBy('title')->get();

		# With eager loading (2 queries)
		//$books = Book::with('author')->orderBy('title')->get();
		foreach($recipes as $recipe) {
			echo $recipe->food->name.' is  used for '.$recipe->title.'<br>';
		}

	}

	public function queryEagerLoadingTagsAndFoods() {

		# Without eager loading (7 Queries)
		$recipes = Recipe::orderBy('title')->get();


		# Print results

		foreach($recipes as $recipe) {
			echo $recipe->title.' is cooked by '.$recipe->food->name.'<br>';
		foreach($recipe->tags as $tag) echo $tag->name.", ";
			echo "<br><br>";
		}

	}

}