<?php


class Recipe extends Eloquent {

	public function food() {
       
	   protected $guarded = array('id');
		
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('Food');
    }
    public function tags() {
        # Books belong to many Tags     
        return $this->belongsToMany('Tag');
    }

}