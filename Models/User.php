<?php

require_once "DataBase/connection.php";
require_once "../Utils/GetDate.php";

class User{



    public function __construct(){
        $this->conn = new Connection();
        $this->mysqli = $this->conn->dbConnect();

        $this->date = new GetDate();
        $this->getDate = $this->date->getDate();
    }

    public function save($name,$surname, $email, $password){
        $sql = "INSERT INTO users (name_user, surname_user, email_user, pass_user, create_at) 
        VALUES ('$name', '$surname', '$email', '$password', '$this->getDate')";

        if (mysqli_query($this->mysqli, $sql)) {
            echo "User created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($this->mysqli);
        }
        
    }

    public function login($mail, $password){

        $sql = "SELECT * FROM task_manager.users WHERE users.email_user = '$mail'";
        $query = mysqli_query($this->mysqli, $sql);

        while ($result = mysqli_fetch_array($query)) { 
            if($result['pass_user']  == $password ){
                $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'user found',
                    'name' => $result['name_user'],
                    'surname' => $result['surname_user'],
                    'mail' => $result['email_user']
                    );

                $json['users'][]=$data;
            }else{
                $data = array(
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Password incorrect'
                );
                $json['users'][]=$data; 
                break;
            }
                                 
        }

        if(is_null($json)){
            $data = array(
                'code' => 404,
                'status' => 'error',
                'message' => 'Username does not exist'
            );
            $json['users'][]=$data; 
        }

    
        return json_encode($json);
    }
    public function __destruct(){
        mysqli_close($this->mysqli);
    }

}


$user = new User();
//$user->save("test", "Test", "test@test.com", 123456);
//echo $user->login('test@test.com', 12345);

