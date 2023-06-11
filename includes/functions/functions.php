<?php

// homepage


//keyword io1
function ShowCardParents($stmt, $whatid){
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div id="<?php echo "row" . $whatid?>" class="card-parent">
        <?php
            $cardCount = 0;
            $firstcard = true;
            foreach ($rows as $row) {
                if ($cardCount < 4){
                    if ($firstcard == true){
                        $firstcard = false;
                        ShowCards($whatid ."firstimage",$row['p_name'], $row['p_value'], $row['p_image'], $row['id']);
                        $cardCount ++;
                    }else{
                        ShowCards("secondimage",$row['p_name'], $row['p_value'], $row['p_image'], $row['id']);
                        $cardCount ++;
                    }
                }
            }
        ?>
    </div>
<?php
}

function ShowCards($divId, $name, $value, $image, $id){?>
    <form class="NoSHOW" action="../../web/p/product.php" method="post">
    <button class="NoSHOW" type="submit" name="product">
    <div id="" class="card">
        <img id="<?php echo $divId?>" class="card-text" src="<?php echo "../../images". $image?>">
        <h1 class="card-text"><?php echo $name?></h1>
        <p class="card-text">Value: <?php echo $value?></p>
    </div>
    </button>
    <input value="<?php echo $id ?>" type="hidden" name="productId">
    </form>
<?php
}


//keyword: i02
function io2Nav(){
    ?>
    <div class="i02-nav">
        <div class="i02-nav-one">
            <h1 onclick="highlights(1)" class="navbuttontext" id="highlhite1">Popular</h1>
            <h1 onclick="highlights(2)" class="navbuttontext" id="highlhite2">Trending</h1>
            <h1 onclick="highlights(3)" class="navbuttontext" id="highlhite3">Top</h1>
        </div>
        <div class="i02-nav-two">
            <div id="button1" class="divbutton">
                <h1>Value</h1>
            </div>
            <div id="button2" class="divbutton">
                <h1>Catagorie</h1>
            </div>
            <div id="button3" class="divbutton">
                <h1>View All</h1>
            </div>
        </div>
    </div>
    <hr class="i02">
    <?php
}
function makeTableParent($stmt, $type){
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table class="table">
        <tr><th id="table1">#</th><th id="table1"></th><th id="table2">Name</th><th id="table2">Value</th><th id="table2">Limiteds</th></tr>
        <?php
        if ($type == 1){
            $cardCount = 0;
            $startIndex = 5;
            foreach ($rows as $index => $row) {
                if ($cardCount < 4){
                    ?>
                    <?php
                    makeTable($startIndex + $index, $row['p_image'], $row['p_name'], $row['p_value'], $row['p_limiteds']);
                    $cardCount ++;
                    ?>
                    <?php
                }
            }
        }elseif ($type == 2){
            $cardCount = 0;
            foreach ($rows as $index => $row) {
                if ($cardCount < 4){
                    makeTable($index + 1, $row['p_image'], $row['p_name'], $row['p_value'], $row['p_limiteds']);
                    $cardCount ++;
                }
            }
        }
        ?>
    </table>
    <?php
    $result = $rows;
    return $result;
}
function makeTable($index, $image, $name, $value, $limiteds){?>
        <!-- <form class="NoSHOW" action="" method="post">
        <button class="NoSHOW" type="submit" name=""></button> -->
        <tr id="products">
            <td id="table1"><?php echo $index; ?></td>
            <td id="table1"><img class="tableimg" src="<?php echo "../../images". $image?>"></td>
            <td id="table2"><?php echo $name?></td>
            <td id="table2"><?php echo $value?></td>
            <td id="table2"><?php echo $limiteds?></td>
        </tr>
        <!-- </button>
        </form> -->
    <?php
}


//keyword: i03
function makeCardParenti03($title, $stmt){
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h1><?php echo $title ?></h1>
    <div class="balk">
        <?php
            $cardCount = 0;
            foreach ($rows as $row) {
                if ($cardCount < 5){
                    makeCardio3($row['p_name'], $row['p_creator'], $row['p_value'], $row['p_image']);
                    $cardCount ++;
                }
            }
        ?>
    </div>
    <?php
}
function makeCardio3($name, $creator, $value, $image){
    
    ?>
    <form class="NoSHOW" action="" method="post">
    <button class="NoSHOW" type="submit" name="">
    <div class="kaart">
        <img src="<?php echo "../../images". $image ?>">
        <div id="k1">
            <h1><?php echo $name ?></h1>
            <div id="k2">
                <div id="k3"><p id="gray">Creator</p><p><?php echo $creator ?></p></div>
                <div id="k3"><p id="gray">Value</p><p><?php echo $value ?></p></div>
            </div>
        </div>
    </div>
    </button>
    </form>
    <?php
}
function endCardsParent($title, $type){
    ?>
    <h1><?php echo $title ?></h1>
    <div class="balk">
    <?php
    if ($type == 1){
        makeEndCardio3("Art", "../../images/web/endArt.png");
        makeEndCardio3("Gaming", "../../images/web/endGame.png");
        makeEndCardio3("Memes", "../../images/web/endMemes.png");
        makeEndCardio3("Partnership", "../../images/web/endPartnership.png");
        makeEndCardio3("Cash Out", "../../images/web/endChashout.png");
        ?>
        </div>
        <?php
    }
}
function makeEndCardio3($name, $image){
    
    ?>
        <div class="kaart">
            <img src="<?php echo "../../images". $image ?>">
            <div id="k1">
                <h1><?php echo $name ?></h1>
            </div>
        </div>
    <?php
}

