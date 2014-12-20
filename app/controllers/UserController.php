<?php

class UserController extends BaseController {



	public function __construct() {


		parent::__construct();

        $this->beforeFilter('guest',
		array(
				'only' => array('getLogin','getSignup')
			));
    }



	public function getSignup() {
		return View::make('user_signup');
	}



	public function postSignup() {

		$rules = array(
			'email' => 'required|email|unique:users,email',
			'password' => 'required|min:6'
		);


		$validator = Validator::make(Input::all(), $rules);


		if($validator->fails()) {
			return Redirect::to('/signup')
				->with('flash_message', 'Sign up failed; please fix the errors listed below.')
				->withInput()
				->withErrors($validator);
		}

		$user = new User;
		$user->email    = Input::get('email');
		$user->password = Hash::make(Input::get('password'));

		try {
			$user->save();
		}

		catch (Exception $e) {
			return Redirect::to('/signup')
				->with('flash_message', 'Sign up failed; please try again.')
				->withInput();
		}

		# Log in
		Auth::login($user);
		return Redirect::to('/')->with('flash_message', 'Welcome to Foodrecipes!');
	}


	public function getLogin() {
		return View::make('user_login');
	}



	public function postLogin() {

		$credentials = Input::only('email', 'password');


		if (Auth::attempt($credentials, $remember = false)) {
			return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
		}

		else {
			return Redirect::to('/login')
				->with('flash_message', 'Log in failed; please try again.')
				->withInput();
		}


	}



	public function getLogout() {

		# Log out
		Auth::logout();


		return Redirect::to('/');
	}

}