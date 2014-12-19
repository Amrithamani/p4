<?php
class FoodrecipeSeeder extends Seeder {
	public function run() {
		
		# Clear the tables to a blank slate
		DB::statement('SET FOREIGN_KEY_CHECKS=0'); # Disable FK constraints so that all rows can be deleted, even if there's an associated FK
		DB::statement('TRUNCATE recipes');
		DB::statement('TRUNCATE foods');
		DB::statement('TRUNCATE tags');
		DB::statement('TRUNCATE recipe_tag');
		DB::statement('TRUNCATE users');
		
		# Foods
    $apple = new Food;
    $apple->name = 'Apple';
    $apple->type = 'Fruit';
    $apple->calories = 53;
    $apple->save();

    $carrot = new Food;
    $carrot->name = 'Carrot';
    $carrot->type = 'Vegetable';
    $carrot->calories = 4;
    $carrot->save();

    $pasta = new Food;
    $pasta->name = 'Pasta';
    $pasta->type = 'Salad';
    $pasta->calories = 197;
    $pasta->save();
    
    # Tags (Created using the Model Create shortcut method)
    # Note: Tags model must have `protected $fillable = array('name');` in order for this to work
    
    $lunch        = Tag::create(array('name' => 'lunch'));
    $breakfast    = Tag::create(array('name' => 'breakfast'));
    $brunch       = Tag::create(array('name' => 'brunch'));
    $dinner       = Tag::create(array('name' => 'dinner'));
    
    # Recipes
    $popcorn = new Recipe;
    $popcorn->title = 'Apple popcorn ball';
	$popcorn->created =  2014;
    $popcorn->image = 'http://www.efoodsdirect.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/a/p/apples2.jpg';
    $popcorn->site_link = 'http://www.foodnetwork.com/recipes/articles/50-things-to-make-with-apples/things-to-make-with-apples.html';
    
    # Associate has to be called *before* the food is created (save())
    $popcorn->food()->associate($apple); # Equivalent of $gatsby->author_id = $fitzgerald->id
    $popcorn->save();
    
    # Attach has to be called *after* the recipe is created (save()), 
    # since resulting `recipe_id` is needed in the recipe_tag pivot table
    $popcorn->tags()->attach($lunch);
	$popcorn->tags()->attach($breakfast); 
    $popcorn->tags()->attach($brunch); 
    $popcorn->tags()->attach($dinner);
	
    
    $muffin = new Recipe;
    $muffin->title = 'Carrot muffins';
	$muffin->created = 2013; 
    $muffin->image = 'http://eatbelive.files.wordpress.com/2014/02/carrots-bunch.jpg';
    $muffin->site_link = 'http://allrecipes.com/Recipe/Carrot-Muffins/Detail.aspx?prop24=hn_slide1_Carrot-Muffins&evt19=1';
    $muffin->food()->associate($carrot);
    $muffin->save();
    
    $muffin->tags()->attach($lunch);   
    $muffin->tags()->attach($breakfast); 
    $muffin->tags()->attach($brunch); 
    $muffin->tags()->attach($dinner); 
    
    $plain = new Recipe;
    $plain->title = 'Plain pasta';
	$plain->created = 2012;
    $plain->image = 'http://www.pastaequipments.com/wp-content/uploads/2014/11/pasta-pama.jpg';
    $plain->site_link = 'http://allrecipes.com/Recipes/Pasta-and-Noodles/Homemade-Pasta/Main.aspx?evt19=1&src=hr_browsedeeper&soid=hr_coll_3';
    $plain->food()->associate($pasta);
    $plain->save();
    return 'Done';
	
    $plain->tags()->attach($lunch); 
    $plain->tags()->attach($breakfast); 
    $plain->tags()->attach($brunch);
	$plain->tags()->attach($dinner);
    
		$user = new User;
		$user->email = 'amrimani91@gmail.com';
		$user->password = Hash::make('hello');
		$user->save();
	}
}