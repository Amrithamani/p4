<?php
class DebugController extends BaseController {
	/**
	* http://localhost/debug/index
	*
	* @return String
	*/
	
	public function getIndex() {
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
	}
	
	/**
	* Trigger an error to test debug display settings
	* http://localhost/debug/trigger-error
	*
	* @return Exception
	*/
	
	public function getTriggerError() {
		# Class Foobar should not exist, so this should create an error
		$food = new Foodrecipe;
	}
	
	/**
	* Print all available routes
	* http://localhost/debug/routes
	*
	* @return String
	*/
	
	public function getRoutes() {
		$routeCollection = Route::getRoutes();
		foreach ($routeCollection as $value) {
	    	echo "<a href='/".$value->getPath()."' target='_blank'>".$value->getPath()."</a><br>";
		}
	}
	
	/**
	* http://localhost/debug/books-json
	*
	* @return String
	*/
	
	public function getRecipesJson() {
		# Instantiating an object of the Library class
		$library = new Library(app_path().'/database/recipes.json');
		
		# Get the books
		$recipes = $library->get_recipes();
		# Debug
		return Pre::render($recipes, 'Recipes');
	}
	
	/**
	* Old seeder - have since moved to proper seeding
	* http://localhost/debug/books-json
	*
	* @return String
	*/
	
	public function seedRecipes() {
		
		return 'This seed will no longer work because the recipes table is no longer embedded with the food.';
		
		# Build the raw SQL query
		$sql = "INSERT INTO recipes (food,title,created,image,site_link) VALUES
		        ('Apple','Apple popcorn ball',2014,'http://www.efoodsdirect.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/a/p/apples2.jpg','http://www.foodnetwork.com/recipes/articles/50-things-to-make-with-apples/things-to-make-with-apples.html'),
				('Carrot','Carrot muffins',2013,'http://eatbelive.files.wordpress.com/2014/02/carrots-bunch.jpg','http://allrecipes.com/Recipe/Carrot-Muffins/Detail.aspx?prop24=hn_slide1_Carrot-Muffins&evt19=1'),
				('Pasta','Plain pasta',2012,'http://www.pastaequipments.com/wp-content/uploads/2014/11/pasta-pama.jpg','http://allrecipes.com/Recipes/Pasta-and-Noodles/Homemade-Pasta/Main.aspx?evt19=1&src=hr_browsedeeper&soid=hr_coll_3')
		        ";
		# Run the SQL query
		echo DB::statement($sql);
		
		# Get all the books just to test it worked
		$recipes = DB::table('recipes')->get();
		
		# Print all the books
		echo Paste\Pre::render($recipes,'');
	}
	
	/*
	* Test to make sure we can connect to MySQL
	*
	* @return String
	*/
	
	public function mysqlTest() {
	    # Print environment
	    echo 'Environment: '.App::environment().'<br>';
	    # Use the DB component to select all the databases
	    $results = DB::select('SHOW DATABASES;');
	    # If the "Pre" package is not installed, you should output using print_r instead
	    echo Pre::render($results);
	}
}