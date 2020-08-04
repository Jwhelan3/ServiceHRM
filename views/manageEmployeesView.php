<?php

//View component for the user to manage their employees
require_once('lib/ViewManager.php');
class ManageEmployeesView extends ViewManager
{
	private $pageName = "Manage Employees";
	
	public function __construct($dbLink)
	{
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
	
	//The page contents specific to this page
	public function pageContent()
	{
		$content = '
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Modify Employees</title>
<style>
.manageEmp {
  display: none;
 }
</style>
<script>
var userID = 0;
var currentDept = 0;

//--Dropdown population
$(document).ready(function(){
$.ajax({
    url:"Ajax.php?action=getDepartmentList",
    type:"GET",
    dataType: "json",
    success: function( json ) {
        $.each(json, function(i, value) {
            $("#deptList").append($("<option>").text(value.name).attr("value", value.id));
        });
    }
});
});

//--Dropdown end

/*function getEmp(userID){
    $.ajax({
        type:"GET",
        url:"Ajax.php?action=getAllDetails&empID=",
        data: userID,
        success: function(response){
            var result = JSON.parse(response);
            if (result.response == true) {
                var data = result.rows;
                $("#forename").val(data[0].fName);
                $("#surname").val(data[0].sName);
                $("#salary").val(data[0].salary);
            }
            }
        }
    });
}*/

$( function() {
    function manageEmp( message ) {
      $( "<div>" ).text( message ).prependTo( "#manageEmp" );
      $( "#manageEmp" ).scrollTop( 0 );
    }
 
    $( "#acSearch" ).autocomplete({
      source: "Ajax.php?action=employeeSearch&term=",
      minLength: 2,
      select: function( event, ui ) {
	    var strSplit = ui.item.value.split(" ");
		userID = strSplit[0];
		var fName = strSplit[2];
		var sName = strSplit[3];
            manageEmp( "Selected employee: " + ui.item.value + " - " + userID );
		$("#empNum").val(userID);
		$("#forename").val(fName);
		$("#surname").val(sName);
		$(".manageEmp").show();
                
                //Update the form with the user\'s details
                $.getJSON("Ajax.php?action=getAllDetails&empID=" + userID, null,
        function(data){
                $("#empNum").val(data.id);
                $("#forename").val(data.f_name);
                $("#surname").val(data.s_name);
                $("#salary").val(data.salary);
                $("#jobTitle").val(data.job_title);
                $("#leaveEnt").val(data.holiday_entitlement);
                $("#weeklyHours").val(data.weekly_hours);
                if (val(data.HR_dept) == 1) {
                    $("#hrPer").prop("checked", true);
                }
                else {
                    $("#hrPer").prop("checked", false);
                }
                //$("#hrPer").val(data.HR_dept);
                $("#deptList").val(data.department_id);
});     
                
	  }
          

    });
	
	//Send the updated details to the Listener methods
	var form = $("#manageEmployee");
	form.submit(function(e) {
		e.preventDefault(); // Override the default submit behaviour
    	$.ajax({
           type: "POST",
           url: "Listener.php",
		   data: {
			   action: "manageEmployee",
			   userID: userID,
			   forename: $("#forename").val(),
			   surname: $("#surname").val(),
			   dept: $("#deptList").val(),
			   jobTitle: $("#jobTitle").val(),
                           salary: $("#salary").val(),
                           leaveEntitlement: $("#leaveEnt").val(),
                           weeklyHours: $("#weeklyHours").val(),
                           hrPerms: $("#hrPer").val()
		   },
           action: form.serialize(), //Prepare the form for sending
           success: function(action)
           {
		   	//Show the response
            alert(action);
           }
		   
         });
		 });
	//--
	
	
  } );
</script>
</head>
<body>
<div id="existingEmployee">
	<form name="existingEmployeeSearch"><table border="1" width="100%" class="infoView">
  <tbody>
    <tr>
      <th scope="col">Search for Employee</th>
      </tr>
    <tr>
      <td>
	  	<div class="ui-widget">
  		<label for="acSearch">Employee name: </label>
		<input type="text" id="acSearch" class="acSearch">
		</div>
	  </td>
      </tr>
  </tbody>
</table></form>
	</div>
	<div class="manageEmp" id="manageEmp">
<form name="manageEmployee" id="manageEmployee" action="Listener.php" method="post"><table border="1" width="100%" class="infoView">
    <tbody>
      <tr>
        <th colspan="2" scope="col">Manage Employee</th>
      </tr>
      <tr>
        <td>Employee Number: </td>
        <td><input type="text" name="empNum" id="empNum" readonly></td>
      </tr>
      <tr>
        <td>Forename: </td>
        <td><input type="text" name="forename" id="forename"></td>
      </tr>
      <tr>
        <td>Surname: </td>
        <td><input type="text" name="surname" id="surname"></td>
      </tr>
      <tr>
        <td>Job Title: </td>
        <td><input type="text" name="jobTitle" id="jobTitle"></td>
      </tr>
      <tr>
        <td>Department: </td>
        <td><select id="deptList" name="deptList">
			
		</select></td>
      </tr>
	  <tr>
        <td>Salary: </td>
        <td><input type="text" name="salary" id="salary"></td>
      </tr>
	  <tr>
        <td>Annual Leave Entitlement: </td>
        <td><input type="text" name="leaveEnt" id="leaveEnt"></td>
      </tr>
	  <tr>
        <td>Weekly Hours: </td>
        <td><input type="text" name="weeklyHours" id="weeklyHours"></td>
      </tr>
	  <tr>
        <td>HR Permissions: </td>
        <td><input type="checkbox" name="hrPer" id="hrPer"></td>
      </tr>
      <tr>
        <td>Reset Password: </td>
        <td><input type="checkbox" name="resetAcc"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><button name="saveChanges">Save Changes</button></td>
      </tr>
    </tbody>
  </table></form>
</div>
</body>
</html>
';
		return $content;
	}
}

?>