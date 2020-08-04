<?php

session_start();

//Check whether the user making the AJAX request is the same as the logged in user
function isTheUser($userID) {
    return ($userID == $_SESSION['userID']);
}

//A check on whether the logged in user is a system administrator
function isAdministrator($userID) {
    //Create access to the database
    require_once('lib/Database.php');
    $config = require('inc/config.php');
    $db = new Database($config);
    $statement = "SELECT admin FROM users WHERE id = ?";
    $stmt = $db->connection->prepare($statement);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    return $result;
}

//Check whether the logged in user is in the HR department
function isHR($userID) {
    //Check first whether the user has admin permissions
    if (isAdministrator($userID) == true) {
        echo "x";
        return true;
    }
    //Otherwise check the database
    else {
        //Create access to the database
        require_once('lib/Database.php');
        $config = require('inc/config.php');
        $db = new Database($config);
        $statement = "SELECT HR_dept FROM users WHERE id = ? LIMIT 1";
        $stmt = $db->connection->prepare($statement);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        $stmt->close();
        return $result;
    }
}

//Check whether the user has access to the user in targetID
function hasAccessToUser($targetID) {
    //TODO: Recursive call to see whether a permission has been hit in the chain
    return true;
}

//Takes a user and returns their direct line manager's user id
function findManager($targetID) {
    //Get the user's department
        //Create access to the database
    require_once('lib/Database.php');
    $config = require('inc/config.php');
    $db = new Database($config);
        //Get the department ID
    $statement = "SELECT department_id FROM users WHERE id = ?";
    $stmt = $db->connection->prepare($statement);
    $stmt->bind_param("i", $targetID);
    $stmt->execute();
    $stmt->bind_result($departmentID);
    $stmt->fetch();
    $stmt->close();
    
        //Find the department manager
    $statement = "SELECT manager_id FROM departments WHERE id = ? LIMIT 1";
    $stmt = $db->connection->prepare($statement);
    $stmt->bind_param("i", $departmentID);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    
    //The result contains the ID of the manager for the target user and can be returned
    return $result;
}

function isAManager($targetID) {
    $result = false;
    $count = 0;
    
    //Connect to the database
    require_once('lib/Database.php');
    $config = require('inc/config.php');
    $db = new Database($config);
    //Get the department ID
    $statement = "SELECT id FROM departments WHERE manager_id = ?";
    $stmt = $db->connection->prepare($statement);
    $stmt->bind_param("i", $targetID);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    //Is this user the manager of any departments?
    if ($count > 0) {
        $result = true;
    }
    
    return $result;
}

?>