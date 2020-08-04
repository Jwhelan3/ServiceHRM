<?php

require_once('lib/Database.php');
$config = require_once('inc/config.php');
$db = new Database($config);

require_once('Permissions.php');

//View component to generate a new user
require_once('lib/ViewManager.php');
class NewUserView extends ViewManager
{
	private $pageName = "Add New User";
	
	public function __construct($dbLink)
	{
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
	
	//The page contents specific to this page
	public function pageContent()
	{
		$content = '
<form name="addUser"><table width="75%" border="1" class="infoView" method="post">
  <tbody>
    <tr>
      <th colspan="2" scope="col">New User Form</th>
    </tr>
    <tr>
      <td width="57%">First name:</td>
      <td width="43%"><input type="text" name="forename" id="forename"></td>
    </tr>
    <tr>
      <td>Surname:</td>
      <td><input type="text" name="surname" id="surname"></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><input type="text" name="email" id="email"></td>
    </tr>
    <tr>
      <td>Password:</td>
      <td><input type="password" name="password" id="password"></td>
    </tr>
    <tr>
      <td>Job Title:</td>
      <td><input type="text" name="job_title" id="job_title"></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" value="Create User"></td>
    </tr>
  </tbody>
</table>
</form>
		';
		return $content;
	}
}


$view = new NewUserView($db);

?>