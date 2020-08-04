<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php

session_start();

//Check that the user isn't already logged in
if(isset($_SESSION['userID']))
{
	//User is logged in - redirect to secure area
	header("Location: ServiceHRM.php?action=Dashboard");
}

//User has submitted the login form
if($_POST['submit'])
{
	//User has attempted to login
	//Bring in the UserManager class and create an instance
	require_once('lib/UserManager.php');
	$UserManager = new User_Manager();
	
	//Store the submitted data into variables
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	//Attempt the login
	$result = $UserManager->Login($email, $password);
	
	//Process the result
	if($result)
	{
		//Login succeeded - redirect to the secure area
		header("Location: ServiceHRM.php?action=Dashboard");
		
	}
	
	else
	{
		//Inform the user that the login failed
		echo "Incorrect user credentials";
	}

}

?>

<html>
    <head>
        <title>ServiceHRM - Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="views/layout.css">

    </head>
    <body>
        <div class="navbar" align="center">
            <h1>ServiceHRM</h1>
        </div>
        <div class="loginForm">
            <h2 align="center">Login</h2>
            <form id="login" method="post" action="">
                <ul>
                    <li>
                        <label>Email</label>
                        <div>
                            <input id="email" name="email" type="text" maxlength="255" value=""/>
                        </div>
                    </li>		
                    <li>
                        <label>Password </label>
                        <div>
                            <input id="password" name="password" type="password" maxlength="255" value=""/>
                        </div>
                    </li>
                    <li>
                        <input id="submit" class="button_text" type="submit" name="submit" value="Submit" />
                    </li>
                </ul>
            </form>
        </div>
    </body>
</html>