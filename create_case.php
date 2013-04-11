<?php
ob_start();
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
require(__DIR__ . "/lib/utils.php");
require(__DIR__ . "/case.php");

if(!$_POST['submit']) {
	show_form();
	exit();
}

if( $_POST['submit'] ){
    $db = new Database();
	$db->connect();

    $campaign = mysql_real_escape_string(stripslashes($_POST['campaign']));
	$customer_name = mysql_real_escape_string(stripslashes($_POST['cust_name']));
	$fusion_id = mysql_real_escape_string(stripslashes($_POST['fusion_id']));
	$open_date = mysql_real_escape_string(stripslashes($_POST['open_date']));
	$status = mysql_real_escape_string(stripslashes($_POST['case_status']));
	$closed_date = mysql_real_escape_string(stripslashes($_POST['close_date']));
	$comments = mysql_real_escape_string(stripslashes($_POST['comments']));
	
	$case = new CaseObj($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments);
	$error_msg = validate_form($customer_name, $fusion_id, $open_date, $campaign);
	if($error_msg != NULL){
		show_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments, $error_msg);
	}	
	else{
	
		save_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments);
		done();
	}
}


function show_form($campaign='', $customer_name='', $fusion_id='', $open_date='', $status='', $closed_date='', $comments='', $error_message=''){
	require(__DIR__ . "/html/form.html");
}

function done(){	
	header("Location: home.php");	
}

?>
