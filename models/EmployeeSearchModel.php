<?php

//Provides functionality for JQuery-responsive searches on employee records
class EmployeeSearchModel
{
	private $db;
	public $result;
	
	public function __construct($searchString)
	{
		require_once('lib/Database.php');
		$config = require_once('inc/config.php');
		$this->db = new Database($config);
		$this->getEmployeeList($searchString);
	}
	
	public function getEmployeeList($searchString)
	{
		//Construct the query, execute and store the results in employeeData
		$statement = "SELECT `id`, `f_name`, `s_name` FROM `users` WHERE f_name LIKE CONCAT('%',?,'%') ORDER BY s_name ASC";
		$stmt = $this->db->connection->prepare($statement);
		$stmt->bind_param("s", $searchString);
		$stmt->execute();
		//Place the results into an array
		$stmt->bind_result($id, $f_name, $s_name);
		while ($stmt->fetch()) {
    		$this->result[] = $id. " - " .$f_name. " " .$s_name;
		}
		$stmt->close(); 
	}
}