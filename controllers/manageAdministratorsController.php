<?php

//This inherits from the SystemController - include the class
require_once('lib/SystemController.php');

class ManageAdministratorsController extends SystemController
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
		require_once('views/manageAdministratorsView.php');
		$view = new ManageAdministratorsView($this->db);
	}
}