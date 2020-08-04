<?php

//View component for my details
require_once('lib/ViewManager.php');
class MyDetailsView extends ViewManager
{
	private $pageName = "My Details";
	private $details;
	
	public function __construct($dbLink, $employeeDetails)
	{
		$this->details = $employeeDetails;
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
	
	//The page contents specific to this page
	public function pageContent()
	{
		$content = "
<table width=\"100%\" border=\"1\" class=\"infoView\">
  <tbody>
    <tr>
      <th colspan=\"2\" scope=\"col\">My Employee Details</th>
    </tr>
    <tr>
      <td>Employee Number:</td>
      <td>".$this->details['id']."</td>
    </tr>
    <tr>
      <td>Forename:</td>
      <td>".$this->details['f_name']."</td>
    </tr>
    <tr>
      <td>Surname:</td>
      <td>".$this->details['s_name']."</td>
    </tr>
    <tr>
      <td>Email:</td>
      <td>".$this->details['email']."</td>
    </tr>
    <tr>
      <td>Department:</td>
      <td>".$this->details['department_id']." - ".$this->details['department_name']."</td>
    </tr>
    <tr>
      <td>Job Role:</td>
      <td>".$this->details['job_title']."</td>
    </tr>
    <tr>
      <td>Contractual Weekly Hours:</td>
      <td>".$this->details['weekly_hours']."</td>
    </tr>
    <tr>
      <td>Salary:</td>
      <td>£".number_format($this->details['salary'], 2)."</td>
    </tr>
    <tr>
      <td>Pay Period:</td>
      <td>".$this->details['pay_period']."</td>
    </tr>
    <tr>
      <td>Holiday Entitlement:</td>
      <td>".$this->details['holiday_entitlement']." (working weeks)</td>
    </tr>
	 <tr>
      <td>Address (Line 1):</td>
      <td>".$this->details['address_1']."</td>
    </tr>
	 <tr>
      <td>Address (Line 2):</td>
      <td>".$this->details['address_2']."</td>
    </tr>
	 <tr>
      <td>Address (Line 3):</td>
      <td>".$this->details['address_3']."</td>
    </tr>
	 <tr>
      <td>Address (Line 4):</td>
      <td>".$this->details['address_4']."</td>
    </tr>
	 <tr>
      <td>Postcode:</td>
      <td>".$this->details['post_code']."</td>
    </tr>
	 <tr>
      <td>Contact Number:</td>
      <td>".$this->details['contact_number']."</td>
    </tr>
    <tr>
      <td colspan=\"2\"><a href=\"ServiceHRM.php?action=MyDetailsUpdate\">Update My Details</a></td>
    </tr>
  </tbody>
</table>
		";
		return $content;
	}
}

?>