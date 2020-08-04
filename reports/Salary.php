<?php session_start();

$db;
$result;
	
//Create access to the database
require_once('../lib/Database.php');
$config = require_once('../inc/config.php');
$db = new Database($config);
$numOfEmps = 0;
$totalSalary = 0;
	

//Construct the query, execute and store the results in employeeData
$statement = "SELECT `id`, `f_name`, `s_name`, `job_title`, `salary` FROM `users` ORDER BY s_name ASC";
$stmt = $db->connection->prepare($statement);
$stmt->execute();
//Place the results into an array
$stmt->bind_result($id, $f_name, $s_name, $job_title, $salary);
while ($stmt->fetch()) {
    $result[] = $id. " - " .$f_name. " " .$s_name. " - " .$job_title. " - £" .$salary;
	$totalSalary += $salary;
	$numOfEmps++;
}
$stmt->close(); 

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Salary Report</title>
</head>

<body>
	<table width="60%" border="1">
  <tbody>
    <tr>
      <th scope="col">
		  Total Salary: £<?=$totalSalary?>
		  <br>Average Salary: £<?=$totalSalary/$numOfEmps?>
		  <br>Employee List</th>
    </tr>
<?php
	//Output the results
	  for ($i = 0; $i < $numOfEmps; $i++)
	  {
echo '
    <tr>
      <td>'.$result[$i].'</td>
    </tr>';
	  }
?>
  </tbody>
</table>

</body>
</html>