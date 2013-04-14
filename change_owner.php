<?php
// ini_set('display_errors',1); 
//  error_reporting(E_ALL);

ob_start();
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
require(__DIR__ . "/case.php");
require(__DIR__ . "/lib/utils.php");

if(!$_POST['change_owner']) {
	go_to_home_page();
}

if( $_POST['change_owner'] ){
    $db = new Database();
	$db->connect();

    $case_owner = mysql_real_escape_string(stripslashes($_POST['current_case_owner']));
    $new_case_owner = mysql_real_escape_string(stripslashes($_POST['new_case_owner']));
    $customer_name = mysql_real_escape_string(stripslashes($_POST['customer_name']));
    $fusion_id = mysql_real_escape_string(stripslashes($_POST['fusion_id']));

	$error_message = validate_change_owner_form($case_owner, $new_case_owner);

	if($error_message != NULL){
		require("./html/change_owner.html");	
	}	
	else{
		$new_case_owner_id = get_new_case_owner_id($new_case_owner);
		update_case_owner($fusion_id, $case_owner, $new_case_owner, $new_case_owner_id);
		add_audit_trial($fusion_id, $case_owner, $new_case_owner);	
		go_to_home_page();
	}
}

function update_case_owner($fusion_id, $case_owner, $new_case_owner, $new_case_owner_id){
	$sql = "UPDATE case_details SET owner_id=$new_case_owner_id ,owner_name='$new_case_owner' WHERE fusion_id='$fusion_id' AND owner_name='$case_owner' ";
	mysql_query($sql) or die(mysql_error());
}

function add_audit_trial($fusion_id, $case_owner, $new_case_owner){
	$user_id = $_SESSION['user_id'];
	$user_name = $_SESSION['user'];
	
	$sql = "INSERT INTO audit_case_owner_change (fusion_id, old_case_owner, new_case_owner, updated_by_id, updated_by_name) VALUES('$fusion_id', '$case_owner', '$new_case_owner', $user_id, '$user_name')";
	mysql_query($sql) or die(mysql_error());
}

function go_to_home_page(){
	header("Location: home.php");	
}

function validate_change_owner_form($current_case_owner, $new_case_owner){
    $error_message = NULL;
	
	if($new_case_owner == NULL)
		$error_message .= "New Case Owner cannot be empty \n";

	if($new_case_owner == $current_case_owner)
		$error_message .= "New case owner and Current case owner cannot be same";
	
	return $error_message;	
}

function get_new_case_owner_id($new_case_owner){
	$new_case_owner_id;	
	$sql = "SELECT id FROM users WHERE username='$new_case_owner'";
	$result = mysql_query($sql) or die(mysql_error());

	if(mysql_num_rows($result) == 1){
		$row = mysql_fetch_row($result);
		return $row[0];
	}	

	go_to_home_page();	
}
