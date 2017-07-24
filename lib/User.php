<?php

include_once "Session.php";
include "Database.php";
include "Validation.php";

class User
{
    private $db;
    private $validation;
    public function __construct(){
        $this->db = new Database();
        $this->validation = new Validation();
    }

    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function getLoggedinUser($email, $password)
    {
        $sql = "SELECT * FROM user WHERE email = :email AND password = :password";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @return array
     */
    public function getAllUser()
    {
        $sql = "SELECT * FROM user ORDER BY id DESC";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        $sql = "SELECT * FROM user WHERE id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $id
     * @param $data
     * @return string
     */
    public function updateUser($id, $data)
    {
        $name = $data['name'];
        $username = $data['username'];
        $email = $data['email'];

        if ($this->validation->areFieldsEmpty([$name, $username, $email])) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> fields must not be empty</div>";

            return $msg;
        }

        if (strlen($username) < 3) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username is too short!</div>";

            return $msg;
        } elseif (preg_match('/[^a-z0-9_-]+/', $username)) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username can only contain alphabets, numbers, underscores and dashes!</div>";

            return $msg;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Invalid email!</div>";

            return $msg;
        }


        $sql = "UPDATE user SET name = :name, username = :username, email = :email WHERE id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":name", $name);
        $query->bindValue(":username", $username);
        $query->bindValue(":email", $email);
        $query->bindValue(":id", $id);
        $result = $query->execute();
        if ($result) {
            $updatedUser = $this->getUserById($id);
            Session::init();
            Session::set('login', true);
            Session::set('name', $updatedUser->name);
            Session::set('username', $updatedUser->username);
            $msg = "<div class='alert alert-success'><strong>Congratulations!</strong> Successfully updated!</div>";

            return $msg;
        } else {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> sorry failed to update</div>";

            return $msg;
        }
    }

    /**
     * @param $id
     * @param $data
     * @return string
     */
    public function updateUserPassword($id, $data)
    {
        $old_password = $data['old_password'];
        $password = $data['password'];

        if ($this->validation->areFieldsEmpty([$old_password, $password])) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> fields must not be empty</div>";

            return $msg;
        }

        $old_password = md5($old_password);
        $isUser = $this->isUserByPassword($id, $old_password);
        if(!$isUser){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> sorry old password not matched</div>";

            return $msg;
        }

        $password = md5($password);
        $sql = "UPDATE user SET password = :password WHERE id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":password", $password);
        $query->bindValue(":id", $id);
        $result = $query->execute();

        if ($result) {
            $msg = "<div class='alert alert-success'><strong>Congratulations!</strong> Successfully updated!</div>";

            return $msg;
        } else {

            $msg = "<div class='alert alert-danger'><strong>Error!</strong> sorry failed to update</div>";
            return $msg;
        }


    }

    /**
     * @param $id
     * @param $password
     * @return bool
     */
    public function isUserByPassword($id, $password)
    {
        $sql = "SELECT password FROM user WHERE id = :id AND password = :password ";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->bindValue(":password", $password);
        $query->execute();
        if($query->rowCount() > 0){

            return true;
        } else{

            return false;
        }
    }
}