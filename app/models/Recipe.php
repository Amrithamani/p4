<?php


class Recipe extends Eloquent {

	protected $guarded = array('id','created_at', 'updated_at');

	public function food() {

        # Define an inverse one-to-many relationship.
        return $this->belongsTo('Food');
    }

    public function tags() {

        return $this->belongsToMany('Tag');
    }

	    public function updateTags($new = array()) {


	        foreach($new as $tag) {
	            if(!$this->tags->contains($tag)) {
	                $this->tags()->save(Tag::find($tag));
	            }
	        }


	        foreach($this->tags as $tag) {
	            if(!in_array($tag->pivot->tag_id,$new)) {
	                $this->tags()->detach($tag->id);
	            }
	        }
    }


	public static function search($query) {

        if($query) {

			# Eager load tags and author
            $recipes = Recipe::with('tags','food')
            ->whereHas('food', function($q) use($query) {
                $q->where('name', 'LIKE', "%$query%");
            })
            ->orWhereHas('tags', function($q) use($query) {
                $q->where('name', 'LIKE', "%$query%");
            })
            ->orWhere('title', 'LIKE', "%$query%")
            ->orWhere('created', 'LIKE', "%$query%")
            ->get();

		}


        else {

            $recipes = Recipe::with('tags','food')->get();
        }

		return $recipes;
    }

}