<?php

//Require the Manager class
require_once('lib/System.php');

//This class extends the system class to add user functionality, designed to run concurrently to System and View managers
class User_Manager extends System
{	
	//Construct the class
	public function __construct()
	{
		//Call the parent's constructor to initialise the System class
		parent::__construct();
	}
	
	//Create a new user: Requires a first name, surname, email & password
	public function CreateUser($fName, $sName, $email, $password)
	{
		//$this->db = self::$db;
		$errorDetected = false;	//Flag - user can only be created if this is true at the final check
		$returnMessage = "";	//Message to return to the user

		//--Check for errors
			//Is the email valid?
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			//The provided email addresses wasn't a valid email - inform the user
			$errorDetected = true;
			$returnMessage .= "</br> The email address is invalid.";
		}
		
			//Is the password secure enough?
		if(strlen($password) <= 5)
		{
			//The password is too short
			$errorDetected = true;
			$returnMessage .= "</br> The password is too short - please choose a password that is 5 or more characters in length.";
		}
		
		if(strlen($password) >30)
		{
			//The password is too long
			$errorDetected = true;
			$returnMessage .= "</br> The password is too long - please choose a password that is 30 characters or less.";
		}
		
		//Check that the email address isn't already in use
			//Query the database
		$statement = "SELECT email FROM `users` WHERE email = ?";
		$stmt = $this->db->connection->prepare($statement);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$queryResult = $stmt->get_result()->fetch_assoc();
		$stmt->close();
		
		//Does the email address already exist?
		if($queryResult)
		{
			//Email exists and cannot be used again
			$errorDetected = true;
			$returnMessage .= "</br> This email address is already in use.";
		}
		
		
		//--End of error checking
		
		/*Post validation processing
		Were errors found?
		*/
		if($errorDetected)
		{
			//Errors were detected - return to user
			return $returnMessage;
		}
		
		else
		{
			//Bring in the Security class and create a Security object
			require_once('lib/Security.php');
			$Security = new Security();
			//Hash the password
			$password = $Security->PasswordHash($password);
			
			//No errors - create the user
			$statement = "INSERT INTO `users` (email, password, f_name, s_name, date_created) VALUES (?, ?, ?, ?, now())";
			$stmt = $this->db->connection->prepare($statement);
			$stmt->bind_param("ssss", $email, $password, $fName, $sName);
			$stmt->execute();
			
			//Operation complete - get the auto-assigned ID
			$userID = mysqli_insert_id($this->db->connection);
			
			//Inform the user
			$returnMessage = "User created successfully.";
			$this->Audit->CreateEntry($userID, "User created successfully");
			return $returnMessage;
		}
	}
	
	//Attempt to login with a provided email and password
	public function Login($email, $password)
	{
		$result = false;	//Set a flag to determine whether the login was successful
		
		//Check whether the provided email exists - return the password incase it does
		$statement = "SELECT id, password FROM `users` WHERE email = ?";
		$stmt = $this->db->connection->prepare($statement);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$queryResult = $stmt->get_result()->fetch_assoc();
		
		//Check if the email was returned
		if($queryResult)
		{
			//Email exists - now try the password
			$hash = $queryResult['password'];
			$userID = $queryResult['id'];
			
			//Bring in the security class to compare the hashes
			require_once('lib/Security.php');
			$Security = new Security();
			$result = $Security->PasswordVerify($password, $hash);
			
			//Result of the hash comparison
			if($result)
			{
				//Password hashes match - store the successful login in the audit logs
				$this->Audit->CreateEntry($userID, "Successful login");
				
				//Initialise the session variables
				$_SESSION['userID'] = $userID;
			}
			
			else
			{
				//Login failed - create a log entry with the User ID
				$this->Audit->CreateEntry($userID, "Failed login attempt");
			}
		}
		
		$stmt->close();	//Prepared statement no longer needed
		return $result;	//This will only be true if the email and password checks succeeded
	}
}