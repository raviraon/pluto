<?php
ob_start();
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
require(__DIR__ . "/case.php");

if( $_POST['submit'] ){
    $db = new Database();
	$db->connect();

    $campaign = mysql_real_escape_string(stripslashes($_POST['campaign']));
	$customer = mysql_real_escape_string(stripslashes($_POST['cust_name']));
	$fusion_id = mysql_real_escape_string(stripslashes($_POST['fusion_id']));
	$open_date = mysql_real_escape_string(stripslashes($_POST['open_date']));
	$status = mysql_real_escape_string(stripslashes($_POST['case_status']));
	$closed_date = mysql_real_escape_string(stripslashes($_POST['close_date']));
	$comments = mysql_real_escape_string(stripslashes($_POST['comments']));
	
	$case = new CaseObj($campaign, $customer, $fusion_id, $open_date, $status, $closed_date, $comments);
	validate_form($case);
	save_form($campaign, $customer, $fusion_id, $open_date, $status, $closed_date, $comments);
}

show_form();
		
function save_form($campaign, $customer, $fusion_id, $open_date, $status, $closed_date, $comments){
	$user_id = $_SESSION["user_id"];
	
	if($closed_date == ""){
		$closed_date = "null";
	}
	else{
		$closed_date = "'".$closed_date."'";
	}
	
	$sql = "INSERT INTO case_details (user_id, campaign, customer_name, fusion_id, open_date, status, close_date, comments) VALUES (1, '$campaign', '$customer', '$fusion_id', '$open_date', '$status', $closed_date, '$comments')";
	$result= mysql_query($sql) or die(mysql_error());
}

function show_form($error_message=""){
	require(__DIR__ . "/html/form.html");
}

function validate_form($case){
	return " ";
}

function process_form(){	
	header("Location: show.php");	
}
?>
