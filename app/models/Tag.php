<?php

class Tag extends Eloquent { 

    public function recipes() {
	
		
	
        # Tags belong to many Books
        return $this->belongsToMany('Recipe');
    }
}