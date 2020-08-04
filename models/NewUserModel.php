<?php

//Reading methods for multiple users of the system
class NewUserModel
{
	private $db;
	
	public function __construct()
	{
		require_once('lib/Database.php');
		$config = require_once('inc/config.php');
		$this->db = new Database($config);
    }
    
    public function checkIfEmailInUse($email)
    {
        $statement = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->connection->prepare($statement);
        $stmt->bind_param("s", $email);
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

	public function createUser($f_name, $s_name, $email, $password, $job_title)
	{
		//Insert the row
		$statement = "INSERT INTO users (f_name, s_name, email, password, job_title, date_created) VALUES (?, ?, ?, ?, ?, now())";
		$stmt = $this->db->connection->prepare($statement);
		$stmt->bind_param("sssss", $f_name, $s_name, $email, $password, $job_title);
		$stmt->execute();
		$stmt->close();
	}
}