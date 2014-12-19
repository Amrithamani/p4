<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	
	public function __construct() {
		# Any submissions via POST need to pass the CSRF filter
		$this->beforeFilter('csrf', array('on' => 'post'));

	
	}

}
