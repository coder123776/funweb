<?php

class UserToDb extends database {
    protected function checkUsername($username, $email){
        $stmt = $this->connect()->prepare('SELECT * FROM user WHERE user_username = ? OR user_email = ?;');
        if (!$stmt->execute(array($username, $email))){
            $stmt = null;
            header("location: ../../users/start/signup.php?fail");
            exit();
        }

        $resultCheck = null;
        if ($stmt->rowCount() > 0){
            $resultCheck = false;
        }else{
            $resultCheck = true;
        }
        $stmt = null;
        return $resultCheck;
    }
    protected function setUser($username, $email, $name, $password, $budget, $picture, $onlinedate, $country, $description, $verify, $userid){
        $stmt = $this->connect()->prepare('INSERT INTO user (user_username, user_email, user_name, user_password, user_budget, user_picture, user_onlineDate, user_country, user_description, user_verify, user_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if (!$stmt->execute(array($username, $email, $name, $hashed_password, $budget, $picture, $onlinedate, $country, $description, $verify, $userid))){
            $stmt = null;
            header("location: ../../users/start/signup.php?fail");
            exit();
        }
        $stmt = null;
    }
}

class UserToWeb extends database{
    protected function getuser($username, $password){
        $stmt = $this->connect()->prepare('SELECT * FROM user WHERE user_username = ? OR user_email = ?');

        if (!$stmt->execute(array($username, $password))){
            $stmt = null;
            header("location: ../../users/start/login.php?fail");
            exit();
        }
        if ($stmt->rowCount() == 0){
            $stmt = null;
            header("location: ../../users/start/login.php?usernotfound");
            exit();
        }

        $password_hashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $check_password = password_verify($password, $password_hashed[0]['user_password']);

        if ($check_password == false){
            $stmt = null;
            header("location: ../../users/start/login.php?passwordincorrect");
            exit();
        }elseif ($check_password == true){
            $stmt = $this->connect()->prepare('SELECT * FROM user WHERE user_username = ? OR user_email = ? AND user_password = ?;');

            if (!$stmt->execute(array($username, $username, $password))){
                $stmt = null;
                header("location: ../../users/start/login.php?fail");
                exit();
            }
            if ($stmt->rowCount() == 0){
                $stmt = null;
                header("location: ../../users/start/login.php?usernotfound");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['userid'] = $user[0]['user_id'];
        }
        $stmt = null;
    }
}