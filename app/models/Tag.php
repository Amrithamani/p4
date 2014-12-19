<?php

class Tag extends Eloquent {

	protected $fillable = array('name');

    public function recipes() {

        # Tags belong to many Books
        return $this->belongsToMany('Recipe');
    }

	# Model events...
	# http://laravel.com/docs/eloquent#model-events

	public static function boot() {

		parent::boot();

		static::deleting(function($tag) {
            DB::statement('DELETE FROM recipe_tag WHERE tag_id = ?', array($tag->id));
        });

	}

	public static function getIdNamePair() {

	       $tags = Array();

	       $collection = Tag::all();

	       foreach($collection as $tag) {
	            $tags[$tag->id] = $tag->name;
	        }
	        return $tags;
    }

}