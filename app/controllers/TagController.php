<?php

class TagController extends \BaseController {

	public function __construct() {


		parent::__construct();

		$this->beforeFilter('auth');

	}


	public function index() {
		$tags = Tag::all();
		return View::make('tag_index')->with('tags',$tags);
	}


	public function create() {
		return View::make('tag_create');
	}


	public function store() {
		$tag = new Tag;
		$tag->name = Input::get('name');
		$tag->save();

		return Redirect::action('TagController@index')->with('flash_message','Your tag been added.');
	}



	public function show($id) {
		try {
			$tag = Tag::findOrFail($id);
		}

		catch(Exception $e) {
			return Redirect::to('/tag')->with('flash_message', 'Tag not found');
		}

		return View::make('tag_show')->with('tag', $tag);

	}



	public function edit($id) {

		try {
			$tag = Tag::findOrFail($id);
		}

		catch(Exception $e) {
			return Redirect::to('/tag')->with('flash_message', 'Tag not found');
		}


		return View::make('tag_edit')->with('tag', $tag);
	}



	public function update($id) {

		try {
			$tag = Tag::findOrFail($id);
		}

		catch(Exception $e) {
			return Redirect::to('/tag')->with('flash_message', 'Tag not found');
		}

		$tag->name = Input::get('name');
		$tag->save();

		return Redirect::action('TagController@index')->with('flash_message','Your tag has been saved.');
	}



	public function destroy($id) {
		try {
			$tag = Tag::findOrFail($id);
		}

		catch(Exception $e) {
			return Redirect::to('/tag')->with('flash_message', 'Tag not found');
		}


		Tag::destroy($id);
		return Redirect::action('TagController@index')->with('flash_message','Your tag has been deleted.');

	}

}