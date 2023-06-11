<?php

class Products extends database{
    private function databaseQuery($query, $type, $creator = null){
        $stmt = $this->connect()->prepare($query);
        if ($creator){
            if (!$stmt->execute(array($creator))) {
                $stmt = null;
                header("location: ../../web/main/index.php?fail");
                exit();
            }
        }else{
            if (!$stmt->execute()) {
                $stmt = null;
                header("location: ../../web/main/index.php?fail");
                exit();
            }
        }
        $result = null;
        if ($stmt->rowCount() == 0){
            $result = false;
        }else{
            // io1
            if ($type == 5){
                ShowCardParents($stmt, 1);
            }
            if ($type == 6){
                ShowCardParents($stmt, 2);
            }
            if ($type == 7){
                ShowCardParents($stmt, 3);
            }
            // io2
            if ($type == 1){
                makeTableParent($stmt, 1);
            }
            if ($type == 2){
                makeTableParent($stmt, 2);
            }
            // io3
            if ($type == 3){
                makeCardParenti03(date("F"). " Spotlights", $stmt);
            }
            if ($type == 4){
                makeCardParenti03("Trending in Art", $stmt);
            }
            if ($type == 9){
                makeCardParenti03("Trending in Gaming", $stmt);
            }
            if ($type == 10){
                makeCardParenti03("Trending in Memes", $stmt);
            }
            if ($type == "end"){
                endCardsParent("Explore Catagories", 1);
            }
            // developer && sponsored cards
            if ($type == "developer"){
                devCards($stmt);
            }
            if ($type == "sponsor"){
                sponsorCards($stmt);
            }

        }
        $stmt = null;
        return $result;
    }


