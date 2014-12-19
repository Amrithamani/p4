<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('recipes', function($table) {
		        # AI, PK
					$table->increments('id');

					# created_at, updated_at columns
					$table->timestamps();

					# General data...
					$table->string('title');
					$table->integer('food_id')->unsigned(); # Important! FK has to be unsigned because the PK it will reference is auto-incrementing
					$table->integer('created');
					$table->string('image');
					$table->string('site_link');

					# Define foreign keys...
					$table->foreign('food_id')->references('id')->on('foods');
						});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recipes');
	}

}
