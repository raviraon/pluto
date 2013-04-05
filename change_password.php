<?php
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
// require(__DIR__ . "/lib/utils.php");
if(!$_POST['Change-Password']) {
	show_change_password_form();
	exit();
}

if( $_POST['Change-Password'] ){
    $db = new Database();
	$db->connect();

    $current_password = mysql_real_escape_string(stripslashes($_POST['current']));
	$new_password = mysql_real_escape_string(stripslashes($_POST['new']));
	$confirm_password = mysql_real_escape_string(stripslashes($_POST['confirm']));
		
	$error_msg = validate_form($current_password, $new_password, $confirm_password);
	if($error_msg != NULL){
		show_change_password_form($error_msg);
	}	
	// else{
	// 	save_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments);
	// 	done();
	// }
}

function validate_form($current_password, $new_password, $confirm_password){
	$error_msg='';
	if(!$current_password || !$new_password || !$confirm_password){
		$error_msg = "All fields in this page are mandatory";		
	}
	return $error_msg;
	// elseif(){
	// 	
	// }
}

function show_change_password_form($error_msg=''){
	require(__DIR__ . "/html/change_password.html");
}
	
?>