<?php

/*
Controls the hierarchy of secure-area pages (logged-in)
Extends the system class to include extra authentication checks
*/

require_once('lib/System.php');	//Bring in the system class

class SystemController extends System
{
	//Force the parents constructor to initialise the required variables
	public function __construct()	//Require the page name for the HTML headers
	{
		parent::__construct();
		
		//Ensure that the user is logged in
		//session_start();
		if(!isset($_SESSION['userID']))
		{
			//User hasn't logged in: Redirect to the homepage
			header("Location: index.php");
		}		
	}
}

?>