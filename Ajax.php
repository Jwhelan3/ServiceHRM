<?php

//Functionality for managing the AJAX calls from client-side operations

//Search for an employee based on the name
function employeeSearch($term)
{
	//Ensure the search string is greater than two characters
	if(strlen($term) >= 2)
	{
		//Load the database model
		require_once('models/EmployeeSearchModel.php');
		$model = new EmployeeSearchModel($term);
		
		//Check whether or not the result is empty
		if ($model->result != "")
		{
			//Output the results
			echo json_encode($model->result);
		}
		
		//Clear the output buffer 
		flush();
	}
}

function getAllDetails($userID)
{
    //Load the database model
    require('models/EmployeeDetailsModel.php');
    $userModel = new EmployeeDetailsModel($userID);
    $userDetails = $userModel->findEmployee();
    
    //Return the results
    echo json_encode($userDetails);
    
    //Clear the output buffer
    flush();
}

//Get an employee's details with the provided ID
function getEmployeeDetails($term)
{
		require_once('models/EmployeeDetailsModel.php');
		$model = new EmployeeDetailsModel($term);
		
		//Check whether or not the result is empty
		if ($model->result != "")
		{
			//Output the results
			echo json_encode($model->result);
		}
		
		//Clear the output buffer 
		flush();
}

//Get the department list (all)
function getDepartments()
{
	//Load in the departments model
	require_once('models/DepartmentDetailsModel.php');
	$model = new DepartmentDetailsModel();
	//Outut the list of departments in JSON format
	echo json_encode($model->result);
	//Clear the buffer
	flush();
}

//Get an employee's details with their ID
function fetchEmployee($empID)
{
	//Load the relevant model
	require_once('models/EmployeeDetailsModel.php');
	$model = new EmployeeDetailsModel($empID);
	
	//Output the employee details
	echo json_encode($model->result);
	
	//Clear the buffer
	flush();
}

//Fetch the leave for a given user
function myLeave($empID)
{
	//Load the leave model
	require_once('models/LeaveModel.php');
	$model = new LeaveModel();
	$model->fetchLeave($empID);
	echo json_encode($model->result);
	flush();
}

//Add a new notification to the system
function addNotification($userID, $text)
{
	//Load the notification model
	require_once('models/NotificationModel.php');
	$model = new NotificationModel();
	$model->addNotification($userID, $text);
}

//Add leave (employee ID, start date, end date, title)
function addLeave($empID, $s, $e, $t)
{
	//Load the leave model
	require_once('models/LeaveModel.php');
	$model = new LeaveModel();
	$model->addLeave($empID, $s, $e, $t);
        
        //Create the notification
        require_once('Permissions.php');
        $mgr = findManager($empID);
        $msg = "A new leave quest has been created for employee: ";
        $msg .= $empID;
        addNotification($mgr, $msg);
}

function getMyNotifications($userID)
{
	//Load the notification model
	require_once('models/NotificationModel.php');
	$model = new NotificationModel();
	$model->getMyNotifications($userID);
	echo json_encode($model->result);
}


//Determine what request was received

//Search for an employee based on name
if ($_GET['action'] == "employeeSearch")
{
	$searchTerm = $_GET['term'];
	employeeSearch($searchTerm);
}

//Request for a list of all employees
if ($_GET['action'] == "getEmployeeDetails")
{
	$searchTerm = $_GET['term'];
	employeeSearch($searchTerm);
}

//Request for a list of all departments
if ($_GET['action'] == "getDepartmentList")
{
	//Return a list of departments
	getDepartments();
}

//Request for details of a specific user
if ($_GET['action'] == "fetchEmployee")
{
	$empID = $_GET['id'];
	fetchEmployee($empID);
}

//User has opened the leave calendar and it needs to be populated with their leave
if ($_GET['action'] == "myLeave")
{
	$empID = $_GET['empID'];
	myLeave($empID);
}

//User has added leave
if ($_GET['action'] == "addLeave")
{
	$empID = $_GET['id'];
	$s = $_GET['start'];
	$e = $_GET['end'];
	$t = $_GET['type'];
	addLeave($empID, $s, $e, $t);
}

//User requested their notifications
if ($_GET['action'] == "getMyNotifications")
{
	$userID = $_GET['empID'];
	getMyNotifications($userID);
}

//A new notification needs adding for the provided user with the provided message
if ($_GET['action'] == "addNotification")
{
	$userID = $_GET['empID'];
	$text = $_GET['message'];
	addNotification($userID, $text);
}

//Fetch an employee's details
if ($_GET['action'] == "getAllDetails")
{
    $userID = $_GET['empID'];
    getAllDetails($userID);
}

?>