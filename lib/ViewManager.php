<?php

/* This class brings the user-interface together, running concurrently with the
System Manager class. This class will set up the standard template of the page,
allowing the controllers to instruct their views to populate the non-standard part
of a given URI. */
class ViewManager
{
	private $pageName;	//Used for the HTML head section
	protected $pageData;//Array to display the various elements of page data through the generic components
	protected $UserModel;	//User database functionality
        protected $NotificationModel; //Whether or not to indicate new notifications to the user
	
	public function __construct($pageName, $pageContents, $dbLink)
	{
		//Initialise the models
		require_once('models/UserModel.php');
                require_once('models/NotificationModel.php');
		$this->UserModel = new UserModel($dbLink);
                $this->NotificationModel = new NotificationModel($dbLink);
		
		//Fetch employee data
		$this->pageData['admin_link'] = "";
		$this->pageData['hr_link'] = "";
                $this->pageData['notification_link'] = "Notifications";
                $this->pageData['leave_req_link'] = "";
                
		self::GetEmployeeData();
		
		//Set the class attributes
		$this->pageName = $pageName;
		self::generateTop();
		echo $pageContents;
		self::generateEnd();
	}
        
        //Indicate to the user whether they have new notifications
        public function getNotifications($userID)
        {
            $this->NotificationModel->getMyNotifications($userID);
            $result = $this->NotificationModel->result;
            
            //If the result is null, no further action should be taken
            if($result != null)
            {
                //Get the number of notifications
                $r = 'Notifications (';
                $r .= count($result);
                $r .= ')';
                $this->pageData['notification_link'] = $r;
            }
        }
	
	//Retrieve the data for the employee from the database to populate the generic page components
	protected function GetEmployeeData()
	{
		//Get the user's ID from the session data
		$userID = $_SESSION['userID'];
		//Fetch the current employee's data from the appropriate model
		$this->userData = $this->UserModel->getCurrentEmployee();
                
                //Find out whether this user manages a department
                $this->userData['isManager'] = 0;
                if (isAManager($_SESSION['userID'])) {
                    $this->userData['isManager'] = 1;
                }
                
                //Create the notification link title
                $this->getNotifications($userID);
                
                //If the user is a manager of a department, give them additional options
                if($this->userData['isManager'] == 1) {
                    $this->pageData['hr_link'] = 
          '<a href="ServiceHRM.php?action=ManageEmployees">Manage Employees</a><br>
          <a href="ServiceHRM.php?action=LeaveRequests">Leave Requests</a><br>
          <a href="ServiceHRM.php?action=ReportingCentre">Reporting Centre</a><br>';
                }
                
		//If the user is HR, allow views of the HR administration links (overrides the manager options giving 1 extra link
		if($this->userData['HR_dept'] == 1)
		{
			$this->pageData['hr_link'] = '
		  <h3>Employee Management</h3>
          <a href="ServiceHRM.php?action=ManageEmployees">Manage Employees</a><br>
          <a href="ServiceHRM.php?action=ManageDepartment">Manage Departments</a><br>
          <a href="ServiceHRM.php?action=LeaveRequests">Leave Requests</a><br>
          <a href="ServiceHRM.php?action=ReportingCentre">Reporting Centre</a><br>
			';
		}
		
		//If the user is admin, allow view of the system administration links
		if($this->userData['admin'] == 1)
		{
			$this->pageData['admin_link'] = '<br>
		  <h3>System Management</h3>
		  <a href="ServiceHRM.php?action=AddUser">New User</a><br>
          <a href="ServiceHRM.php?action=AddDepartment">New Department</a><br></td>';
		}
	}
	
        
        //Create the 'top' of the script (the header and navigation bar)
	protected function generateTop()
	{
		echo
'<!DOCTYPE html>
<html>
	<head>
    	<title>ServiceHRM - '.$this->pageName.'</title>
    	<meta charset="UTF-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<link rel="stylesheet" href="views/layout.css">
		<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
    </head>
    <body>
    <div class="navbar" align="right">
        <a href="logout.php">Logout</a>
    </div>
    <section class="container">
        <div class="leftBar">
            <table class="leftBarTable">
      		<tr>
        		<th>'.$this->userData['f_name'].' '.$this->userData['s_name'].'<br>
				'.$this->userData['job_title'].' <br>
				'.$this->userData['department_name'].'</th>
			</tr>
      		<tr>
        <td><br>
		  <h3>Navigation</h3>
		  <a href="ServiceHRM.php?action=Dashboard">Dashboard</a><br>
          <a href="ServiceHRM.php?action=MyDetails">My Details</a><br>
          <a href="ServiceHRM.php?action=LeavePlanner">Leave Planner</a><br>
          <a href="ServiceHRM.php?action=MyTeam">My Team</a><br>
          <a href="ServiceHRM.php?action=Notifications">'.$this->pageData['notification_link'].'</a><br>
		  <br>
		  '.$this->pageData['hr_link'].'
		  '.$this->pageData['admin_link'].'
      </tr>
    		</table>
        </div>
        <div class="contentArea">
		';
	}
	
	protected function generateEnd()
	{
				echo
		'</div>
    </section>
    </body>
</html>';
	}
}