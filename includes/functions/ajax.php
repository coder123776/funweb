<?php
session_start();
include_once("../../includes/classes/database.php");
include_once("../../includes/functions/functions.php");
include_once("../../includes/controllers/UserController.php");
include_once("../../includes/classes/UserClasses.php");
include_once("../../includes/classes/ProductClasses.php");
include_once("../../includes/classes/FriendsClasses.php");
$userid = $_SESSION['userid'];


// Friends
$searchOptions = [
    'SearchNewFriends' => 5,
    'SearchFriends' => 1,
    'SearchFollowing' => 2,
    'SearchFollowers' => 3,
    'SearchGroups' => 4
];

foreach ($searchOptions as $postKey => $option) {
    if (isset($_POST[$postKey])) {
        $input = $_POST[$postKey];
        $Friend = new Friends($userid);
        
        if ($input !== '') {
            $result = $Friend->FindFriends($input, $option);
            $inputLength = strlen($input);
            
            if ($inputLength !== 0) {
                if ($result) {
                    foreach ($result as $friend) {
                        makeFriendsCard(($option === 5) ? 3 : 1, $friend['user_picture'], $friend['user_username']);
                    }
                } else {
                    echo "<h1 id='nofriends'>No Results Found</h1>";
                }
            } else {
                echo "<h1 id='nofriends'>No Results Found</h1>";
            }
        } else {
            $Friend->Myfriends("FRIENDS");
        }
        break;
    }
}



