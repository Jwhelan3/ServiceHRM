<?php

//View component for managing a department
require_once('lib/ViewManager.php');

class DepartmentView extends ViewManager
{
	private $pageName = "Manage Departments";
	private $model;
	private $dList;
	
	public function __construct($dbLink, $model)
	{
		$this->model = $model;
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
	
	//Display a list of active departments in the system
	private function displayList()
	{
		//Fetch the list
		$this->model->getDepartmentList();
		$num = $this->model->numberOfDepartments;
		for ($i = 0; $i < $num; $i++)
		{ 
			$this->dList .=
   '<tr>
      <td><a href="ServiceHRM.php?action=ManageDepartment&deptID='.$this->model->result[$i]['id'].'">'.$this->model->result[$i]['id'].' - '.$this->model->result[$i]['name'].'</a></td>
   </tr>';
		}
	}
	
	//The page contents specific to this page
	public function pageContent()
	{
		$this->displayList();
		$content = '
<div align="center"><table width="60%" border="1" class="infoView">
  <tbody>
    <tr>
      <th scope="col">Manage a Department</th>
    </tr>
    	  '.$this->dList.'
  </tbody>
</table></div>
		';
		return $content;
	}
}

?>