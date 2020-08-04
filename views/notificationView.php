<?php

//View component for managing the user's notifications
require_once('lib/ViewManager.php');

class NotificationView extends ViewManager
{
	private $pageName = "Notifications";
	private $notifications;
	
	public function __construct($notifications, $dbLink)
	{
		$this->notifications = $notifications;
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
        
        //Display the notifications in a list format. If there are none, report this back to the user
        public function displayList()
        {
            if ($this->notifications == null)
            {
                $res = 
                '<tr><td>
                    There are no new notifications to view.
                </td></tr>';
            }
            
            else
            {
                $res = 
                '<tr><td>
                    <a href="ServiceHRM.php?action=Notifications&read=true">Mark all as read</a>
                </td></tr>';
                for($i = 0; $i < count($this->notifications); $i++)
                {
                    $row = $this->notifications[$i];
                    //$date = date($row['date']);
                    $date = date_format (new DateTime($row['date']), 'd-m-Y');
                    $text = $row['text'];
                    $res .= '<tr><td>'.$date.' - '. $text .'</td></tr>';
                }
            }
            
            return $res;
        }
	
	
	//The page contents specific to this page
	public function pageContent()
	{
		$content = '
<div align="center"><table width="60%" border="1" class="infoView">
  <tbody>
    <tr>
      <th scope="col">New Notifications</th>
    </tr>
    	  '.$this->displayList().'
  </tbody>
</table></div>
		';
		return $content;
	}
}

?>