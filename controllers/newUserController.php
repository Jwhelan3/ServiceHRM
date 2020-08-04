<?php

//This inherits from the SystemController - include the class
require_once('lib/SystemController.php');

//Controller for adding a new user to the system
class NewUserController extends SystemController
{
	public function __construct()
	{
		//Instantiate the parent
		parent::__construct();
		$this->loadView();

	}
	
	//Draw the page contents
	private function loadView()
	{
		//Fetch the view
		require_once('views/newUserView.php');
		$view = new NewUserView($this->db);
	}
}