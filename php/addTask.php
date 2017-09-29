<?php 
/*
*    This file adds data to the db
*/
require_once 'db.php'; // The mysql database connection script

// check if the the task passed isset.
if(isset($_GET['task'])){
    $task = $_GET['task'];
    $status = "0";
    $created = time();

    // Insert data
    $query="INSERT INTO tasks(task,status,created_at)  VALUES ('$task', '$status', '$created')";
    $result = $mysqli->query($query) or die($mysqli->error.__LINE__);
    $result = $mysqli->affected_rows;

    // output in json format
    echo $json_response = json_encode($result);
}
?>
