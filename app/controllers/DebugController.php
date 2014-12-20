<?php
class DebugController extends BaseController {

		public function __construct() {

			parent::__construct();
	}


	public function missingMethod($parameters = array()) {

		return 'Method "'.$parameters[0].'" not found';

	}



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


	public function getTriggerError() {
		# Class Foobar should not exist, so this should create an error
		$food = new Foodrecipe;
	}


	public function getRoutes() {
		$routeCollection = Route::getRoutes();
		foreach ($routeCollection as $value) {
	    	echo "<a href='/".$value->getPath()."' target='_blank'>".$value->getPath()."</a><br>";
		}
	}



	public function getRecipesJson() {


		# Instantiating an object of the Library class
		$library = new Library(app_path().'/database/recipes.json');

		# Get the recipes
		$recipes = $library->getRecipes();

		# Debug
		return Pre::render($recipes, 'Recipes');
	}



	public function getSeedRecipes() {

		return 'This seed will no longer work because the recipes table is no longer embedded with the food.';

		# Build the raw SQL query
		$sql = "INSERT INTO recipes (food,title,created,image,site_link) VALUES
		        ('Apple','Apple popcorn ball',2014,'http://www.efoodsdirect.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/a/p/apples2.jpg','http://www.foodnetwork.com/recipes/articles/50-things-to-make-with-apples/things-to-make-with-apples.html'),
				('Carrot','Carrot muffins',2013,'http://eatbelive.files.wordpress.com/2014/02/carrots-bunch.jpg','http://allrecipes.com/Recipe/Carrot-Muffins/Detail.aspx?prop24=hn_slide1_Carrot-Muffins&evt19=1'),
				('Pasta','Plain pasta',2012,'http://www.pastaequipments.com/wp-content/uploads/2014/11/pasta-pama.jpg','http://allrecipes.com/Recipes/Pasta-and-Noodles/Homemade-Pasta/Main.aspx?evt19=1&src=hr_browsedeeper&soid=hr_coll_3')
		        ";
		# Run the SQL query
		echo DB::statement($sql);

		# Get all the recipes just to test it worked
		$recipes = DB::table('recipes')->get();

		# Print all the recipes
		echo Paste\Pre::render($recipes,'');
	}



	public function getMysqlTest() {

	   # Print environment
	    echo 'Environment: '.App::environment().'<br>';

	    $results = DB::select('SHOW DATABASES;');

	    echo Pre::render($results);
	}

	public function getSessionsAndCookies() {

		# Log in check
	    if(Auth::check())
	        echo "You are logged in: ".Auth::user();
	    else
	        echo "You are not logged in.";
	    echo "<br><br>";

	    # Cookies
	    echo "<h1>Your Raw, encrypted Cookies</h1>";
	    echo Paste\Pre::render($_COOKIE,'');

	    # Decrypted cookies
	    echo "<h1>Your Decrypted Cookies</h1>";
	    echo Paste\Pre::render(Cookie::get(),'');
	    echo "<br><br>";

	    # All Session files
	    echo "<h1>All Session Files</h1>";
	    $files = File::files(app_path().'/storage/sessions');

	    foreach($files as $file) {
	        if(strstr($file,Cookie::get('laravel_session'))) {
	            echo "<div style='background-color:yellow'><strong>YOUR SESSION FILE:</strong><br>";
	        }
	        else {
	            echo "<div>";
	        }
	        echo "<strong>".$file."</strong>:<br>".File::get($file)."<br>";
	        echo "</div><br>";
	    }
	    echo "<br><br>";

	    # Your Session Data
	    $data = Session::all();
	    echo "<h1>Your Session Data</h1>";
	    echo Paste\Pre::render($data,'Session data');
	    echo "<br><br>";

	    # Token
	    echo "<h1>Your CSRF Token</h1>";
	    echo Form::token();
	    echo "<script>document.querySelector('[name=_token]').type='text'</script>";
	    echo "<br><br>";
	}
}