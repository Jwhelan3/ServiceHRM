<?php session_start();
	
//Create access to the database
require_once('../lib/Database.php');
$config = require_once('../inc/config.php');
$db = new Database($config);

//Construct the query, execute and store the results in employeeData
$statement = "SELECT `id`, `f_name`, `s_name`, `job_title`, `salary`, `department_id` FROM `users` ORDER BY s_name ASC";
$stmt = $db->connection->prepare($statement);
$stmt->execute();
//Place the results into an array
$stmt->bind_result($id, $f_name, $s_name, $job_title, $salary, $department_id);

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
      <th scope="col">Employee Number</th>
      <th scope="col">First Name</th>
      <th scope="col">Surname</th>
      <th scope="col">Job Title</th>
      <th scope="col">Department</th>
      <th scope="col">Salary</th>
    </tr>
	  <?php
	  while ($stmt->fetch()) {
    echo'<tr>
      <td>'.$id.'</td>
      <td>'.$f_name.'</td>
      <td>'.$s_name.'</td>
      <td>'.$job_title.'</td>
      <td>'.$department_id.'</td>
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