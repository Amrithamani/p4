<?php


	/**
	* Index
	*/

	Route::get('/', 'IndexController@getIndex');

	/**
	* User
	* (Explicit Routing)
	*/
	# Note: the beforeFilter for 'guest' on getSignup and getLogin is handled in the Controller

	Route::get('/signup', 'UserController@getSignup');
	Route::get('/login', 'UserController@getLogin' );
	Route::post('/signup', 'UserController@postSignup' );
	Route::post('/login', 'UserController@postLogin' );
	Route::get('/logout', 'UserController@getLogout' );

	/**
	* Book
	* (Explicit Routing)
	*/

	Route::get('/recipe', 'RecipeController@getIndex');
	Route::get('/recipe/edit/{id}', 'RecipeController@getEdit');
	Route::post('/recipe/edit', 'RecipeController@postEdit');
	Route::get('/recipe/create', 'RecipeController@getCreate');
	Route::post('/recipe/create', 'RecipeController@postCreate');
	Route::post('/recipe/delete', 'RecipeController@postDelete');

	/**
	* Tag
	* (Implicit RESTful Routing)
	*/
	Route::resource('tag', 'TagController');

	/**
	* Debug
	* (Implicit Routing)
	*/

	Route::controller('debug', 'DebugController');


	/**
	* Demos
	*/

	Route::get('/demo/csrf-example', 'DemoController@csrf');
	Route::get('/demo/collections', 'DemoController@collections');


	Route::get('/demo/crud-create', 'DemoController@crudCreate');
	Route::get('/demo/crud-read', 'DemoController@crudRead');
	Route::get('/demo/crud-update', 'DemoController@crudUpdate');
	Route::get('/demo/crud-delete', 'DemoController@crudDelete');

	Route::get('/demo/collections', 'DemoController@collections');
	Route::get('/demo/query-without-constraints', 'DemoController@queryWithoutConstraints');
	Route::get('/demo/query-with-constraints', 'DemoController@queryWithConstraints');
	Route::get('/demo/query-responsibility', 'DemoController@queryResponsibility');
	Route::get('/demo/query-with-order', 'DemoController@queryWithOrder');

	Route::get('/demo/query-relationships-food', 'DemoController@queryRelationshipsFood');
	Route::get('/demo/query-relationships-tags', 'DemoController@queryRelationshipstags');
	Route::get('/demo/query-eager-loading-foods', 'DemoController@queryEagerLoadingFoods');
	Route::get('/demo/query-eager-loading-tags-and-foods', 'DemoController@queryEagerLoadingTagsAndFoods');

