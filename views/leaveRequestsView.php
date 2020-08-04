<?php

//View component for managing the user's notifications
require_once('lib/ViewManager.php');

class LeaveRequestsView extends ViewManager
{
	private $pageName = "Leave Requests";
        private $feedback;
	private $requests;
	
	public function __construct($requests, $feedback, $dbLink)
	{
		$this->requests = $requests;
                $this->feedback = $feedback;
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
        
        //Display the requests in a list format. If there are none, report this back to the user
        public function displayList()
        {
            if ($this->requests == null)
            {
                $res = 
                '<tr colspan="5"><td>
                    There are no new requests to view.
                </td></tr>';
            }
            
            else
            {
                $res = "";
                foreach($this->requests as $row)
                {
                    //$date = date($row['date']);
                    $res .= '<tr><td width="15%">Employee number: '.$row['user_id'].'</td><td width="15%">Start date: '.$row['start'].'</td><td width="15%">End date: '.$row['end'].'</td><td>Reason: '.$row['title'].'</td><td width="15%"><a href="ServiceHRM.php?action=LeaveRequests&a=approve&id='.$row['id'].'">Approve</a> | <a href="ServiceHRM.php?action=LeaveRequests&a=reject&id='.$row['id'].'">Reject</a></td></tr>';
                }
                
            }
            
            return $res;
        }
	
	
	//The page contents specific to this page
	public function pageContent()
	{
		$content = '
<div align="center"><table width="60%" border="1" class="infoView">
'.$this->feedback.'
  <tbody>
    <tr colspan="5">
      <th scope="col" colspan="5">New Notifications</th>
    </tr>
    	  '.$this->displayList().'
  </tbody>
</table></div>
		';
		return $content;
	}
}

?>