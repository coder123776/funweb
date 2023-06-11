<?php

class Signup extends UserToDb{
    private $name; private $username; private $email; private $password; private $password_repeat;
    private $budget; private $picture; private $onlineDate; private $country; private $description;
    private $verify; private $userid;

    public function __construct($name, $username, $email, $password, $password_repeat){
        $userlocation = @unserialize (file_get_contents('http://ip-api.com/php/'));
        $location = $userlocation['country'];
        $date = date("d F Y");
        $blancImg = "../../images/userLogg/blancUser.png";
        $description = "";
        $verify = "FALSE";
        $budget = 0;
        $userid = $username . "#" . uniqid();

        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->password_repeat = $password_repeat;
        $this->budget = $budget;
        $this->picture = $blancImg;
        $this->onlineDate = $date;
        $this->country = $location;
        $this->description = $description;
        $this->verify = $verify;
        $this->userid = $userid;
    }

    public function signupuser(){
        if ($this->emptyInput() == false){
            header("location: ../../users/start/signup.php?error=emptyinput");
            exit();
        }
        if ($this->invalidName() == false){
            header("location: ../../users/start/signup.php?error=invalidName");
            exit();
        }
        if ($this->invalidEmail() == false){
            header("location: ../../users/start/signup.php?error=invalidEmail");
            exit();
        }
        if ($this->passwordMatch() == false){
            header("location: ../../users/start/signup.php?error=passworddontMatch");
            exit();
        }
        if ($this->usernameTaken() == false){
            header("location: ../../users/start/signup.php?error=usernameTaken");
            exit();
        }
        $this->setUser($this->username, $this->email, $this->name, $this->password, $this->budget, $this->picture, $this->onlineDate, $this->country, $this->description, $this->verify, $this->userid);
    }

    private function emptyInput(){
        $result = false;
        if (empty($this->name) || empty($this->username) || empty($this->email) || empty($this->password) || empty($this->password_repeat)){
            $result = false;
        }else{
            $result = true;
        } return $result;
    }
    private function invalidName(){
        $result = false;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)){
            $result = false;
        }else{
            $result = true;
        } return $result;
    }
    private function invalidEmail(){
        $result = false;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $result = false;
        }else{
            $result = true;
        } return $result;
    }
    private function passwordMatch(){
        $result = false;
        if ($this->password !== $this->password_repeat){
            $result = false;
        }else{
            $result = true;
        } return $result;
    }
    private function usernameTaken(){
        $result = false;
        if (!$this->checkUsername($this->username, $this->email)){
            $result = false;
        }else{
            $result = true;
        } return $result;
    }
}

class Login extends UserToWeb{
    private $username;
    private $password;
    public function __construct($username, $password){
        $this->username = $username;
        $this->password = $password;
    }
    public function loginUser(){
        if ($this->emptyInput() == false){
            header("location: ../../users/start/login.php?emptyinput");
            exit();
        }
        $this->getuser($this->username, $this->password);
    }

    private function emptyInput(){
        $result = false;
        if (empty($this->password) || empty($this->username)){
            $result = false;
        }else{
            $result = true;
        } return $result;
    }
}

class CheckUser extends database{
    private $userid;
    public function __construct($userid){
        $this->userid = $userid;
    }
    private function databaseQuery($table){
        $stmt = $this->connect()->prepare("SELECT $table FROM `user` WHERE user_id = ?;");
        if (!$stmt->execute(array($this->userid))) {
            $stmt = null;
            header("location: ../../web/main/index.php?fail");
            exit();
        }
        $result = null;
        if ($stmt->rowCount() == 0){
            $result = false;
        }else{
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $row[0][$table];
        }
        $stmt = null;
        return $result;
    }
    public function getUserId(){
        return $this->userid;
    }
    public function getName(){
        $result = $this->databaseQuery("user_name");
        return $result;
    }
    public function getUsername(){
        $result = $this->databaseQuery("user_username");
        return $result;
    }
    public function getEmail(){
        $result = $this->databaseQuery("user_email");
        return $result;
    }
    public function getBudget(){
        $result = $this->databaseQuery("user_budget");
        return $result;
    }
    public function getPicture(){
        $result = $this->databaseQuery("user_picture");
        return $result;
    }
    public function getOnlineDate(){
        $result = $this->databaseQuery("user_onlineDate");
        return $result;
    }
    public function getCountry(){
        $result = $this->databaseQuery("user_country");
        return $result;
    }
    public function getDescription(){
        $result = $this->databaseQuery("user_description");
        return $result;
    }
    public function getVerify(){
        $result = $this->databaseQuery("user_verify");
        return $result;
    }
}