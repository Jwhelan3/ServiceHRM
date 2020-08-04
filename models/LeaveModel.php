<?php

//This model allows leave to be read, updated and deleted for use with AJAX & the FullCalendar library
class LeaveModel
{
	private $db;
	public $result;
	
	public function __construct()
	{
		include_once('lib/Database.php');
		$config = require('inc/config.php');
		$this->db = new Database($config);
	}
	
	//Get the current leave from the system associated with the current user
	public function fetchLeave($userID)
	{
		$stmt = "SELECT start_date AS start, end_date AS end, type AS title FROM `leave` WHERE user_id = ?";
		$stmt = $this->db->connection->prepare($stmt);
		$stmt->bind_param("i", $userID);
		$stmt->execute();
		//Place the results into an array
		$data = $stmt->get_result();
		$res = array();
		while ($row = mysqli_fetch_assoc($data)) 
		{
                    $row['title'] = "Annual Leave";
                    array_push($res, $row);
                }
		$this->result = $res;
		$stmt->close();
	}
        
        public function fetchLeaveRequests($userID)
	{
		$stmt = "SELECT id, user_id, start_date AS start, end_date AS end, type AS title FROM `leave` WHERE user_id = ? AND approved = 0";
		$stmt = $this->db->connection->prepare($stmt);
		$stmt->bind_param("i", $userID);
		$stmt->execute();
		//Place the results into an array
		$data = $stmt->get_result();
		$res = array();
		//$this->result = $data->fetch_assoc();
		while ($row = mysqli_fetch_assoc($data)) 
		{
        	array_push($res, $row);
    	}
		$this->result = $res;
		$stmt->close();
	}
	
	//Add a new leave entry, adjusting the dates for incompatability with the third-party library
	public function addLeave($userID, $start, $end, $type)
	{
		$stmt = "INSERT INTO `leave` (user_id, start_date, end_date, type, request_date, approved) VALUES (?, ? + INTERVAL 1 DAY, ? + INTERVAL 1 DAY, ?, now(), 0)";
		$stmt = $this->db->connection->prepare($stmt);
		if ($stmt)
		{
			$stmt->bind_param("isss", $userID, $start, $end, $type);
			$stmt->execute();
			$stmt->close();
			return true;
		}
		
		else
		{
			return false;
		}
	}
        
        //Find the user a leave record is associated with
        public function getUserId($leaveID) {
            $stmt = "SELECT `user_id` FROM `leave` WHERE `id` = ?";
            $stmt = $this->db->connection->prepare($stmt);
            $stmt->bind_param("i", $leaveID);
            $stmt->execute();
            $res = $stmt->get_result()->fetch_assoc();
            $data = $res['user_id'];
            $stmt->close();
            return $data;
        }
        
        //Approve a leave request
        public function approveLeave($leaveID) {
            $stmt = "UPDATE `leave` SET `approved` = 1 WHERE `id` = ?";
            $stmt = $this->db->connection->prepare($stmt);
            $stmt->bind_param("i", $leaveID);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        
        //Delete a leave record - used to denote that a request was rejected
        public function deleteLeave($leaveID) {
            $stmt = "DELETE FROM `leave` WHERE `id` = ?";
            $stmt = $this->db->connection->prepare($stmt);
            $stmt->bind_param("i", $leaveID);
            $stmt->execute();
            $stmt->close();
            return true;
        }
}