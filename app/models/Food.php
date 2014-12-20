<?php

class Food extends Eloquent {

	public function recipe() {

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