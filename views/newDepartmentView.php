<?php

//View component to generate a new department
require_once('lib/ViewManager.php');
class NewDepartmentView extends ViewManager
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
	var form = $("#addDept");
	
	form.submit(function(e) {
		e.preventDefault(); // Override the default submit behaviour
    	$.ajax({
           type: "POST",
           url: "Listener.php",
		   data: {
			   action: "addDept",
			   name: $("#dName").val(),
         manager: $("#manager").val(),
         level: $("#level").val()
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
<form name="addDept" id="addDept"><table width="75%" border="1" class="infoView">
  <tbody>
    <tr>
      <th colspan="2" scope="col">New User Form</th>
    </tr>
    <tr>
      <td width="57%">Department name:</td>
      <td width="43%"><input type="text" name="dName" id="dName"></td>
    </tr>
    <tr>
      <td>Manager:</td>
      <td><input type="text" name="manager" id="manager"></td>
    </tr>
    <tr>
      <td>Hierarchy Level:</td>
      <td><input type="text" name="level" id="level"></td>
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