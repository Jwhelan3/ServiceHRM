<?php

/*
Utility library providing security functionality. Seperate from the rest
of the libraries to avoid unnessecary database operations.
*/

class Security
{	
	//Apply the bcrypt hash to a given password and return the resulting hash
	public function PasswordHash($string)
	{
		return password_hash($string, PASSWORD_DEFAULT);	//Apply the hash and store in $result
	}
	
	//Verify whether a password is correct or incorrect - requires the original hash
	//from the database to compare against
	public function PasswordVerify($attemptedPassword, $originalHash)
	{
		return password_verify($attemptedPassword, $originalHash);	//Return true (correct) or false (incorrect)
	}
}

?>