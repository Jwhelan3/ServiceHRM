<?php

//Reading methods for multiple users of the system
class UserModel
{
	private $db;
	
	public function __construct($dbLink)
	{
		$this->db = $dbLink;
	}
	
	//Get the details for the employee currently using the system
	public function getCurrentEmployee()
	{
		//Get the user's ID from the session data
		$userID = $_SESSION['userID'];
		
		//Construct the query, execute and store the results in employeeData
		$statement = "SELECT * FROM users WHERE id = ?";
		$stmt = $this->db->connection->prepare($statement);
		$stmt->bind_param("i", $userID);
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
	
	//Get a list of all current employees in the systemm
	public function getUserList()
	{
		//Fetch the users from the database
		$statement = "SELECT id, f_name, s_name FROM users";
		$stmt = $this->db->connection->prepare($statement);
		$stmt->execute();
		$userList = $stmt->get_result()->fetch_assoc();
		$stmt->close();
		
		//Return the list
		return $userList;
	}
        
        //Get a list of all current employee IDs
	public function getIDList()
	{
		//Fetch the users from the database
                $result[0] = 0;
		$statement = "SELECT id FROM users";
		$stmt = $this->db->connection->prepare($statement);
		$stmt->execute();
                $res = $stmt->get_result();
                $i = 0;
                while($row = $res->fetch_assoc()){
                    $result[$i] = $row['id'];
                    $i++;
                }
		$stmt->close();
		
		//Return the list
		return $result;
	}
}