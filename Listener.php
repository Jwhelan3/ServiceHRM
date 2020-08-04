<?php
session_start();
//error_reporting(0);	//No errors should be outputted on this script

//Check whether the HTTP request was a post
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	//Add a new user
	if($_REQUEST['action'] == "addUser")
	{
		$errors = 0;
		$fName = $_REQUEST['fname'];
		$sName = $_REQUEST['sname'];
		$email = $_REQUEST['email'];
		$password = $_REQUEST['password'];
		$jobTitle = $_REQUEST['jobTitle'];

		//Load the model
		require_once('models/NewUserModel.php');
		$userModel = new NewUserModel();

		//Validate the fields
		if (strlen($fName) < 1 || strlen($fName) > 30) {
			$errors = 1;
			echo "Error: First name must be between 1 and 30 characters.\n";
		}
		
		if (strlen($sName) < 1 || strlen($sName) > 30) {
			$errors = 1;
			echo "Error: Surname must be between 1 and 30 characters.\n";
		}
		
		if (strlen($jobTitle) < 1 || strlen($jobTitle) > 40) {
			$errors = 1;
			echo "Error: Job title must be between 1 and 40 characters.\n";
		}

		if (strlen($password) < 5 || strlen($password) > 30) {
			$errors = 1;
			echo "Error: Password must be between 5 and 30 characters.\n";
		}

		if ($errors == 0) {
		//Does the user exist?
		if ($userModel->checkIfEmailInUse($email) == true)
		{
			$errors = 1;
			echo "Email already in use.\n";
		}
		}
		
		if ($errors == 0) {
			//Create user
			//Hash the password
			$password = password_hash($password, PASSWORD_DEFAULT);
			$userModel->createUser($fName, $sName, $email, $password, $jobTitle);
			echo "User successfully created";
		}
		
	}

	//(Admin) - Updating an employee's details
	if($_REQUEST['action'] == "manageEmployee")
	{
		//Bind the parameters to variables
		$errors = 0;
		$userID = $_REQUEST['userID'];
		$fName = $_REQUEST['forename'];
		$sName = $_REQUEST['surname'];
		$dept = $_REQUEST['dept'];
		$jobTitle = $_REQUEST['jobTitle'];
                $salary = $_REQUEST['salary'];
                $leaveEnt = $_REQUEST['leaveEntitlement'];
                $weeklyHours = $_REQUEST['weeklyHours'];
                $hrPerms = $_REQUEST['hrPerms'];
		//Load in the model
		require_once('models/EmployeeDetailsModel.php');
		$employeeModel = new EmployeeDetailsModel($userID);
		
		//Validate the fields
		if (strlen($fName) < 1 || strlen($fName) > 30) {
			$errors = 1;
			echo "Error: First name must be between 1 and 30 characters.\n";
		}
		
		if (strlen($sName) < 1 || strlen($sName) > 30) {
			$errors = 1;
			echo "Error: Surname must be between 1 and 30 characters.\n";
		}
		
		if (strlen($jobTitle) < 1 || strlen($jobTitle) > 40) {
			$errors = 1;
			echo "Error: Job title must be between 1 and 40 characters.\n";
		}
                
                if ($salary < 0 || $salary > 9999999)
                {
                    $errors = 1;
                    echo "Error: Salary wasn't valid.\n";
                }
                
                if ($weeklyHours < 0 || $weeklyHours > 999)
                {
                    $errors = 1;
                    echo "Error: Weekly hours weren't valid.\n";
                }
		
		//The fields passed validation - proceed with the update
		if ($errors == 0)
		{	
			$result = $employeeModel->updateEmployeeRecord($userID, $fName, $sName, $dept, $jobTitle, $salary, $weeklyHours);
			
			if($result == true)
			{
				echo "Changes saved successfully";
			}
			
			//A database error has likely occured
			else
			{
				echo "An error has occurred";
			}
		}
		
	}

	//The user has tried to modify a department
	if($_REQUEST['action'] == "manageDepartment")
	{
		$errors = 0;
		$deptID = $_REQUEST['deptID'];
		$deptName = $_REQUEST['deptName'];
		$deptLevel = $_REQUEST['deptLevel'];
		$manager = $_REQUEST['manager'];
		
		//Validate the fields
		if (strlen($deptName) < 1 || strlen($deptName) > 30) {
			$errors = 1;
			echo "Error: Department name must be between 1 and 30 characters.\n";
		}
		if ($deptLevel < 1 || $deptLevel > 9999) {
			$errors = 1;
			echo "Error: Department level must be between 1 and 9999.\n";
		}
		
		//Changes can be saved
		if ($errors == 0)
		{
			require_once('models/DepartmentDetailsModel.php');
			$model = new DepartmentDetailsModel();
			$result = $model->updateDepartment($deptID, $deptName, $deptLevel, $manager);
			if ($result)
			{
				echo "Changes saved successfully";
			}
			
			else
			{
				echo "Unable to make changes, an error has occurred";
			}
		}
	}

	//Creating new department
	if($_REQUEST['action'] == "addDept")
	{
		$errors = 0;
		$name = $_REQUEST['name'];
		$manager = $_REQUEST['manager'];
		$level = $_REQUEST['level'];
		require_once('models/NewDepartmentModel.php');
		$model = new NewDepartmentModel();

		//Validate the fields
		if (strlen($name) < 1 || strlen($name) > 30) {
			$errors = 1;
			echo "Error: Department name must be between 1 and 30 characters.\n";
		}

		if ($level < 0 || $level > 9999)
		{
			$errors = 1;
			echo "Error: department level must be between 1 and 9999.\n";
		}

		if($errors == 0)
		{
			if($model->checkIfNameInUse($name))
			{
				$errors = 1;
				echo "Please choose a unique department name";
			}
		}

		if($errors == 0)
		{
			$model->createDepartment($name, $manager, $level);
			echo "Department successfully created";
		}

		
	}

	if($_REQUEST['action'] == "updateMyDetails")
	{
		$errors = 0;
		$userID = $_REQUEST['userID'];
		$fname = $_REQUEST['fname'];
		$sname = $_REQUEST['sname'];
		$addr1 = $_REQUEST['address_1'];
		$addr2 = $_REQUEST['address_2'];
		$addr3 = $_REQUEST['address_3'];
		$addr4 = $_REQUEST['address_4'];
		$postcode = $_REQUEST['postcode'];
		$contact_number = $_REQUEST['contact_number'];

		//Validation
		if (strlen($fname) < 1 || strlen($fname) > 30) {
			$errors = 1;
			echo "Error: First name must be between 1 and 30 characters.\n";
		}
		
		if (strlen($sname) < 1 || strlen($sname) > 30) {
			$errors = 1;
			echo "Error: Surname must be between 1 and 30 characters.\n";
		}

		if (strlen($addr1) < 1 || strlen($addr1) > 30) {
			$errors = 1;
			echo "Error: Address 1 must be valid.\n";
		}
		
		if (strlen($postcode) < 1 || strlen($postcode) > 8) {
			$errors = 1;
			echo "Error: Postcode must be valid.\n";
		}

		if (strlen($contact_number) < 5 || strlen($contact_number) > 15) {
			$errors = 1;
			echo "Contact number must be valid.\n";
		}

		if ($errors == 0)
		{
			require_once('models/UpdateEmployeeDetailsModel.php');
			$model = new UpdateEmployeeDetailsModel;
			if($model->updateEmployeeRecord($userID, $fname, $sname, $addr1, $addr2, $addr3, $addr4, $postcode, $contact_number) == true)
			{
				echo "Successfully changed details.";
			}

			else
			{
				echo "Something went wrong.";
			}
		}
	}
	
	//Unable to associate a user action
	//else echo "An error has occured";
}

//The request wasn't a post
else
{
	echo "Something went wrong";
}

?>