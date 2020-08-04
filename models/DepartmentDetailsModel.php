<?php

//Department CRUD operations, with more granular levels of detail
class DepartmentDetailsModel
{
	private $db;
	public $result;
	
	public function __construct()
	{
		require_once('lib/Database.php');
		$config = require_once('inc/config.php');
		$this->db = new Database($config);
		$this->getDepartmentsList();
	}
	
	public function getDepartmentsList()
	{
		//Construct the query, execute and store the results in departmentData
		$statement = "SELECT id, department_name FROM departments ORDER BY department_name ASC";
		$stmt = $this->db->connection->prepare($statement);
		try {
			$stmt->execute();
			$stmt->bind_result($id, $department_name);
			//Place the results into an array
			while ($stmt->fetch()) {
				
    			$this->result[] = array("id"=>$id, "name"=>$department_name);
			}
			//$this->result = 
		}
		catch(Exception $e) {
			echo "Something went wrong.";
		}
		finally {
			$stmt->close(); 
		}
	}
	
	public function updateDepartment($deptID, $deptName, $deptLevel, $manager)
	{
		$statement = "UPDATE departments SET department_name = ?, department_level = ?, manager_id = ? WHERE id = ?";
		$stmt = $this->db->connection->prepare($statement);
		try {
			$stmt->bind_param("siii", $deptName, $deptLevel, $manager, $deptID);
			//Return true if this was a success - false if not
			$stmt->execute();
			return true;
		}
		catch(Exception $e) {
			return false;
		}
		finally {
			$stmt->close();
		}
	}
}