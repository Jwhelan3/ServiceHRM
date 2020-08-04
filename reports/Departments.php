<?php session_start();
	
//Create access to the database
require_once('../lib/Database.php');
$config = require_once('../inc/config.php');
$db = new Database($config);

//Construct the query, execute and store the results in employeeData
$statement = "SELECT `id`, `department_name`, `manager_id`, `department_level` FROM `departments` ORDER BY department_name ASC";
$stmt = $db->connection->prepare($statement);
$stmt->execute();
//Place the results into an array
$stmt->bind_result($id, $name, $manager, $department_level);
$salary = 0;

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Employee Report</title>
</head>

<body>
<table width="75%" border="1">
  <tbody>
    <tr>
      <th scope="col">Department Number</th>
      <th scope="col">Department Name</th>
      <th scope="col">Manager</th>
      <th scope="col">Hierarchy Level</th>
      <th scope="col">Total Department Salary</th>
    </tr>
	  <?php
	  while ($stmt->fetch()) {
    echo'<tr>
      <td>'.$id.'</td>
      <td>'.$name.'</td>
      <td>'.$manager.'</td>
      <td>'.$department_level.'</td>
      <td>£'.$salary.'</td>
    </tr>';
	  }
		 ?>
  </tbody>
</table>

</body>
</html>

<?php

$stmt->close(); 

?>