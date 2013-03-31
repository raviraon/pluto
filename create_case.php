<?php
ob_start();
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
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
	$error_msg = validate_form($customer_name, $fusion_id, $open_date);
	if($error_msg != NULL){
		show_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments, $error_msg);
	}	
	else{
	
		save_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments);
		done();
	}
}

function save_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments){
	$user_id = $_SESSION["user_id"];
	$user_name = $_SESSION["user"];
	
	if($closed_date == ""){
		$closed_date = "null";
	}
	else{
		$closed_date = "'".$closed_date."'";
	}
	
	$sql = "INSERT INTO case_details (user_id, user_name, campaign, customer_name, fusion_id, open_date, status, close_date, comments, updated_by) VALUES (1, '$user_name', '$campaign', '$customer_name', '$fusion_id', '$open_date', '$status', $closed_date, '$comments', '$user_name')";
	$result= mysql_query($sql) or die(mysql_error());
}

function validate_form($customer_name, $fusion_id, $open_date){
    $error_message = NULL;
	
	if($customer_name == NULL)
		$error_message .= "Customer Name : ";
	
	if($fusion_id == NULL)
		$error_message .= "Fusion ID : ";

	if($open_date == NULL)
		$error_message .= "Open Date  ";
		
	if($error_message != NULL)
		$error_message .= " cannot be empty. ";
		$error_message = str_replace(":", "/", $error_message);

	$sql = "SELECT id from case_details where fusion_id = '$fusion_id'";
	$result= mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result) != 0)
		$error_message .= " Fusion ID : " . $fusion_id . " already exists"; 
	
	return $error_message;
}

function show_form($campaign='', $customer_name='', $fusion_id='', $open_date='', $status='', $closed_date='', $comments='', $error_message=''){
	require(__DIR__ . "/html/form.html");
}

function done(){	
	header("Location: home.php");	
}

?>
