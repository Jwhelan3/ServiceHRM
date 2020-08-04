<?php

//Fetch the permissions file to check the user is authorised for each action
require_once('Permissions.php');

//Retrieve the relevant URI parameter	
//Sanitise the variable to mitigate vulnerability risks
$userAction = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_URL);
	
//Load the appropriate controller
switch ($userAction)
{
	case "Dashboard":
		Dashboard();
		break;
		
	case "ManageEmployees":
		ManageEmployees();
		break;

	case "ManageAdministrators":
		ManageAdministrators();
		break;
		
	case "ManageDepartment":
		ManageDepartments();
		break;
		
	case "MyDetails":
		MyDetails();
		break;
		
	case "MyDetailsUpdate":
		MyDetailsUpdate();
		break;
		
	case "LeavePlanner":
		LeavePlanner();
		break;
		
	case "ReportingCentre":
		ReportingCentre();
		break;
		
	case "AddUser":
		AddUser();
		break;
		
	case "AddDepartment":
            AddDepartment();
		break;
            
        case "Notifications":
            Notifications();
            break;
        
        case "LeaveRequests":
            LeaveRequests();
            break;
		
	default:
		PageNotFound();
		break;
}


//Bring in the controller file and run it via its constructor
function Dashboard()
{
	//Bring in the appropriate controller
	require_once('controllers/dashboardController.php');

	//Instantiate the controller
	$dashboard = new DashboardController();
}

function ManageEmployees() {
    
    //Include and initialise the controller
        require_once('controllers/manageEmployeesController.php');
        $manageEmployees = new ManageEmployeesController();
}

function ManageAdministrators()
{
	require_once('controllers/manageAdministratorsController.php');
	
	$manageAdministrators = new ManageAdministratorsController();
}

function MyDetails()
{
	require_once('controllers/myDetailsController.php');
	
	$myDetails = new MyDetailsController();
}

function MyDetailsUpdate()
{
	require_once('controllers/myDetailsUpdateController.php');
	
	$myDetailsUpdate = new MyDetailsUpdateController();
}

function LeavePlanner()
{
	require_once('controllers/leavePlannerController.php');
	
	$leavePlanner = new leavePlannerController();
}

function ReportingCentre()
{
	require_once('controllers/reportingController.php');
	
	$reportingCentre = new reportingController();
}

function ManageDepartments()
{
	//Check whether the user has tried to manage an existing department, otherwise default to 0
	require_once('controllers/departmentController.php');
	
	//Send the request to the correct path
	if (filter_input(INPUT_GET, 'deptID', FILTER_SANITIZE_URL) != null)
	{
		$deptID = filter_input(INPUT_GET, 'deptID', FILTER_SANITIZE_URL);
	}
	
	else
	{
		$deptID = 0;
	}
	
	$manageDept = new DepartmentController($deptID);
}

function addUser()
{
	require_once('controllers/newUserController.php');
	$newUser = new NewUserController();
}

function addDepartment()
{
	require_once('controllers/newDepartmentController.php');
	$newDepartment = new NewDepartmentController();
}

function Notifications()
{
        require_once('controllers/notificationController.php');
         
        $markAsRead = false;
        
        if(filter_input(INPUT_GET, 'read', FILTER_SANITIZE_URL) == true)
        {
            $markAsRead = true;
        }
        
        $notifications = new NotificationController($markAsRead);
}

function LeaveRequests()
{
    require_once('controllers/leaveRequestsController.php');
    
    $action = null;
    $id = 0;
    
    if(filter_input(INPUT_GET, 'a', FILTER_SANITIZE_URL) == true)
        {
            $action = filter_input(INPUT_GET, 'a', FILTER_SANITIZE_URL);
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_URL);
        }
        
    $leaveRequests = new LeaveRequestsController($action, $id);
}

function PageNotFound()
{
	//There was no action associated with the given URI (e.g page not found)
	header("location: ServiceHRM.php?action=Dashboard");
}


?>