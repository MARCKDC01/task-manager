<?php
require_once "DataBase/connection.php";
require_once "../Utils/GetDate.php";

class Task{
    private $taskId;
    private $userId;
    private $taskName;
    private $taskDescription;
    private $createAt;
    private $updateAr;
    
    function __construct(){
        $this->conn = new Connection();
        $this->mysqli = $this->conn->dbConnect();

        $this->date = new GetDate();
        $this->getDate = $this->date->getDate();

    }

    function save($userId, $taskName, $taskDescription){
        $sql = "INSERT INTO task (user_id, task_name, task_description, created_at) 
        VALUES ('$userId', '$taskName', '$taskDescription', '$this->getDate')";

        if (mysqli_query($this->mysqli, $sql)) {
            echo "Task created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($this->mysqli);
        }
    }

    function listAll($userId){
        $sql = "SELECT * FROM task WHERE task.user_id = '$userId'";
        $query = mysqli_query($this->mysqli, $sql);

        while ($result = mysqli_fetch_array($query)) { 
            $data = array(
                'code' => 200,
                'status' => 'success',
                'message' => 'task found',
                'taskId' => $result['task_id'],
                'taskName' => $result['task_name'],
                'tasDescription' => $result['task_description'],
                'createdAt' => $result['created_at'],
                'updatedAt' => $result['updated_at']
            );
            $json['task'][]=$data;
        }

        if(is_null($json)){
            $data = array(
                'code' => 404,
                'status' => 'error',
                'message' => 'the user does not register tasks'
            );
            $json['task'][]=$data; 
        }
        
        return json_encode($json);
    }

    function listOne($userId, $taskId){
        
        $sql = "SELECT * FROM task WHERE task.user_id = '$userId' AND task.task_id = '$taskId'";
        $query = mysqli_query($this->mysqli, $sql);
       

        while ($result = mysqli_fetch_array($query)) { 
            $data = array(
                'code' => 200,
                'status' => 'success',
                'message' => 'task found',
                'taskId' => $result['task_id'],
                'taskName' => $result['task_name'],
                'tasDescription' => $result['task_description'],
                'createdAt' => $result['created_at'],
                'updatedAt' => $result['updated_at']
            );
            $json['task'][]=$data;
        } 
        if(is_null($json)){
            $data = array(
                'code' => 404,
                'status' => 'error',
                'message' => 'Task not found'
            );
            $json['task'][]=$data; 
        }

    
        return json_encode($json);     
    }

    function update($userId, $taskId, $taskName, $taskDescription){
        $task = new Task();
        $sql = "UPDATE task SET task_name = '$taskName', task_description = '$taskDescription', updated_at = '$this->getDate '
                WHERE task.user_id = '$userId' AND task.task_id = '$taskId'";
        $query = mysqli_query($this->mysqli, $sql);

        if($query == true){
            $data = array(
                'code' => 200,
                'status' => 'success',
                'message' => 'Task  updated'
            );
            $json['task'][]=$data;
        }else{
            $data = array(
                'code' => 404,
                'status' => 'error',
                'message' => 'Task not updated'
            );
            $json['task'][]=$data;
            
        }

        return json_encode($json);  
    }

    function __destruct(){
        mysqli_close($this->mysqli);
    }
    
}

$task = new Task();
//$task->save(1, 'My Two task', 'This is my two task');
//echo $task->listAll(1);
//echo $task->listOne(1,2);

 echo $task->update(1,2, "My  two updated", "This is my two task updated");