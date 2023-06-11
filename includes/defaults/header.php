<?php
if (isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
    $user = new CheckUser($userid);
    $Friend = new Friends($userid);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" type="image/x-icon" href="<?php if($_SESSION['filetype'] == 1){echo "../../images/header/logo.png";}elseif($_SESSION['filetype'] == 2){echo "../../images/header/logo.png";}?>">
    <!-- <script src="../../app/header.js"></script> -->
</head>

<body>
<div class="dropdown-parent" id="dropdown-parent"></div>
<div id="dropdown-porfile" class="dropdown-porfile">
    <div class="dropdown-profs"><span class="material-symbols-outlined">person</span><h1>Profile</h1></div>
    <div onclick="GoToLocations('../../users/start/logout.php')" class="dropdown-profs"><span class="material-symbols-outlined">logout</span><h1>Log Out</h1></div>
</div>


<nav class="navbody" id="navbody">
    <div class="navbody-child1">
        <div onclick="slide()" class="lines" id="lines">
            <div id="line1" class="line"></div>
            <div id="line2" class="line"></div>
            <div id="line3" class="line"></div>
        </div>
    </div>

    <div onclick="GoToLocations('../../web/main/index.php')" class="navbody-child2">
        <img id="logo" src="../../images/header/logo.png">
    </div>

    <div class="navbody-child3">
        <?php
        if (isset($userid)){?>
        <div class="child3">
            <img onclick="slide2()" id="userlog1" class="profileIcons" src="<?php echo "../../images". $user->getPicture(); ?>">
        </div>
        <div class="child3">
            <span onclick="GoToLocations('../../users/payment/cart.php')" id="headericon1" class="material-symbols-outlined">shopping_cart</span>
        </div>
        <div class="child3">
            <span onclick="GoToLocations('../../users/social/friends.php')" id="headericon2" class="material-symbols-outlined">group</span>
        </div>
        <div class="child3">
            <span onclick="GoToLocations('../../users/payment/wishlist.php')" id="headericon3" class="material-symbols-outlined">favorite</span>
        </div>
        <?php
        }else{?>

        <div id="userlog" class="child3">
            <a id="c3a1" class="Headersignbuttons" href="../../users/start/login.php">Login</a>
            <a id="c3a2" class="Headersignbuttons" href="../../users/start/signup.php">Sign Up</a>
        </div>
        <?php
        }?>
        <div class="child3"></div>
    </div>
</nav>
</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    //dropdown function
    var line1 = document.getElementById('line1');
    var line2 = document.getElementById('line2');
    var line3 = document.getElementById('line3');
    var dropdown = document.getElementById('dropdown-parent');
    var isSlided = false;

    function slide() {
        if (isSlided == false) {
            line1.style.marginTop = "3vh";
            line3.style.marginTop = "3vh";
            dropdown.style.marginLeft = "-2vw";
            isSlided = true;
        } else {
            line1.style.marginTop = "1vh";
            line3.style.marginTop = "5vh";
            dropdown.style.marginLeft = "-30vw";
            isSlided = false;
        }
    }

    $(function() {
    var scrollTriggered = false;
    $(window).on("scroll", function() {
        if ($(window).scrollTop() > 50 && !scrollTriggered) {
            $(".navbody").addClass("navactive");
            changeIcons();
            scrollTriggered = true;
        } else if ($(window).scrollTop() <= 50 && scrollTriggered) {
            $(".navbody").removeClass("navactive");
            changeIcons();
            scrollTriggered = false;
        }
    });
});

    //dropdown 2 slide
    var dropdown2 = document.getElementById('dropdown-porfile');
    var isSlided2 = false;
    function slide2(){
        if (isSlided2 == false) {
            dropdown2.style.top = "10vh";
            dropdown2.style.opacity = "1";
            dropdown2.style.pointerEvents = "all";
            isSlided2 = true;
        } else {
            dropdown2.style.top = "12vh";
            dropdown2.style.opacity = "0";
            dropdown2.style.pointerEvents = "none";
            isSlided2 = false;
        }
    }

    function getAverageImageColor(image) {
        return new Promise(function(resolve, reject) {
            var img = document.createElement('img');
            img.src = image;

            img.onload = function() {
                var canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                var context = canvas.getContext('2d');
                context.drawImage(img, 0, 0);

                var imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                var pixels = imageData.data;
                var pixelCount = pixels.length / 4;
                var totalRed = 0;
                var totalGreen = 0;
                var totalBlue = 0;

                for (var i = 0; i < pixels.length; i += 4) {
                    totalRed += pixels[i];
                    totalGreen += pixels[i + 1];
                    totalBlue += pixels[i + 2];
                }

                var avgRed = Math.round(totalRed / pixelCount);
                var avgGreen = Math.round(totalGreen / pixelCount);
                var avgBlue = Math.round(totalBlue / pixelCount);

                var avgColor = 'rgb(' + avgRed + ', ' + avgGreen + ', ' + avgBlue + ')';
                resolve(avgColor);
            };

            img.onerror = function() {
                reject(new Error('Fout bij het laden van de afbeelding.'));
            };
        });
    }

    var defaultColor = "white";
    var firstColor = "black";
    var secondCollor = "white";

    var headerColors = true;
    var Htext1 = document.getElementById("c3a1");
    var Htext2 = document.getElementById("c3a2");
    var cartIcon = document.getElementById("headericon1");
    var friendIcon = document.getElementById("headericon2");
    var wishlistIcon = document.getElementById("headericon3");
    var userOnline =false;

    <?php
    if (isset($_SESSION['userid'])) {
        if ($_SESSION['headerColor'] == "black") {?>
            defaultColor = "black";
            firstColor = "black";
            secondCollor = "black";
            <?php
        }
        ?>
        userOnline = true;
        <?php
    }elseif ($_SESSION['headerColor'] == "black"){?>
            defaultColor = "black";
            firstColor = "black";
            secondCollor = "black";
    <?php
    }
    ?>
    function changeIcons() {
        if (userOnline == true){
            if (headerColors == true) {
                line1.style.backgroundColor = firstColor;
                line2.style.backgroundColor = firstColor;
                line3.style.backgroundColor = firstColor;
                cartIcon.style.color = firstColor;
                friendIcon.style.color = firstColor;
                wishlistIcon.style.color = firstColor;
                headerColors = false;
            } else {
                line1.style.backgroundColor = secondCollor;
                line2.style.backgroundColor = secondCollor;
                line3.style.backgroundColor = secondCollor;
                cartIcon.style.color = secondCollor;
                friendIcon.style.color = secondCollor;
                wishlistIcon.style.color = secondCollor;
                headerColors = true;
            }
        }else{
            if (headerColors == true) {
                line1.style.backgroundColor = firstColor;
                line2.style.backgroundColor = firstColor;
                line3.style.backgroundColor = firstColor;
                Htext1.style.color = firstColor;
                Htext2.style.color = firstColor;
                headerColors = false;
            } else {
                line1.style.backgroundColor = secondCollor;
                line2.style.backgroundColor = secondCollor;
                line3.style.backgroundColor = secondCollor;
                Htext1.style.color = secondCollor;
                Htext2.style.color = secondCollor;
                headerColors = true;
            }
        }
    }
</script>