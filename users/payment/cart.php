<?php
session_start();
$_SESSION['filetype'] = 2;
include_once("../../includes/classes/database.php");
include_once("../../includes/functions/functions.php");
include_once("../../includes/controllers/UserController.php");
include_once("../../includes/classes/UserClasses.php");
include_once("../../includes/classes/ProductClasses.php");
include_once("../../includes/defaults/header.php");
?>
<br>
<br>
<br>
<br>
<br>
<?php
$lastOnline = "5 june 2023";
$lastOnlineTimestamp = strtotime($lastOnline);
$currentTimestamp = time();
$timeDifference = $currentTimestamp - $lastOnlineTimestamp;
$yearsAgo = floor($timeDifference / (60 * 60 * 24 * 365));
$monthsAgo = floor($timeDifference / (60 * 60 * 24 * 30));
$daysAgo = floor($timeDifference / (60 * 60 * 24));
$hoursAgo = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));

if ($yearsAgo > 0) {
    echo $yearsAgo . " jaar geleden";
} elseif ($monthsAgo > 0) {
    echo $monthsAgo . " maand(en) geleden";
} elseif ($daysAgo > 1) {
    echo $daysAgo . " dagen geleden";
} elseif ($daysAgo === 1) {
    echo "1 dag geleden";
} else {
    echo $hoursAgo . " uur geleden";
}

include_once("../../includes/defaults/footer.php");
?>