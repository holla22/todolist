<?php
require('db.class.php');
require('tasks.class.php');

// SET DB DETAILS HERE
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'price_check';

// create db connection
$dbConnection = new DB($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);

// get data from angular controllers post method
$data = json_decode(file_get_contents("php://input"));

$sType = $data->type;
//avoid undefined property
if(!empty($data->taskId) && isset($data->taskId)){ $taskId = $data->taskId; }else{ $taskId = false; }

$aVal = [];
switch ($sType) {
    case 'get':
            $aVal = ['STATUS'=>'%'];
            $tasks = new Tasks($sType,$aVal,$dbConnection);
        break;

    case 'add':
            $aVal['TASK'] = $data->task;
            $aVal['STATUS'] = 0;
            $aVal['CREATED'] = time();
            $tasks = new Tasks($sType,$aVal,$dbConnection);
        break;

    case 'update':
            error_log("ID: ".$data->taskId);
            
            $aVal['ID'] = $taskId;
            $aVal['STATUS'] = $data->status;
            $tasks = new Tasks($sType,$aVal,$dbConnection);
        break;

    case 'delete':
            $aVal['ID'] = $data->taskId;
            $tasks = new Tasks($sType,$aVal,$dbConnection);
        break;
}