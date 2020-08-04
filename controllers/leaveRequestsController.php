<?php

//This inherits from the SystemController - include the class
require_once('lib/SystemController.php');

//Provides an interface for a manager or HR administrator to accept or refuse leave requests
class LeaveRequestsController extends SystemController
{
    
    protected $requests;
    protected $feedback;
    protected $currentUser;
    
	public function __construct($action, $id)
	{
		//Instantiate the parent
		parent::__construct();
                
                //Get the user ID
                $this->currentUser = $_SESSION['userID'];
                
                //Check for requests
                if ($action == "approve" || $action == "reject") {
                    $this->processRequest($id, $action);
                }
                
                //Fetch the outstanding requests
                $this->getRequests();
                
                //Load the view
		$this->loadView();

	}
	
        //Fetches the requests that this user should be able to see
        private function getRequests()
        {
            //Is the user an administrator or HR?
            //require('Permissions.php');
            
            if (isAdministrator($this->currentUser) || isHR($this->currentUser))
            {
                //Get all users
                require_once('models/UserModel.php');
                $userModel = new UserModel($this->db);
                $userList = $userModel->getIDList();
                
                //Get the leave model
                require_once('models/LeaveModel.php');
                $leaveModel = new LeaveModel();
                
                //Loop through each user retrieving their requests
                $i = 0;
                foreach($userList as $row) {
                    $leaveModel->fetchLeaveRequests($row);
                    
                    //If this is the first leave request encountered, this can become the array
                    if ($this->requests == null)
                    {
                        $this->requests = $leaveModel->result;
                    }
                    
                    //Otherwise, requests exist already and this should be merged instead
                    else
                    {
                        array_merge($this->requests, $leaveModel->result);
                    }
                    $i++;
                }
            }
            
            //The user isn't a HR or administrator - are they an employee?
            else if (isAManager($_SESSION['userID'])) {
                //Get the departments managed by this user
                require_once('models/DepartmentModel.php');
                $departmentModel = new DepartmentModel($this->db);
                $departmentList = $departmentModel->getIDList($this->currentUser);
                
                //Compile a list of direct reports
                $userList[0] = 0;
                require_once('models/UserModel.php');
                $userModel = new UserModel($this->db);
                $i = 0;
                
                foreach($departmentList as $dRow) {
                    $userList[$i] = $userModel->getIDList();
                }
            }
            
            //The user doesn't have the permissions to view this page - send them to the dashboard
            else {
                header("Location: ServiceHRM.php");
            }
        }
        
        //If the user has taken an action, this method takes the leave ID and the chosen action and attempts to process it
        private function processRequest($id, $action)
        {
            //If the user approved a request
            if ($action == "approve" && $id > 0)
            {
                $this->feedback = "Your recent leave request has been approved - see the leave planner for more information.";
                                
                //Mark the leave as approved
                require('models/LeaveModel.php');
                $leaveModel = new LeaveModel();
                $leaveModel->approveLeave($id);
                
                //Get the target user ID
                $tUser = $leaveModel->getUserId($id);
               
                //Send a notification
                require('models/NotificationModel.php');
                $notificationModel = new NotificationModel();
                $notificationModel->addNotification($tUser, $this->feedback);
                
                $this->feedback = "Leave request approved.";
            }
            
            //Request was refused
            else if ($action == "reject" && $id > 0)
            {
                $this->feedback = "Your recent leave request has been rejected - see the leave planner for more information.";
                
                //Mark the leave as approved
                require('models/LeaveModel.php');
                $leaveModel = new LeaveModel();
                $leaveModel->deleteLeave($id);
                
                //Get the target user ID
                $tUser = $leaveModel->getUserId($id);
               
                //Send a notification
                require('models/NotificationModel.php');
                $notificationModel = new NotificationModel();
                $notificationModel->addNotification($tUser, $this->feedback);
                
                $this->feedback = "Leave request rejected.";
            }
            
            //Unable to determine the request
            else
            {
                $this->feedback = "Something went wrong";
            }
        }
        
	//Draw the page contents
	private function loadView()
	{
		//Fetch the view
		require_once('views/leaveRequestsView.php');
		$view = new LeaveRequestsView($this->requests, $this->feedback, $this->db);
	}
}