// FRIENDS PAGE
//keyword: friendsbody
function makeFriendsCard($type, $picture, $name){
    if ($type == 1){
        //Friend card
    ?>
    <div class="friends-card"><img src="<?php echo $picture ?>"><h1><?php echo $name ?></h1></div>
    <?php
    }elseif ($type == 2){
        //Friend request
    ?>
    <div class="friendRequest"><div class="friendRequest2"><img class="rqimg" src="<?php echo $picture ?>" class=""><div class="rq1">
    <div class="rq2"><h1><strong><?php echo $name ?></strong> Sent you a friend request.</h1></div>
    <div class="rq3"><button id="rqaccept" class="rqbtn">Accept</button>
    <button id="rqdecline" class="rqbtn">Decline</button>
    <button id="rqdismiss" class="rqbtn">Dismiss</button></div></div></div></div>
    <?php
    }elseif ($type == 3){
        //Friend Card Add
    ?>
    <div id="addFbtn" class="friends-card"><img src="<?php echo $picture ?>"><h1><?php echo $name ?></h1><button class="friendcardBtn" type="submit">Add friend</button></div>
    <?php
    }
}

// show owned products
function ownedProducts($Pmanger, $products) {
    foreach ($products as $product) {
        $serialNumber = $product['Serial'];
        $productID = $product['ID'];
        $userID = $product['User ID'];

        $checkifsold = $Pmanger->checkIfsold($productID, $userID, $serialNumber, 1);
        ?>
        <form class="NoSHOW" method="post">
        <div class="product">
            <div class="ownerInf">
                <p class="serial">serial #<?php echo $serialNumber ?> / 1000</p>
            </div>
            <div class="buy-parent">
                <?php
                if ($checkifsold === true){?>
                <button class="buybutton" name="cancelItem">Cancel</button>
                <?php
                }else{?>
                <button class="sellItem" name="sellItem">Sell</button>
                <?php
                }
                ?>
            </div>
        </div>
            <?php
            // CSRF-token voor security
            generateToken("serialId", $serialNumber);
            generateToken("productId", $productID);
            generateToken("userid", $userID);
            ?>
            <input type="hidden" name="serialId" value="<?php echo $serialNumber ?>">
            <input type="hidden" name="productId" value="<?php echo $productID ?>">
            <input type="hidden" name="userid" value="<?php echo $userID ?>">
        </form>
        <?php
    }
}

function generateToken($input, $value) {
    $_SESSION["POST_$input=$value"] = $input;
    return $input;
}
function getCSRFToken($input, $value) {
    if (isset($_SESSION["POST_$input=$value"])) {
        return $_SESSION["POST_$input=$value"];
    }
    return null;
}
function validateToken($input, $value) {
    if (isset($_SESSION["POST_$input=$value"])) {
        $isValid = $_SESSION["POST_$input=$value"] === $input;
        unset($_SESSION["POST_$input=$value"]);
        return $isValid;
    }
    return false;
}



