<?php

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
    <script>
    $( function() {
		//Send the updated details to the Listener methods
	var form = $("#addUser");
	
	form.submit(function(e) {
		e.preventDefault(); // Override the default submit behaviour
    	$.ajax({
           type: "POST",
           url: "Listener.php",
		   data: {
			   action: "addUser",
			   fname: $("#forename").val(),
         sname: $("#surname").val(),
         password: $("#password").val(),
			   email: $("#email").val(),
			   jobTitle: $("#job_title").val()
		   },
           action: form.serialize(), //Prepare the form for sending
           success: function(action)
           {
		   	//Show the response
            alert(action);
           }
		   
         });
		 });
    } );		 </script>
<form name="addUser" id="addUser"><table width="75%" border="1" class="infoView">
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
      <td><button name="saveChanges">Save Changes</button></td>
    </tr>
  </tbody>
</table>
</form>
		';
		return $content;
	}
}

?>