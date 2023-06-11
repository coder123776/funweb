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

<?php
include_once("../../includes/defaults/footer.php");
?>