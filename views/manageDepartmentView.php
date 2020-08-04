<?php

//View component to manage and existing department
require_once('lib/ViewManager.php');

class ManageDepartmentView extends ViewManager
{
	//Private data members utilised to populate the form
	private $pageName = "Manage Department";
	private $model;
	private $dID;
	private $empList;
	
	public function __construct($dbLink, $model, $dID)
	{
		$this->dID = $dID;
		$this->model = $model;
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
	
	//The page contents specific to this page
	public function pageContent()
	{
		$departmentData = $this->model->getCurrentDepartment($this->dID);
		$departmentData = $this->model->result;
		
		if ($departmentData['parent_department'] == 0)
		{
			//No parent department, overload with default text
			$departmentData['parent_department'] = "No parent department";
		}
		
		else
		{
			//Load the details of the parent department
			$parentDept = $this->model->getCurrentDepartment($departmentData['parent_department']);
			$parentDept = $this->model->result;
			$departmentData['parent_department'] = '<a href="ServiceHRM.php?action=ManageDepartment&deptID='.$departmentData['parent_department'].'">'.$parentDept['department_name'].'</a>';
		}
		
		//Get a list of employees
		$this->model->employeesByDepartment($this->dID);
		$empList = '<tr>
      <td>This department has no assigned emloyees</td>
      <td></td>
    </tr>';
		
		//If this department has assigned employees, display their details. Otherwise, indicate that there are no employees
		if ($this->model->numberOfEmps > 0)
		{
			$empList = "";
			for ($i = 0; $i < $this->model->numberOfEmps; $i++)
			{
				$empList .= 
	'<tr>
      <td>'.$this->model->result[$i]['id'].' - '.$this->model->result[$i]['name'].'</td>
      <td>'.$this->model->result[$i]['job_title'].'</td>
    </tr>';
			}
		}
		

		$content = '
		<!doctype html>
		<html>
		<head>
		<meta charset="utf-8">
		<script>
		deptID = '.$this->dID.'
		$( function() {
		//Send the updated details to the Listener methods
	var form = $("#manageDepartment");
	
	form.submit(function(e) {
		e.preventDefault(); // Override the default submit behaviour
    	$.ajax({
           type: "POST",
           url: "Listener.php",
		   data: {
			   action: "manageDepartment",
			   deptID: deptID,
			   deptName: $("#dName").val(),
			   deptLevel: $("#hLevel").val(),
			   manager: $("#manager").val()
		   },
        		action: form.serialize(), //Prepare the form for sending
           		success: function(action)
           {
		   	//Show the response
            alert(action);
           }
		   
         });
		 });
		} );
		 </script>
		 </head>
		 <body>
<form name="manageDepartment" id="manageDepartment" action="Listener.php" method="post">
<table width="75%" border="1" class="infoView">
  <tbody>
    <tr>
      <th colspan="2" scope="col">Department Details</th>
    </tr>
    <tr>
      <td>Department ID:</td>
      <td>'.$departmentData['id'].'</td>
    </tr>
    <tr>
      <td>Name:</td>
      <td><input name="dName" id ="dName" type="text" value="'.$departmentData['department_name'].'"></td>
    </tr>
    <tr>
      <td>Hierarchy Level:</td>
      <td><input name="hLevel" type="text" id="hLevel" value="'.$departmentData['department_level'].'"></td>
    </tr>
    <tr>
      <td>Manager:</td>
      <td><input name="manager" id="manager" type="text" value="'.$departmentData['manager_id'].'"></td>
    </tr>
    <tr>
      <td>Parent Department:</td>
      <td>'.$departmentData['parent_department'].'</td>
    </tr>
    <tr>
      <td>Total Employees:</td>
      <td>0</td>
    </tr>
	<tr>
      <td></td>
      <td><button name="saveChanges">Save Changes</button></td>
    </tr>
  </tbody>
</table></form>
<p>&nbsp;</p>
<table width="75%" border="1">
  <tbody>
    <tr>
      <th colspan="2" scope="col">Members</th>
    </tr>
    '.$empList.'
  </tbody>
</table>
</body>
</html>';
		return $content;
	}
}

?>