<?php 
/*
*  This file updates data to the db
*/
require_once 'db.php'; // The mysql database connection script

// check if the the task passed isset.
if(isset($_GET['taskID']))
{
    $status = $_GET['status'];
    $taskID = $_GET['taskID'];

    // update data
    $query="update tasks set status='$status' where id='$taskID'";
    $result = $mysqli->query($query) or die($mysqli->error.__LINE__);
    $result = $mysqli->affected_rows;

    // output in json format
    $json_response = json_encode($result);
}
?>