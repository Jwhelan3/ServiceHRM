<?php

//This inherits from the SystemController - include the class
require_once('lib/SystemController.php');

//Controller for adding a new department for the system
class NewDepartmentController extends SystemController
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
		//Fetch the view and provide connectivity
		require_once('views/newDepartmentView.php');
		$view = new NewDepartmentView($this->db);
	}
}