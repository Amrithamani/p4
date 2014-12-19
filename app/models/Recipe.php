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