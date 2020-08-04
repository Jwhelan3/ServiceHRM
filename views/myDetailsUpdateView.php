<?php

//View component for the user to update their details
require_once('lib/ViewManager.php');
class MyDetailsUpdateView extends ViewManager
{
	private $pageName = "Update My Details";
	private $details;
	
	public function __construct($dbLink, $employeeDetails)
	{
		$this->details = $employeeDetails;
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
	
	//The page contents specific to this page
	public function pageContent()
	{
    //Ajax
    $content = '
    <script>
    $( function() {
		//Send the updated details to the Listener methods
	var form = $("#updateDetails");
	
	form.submit(function(e) {
		e.preventDefault(); // Override the default submit behaviour
    	$.ajax({
           type: "POST",
           url: "Listener.php",
		   data: {
         action: "updateMyDetails",
         userID: '.$this->details['id'].',
			   fname: $("#f_name").val(),
         sname: $("#s_name").val(),
         address_1: $("#addr1").val(),
         address_2: $("#addr2").val(),
         address_3: $("#addr3").val(),
         address_4: $("#addr4").val(),
         postcode: $("#postcode").val(),
         contact_number: $("#c_number").val()
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
    ';
    //HTML
    $content .= "
<form name=\"updateDetails\" id=\"updateDetails\">
<table width=\"100%\" border=\"1\">
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
      <td><input id=\"f_name\" name=\"f_name\" type=\"text\" value=\"".$this->details['f_name']."\"></td>
    </tr>
    <tr>
      <td>Surname:</td>
      <td><input id=\"s_name\" name=\"s_name\" type=\"text\" value=\"".$this->details['s_name']."\"></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td>".$this->details['email']."</td>
    </tr>
    <tr>
      <td>Address 1:</td>
      <td><input id=\"addr1\" name=\"addr1\" type=\"text\" value=\"".$this->details['address_1']."\"></td>
    </tr>
    <tr>
      <td>Address 2:</td>
      <td><input id=\"addr2\" name=\"addr2\" type=\"text\" value=\"".$this->details['address_2']."\"></td>
    </tr>
    <tr>
      <td>Address 3:</td>
      <td><input id=\"addr3\" name=\"addr3\" type=\"text\" value=\"".$this->details['address_3']."\"></td>
    </tr>
    <tr>
      <td>Address 4:</td>
      <td><input id=\"addr4\" name=\"addr4\" type=\"text\" value=\"".$this->details['address_4']."\"></td>
    </tr>
    <tr>
      <td>Postcode:</td>
      <td><input id=\"postcode\" name=\"postcode\" type=\"text\" value=\"".$this->details['post_code']."\"></td>
    </tr>
    <tr>
      <td>Contact Number:</td>
      <td><input id=\"c_number\" name=\"c_number\" type=\"text\" value=\"".$this->details['contact_number']."\"></td>
    </tr>
    <tr>
      <td colspan=\"2\"><input type=\"submit\" value=\"Save Changes\"></td>
    </tr>
  </tbody>
</table>
</form>
		";
		return $content;
	}
}

?>