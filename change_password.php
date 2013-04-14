<?php
// ini_set('display_errors',1); 
//  error_reporting(E_ALL);
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");

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
	else{
		update_password($new_password);
		logout();
	}
}

function update_password($new_password){
	$id = $_SESSION['user_id'];
	$sql = "UPDATE users SET password=md5('$new_password') WHERE id=$id";
	mysql_query($sql) or die(mysql_error());
}

function check_current_password($password){
	$id = $_SESSION['user_id'];
	$sql = "SELECT * FROM users WHERE id=$id AND password=md5('$password')";
	$result = mysql_query($sql) or die(mysql_error());
	return mysql_num_rows($result) == 1;
}

function validate_form($current_password, $new_password, $confirm_password){
	$error_msg='';
	if(!$current_password || !$new_password || !$confirm_password){
		$error_msg = "All fields in this page are mandatory";		
	}
	elseif($new_password != $confirm_password){
		$error_msg = "New Password and Confirm Password does not match.";		
	}
	elseif(strlen($new_password) < 6){
		$error_msg = "Password should be minimum 6 charecters";		
	}
	elseif($current_password == $new_password){
		$error_msg = "Current and New password cannot be same.";		
	}

	elseif(!check_current_password($current_password)){
		$error_msg = "Incorrect password";		
	}
	return $error_msg;
}


function show_change_password_form($error_msg=''){
	require(__DIR__ . "/html/change_password.html");
}

function logout(){
	$error_message='Successfully updated to new password';
	header("Location: logout.php");	
	
}
	
?>