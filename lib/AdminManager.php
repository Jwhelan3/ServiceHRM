<?php


/*Allows additional functionality on top of the systemmanager class
for the most secure pages in the system.*/
require_once('lib/SystemController.php');

class AdminManager extends SystemController
{
	//Requires initialisation with the page's name
	public function __construct()
	{
		//Call the parent's constructor to initialise the system
		parent::__construct();
		
		//Add extra checks to ensure the user is an administrator
		if (!$this->pageData['admin'])
		{
			//User is not an administrator - kick them back to the dashboard
			header("Location: ServiceHRM.php?action=Dashboard");
			
			//Create a log entry
			$this->Audit->CreateEntry($_SESSION['userID'], "Unauthorised admin access attempt");
		}
	}
}

?>