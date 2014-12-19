<?php


class Recipe extends Eloquent {

	protected $guarded = array('id','created_at', 'updated_at');

	public function food() {

        # Define an inverse one-to-many relationship.
        return $this->belongsTo('Food');
    }

    public function tags() {
        # Books belong to many Tags
        return $this->belongsToMany('Tag');
    }

	 /**
	    * This array will compare an array of given tags with existing tags
	    * and figure out which ones need to be added and which ones need to be deleted
	    */
	    public function updateTags($new = array()) {
	        // Go through new tags to see what ones need to be added
	        foreach($new as $tag) {
	            if(!$this->tags->contains($tag)) {
	                $this->tags()->save(Tag::find($tag));
	            }
	        }
	        // Go through existing tags and see what ones need to be deleted
	        foreach($this->tags as $tag) {
	            if(!in_array($tag->pivot->tag_id,$new)) {
	                $this->tags()->detach($tag->id);
	            }
	        }
    }
	/**
    * Search among books, authors and tags
    * @return Collection
    */

	public static function search($query) {
        # If there is a query, search the library with that query
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

		# Otherwise, just fetch all books
        else {
            # Eager load tags and author
            $recipes = Recipe::with('tags','food')->get();
        }

		return $recipes;
    }

}