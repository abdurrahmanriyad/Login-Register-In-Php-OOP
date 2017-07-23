<?php
    include_once "Session.php";
    include_once "Database.php";
    include_once "Validation.php";

class UserAuthentication
{
    private $db;
    private $validation;
    public function __construct(){
        $this->db = new Database();
        $this->validation = new Validation();
    }

    /**
     * @param $data
     * @return string
     */
    public function userRegistration($data)
    {
        $name = $data['name'];
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];

        $emailUsed = $this->isEmailUsed($email);

        if ($this->validation->areFieldsEmpty([$name, $username, $email, $password])) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> fields must not be empty</div>";
            return $msg;
        }

        if ($this->validation->getFieldLength($username) < 3) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username is too short!</div>";
            return $msg;
        }elseif(preg_match('/[^a-z0-9_-]+/', $username)){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username can only contain alphabets, numbers, underscores and dashes!</div>";
            return $msg;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Invalid email!</div>";
            return $msg;
        }

        if ($emailUsed) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> this email seems have not used yet!</div>";
            return $msg;
        }

        $password = md5($data['password']);
        $sql = "INSERT INTO user (name, username, email, password) VALUES(:name, :username, :email, :password)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":name", $name);
        $query->bindValue(":username", $username);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $result = $query->execute();

        if ($result) {
            $msg = "<div class='alert alert-success'><strong>Congratulations!</strong> Successfully registered</div>";
            return $msg;
        } else {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> sorry failed to register</div>";
            return $msg;
        }
    }

    /**
     * @param $data
     * @return string
     */
    public function userLogin($data)
    {

        $email = $data['email'];
        $password = $data['password'];

        $emailUsed = $this->isEmailUsed($email);

        if ($this->validation->areFieldsEmpty([$email, $password])) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> fields must not be empty</div>";
            return $msg;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Invalid email!</div>";
            return $msg;
        }

        if (!$emailUsed) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> this email seems have not used yet!</div>";
            return $msg;
        }

        $password = md5($data['password']);
        $userObject = new User();
        $user = $userObject->getLoggedinUser($email, $password);

        if ($user) {
            Session::init();
            Session::set('login', true);
            Session::set('id', $user->id);
            Session::set('name', $user->name);
            Session::set('username', $user->username);
            Session::set('login_msg',"<div class='alert alert-success'><strong>Success!</strong> You are logged in!</div>" );
            header("Location: index.php");
        } else {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> No data found!</div>";
            return $msg;
        }

        return "";
    }

    /**
     * @param $email
     * @return bool
     */
    public function isEmailUsed($email)
    {
        $sql = "SELECT email FROM user WHERE email = :email";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":email", $email);
        $query->execute();
        if($query->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }
}