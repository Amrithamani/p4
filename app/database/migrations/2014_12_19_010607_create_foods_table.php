<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('foods', function($table) {
					# AI, PK
					$table->increments('id');

					# created_at, updated_at columns
					$table->timestamps();

					# General data...
					$table->string('name');
					$table->date('type');
					$table->integer('calories');

					# Define foreign keys...
					# none needed
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('foods');
	}

}
