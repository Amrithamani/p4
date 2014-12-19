<?php

class Tag extends Eloquent { 
	
	protected $fillable = array('name');
	
    public function recipes() {
	
		
	
        # Tags belong to many Books
        return $this->belongsToMany('Recipe');
    }
}