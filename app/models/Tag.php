<?php

class Tag extends Eloquent { 

    public function recipes() {
	
		protected $fillable = array('name');
	
        # Tags belong to many Books
        return $this->belongsToMany('Recipe');
    }
}