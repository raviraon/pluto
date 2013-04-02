<?php
ob_start();
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
require(__DIR__ . "/case.php");
require(__DIR__ . "/lib/utils.php");

if(!$_GET['case_id']) {
	header("Location: home.php");	
}

$db = new Database();
$db->connect();
$case_id = mysql_real_escape_string(stripslashes($_GET['case_id']));

$sql = "SELECT fusion_id, campaign, customer_name, open_date, close_date, status, created_at, updated_at, comments FROM case_details WHERE fusion_id = '$case_id'";

$result = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($result) != 0){
	$row = mysql_fetch_object($result);
	$campaign = $row->campaign;
	$customer_name = $row->customer_name;
	$fusion_id = $row->fusion_id;
	$open_date = format_date($row->open_date);
	$close_date = format_date($row->close_date);
	$status = $row->status;
	$created_at = $row->created_at;
	$updated_at = $row->updated_at;
	$comments = $row->comments;
	
	require("./html/view_form.html");
}
else{
	header("Location: home.php");	
}



