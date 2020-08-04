<?php

//This acts as the home view
require_once('lib/ViewManager.php');
class DashboardView extends ViewManager
{
	private $pageName = "Dashboard";
	
	public function __construct($dbLink)
	{
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
	
	//The page contents specific to this page
	public function pageContent()
	{
            $content = "Welcome to the ServiceHRM HR self-service system. ";
            return $content;
	}
}

?>