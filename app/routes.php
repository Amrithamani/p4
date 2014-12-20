<?php

	Route::get('/classes', function() {
	echo Paste\Pre::render(get_declared_classes(),'');
	});



	Route::get('/', 'IndexController@getIndex');



	Route::get('/signup', 'UserController@getSignup');
	Route::get('/login', 'UserController@getLogin' );
	Route::post('/signup', 'UserController@postSignup' );
	Route::post('/login', 'UserController@postLogin' );
	Route::get('/logout', 'UserController@getLogout' );



	Route::get('/recipe', 'RecipeController@getIndex');
	Route::get('/recipe/edit/{id}', 'RecipeController@getEdit');
	Route::post('/recipe/edit', 'RecipeController@postEdit');
	Route::get('/recipe/create', 'RecipeController@getCreate');
	Route::post('/recipe/create', 'RecipeController@postCreate');
	Route::post('/recipe/delete', 'RecipeController@postDelete');


	Route::resource('tag', 'TagController');



	Route::controller('debug', 'DebugController');




	Route::get('/demo/collections', 'DemoController@collections');



	Route::get('/demo/crud-read', 'DemoController@crudRead');
	Route::get('/demo/crud-delete', 'DemoController@crudDelete');

	Route::get('/demo/collections', 'DemoController@collections');
	Route::get('/demo/query-responsibility', 'DemoController@queryResponsibility');

	Route::get('/demo/query-relationships-food', 'DemoController@queryRelationshipsFood');
	Route::get('/demo/query-eager-loading-foods', 'DemoController@queryEagerLoadingFoods');
	Route::get('/demo/query-eager-loading-tags-and-foods', 'DemoController@queryEagerLoadingTagsAndFoods');

