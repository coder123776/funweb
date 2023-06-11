<?php
session_start();
$_SESSION['filetype'] = 2;
$_SESSION['WebAllowed'] = true;
$_SESSION['headerColor'] = "white";
include_once("../../includes/classes/database.php");
include_once("../../includes/functions/functions.php");
include_once("../../includes/controllers/UserController.php");
include_once("../../includes/classes/UserClasses.php");
include_once("../../includes/classes/ProductClasses.php");
include_once("../../includes/classes/FriendsClasses.php");
include_once("../../includes/defaults/header.php");

$productManager = new Products();

if (isset($_SESSION['userid'])){
    $welcomeText = "Welcome At FunWeb " . $user->getUsername();
}else{
    $welcomeText = "Welcome At FunWeb ";
}
?>
<link rel="stylesheet" href="../../css/web_index.css">
<title><?php echo $welcomeText ?></title>


<section id="index01" class="index-01">
    <h1 id="headingText" class="headingtext"><?php echo $welcomeText ?></h1>
    <div class="slider-parent">
                <?php
                $productManager->getProductsI01(1);
                $productManager->getProductsI01(2);
                $productManager->getProductsI01(3);
                ?>
    </div>
</section>

<section class="index-02">
    <?php
    io2Nav();
    ?>
    <div class="i02-body">
        <div class="table-parent">
            <?php
            $productManager->getProductsI02(2);
            $productManager->getProductsI02(1);
            ?>
        </div>
    </div>
</section>


<section class="index-03">
    <div class="balk-parent">
        <?php
        $productManager->getProductsI03(1);
        $productManager->getProductsI03(2);
        $productManager->getProductsI03(3);
        $productManager->getProductsI03(4);
        $productManager->getProductsI03("end");
        ?>
    </div>
</section>


<script>
    //dropdown
    var high1 = document.getElementById('highlhite1');
    var high2 = document.getElementById('highlhite2');
    var high3 = document.getElementById('highlhite3');


    function highlights(wich){
        if (wich == 1){
            high1.style.borderBottom = "0.5vh solid black";
            high2.style.borderBottom = "none";
            high3.style.borderBottom = "none";
        }else
        if (wich == 2){
            high1.style.borderBottom = "none";
            high2.style.borderBottom = "0.5vh solid black";
            high3.style.borderBottom = "none";
        }else
        if (wich == 3){
            high1.style.borderBottom = "none";
            high2.style.borderBottom = "none";
            high3.style.borderBottom = "0.5vh solid black";
        }
    }

    //text slider
    var slidetext = document.getElementById("headingText");
    slidetext.style.marginLeft = "-30vw";
    function textsliding(){
        slidetext.style.marginLeft = "5vw";
    }


    //card slider and colors calculator

    var bannerStatus = 1;
    var index = document.getElementById("index01");

    async function processImages() {
    var image1 = document.getElementById("1firstimage").src;
    var image2 = document.getElementById("2firstimage").src;
    var image3 = document.getElementById("3firstimage").src;
  
    var rgb1 = await getAverageImageColor(image1);
    var rgb2 = await getAverageImageColor(image2);
    var rgb3 = await getAverageImageColor(image3);
    index.style.background = "linear-gradient(0deg, white, " + rgb2 + ")";

    var startLoop = setInterval(function() {
        bannerLoop(rgb1, rgb2, rgb3);
    }, 5000);
    }

    function bannerLoop(rgb1, rgb2, rgb3) {
        var card_parent1 = document.getElementById("row1");
        var card_parent2 = document.getElementById("row2");
        var card_parent3 = document.getElementById("row3");

        if (bannerStatus === 1) {
    card_parent1.style.opacity = "0";
    setTimeout(function() {
        card_parent1.style.marginLeft = "90vw";
        card_parent2.style.marginLeft = "-90vw";
        card_parent3.style.marginLeft = "0vw";
        index.style.background = "linear-gradient(0deg, white, " + rgb3 + ")";
    }, 1000);
    setTimeout(function() {
        card_parent1.style.opacity = "1";
    }, 5000);
    bannerStatus = 2;
    } else if (bannerStatus === 2) {
    card_parent2.style.opacity = "0";
    setTimeout(function() {
        card_parent1.style.marginLeft = "0vw";
        card_parent2.style.marginLeft = "90vw";
        card_parent3.style.marginLeft = "-90vw";
        index.style.background = "linear-gradient(0deg, white, " + rgb1 + ")";
    }, 1000);
    setTimeout(function() {
        card_parent2.style.opacity = "1";
    }, 5000);
    bannerStatus = 3;
    } else if (bannerStatus === 3) {
    card_parent3.style.opacity = "0";
    setTimeout(function() {
        card_parent1.style.marginLeft = "-90vw";
        card_parent2.style.marginLeft = "0vw";
        card_parent3.style.marginLeft = "90vw";
        index.style.background = "linear-gradient(0deg, white, " + rgb2 + ")";
    }, 1000);
    setTimeout(function() {
        card_parent3.style.opacity = "1";
    }, 5000);
    bannerStatus = 1;
    }
    }

    window.onload = function() {
    processImages();
    setTimeout(textsliding(), 1000);
    };


</script>

<?php
include_once("../../includes/defaults/footer.php");