    //keyword i01
    public function getProductsI01($type){
        if ($type == 1){
            $result = $this->databaseQuery("SELECT p_name, p_value, p_limiteds, p_image, id FROM `product` ORDER BY `product`.`p_owners` DESC LIMIT 8, 100", 5);
            return $result;
        }
        if ($type == 2){
            $result = $this->databaseQuery("SELECT p_name, p_value, p_limiteds, p_image, id FROM `product` ORDER BY `product`.`p_owners` DESC LIMIT 0, 100", 6);
            return $result;
        }
        if ($type == 3){
            $result = $this->databaseQuery("SELECT p_name, p_value, p_limiteds, p_image, id FROM `product` ORDER BY `product`.`p_owners` DESC LIMIT 4, 100", 7);
            return $result;
        }
    }
    //keyword: i02
    public function getProductsI02($type){
        if ($type == 1){
                $result = $this->databaseQuery("SELECT p_name, p_value, p_limiteds, p_image FROM `product` ORDER BY `product`.`p_owners` DESC LIMIT 5, 100", 1);
                return $result;
            }else{
                $result = $this->databaseQuery("SELECT p_name, p_value, p_limiteds, p_image FROM `product` ORDER BY `product`.`p_owners` DESC LIMIT 0, 100", 2);
                return $result;
            }
    }
    //keyword: i03
    public function getProductsI03($type){
        if ($type == 1){
            $result = $this->databaseQuery("SELECT p_name, p_value, p_image, p_creator FROM `product` ORDER BY `product`.`p_owners` DESC LIMIT 0, 100", 3);
            return $result;
        }elseif ($type == 2){
            $result = $this->databaseQuery("SELECT p_name, p_value, p_image, p_creator FROM `product` ORDER BY `product`.`p_owners` DESC LIMIT 0, 100", 4);
            return $result;
        }elseif ($type == 3){
                $result = $this->databaseQuery("SELECT p_name, p_value, p_image, p_creator FROM `product` ORDER BY `product`.`p_owners` DESC LIMIT 0, 100", 9);
                return $result;
        }elseif ($type == 4){
                $result = $this->databaseQuery("SELECT p_name, p_value, p_image, p_creator FROM `product` ORDER BY `product`.`p_owners` DESC LIMIT 0, 100", 10);
                return $result;
        }elseif ($type == "end"){
            $result = $this->databaseQuery("SELECT p_name, p_value, p_image, p_creator FROM `product` ORDER BY `product`.`p_owners` DESC LIMIT 0, 100", "end");
            return $result;
        }
    }
    // for the grapic
    public function getdataforGrapic($productId){
        $stmt = $this->connect()->prepare("SELECT * FROM product WHERE id = ?");
        if (!$stmt->execute(array($productId))) {
            $stmt = null;
            header("location: ../../web/main/index.php?fail");
            exit();
        }
        $result = null;
        if ($stmt->rowCount() == 0){
            $result = false;
        }else{
            $maandenData = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $prijzen = explode(',', $row['p_historyprices']);
                foreach ($prijzen as $index => $prijs) {
                    $maandenData[] = $prijs;
                }
            }
            $result = implode(',', $maandenData);
        }
        $stmt = null;
        return $result;
    }
    // get the owners from limetids
    private function getOwnedProducts($productId, $userid, $type, $AddOrDelete = null, $serialV = null) {
        $database = new Database();
        $conn = $database->connect();
        $stmt = $conn->prepare("SELECT user_id, user_ownedproduct FROM user where user_id = ?;");
        if (!$stmt->execute(array($userid))) {
            $stmt = null;
            header("location: ../../web/main/index.php?fail");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $resellers = false;
        } else {
            $resellers = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $userId = $row["user_id"];
                $ownedProducts = $row["user_ownedproduct"];
                $products = explode(",", $ownedProducts);
                if ($type == 1){
                foreach ($products as $product) {
                    $parts = explode(";", $product);
                    if (count($parts) == 2) {
                            $serialValue = substr($parts[0], strpos($parts[0], '=') + 1);
                            $idValue = $parts[1];
                            if ($idValue == $productId) {
                                $resellerData = array(
                                    'Serial' => $serialValue,
                                    'ID' => $idValue,
                                    'User ID' => $userId
                                );
                                $resellers[] = $resellerData;
                            }
                        }
                    }
                }elseif ($type == 2){

                    $checkItem = $conn->prepare("SELECT user_ownedproduct FROM user where user_id = ?;");
                    if (!$checkItem->execute(array($userid))) {
                        $checkItem = null;
                        header("location: ../../web/main/index.php?fail");
                        exit();
                    } 
                    if ($checkItem->rowCount() == 0) {
                        $result = false;
                    } else {
                        if ($item = $checkItem->fetch(PDO::FETCH_ASSOC)){
                            $ownedItems = $item["user_ownedproduct"];

                            if ($AddOrDelete == "delete"){
                                $toRemove = "serial=$serialV;$productId";
                                $updatedItems = str_replace($toRemove, "", $ownedItems);
                                $updatedItems = str_replace(",,", ",", $updatedItems);
                                $updatedItems = trim($updatedItems, ",");
                                $itemsArray = explode(",", $updatedItems);
                                $updatedItemsString1 = implode(",", $itemsArray);

                                $update = $this->connect()->prepare("UPDATE user SET user_ownedproduct = ? WHERE user_id = ?;");
                                if (!$update->execute(array($updatedItemsString1, $userid))) {
                                    $update = null;
                                    header("location: ../../web/main/index.php?fail");
                                    exit();
                                }
                                $update = null;
                                $this->cancelReselling($userId, $productId, $serialV);
                            }elseif ($AddOrDelete == "add"){
                                $toAdd = "serial=$serialV;$productId";
                                $updatedItems = $ownedItems . "," . $toAdd;
                                $updatedItems = str_replace(",,", ",", $updatedItems);
                                $updatedItems = trim($updatedItems, ",");
                                $itemsArray = explode(",", $updatedItems);
                                $updatedItemsString2 = implode(",", $itemsArray);

                                $update2 = $this->connect()->prepare("UPDATE user SET user_ownedproduct = ? WHERE user_id = ?;");
                                if (!$update2->execute(array($updatedItemsString2, $userid))) {
                                    $update2 = null;
                                    header("location: ../../web/main/index.php?fail");
                                    exit();
                                }
                                $update2 = null;
                            }
                        }
                    }
                }
            }
        }
        $stmt = null;
        $checkItem = null;
        return $resellers;
    }
    public function ownedProducts($pmnger, $productId, $userId){
        $products = $this->getOwnedProducts($productId, $userId, 1);
        ownedProducts($pmnger, $products);
        return $products;
    }
    private function getResellers($productId, $userid = null, $prodserial = null, $type = null){
        $stmt = $this->connect()->prepare("SELECT * FROM resellers WHERE r_limited = ? ORDER BY `resellers`.`r_price` ASC");
        if (!$stmt->execute(array($productId))) {
            $stmt = null;
            header("location: ../../web/main/index.php?fail");
            exit();
        }
        $result = null;
        if ($stmt->rowCount() == 0){
            $result = false;
        }else{
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $username = $row['r_name'];
                $serial = $row['r_serial'];
                $price = $row['r_price'];
                $image = $row['r_image'];
                $reselUser = $row['r_userid'];
                $LimetidId = $row['r_limited'];
                $id = $row['id'];
                if ($type == 1){
                    if ($LimetidId == $productId && $reselUser == $userid && $serial == $prodserial){
                        $result = true;
                    }
                }else{
                    $result = true;
                    if ($userid === $reselUser){
                        resellers($username, $image, $serial, $price, $id, 2, $reselUser);
                    }else{
                        resellers($username, $image, $serial, $price, $id, 1, $reselUser);
                    }
                }
            }
        }
        $stmt = null;
        return $result;
    }
    public function resellers($productId, $userid){
        $result = $this->getResellers($productId, $userid);
        return $result;
    }
    public function checkIfsold($productId, $userid, $prodserial, $type){
        $result = $this->getResellers($productId, $userid, $prodserial, $type);
        return $result;
    }
    // get products
    private function getProducts($productId, $type) {
        $stmt = $this->connect()->prepare("SELECT * FROM product WHERE id = ?");
        if (!$stmt->execute(array($productId))) {
            $stmt = null;
            header("location: ../../web/main/index.php?fail");
            exit();
        }
    
        $result = false;
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $columnMapping = [
                "name" => "p_name",
                "value" => "p_value",
                "description" => "p_description",
                "image" => "p_image",
                "company" => "p_company",
                "tags" => "p_tags",
                "limiteds" => "p_limiteds",
                "creator" => "p_creator",
                "medal" => "p_medal",
                "startdate" => "p_startdate",
                "owners" => "p_owners",
                "views" => "p_views",
                "favorites" => "p_favorites",
                "likes" => "p_likes",
                "dislikes" => "p_dislikes",
                "historyprices" => "p_historyprices",
                "sponsor" => "p_sponsor"
            ];
    
            if (array_key_exists($type, $columnMapping)) {
                $result = $row[$columnMapping[$type]];
            }
        }
    
        $stmt = null;
        return $result;
    }
    
    public function getproduct($productId, $type){
        return $this->getProducts($productId, $type);
    }
    // add te resellers
    private function addReseller($userid, $name, $limetid, $serial, $value, $image){
        $stmt = $this->connect()->prepare("INSERT INTO resellers (r_userid, r_name, r_limited, r_serial, r_price, r_image) VALUES (?, ?, ?, ?, ?, ?);");
        if (!$stmt->execute(array($userid, $name, $limetid, $serial, $value, $image))) {
            $stmt = null;
            header("location: ../../web/main/index.php?fail");
            exit();
        }
        $stmt = null;
    }
    public function resel($userid, $name, $limetid, $serial, $value, $image){
        $this->addReseller($userid, $name, $limetid, $serial, $value, $image);
    }
    // cancel resel
    private function cancelReselling($userid, $productid, $serialid){
        $stmt = $this->connect()->prepare("DELETE FROM resellers WHERE r_userid = ? AND r_limited = ? AND r_serial = ?");
        if (!$stmt->execute(array($userid, $productid, $serialid))) {
            $stmt = null;
            header("location: ../../web/main/index.php?fail");
            exit();
        }
        $stmt = null;
    }
    public function cancel($userid, $productid, $serialid){
        $this->cancelReselling($userid, $productid, $serialid);
    }
    public function sales($productId, $userId){
        $products = $this->getOwnedProducts($productId, $userId, 1);
        return $products;
    }
    public function buyItem($productid, $serialid, $userid, $resellerid){
        $this->getOwnedProducts($productid, $userid, 2, "add", $serialid);
        $this->getOwnedProducts($productid, $resellerid, 2, "delete", $serialid);
    }
    public function getDevItems($type, $creator){
        if ($type == 1){
            $this->databaseQuery("SELECT * FROM product WHERE p_creator = ?", "developer", $creator);
        }elseif ($type == 2){
            $this->databaseQuery("SELECT * FROM product", "sponsor");
        }
    }
    
}
