<?php

//CRUD operations for employees, associated with the Employee and Departments tables
class EmployeeDetailsModel
{
	private $db;
	public $result;
        private $userID;
	public $numberOfEmps = 0;
        public $employeeData;
	
	public function __construct($userID)
	{
		require_once('lib/Database.php');
		$config = require('inc/config.php');
		$this->db = new Database($config);
		$this->getEmployeeList($userID);
                $this->userID = $userID;
	}
        
        public function findEmployee()
        {
            //Construct the query, execute and store the results in employeeData
		$statement = "SELECT * FROM users WHERE id = ?";
		$stmt = $this->db->connection->prepare($statement);
		$stmt->bind_param("i", $this->userID);
		$stmt->execute();
		$this->employeeData = $stmt->get_result()->fetch_assoc();
		$stmt->close();
		$deptID = $this->employeeData['department_id'];
		//Insert the department's name for readability
		if ($deptID > 0)	//Ensure the employee is assigned to a valid department
		{
			$statement = "SELECT * FROM departments WHERE id = ?";
			$stmt = $this->db->connection->prepare($statement);
			$stmt->bind_param("i", $deptID);
			$stmt->execute();
			$this->departmentData = $stmt->get_result()->fetch_assoc();
			$this->employeeData['department_name'] = $this->departmentData['department_name'];
			$stmt->close();
		}
		
		//Return the resulting data inside an associative array
		return $this->employeeData;
        }
	
	public function getEmployeeList($userID)
	{
		//Construct the query, execute and store the results in employeeData
		$statement = "SELECT * FROM users WHERE id = ? LIMIT 1";
		$stmt = $this->db->connection->prepare($statement);
		try {
			$stmt->bind_param("i", $userID);
			$stmt->execute();
			//Place the results into an array
			$data = $stmt->get_result();
			$this->result = $data->fetch_assoc();
		}
		catch(Exception $e) {
			echo "Something went wrong.";
		}
		finally {
			$stmt->close(); 
		}
	}
	
	public function updateEmployeeRecord($userID, $fName, $sName, $dept, $jobTitle, $salary, $weeklyHours)
	{
		$statement = "UPDATE `users` SET `f_name` = ?, `s_name` = ?, `department_id` = ?, `job_title` = ?, `salary` = ?, `weekly_hours` = ? WHERE `id` = ?";
		$stmt = $this->db->connection->prepare($statement);
		try {
			$stmt->bind_param("ssisddi", $fName, $sName, $dept, $jobTitle,  $salary, $weeklyHours, $userID);
      
			//Return true if this was a success - false if not
			$stmt->execute() or die ($stmt->error);
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