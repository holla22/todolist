<?php 
require_once 'db.php'; // The mysql database connection script

$status = '%'; // used to get all data

// get data
$query="select ID, TASK, STATUS from tasks where status like '$status' order by status,id desc";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

// run through selected data and add to array
$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$arr[] = $row;	
	}
}
# JSON-encode the response
echo $json_response = json_encode($arr);
?>