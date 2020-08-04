<?php

//Allow CRUD operations for the notification table
class NotificationModel
{
	private $db;
	public $result;
	
        //OLD
        /*
	public function __construct()
	{
		require_once('lib/Database.php');
		$config = require_once('inc/config.php');
		$this->db = new Database($config);
	}*/
        
        //NEW
        public function __construct()
	{
		require_once('lib/Database.php');
		$config = require('inc/config.php');
		$this->db = new Database($config);
	}
	
	//Fetch the current notifications for the provided user
	public function getMyNotifications($userID)
	{
		$stmt = "SELECT * FROM notifications WHERE user_id = ? AND viewed = 0";
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
	
	//Add a new notification, adding the given text, to the provided user
	public function addNotification($userID, $text)
	{
		$stmt = "INSERT INTO `notifications` (`user_id`, `text`, `date`) VALUES (?, ?, now())";
		$stmt = $this->db->connection->prepare($stmt);
		$stmt->bind_param("is", $userID, $text);
		$stmt->execute();
                $this->result = true;
		$stmt->close();
	}
        
        public function markAsRead($userID)
        {
            $stmt = "UPDATE notifications SET viewed = 1 WHERE user_id = ?";
            $stmt = $this->db->connection->prepare($stmt);
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $this->result = true;
            $stmt->close();
        }
}