<?php
include_once("../../includes/classes/database.php");
include_once("../../includes/controllers/UserController.php");
include_once("../../includes/classes/UserClasses.php");

if (isset($_POST['signupUser'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];

    $signup = new Signup($name, $username, $email, $password, $password_repeat);
    $signup->signupuser();
    $login = new Login($username, $password);
    $login->loginUser();
    header("location: ../../web/main/index.php");
}
if (isset($_POST['loginuser'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $login = new Login($username, $password);
    $login->loginUser();
    header("location: ../../web/main/index.php");
}