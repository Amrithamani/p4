<?php

class Library {

	// Properties (Variables)
	private $recipes; // Array
	private $path; // String

	// Methods (Functions)
	public function setPath($path) {
		$this->path = $path;
	}

	public function getPath() {
		return $this->path;
	}

	public function getRecipes() {
		// Get the file
    	$recipes = File::get(app_path().'/database/recipes.json');

		// Convert to an array
    	$this->recipes = json_decode($recipes,true);
    	return $this->recipes;
	}


	public function search($query) {

		$results = Array();

		foreach($this->recipes as $title => $recipe) {


			if(stristr($title,$query)) {


				$results[$title] = $recipe;
			}


			else {

				if(self::search_recipe_attributes($recipe,$query)) {

					$results[$title] = $recipe;
				}
			}
		}
		return $results;
	}

	private function search_recipe_attributes($attributes,$query) {

		foreach($attributes as $k => $value) {

		  	# Dig deeper
		    if (is_array($value)) {
		    	return self::search_recipe_attributes($value,$query);
		    }

				if(stristr($value,$query)) {
					return true;
				}
		}
		return false;
	}

}
