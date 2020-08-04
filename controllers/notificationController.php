<?php

//This inherits from the SystemController - include the class
require_once('lib/SystemController.php');

//Notifications controller
class NotificationController extends SystemController
{
	public function __construct($markAsRead)
	{
		//Instantiate the parent
		parent::__construct();
                
                //Do the notifications need to be marked as read?
                if ($markAsRead == true)
                {
                    $this->markAsRead();
                }
                
                $notifications = $this->getNotifications();
                
		$this->loadView($notifications);
	}
        
        //Load the notifications to be sent in to the view
        private function getNotifications()
        {
            require_once('models/NotificationModel.php');
            $notificationModel = new NotificationModel();
            $notifications = $notificationModel->getMyNotifications($_SESSION['userID']);
            $notifications = $notificationModel->result;
            return $notifications;
        }
	
	//Draw the page contents
	private function loadView($notifications)
	{
		//Fetch the view
		require_once('views/notificationView.php');
		$view = new NotificationView($notifications, $this->db);
	}
        
        private function markAsRead()
        {
            require_once('models/NotificationModel.php');
            $notificationModel = new NotificationModel();
            $action = $notificationModel->markAsRead($_SESSION['userID']);
        }
}