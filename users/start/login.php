<?php
session_start();
$_SESSION['filetype'] = 2;
$_SESSION['WebAllowed'] = false;
$_SESSION['headerColor'] = "black";
if (!isset($_SESSION['previous_page'])) { $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];}
include_once("../../includes/classes/database.php");
include_once("../../includes/controllers/UserController.php");
include_once("../../includes/classes/UserClasses.php");

include_once("../../includes/defaults/header.php");
?>

<link rel="stylesheet" href="../../css/users_login&signup.css">
<form action="../../includes/functions/UserPosts.php" method="post">
<div class="logbody">
    <div class="form">
    <h1>Log In</h1>
        <div class="form-child">
        <label for="username">username</label><br>
        <img class="labelImg" src="../../images/userLogg/user.png">
        <input onclick="inpupHr(1)" id="inp1" class="input" type="text" name="username" placeholder="your username.." required>
        <hr id="hrusername" class="hr">
        <label for="password">password</label><br>
        <img class="labelImg" src="../../images/userLogg/password.png">
        <input onclick="inpupHr(2)" id="inp2" class="input" type="password" name="password" placeholder="your password.." required>
        <hr id="hrpassword" class="hr">
        <p id="forgtpass">forgot password?</p>
        </div>

        <?php
        if(isset($_GET['usernotfound'])){?>
        <p id="Logerror">user doesn't exist!</p>
        <?php
        }elseif(isset($_GET['passwordincorrect'])){?>
        <p id="Logerror">the password is incorrect!</p>
        <?php
        }elseif(isset($_GET['needloginfirst'])){?>
        <p id="Logerror">you need to login first!</p>
        <?php
        }
        ?>

        <button class="userbutton2" type="submit" name="loginuser">Log In</button>

        <p id="lastlast">Don't have an account?</p>
        <a id="lastlast" href="../start/signup.php">Sign Up</a>
        </div>
</div>
</form>

<script>
    // color switches
    var hr1 = document.getElementById('hrusername');
    var hr2 = document.getElementById('hrpassword');

    var input1 = document.getElementById('inp1');
    var input2 = document.getElementById('inp2');

    var color1 = "red";
    var color2 = "rgb(132, 98, 255)";

    function inpupHr(whatInp){
        if (whatInp == 1){
            hr1.style.backgroundColor = color1;
            hr2.style.backgroundColor = color2;
        }
        if (whatInp == 2){
            hr1.style.backgroundColor = color2;
            hr2.style.backgroundColor = color1;
        }
    }
</script>

<?php
include_once("../../includes/defaults/footer.php");