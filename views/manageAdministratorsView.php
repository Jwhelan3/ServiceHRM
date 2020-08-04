<?php

//Manage the administrators & HR members of the system
require_once('lib/ViewManager.php');
class ManageAdministratorsView extends ViewManager
{
	private $pageName = "Manage Administrators";
	
	public function __construct($dbLink)
	{
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
	
	//The page contents specific to this page
	public function pageContent()
	{
		$content = "";
		return $content;
	}
}

?>