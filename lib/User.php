<?php
    include_once "Session.php";
    include "Database.php";
class User
{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }

    public function userRegistration($data){
        $name = $data['name'];
        $username = $data['username'];
        $email = $data['email'];
        $password = md5($data['password']);

        $emailUsed = $this->isEmailUsed($email);

        if($name == "" OR $username == "" OR $email == "" OR $password == ""){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> fields must not be empty</div>";
            return $msg;
        }

        if(strlen($username) < 3){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username is too short!</div>";
            return $msg;
        }elseif(preg_match('/[^a-z0-9_-]+/', $username)){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username can only contain alphabets, numbers, underscores and dashes!</div>";
            return $msg;
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Invalid email!</div>";
            return $msg;
        }

        if($emailUsed){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> email already used!</div>";
            return $msg;
        }


        $sql = "INSERT INTO user (name, username, email, password) VALUES(:name, :username, :email, :password)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":name", $name);
        $query->bindValue(":username", $username);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $result = $query->execute();
        if($result){
            $msg = "<div class='alert alert-success'><strong>Congratulations!</strong> Successfully registered</div>";
            return $msg;
        } else{
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> sorry failed to register</div>";
            return $msg;
        }
    }


    public function isEmailUsed($email){
        $sql = "SELECT email FROM user WHERE email = :email";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":email", $email);
        $query->execute();
        if($query->rowCount() > 0){
            return true;
        } else{
            return false;
        }

    }
}