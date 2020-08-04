<?php

//Department CRUD operations
class DepartmentModel
{
	private $db;
	public $numberOfDepartments = 0;
	public $numberOfEmps = 0;
	
	public function __construct($dbLink)
	{
		$this->db = $dbLink;
	}
	
	public function getCurrentDepartment($dID)
	{
		//Construct the query, execute and store the results in employeeData
		$statement = "SELECT * FROM departments WHERE id = ? LIMIT 1";
		$stmt = $this->db->connection->prepare($statement);
		try {
			$stmt->bind_param("i", $dID);
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
	
	public function getDepartmentList()
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
				$this->numberOfDepartments++;
			}
			//$this->result = 
		}
		catch(Exception $e) {
			echo "Something went wrong.";
			return 0;
		}
		finally {
			$stmt->close(); 
		}
		
		return $this->numberOfDepartments;
	}
        
        //Takes a manager's ID and returns all departments they own
        public function getIDList($manager_id) {
            //Fetch the users from the database
                $result[0] = 0;
		$statement = "SELECT id FROM departments WHERE manager_id = ?";
		$stmt = $this->db->connection->prepare($statement);
                $stmt->bind_param("i", $manager_id);
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
	
	public function employeesByDepartment($departmentID)
	{
		$statement = "SELECT id, f_name, s_name, job_title FROM `users` WHERE department_id = ? ORDER BY s_name ASC";
		$stmt = $this->db->connection->prepare($statement);
		try {
			$stmt->bind_param("i", $departmentID);
			$stmt->execute();
			$stmt->bind_result($id, $f_name, $s_name, $job_title);
			while ($stmt->fetch()) {
    			$this->result[] = array("id"=>$id, "name"=>($f_name. " " .$s_name), "job_title"=>$job_title);
				$this->numberOfEmps++;
			}
		}
		
		catch(Exception $e) {
			return false;
		}
		
		finally {
			$stmt->close();
		}
	}
}