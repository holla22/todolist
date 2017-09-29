<?php 
/*
* this file deletes data
*/
require_once 'db.php'; // The mysql database connection script

// check if the the task passed isset.
if(isset($_GET['taskID'])){
$taskID = $_GET['taskID'];

// Delete data
$query="delete from tasks where id='$taskID'";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
$result = $mysqli->affected_rows;

// output in json format
echo $json_response = json_encode($result);
}
?>
