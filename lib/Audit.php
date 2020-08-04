<?php

//Create an audit trail in the logs table with the provided parameters

class Audit 
{
	private $dbConnection;
	
	public function __construct($conn)
	{
		//Require a link to the database
		$this->dbConnection = $conn;
	}
	
	public function CreateEntry ($userID, $action)	//userID (int), action (string)
	{
		//Prepare an insert statement with the provided parameters
		$stmt = "INSERT INTO `logs` (user_id, action, timestamp) VALUES (?, ?, now())";
		
		//Insert into the database
		$stmt = $this->dbConnection->prepare($stmt);
		$stmt->bind_param("is", $userID, $action);
		$stmt->execute();
		
		//Insert complete - close the statement
		$stmt->close();
	}
}

?>