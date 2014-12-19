<?php

class Food extends Eloquent {

	public function recipe() {
        
        # Define a one-to-many relationship.
        return $this->hasMany('Recipe');
    }
	
	public static function getIdNamePair() {
		
		$foods = Array();
		
		$collection = Food::all();
	
	foreach($collection as $food) {
			$foods[$food->id] = $food->name;
		}
		return $foods;
	}

	
}