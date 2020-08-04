<?php

//This inherits from the SystemController - include the class
require_once('lib/SystemController.php');
require_once('models/DepartmentModel.php');

//Controller for adding a new department to the system
class DepartmentController extends SystemController
{
	private $deptID;
	protected $model;
	
	public function __construct($deptID)
	{
		//Instantiate the parent
		parent::__construct();
		
		$this->model = new DepartmentModel($this->db);
		
		$this->deptID = $deptID;
		$this->loadView();
	}
	
	//No specific department to be managed - load a list of all departments
	public function defaultView()
	{
		//Fetch the view
		require_once('views/departmentView.php');
		$view = new DepartmentView($this->db, $this->model);
	}
	
	//A department ID has been provided
	public function modifyDepartment()
	{
		require_once('views/manageDepartmentView.php');	
		$view = new ManageDepartmentView($this->db, $this->model, $this->deptID);
	}
	
	//Draw the page contents
	private function loadView()
	{
		//Default view for list of departments
		if ($this->deptID == 0)
		{
			$this->defaultView();
		}
		
		else
		{
			$this->modifyDepartment();
		}
	}
}