// resellers
function resellers($username, $image, $serial, $price, $id, $type, $sellerId){
    generateToken("ItemId", $id);
    generateToken("serialId", $serial);
    generateToken("sellerId", $sellerId);
    ?>
    <form class="NoSHOW" method="post">
    <div class="product">
        <div class="ownerInf">
            <img class="owImg" src="<?php echo $image ?>">
            <h1 class="owName"><?php echo $username ?></h1>
            <p>-</p>
            <p class="serial">serial #<?php echo $serial ?> / 1000</p>
        </div>
        <div class="buy-parent">
            <h1 class="price"><?php echo $price ?></h1>
            <?php
            if ($type == 1){?>
            <button class="buybutton" name="buyItem">Buy</button>
            <?php
            }elseif ($type == 2){?>
            <button class="buybutton" name="cancelItem">Cancel</button>
            <?php
            }
            ?>
        </div>
    </div>
    <input type="hidden" name="ItemId" value="<?php echo $id ?>">
    <input type="hidden" name="serialId" value="<?php echo $serial ?>">
    <input type="hidden" name="sellerId" value="<?php echo $sellerId ?>">
    </form>
    <?php
}
function sellingScreen($userid, $username, $itemid, $productName, $productDiscription, $serialId, $userimage){
    generateToken("SELLuserId", $userid);
    generateToken("SELLusername", $username);
    generateToken("SELLitemid", $itemid);
    generateToken("SELLserial", $serialId);
    generateToken("SELLimage", $userimage);
    ?>
    <form class="NoSHOW" method="post">
    <div class="conform-sell-parent-blur">
    <div class="conform-sell-parent">
        <div onclick="GoToLocations('../../web/p/product.php')" class="close">
            <span class="material-symbols-outlined">close</span>
        </div>
        <img src="../../images/product/Fproduct1.png">
        <div class="conform-sell">
            <h1 class="sellingH1Conformation"><?php echo $productName ?></h1>
            <p class="productBeschrijving"><?php echo $productDiscription ?></p>
            <p class="">Limetid Item Nmr # <?php echo $serialId ?></p>
            <h1 class="sellingH1Conformation">SELLING ITEM</h1>
            <div class="conform">
                <input id="" class="setItemValue" name="itemValue" type="number" placeholder="Give a sell price.." max="999999999" value="" required>
                <button class="sellItemConformation" name="sellConformation">Sell Item</button>

                <input type="hidden" name="SELLuserId" value="<?php echo $userid ?>">
                <input type="hidden" name="SELLusername" value="<?php echo $username ?>">
                <input type="hidden" name="SELLitemid" value="<?php echo $itemid ?>">
                <input type="hidden" name="SELLserial" value="<?php echo $serialId ?>">
                <input type="hidden" name="SELLimage" value="<?php echo $userimage ?>">
            </div>
        </div>
    </div>
    </div>
    </form>
    <?php
}

function devCards($stmt){?>
    <div class="moreFromDev">
        <h1 class="devh1"><span class="material-symbols-outlined">library_books</span>&nbsp; More from developer</h1>
        <div class="devproducts">
    <?php
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $cardCount = 0;
    foreach ($rows as $row) {
        $image = $row['p_image'];
        $name = $row['p_name'];
        $value = $row['p_value'];
        if ($cardCount < 5){?>
            <div class="devcard"><img src="<?php echo "../../images". $image ?>"><p><?php echo $name ?></p><p><?php echo $value ?></p></div>
            <?php
            $cardCount ++;
        }
    }
    ?>
        </div>
    </div>
<?php
}
function sponsorCards($stmt){?>
    <div class="Sponsored">
        <h1 class="sponsorH1"><span class="material-symbols-outlined">handshake</span>&nbsp; Sponsored</h1>
        <div class="sponsoredItems">
        <?php
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $cardCount = 0;
        foreach ($rows as $row) {
            $image = $row['p_image'];
            $name = $row['p_name'];
            $value = $row['p_value'];
            if ($cardCount < 5){?>
                <div class="sponsorCard"><img src="<?php echo "../../images". $image ?>"><p><?php echo $name ?></p><p><?php echo $value ?></p></div>
                <?php
                $cardCount ++;
            }
        }
        ?>
    </div>
</div>
<?php
}
function showMedal($whatmedal){
    if ($whatmedal == 1){?>
    <h1 id="MedalBronze">&nbsp;&nbsp; Bronze</h1>
    <?php
    }elseif ($whatmedal == 2){?>
    <h1 id="MedalSilver">&nbsp;&nbsp; Silver</h1>
    <?php
    }elseif ($whatmedal == 3){?>
    <h1 id="MedalGold">&nbsp;&nbsp; Gold</h1>
    <?php
    }elseif ($whatmedal == 4){?>
    <h1 id="MedalPlatinum">&nbsp;&nbsp; Platinum</h1>
    <?php
    }elseif ($whatmedal == 5){?>
    <h1 id="MedalDiamond">&nbsp;&nbsp; Diamond</h1>
    <?php
    }elseif ($whatmedal == 6){?>
    <h1 id="MedalElite">&nbsp;&nbsp; Elite</h1>
    <?php
    }elseif ($whatmedal == 7){?>
    <h1 id="MedalMaster">&nbsp;&nbsp; Master</h1>
    <?php
    }elseif ($whatmedal == 8){?>
    <h1 id="MedalGrandMaster">&nbsp;&nbsp; GrandMaster</h1>
    <?php
    }elseif ($whatmedal == 9){?>
    <h1 id="MedalLegendary">&nbsp;&nbsp; Legendary</h1>
    <?php
    }
}
