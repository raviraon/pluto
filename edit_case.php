<?php
ob_start();
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
require(__DIR__ . "/lib/utils.php");
require(__DIR__ . "/case.php");

$db = new Database();
$db->connect();

if($_POST['submit']) {
    $campaign = mysql_real_escape_string(stripslashes($_POST['campaign']));
	$customer_name = mysql_real_escape_string(stripslashes($_POST['cust_name']));
	$fusion_id = mysql_real_escape_string(stripslashes($_POST['fusion_id']));
	$open_date = mysql_real_escape_string(stripslashes($_POST['open_date']));
	$status = mysql_real_escape_string(stripslashes($_POST['case_status']));
	$closed_date = mysql_real_escape_string(stripslashes($_POST['close_date']));
	$comments = mysql_real_escape_string(stripslashes($_POST['comments']));
	$case_unique_id = mysql_real_escape_string(stripslashes($_POST['case_unique_id']));
	$error_msg = validate_form($customer_name, $fusion_id, $open_date);
	if($error_msg != NULL){
		show_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments, $error_msg, $case_unique_id);
	}	
	else{
		update_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments, $case_unique_id);
		done($fusion_id);
	}
}

if(!$_GET['case_id']) {
	header("Location: home.php");	
}
else{
	$case_id = mysql_real_escape_string(stripslashes($_GET['case_id']));
	$sql = "SELECT id, fusion_id, campaign, customer_name, open_date, close_date, status, comments FROM case_details WHERE fusion_id = '$case_id'";
	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result) != 0){
		$row = mysql_fetch_object($result);
		$campaign = $row->campaign;
		$customer_name = $row->customer_name;
		$fusion_id = $row->fusion_id;
		$open_date = $row->open_date;
		$closed_date = $row->close_date;
		$status = $row->status;
		$comments = $row->comments;
		$id = $row->id;

		require("./html/form.html");
	}
	else{
		header("Location: home.php");	
	}
}

function show_form($campaign='', $customer_name='', $fusion_id='', $open_date='', $status='', $closed_date='', $comments='', $error_message='', $id=''){
	require(__DIR__ . "/html/form.html");
}

function done($fusion_id){	
	header("Location: view_case.php?case_id=$fusion_id");	
}



