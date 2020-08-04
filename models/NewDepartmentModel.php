<?php

//Reading methods for multiple users of the system
class NewDepartmentModel
{
	private $db;
	
	public function __construct()
	{
		require_once('lib/Database.php');
		$config = require_once('inc/config.php');
		$this->db = new Database($config);
    }
    
    public function checkIfNameInUse($name)
    {
        $statement = "SELECT * FROM departments WHERE department_name = ?";
        $stmt = $this->db->connection->prepare($statement);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) 
        {
            return true;
        }

        else
        {
            return false;
        }
    }

	public function createDepartment($department_name, $manager, $level)
	{
		//Insert the row
		$statement = "INSERT INTO departments (department_name, manager_id, department_level) VALUES (?, ?, ?)";
		$stmt = $this->db->connection->prepare($statement);
		$stmt->bind_param("sii", $department_name, $manager, $level);
		$stmt->execute();
		$stmt->close();
	}
}