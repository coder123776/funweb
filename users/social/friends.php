<?php
session_start();
$_SESSION['filetype'] = 2;
$_SESSION['headerColor'] = "white";
if (!isset($_SESSION['userid'])){
    header("location: ../../users/start/login.php?needloginfirst");
}
include_once("../../includes/classes/database.php");
include_once("../../includes/functions/functions.php");
include_once("../../includes/controllers/UserController.php");
include_once("../../includes/classes/UserClasses.php");
include_once("../../includes/classes/ProductClasses.php");
include_once("../../includes/classes/FriendsClasses.php");
include_once("../../includes/defaults/header.php");
?>
<link rel="stylesheet" href="../../css/users_friends.css">
<title>Friends</title>
<div class="profileText">
    <img src="<?php echo "../../images". $user->getPicture(); ?>">
    <h1><?php echo $user->getUsername(); ?></h1>
</div>
<section class="friend">
    <div class="friend-parent">
        <div class="friend-myfriends">
            <h1><?php echo $Friend->countFriends(); ?></h1>
        </div>

        <div class="friend-search">
            <input id="friendsearch" class="friendsearch" name="" type="text" placeholder="Search Your Friends..">
        </div>

        <div class="friend-options">
            <h1 onclick="friendoption(5)" class="navbuttontext" id="highlhite5">Add Friends</h1>
            <h1 onclick="friendoption(1)" class="navbuttontext" id="highlhite1">Friends</h1>
            <h1 onclick="friendoption(2)" class="navbuttontext" id="highlhite2">Following</h1>
            <h1 onclick="friendoption(3)" class="navbuttontext" id="highlhite3">Followers</h1>
            <h1 onclick="friendoption(4)" class="navbuttontext" id="highlhite4">Groups</h1>
        </div>

        <div class="fbdy-parent">
            <div class="friend-request-body">
                <?php
                $Friend->Myfriends("REQUEST");
                ?>
            </div>
        </div>

        <h1 id="textYourfriends" class="textYourfriends">Your Friends</h1>
        <div class="fbdy-parent">
        <div id="friendsbody" class="friends-body">
            <?php
            $Friend->Myfriends("FRIENDS");
            ?>
            <!-- <div class="friends-card"><img src=""><h1>Example</h1></div> -->
            <!-- <div id="addFbtn" class="friends-card"><img src=""><h1>Example</h1><button class="friendcardBtn" type="submit">Add friend</button></div> -->
        </div>
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript">
var high1 = document.getElementById('highlhite1');
var high2 = document.getElementById('highlhite2');
var high3 = document.getElementById('highlhite3');
var high4 = document.getElementById('highlhite4');
var high5 = document.getElementById('highlhite5');
var typeText = document.getElementById('textYourfriends');
var searchInput = document.getElementById('friendsearch');
var borterBtm = "0.5vh solid black";
var checkoption = 1;

function friendoption(wich) {
    high1.style.borderBottom = "none";
    high2.style.borderBottom = "none";
    high3.style.borderBottom = "none";
    high4.style.borderBottom = "none";
    high5.style.borderBottom = "none";

    if (wich == 1) {
        checkoption = 1;
        high1.style.borderBottom = borterBtm;
        typeText.innerText = "Your Friends";
    } else if (wich == 2) {
        checkoption = 2;
        high2.style.borderBottom = borterBtm;
        typeText.innerText = "Following";
    } else if (wich == 3) {
        checkoption = 3;
        high3.style.borderBottom = borterBtm;
        typeText.innerText = "Your Followers";
    } else if (wich == 4) {
        checkoption = 4;
        high4.style.borderBottom = borterBtm;
        typeText.innerText = "Your Groups";
    } else if (wich == 5) {
        checkoption = 5;
        high5.style.borderBottom = borterBtm;
        typeText.innerText = "Add Friends";
    }
}
friendoption(1);

$(document).ready(function() {
    var delayTimer;
    $("#friendsearch").keyup(function() {
        clearTimeout(delayTimer); // Reset de timer
        var input = $(this).val();
        
        if (input !== "") {
            delayTimer = setTimeout(function() {
                var searchOption;
                
                if (checkoption === 1) {
                    searchOption = "SearchFriends";
                } else if (checkoption === 2) {
                    searchOption = "SearchFollowing";
                } else if (checkoption === 3) {
                    searchOption = "SearchFollowers";
                } else if (checkoption === 4) {
                    searchOption = "SearchGroups";
                } else if (checkoption === 5) {
                    searchOption = "SearchNewFriends";
                }
                
                $.ajax({
                    url: "../../includes/functions/ajax.php",
                    method: "post",
                    data: { [searchOption]: input },
                    success: function(data) {
                        $("#friendsbody").html(data);
                        $("#friendsbody").css("display", "flex");
                    }
                });
            }, 300);
        }
    });
});

</script>

<?php
include_once("../../includes/defaults/footer.php");
?>