<?php
    include_once "Session.php";
    include_once "Database.php";
    include_once "Validation.php";
    include_once "ExceptionMessage.php";

class UserAuthentication
{
    private $db;
    private $validation;
    private $exceptionMessage;
    public function __construct(){
        $this->db = new Database();
        $this->validation = new Validation();
        $this->exceptionMessage = new ExceptionMessage();
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

        if ($this->validation->areFieldsEmpty([$name, $username, $email, $password])) {
            return $this->exceptionMessage->getAlertMessage("Error! fields can't be empty.");
        }

        if ($this->validation->getFieldLength($username) < 3) {

            return $this->exceptionMessage->getAlertMessage("Error! Username is too short!");

        } elseif ($this->validation->preg_match('/[^a-z0-9_-]+/', $username)) {

            return $this->exceptionMessage->getAlertMessage("Error! Username can only contain alphabets, numbers, underscores and dashes!");

        }

        if (!$this->validation->isEmail($email)) {
            return $this->exceptionMessage->getAlertMessage("Error! Invalid email!");
        }

        if ($this->isUsedEmail($email)) {
            return $this->exceptionMessage->getAlertMessage("Error! this email seems have not used yet!");
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
            return $this->exceptionMessage->getSuccessMessage("Congratulations!! Successfully registered!");
        } else {
            return $this->exceptionMessage->getAlertMessage("sorry failed to register");
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


        if ($this->validation->areFieldsEmpty([$email, $password])) {
            return $this->exceptionMessage->getAlertMessage("Error!  fields must not be empty!");
        }

        if ($this->validation->isEmail($email)) {
            return $this->exceptionMessage->getAlertMessage("Error!  Invalid email!");
        }

        if (!$this->isUsedEmail($email)) {
            return $this->exceptionMessage->getAlertMessage("Error!  this email seems have not used yet!!");
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
            Session::set('login_msg',$this->exceptionMessage->getSuccessMessage("Sucess! You are logged in!") );
            header("Location: index.php");
        } else {
            return $this->exceptionMessage->getAlertMessage('Error! No data found!');
        }

        return "";
    }

    /**
     * @param $email
     * @return bool
     */
    public function isUsedEmail($email)
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


    /**
     *Check if login is ok
     */
    public function checkLogin(){
        if(Session::get('login')){
            echo '<script> window.location = "index.php";</script>';
        }
    }

}