<?php

//This inherits from the SystemController - include the class
require_once('lib/SystemController.php');

class ManageEmployeesController extends SystemController
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
		require_once('views/manageEmployeesView.php');
		$view = new ManageEmployeesView($this->db);
	}
}