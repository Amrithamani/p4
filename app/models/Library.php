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
	
	/**
	* @param String $query
	* @return Array $results
	*/
	public function search($query) {
		# If any books match our query, they'll get stored in this array
		$results = Array();
		# Loop through the books looking for matches
		foreach($this->recipes as $title => $recipe) {
					
			# First compare the query against the title
			if(stristr($title,$query)) {
			
				# There's a match - add this book the the $results array
				$results[$title] = $recipe;
			}
			# Then compare the query against all the attributes of the book (author, tags, etc.)
			else {
						
				if(self::search_recipe_attributes($recipe,$query)) {
					# There's a match - add this book the the $results array
					$results[$title] = $recipe;
				}
			}
		}
		return $results;
	}
	/**
	* Resursively search through a book's attributes looking for a query match
	* @param Array $attributes
	* @param String $query
	* @return Boolean
	*/
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
