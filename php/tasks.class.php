<?php

class Tasks {

    private $db;

    public function __construct($sType,$aVal,$dbConnection) 
    {
        // set the db connection
        $this->db = $dbConnection;

        switch ($sType) {
            case 'get':
                   $this->getTask($aVal);
                break;

            case 'add':
                    $this->addTask($aVal);
                break;

            case 'update':
                    $this->updateTask($aVal);
                break;

            case 'delete':
                    $this->deleteTask($aVal);
                break;
        }
    }

    private function getTask($aVal)
    {

        // always use prepared statement, it's more secure
        if($stmt = $this->db->c()->prepare("SELECT id, task, status FROM tasks WHERE status LIKE ? ORDER BY status,id DESC"))
        {
            $stmt->bind_param("s", $aVal['STATUS']); 
            $stmt->execute(); 
            $stmt->bind_result($id, $task, $status);

            $aResult = [];
            while ($stmt->fetch()) {
                $tmp = []; 
                $tmp['ID'] = $id;
                $tmp['TASK'] = $task;
                $tmp['STATUS'] = $status;

                $aResult[] = $tmp;
            }

            $stmt->close();

            echo json_encode($aResult);
        }
        else
        {
            throw new Exception("Error Processing Request", 1);  
        }
    }

    private function addTask($aVal)
    {
        error_log($aVal['TASK']);
        error_log($aVal['STATUS']);
        error_log($aVal['CREATED']);
        if($stmt = $this->db->c()->prepare("INSERT INTO tasks(task,status,created_at)  VALUES (?, ?, ?)"))
        {
            $stmt->bind_param("sis", $aVal['TASK'],$aVal['STATUS'],$aVal['CREATED']); 
            $stmt->execute(); 
            $aResult = $stmt->num_rows(); 

            $stmt->close();

            echo json_encode($aResult);
        }
        else
        {
            throw new Exception("Error Processing Request", 1);  
        }

    }

    private function updateTask($aVal)
    {
        //error_log(print_r($aVal,2));

        if($stmt = $this->db->c()->prepare("UPDATE tasks SET status=? WHERE id=?"))
        {
            $stmt->bind_param("ii", $aVal['STATUS'], $aVal['ID']); 
            $stmt->execute(); 
            $aResult = $stmt->num_rows(); 

            error_log(print_r($aResult,2));

            $stmt->close();

            echo json_encode($aResult);
        }
        else
        {
            throw new Exception("Error Processing Request", 1);  
        }
    }

    private function deleteTask($aVal)
    {
        if($stmt = $this->db->c()->prepare("DELETE FROM tasks WHERE id=?"))
        {
            error_log("ID: ".$aVal['ID']);
            $stmt->bind_param("s", $aVal['ID']); 
            $stmt->execute(); 
            $aResult = $stmt->num_rows(); 

            $stmt->close();
            

            echo json_encode($aResult);
        }
        else
        {
            throw new Exception("Error Processing Request", 1);  
        }
    }
}