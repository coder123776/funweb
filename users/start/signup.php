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

<?php
// echo $_SESSION['oldInputs'];
if(isset($_GET['error'])){
?>
<div class="popup">
    <?php
    if ($_GET['error'] == "emptyinput"){?>
    <h1>Fill</h1>
    <h1>In</h1>
    <h1>All</h1>
    <h1>Fields!</h1>
    <?php
    }elseif ($_GET['error'] == "usernameTaken"){?>
    <h1>Username</h1>
    <h1>Already</h1>
    <h1>Taken</h1>
    <?php
    }elseif ($_GET['error'] == "invalidName"){?>
    <h1>Invalid</h1>
    <h1>Username</h1>
    <h1>"$,#,!, ,&,*"</h1>
    <h1>Not Allowed</h1>
    <?php
    }elseif ($_GET['error'] == "invalidEmail"){?>
    <h1>Email</h1>
    <h1>Doesn't</h1>
    <h1>Exist</h1>
    <?php
    }elseif ($_GET['error'] == "passworddontMatch"){?>
    <h1>Password</h1>
    <h1>Doesn't</h1>
    <h1>Match</h1>
    <?php
    }
    ?>
</div>
<?php
}
?>
<form action="../../includes/functions/UserPosts.php" method="post">
<div class="logbody">
    <div class="form">
    <h1>Sign Up</h1>
        <div class="form-child">
        <label for="name">full name</label><br>
        <img class="labelImg" src="../../images/userLogg/user.png">
        <input onclick="inpupHr(1)" id="inp1" class="input" type="text" name="name" placeholder="your full name.." required maxlength="50" value="<?= $_SESSION['oldInputs'][0] ?? '' ?>">
        <hr id="hrname" class="hr">
        <label for="username">username</label><br>
        <img class="labelImg" src="../../images/userLogg/user.png">
        <input onclick="inpupHr(2)" id="inp2" class="input" type="text" name="username" placeholder="your username.." required maxlength="14" value="<?= $_SESSION['oldInputs'][1] ?? '' ?>">
        <hr id="hrusername" class="hr">
        <label for="email">email</label><br>
        <img class="labelImg" src="../../images/userLogg/email.png">
        <input onclick="inpupHr(3)" id="inp3" class="input" type="text" name="email" placeholder="your email.." required maxlength="100" value="<?= $_SESSION['oldInputs'][2] ?? '' ?>">
        <hr id="hremail" class="hr">
        <label for="password">password</label><br>
        <img class="labelImg" src="../../images/userLogg/password.png">
        <input onclick="inpupHr(4)" id="inp4" class="input" type="password" name="password" placeholder="your password.." required maxlength="250" value="<?= $_SESSION['oldInputs'][3] ?? '' ?>">
        <hr id="hrpassword" class="hr">
        <label for="password_repeat">repeat password</label><br>
        <img class="labelImg" src="../../images/userLogg/password.png">
        <input onclick="inpupHr(5)" id="inp5" class="input" type="password" name="password_repeat" placeholder="your repeat password.." required maxlength="250" value="<?= $_SESSION['oldInputs'][4] ?? '' ?>">
        <hr id="hrpassword_repeat" class="hr">
        <p id="forgtpass"></p>
        </div>

        <button class="userbutton" type="submit" name="signupUser">Sign Up</button>

        <p id="lastlast">Already have an account?</p>
        <a id="lastlast" href="../start/login.php">Log In</a>
        </div>
</div>
</form>

<script>
    // color switches
    var hr1 = document.getElementById('hrname');
    var hr2 = document.getElementById('hrusername');
    var hr3 = document.getElementById('hremail');
    var hr4 = document.getElementById('hrpassword');
    var hr5 = document.getElementById('hrpassword_repeat');

    var input1 = document.getElementById('inp1');
    var input2 = document.getElementById('inp2');
    var input3 = document.getElementById('inp3');
    var input4 = document.getElementById('inp4');
    var input5 = document.getElementById('inp5');

    var color1 = "red";
    var color2 = "rgb(132, 98, 255)";

    function inpupHr(whatInp){
        if (whatInp == 1){
            hr1.style.backgroundColor = color1;
            hr2.style.backgroundColor = color2;
            hr3.style.backgroundColor = color2;
            hr4.style.backgroundColor = color2;
            hr5.style.backgroundColor = color2;
        }
        if (whatInp == 2){
            hr1.style.backgroundColor = color2;
            hr2.style.backgroundColor = color1;
            hr3.style.backgroundColor = color2;
            hr4.style.backgroundColor = color2;
            hr5.style.backgroundColor = color2;
        }
        if (whatInp == 3){
            hr1.style.backgroundColor = color2;
            hr2.style.backgroundColor = color2;
            hr3.style.backgroundColor = color1;
            hr4.style.backgroundColor = color2;
            hr5.style.backgroundColor = color2;
        }
        if (whatInp == 4){
            hr1.style.backgroundColor = color2;
            hr2.style.backgroundColor = color2;
            hr3.style.backgroundColor = color2;
            hr4.style.backgroundColor = color1;
            hr5.style.backgroundColor = color2;
        }
        if (whatInp == 5){
            hr1.style.backgroundColor = color2;
            hr2.style.backgroundColor = color2;
            hr3.style.backgroundColor = color2;
            hr4.style.backgroundColor = color2;
            hr5.style.backgroundColor = color1;
        }
    }
</script>

<?php
include_once("../../includes/defaults/footer.php");