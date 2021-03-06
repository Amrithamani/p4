<?php
class Clean {
	public $tables;
	public function __construct() {


	    DB::statement('SET FOREIGN_KEY_CHECKS=0'); # Disable FK constraints so that all rows can be deleted, even if there's an associated FK
	    $this->tables = Array('recipes', 'foods', 'tags', 'users', 'recipe_tag', 'migrations');
	    $this->truncate();
	    $this->drop();
	    Artisan::call('migrate');
	}

	public function drop() {
		$results = '';
		foreach($this->tables as $table) {
			if(Schema::hasTable($table)) {
	            Schema::drop($table);
	            $results .= 'Dropped '.$table.'<br>';
	        }
	        else {
	           $results .= $table.' did not exist.<br>';
	        }
		}
		return $results;
	}
	public function truncate() {

	    $results = '';

	    foreach($this->tables as $table) {
	        if(Schema::hasTable($table)) {
	            DB::statement('TRUNCATE '.$table);
	            $results .= 'Truncated '.$table.'<br>';
	        }
	        else {
	           $results .= $table.' did not exist.<br>';
	        }
	    }
	    return $results;
	}
}