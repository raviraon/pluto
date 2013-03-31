<?php
ob_start();
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
require(__DIR__ . "/case.php");
if(!$_GET['case_id']) {
	header("Location: home.php");	
}

$db = new Database();
$db->connect();

$case_id = mysql_real_escape_string(stripslashes($_GET['case_id']));


