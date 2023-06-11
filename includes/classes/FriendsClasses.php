<?php


class Friends extends database{
    private $userid;
    public function __construct($userid){
        $this->userid = $userid;
    }
    private function getFriend($status){
        $stmt = $this->connect()->prepare("SELECT friends.friend_sender, friends.friend_reciver FROM `user`, `friends`
        WHERE user.user_id = ? AND friends.friend_status = ?
        AND (friends.friend_sender = ? OR friends.friend_reciver = ?);");
        if (!$stmt->execute(array($this->userid, $status, $this->userid, $this->userid))) {
            $stmt = null;
            header("location: ../../web/main/index.php?fail");
            exit();
        }
        $result = null;
        if ($stmt->rowCount() == 0){
            $result = false;
        }else{
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $row;
        }
        $stmt = null;
        return $result;
    }
    private function getfriends($status) {
        $relation = $this->getFriend($status);
        $friendId = [];
        if ($relation) {
            foreach ($relation as $friend) {
                if ($status == "FRIENDS" && $friend['friend_sender'] === $this->userid) {
                    $friendId[] = $friend['friend_reciver'];
                } elseif ($status == "FRIENDS" && $friend['friend_reciver'] === $this->userid) {
                    $friendId[] = $friend['friend_sender'];
                } elseif ($status == "REQUEST" && $friend['friend_reciver'] === $this->userid) {
                    $friendId[] = $friend['friend_sender'];
                } 
            }
        }
    
        return $friendId ?: false;
    }
    
    private function getFriendsInfo($friendId){
        $stmt = $this->connect()->prepare("SELECT user_id, user_username, user_email, user_name, user_picture, user_onlineDate, 
        user_country, user_description, user_online FROM `user` WHERE user_id = ?;");
        if (!$stmt->execute(array($friendId))) {
            $stmt = null;
            header("location: ../../web/main/index.php?fail");
            exit();
        }
        $result = null;
        if ($stmt->rowCount() == 0){
            $result = false;
        }else{
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $row;
        }
        $stmt = null;
        return $result;
    }
    private function FriendArray($status){
        $friendIds = $this->getfriends($status);
        $friend = array();
        if ($friendIds){
            foreach ($friendIds as $friendId){
                $friend[] = $this->getFriendsInfo($friendId);
            }
        }else{
            $friend = false;
        }
        return $friend;
    }
    public function FindFriends($searchTerm, $type) {
        $result = null;
        $searchTerm = "%$searchTerm%";
        $userid = $this->userid;
    
        if ($type == 1){
            $stmt = $this->connect()->prepare("SELECT user_id, user_username, user_email, user_name, user_picture, user_onlineDate, user_country, user_description, user_online FROM user, friends WHERE user_username LIKE :searchTerm AND (friends.friend_sender = '$userid' AND friends.friend_status = 'FRIENDS' OR friends.friend_reciver = '$userid' AND friends.friend_status = 'FRIENDS') AND NOT user_id = '$userid';");
        } elseif ($type == 2 || $type == 3 || $type == 4 || $type == 5) {
            $stmt = $this->connect()->prepare("SELECT user_id, user_username, user_email, user_name, user_picture, user_onlineDate, user_country, user_description, user_online FROM user, friends WHERE user_username LIKE :searchTerm AND NOT user_id = '$userid';");
        }
    
        $stmt->bindParam(":searchTerm", $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt = null;
        return $result;
    }
    
    
    public function Myfriends($status, $searchTerm = null) {
        $friends = $this->FriendArray($status);
        if ($status == "FRIENDS"){
            if ($friends){
                foreach ($friends as $friend){
                    makeFriendsCard(1, $friend[0]['user_picture'], $friend[0]['user_username']);
                }
            }else{
                $friends = $this->FriendArray("FRIENDS");
                if ($friends == false){
                    echo "<h1 id='nofriends'>You don't Have Any Friends</h1>";
                }else{
                    echo "<h1 id='nofriends'>No Results Found</h1>";
                }
            }
        } elseif ($status == "REQUEST") {
            if ($friends){
                foreach ($friends as $friend){
                    makeFriendsCard(1, $friend[0]['user_picture'], $friend[0]['user_username']);
                }
            }else{
                echo "<h1 id='nofriendRequest'></h1>";
            }
        }
    }

    public function countFriends() {
        $friends = $this->FriendArray("FRIENDS");
        if ($friends) {
            $count = count($friends);
            echo "Your Friends: " . $count . " / 200";
        } else {
            echo "Your Friends: 0 / 200";
        }
    }

}