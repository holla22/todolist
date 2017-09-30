<?php

class Tasks {

    private $db;
    // added this as I'm only authing with one apiKey
    // can be extended to search DB for authKey against
    // user accounts.
    private $authKey = 'ac54bcf346e578feb46888b3ecd2344f';

    public function __construct($sType,$aVal,$dbConnection) 
    {
        //lets check if user is authenticated
        $this->checkAuth();

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

    private function checkAuth()
    {
       $headers = getallheaders();

       if($headers['X-AUTH-KEY'] !== $this->authKey)
       {
           throw new Exception("API Authentication Failed", 1);
       }
        return $authed = true;
      
        
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

        if($stmt = $this->db->c()->prepare("UPDATE tasks SET status=? WHERE id=?"))
        {
            $stmt->bind_param("ii", $aVal['STATUS'], $aVal['ID']); 
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

    private function deleteTask($aVal)
    {
        if($stmt = $this->db->c()->prepare("DELETE FROM tasks WHERE id=?"))
        {
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