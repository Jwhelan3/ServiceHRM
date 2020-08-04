<?php

//This inherits from the SystemController - include the class
require_once('lib/SystemController.php');

//LeavePlanner controller - most of the functionality is handled seperately in AJAX requests
class LeavePlannerController extends SystemController
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
		require_once('views/leavePlannerView.php');
		$view = new LeavePlannerView($this->db);
	}
}