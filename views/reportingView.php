<?php

//Re-route the user to reports, which will open in a new window
require_once('lib/ViewManager.php');
class ReportingView extends ViewManager
{
	private $pageName = "Reporting Centre";
	
	public function __construct($dbLink)
	{
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
	
	//The page contents specific to this page
	public function pageContent()
	{
		$content = '
		<div align="center">
<h1>Reporting Centre</h1>
<table width="75%" border="1" class="infoView">
  <tbody>
    <tr>
      <th scope="col">Department Reports</th>
      <th scope="col">Business Reports</th>
    </tr>
    <tr>
      <td><p><a href="reports/Departments.php" target="new">Department Overview</a></p>
        <p><a href="reports/Employees.php" target="new">Employee Information</a></p></td>
      <td><p><a href="reports/Salary.php" target="new">Salary Information</a></p>
        </td>
    </tr>
  </tbody>
</table></div>
		';
		return $content;
	}
}

?>