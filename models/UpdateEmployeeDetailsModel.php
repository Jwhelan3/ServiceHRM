<?php

//Reading methods for multiple users of the system
class UpdateEmployeeDetailsModel
{
	private $db;
	
	public function __construct()
	{
		require_once('lib/Database.php');
		$config = require_once('inc/config.php');
		$this->db = new Database($config);
    }

    public function updateEmployeeRecord($userID, $fName, $sName, $addr1, $addr2, $addr3, $addr4, $postcode, $contact_number)
	{
        $statement = "UPDATE users SET `f_name` = ?, `s_name` = ?, `address_1` = ?, `address_2` = ?, `address_3` = ?, `address_4` = ?, `post_code` = ?, `contact_number` = ? WHERE `id` = ?";
        $stmt = $this->db->connection->prepare($statement);
		try {
			$stmt->bind_param("ssssssssi", $fName, $sName, $addr1, $addr2, $addr3, $addr4, $postcode, $contact_number, $userID);
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