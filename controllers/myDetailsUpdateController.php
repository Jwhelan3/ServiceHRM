<?php

//This inherits from the SystemController - include the class
require_once('lib/SystemController.php');

class MyDetailsUpdateController extends SystemController
{
	public function __construct()
	{
		//Instantiate the parent
		parent::__construct();
		$employeeDetails = $this->getDetails();
		$this->loadView($employeeDetails);
	}
	
	//Fetch the employee details from the user model
	private function getDetails()
	{
		require_once('models/UserModel.php');
		$userModel = new UserModel($this->db);
		$employeeDetails = $userModel->getCurrentEmployee();
		return $employeeDetails;
	}
	
	//Draw the page contents
	private function loadView($employeeDetails)
	{
		//Fetch the view
		require_once('views/myDetailsUpdateView.php');
		$view = new MyDetailsUpdateView($this->db, $employeeDetails);
	}
}