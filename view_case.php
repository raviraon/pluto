<?php
// ini_set('display_errors',1); 
//  error_reporting(E_ERROR);

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

$sql = "SELECT owner_id, owner_name, fusion_id, campaign, customer_name, open_date, close_date, status, created_at, updated_at, comments FROM case_details WHERE fusion_id = '$case_id'";

$result = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($result) != 0){
	$row = mysql_fetch_object($result);
	$case_owner = $row->owner_name;
	$campaign = $row->campaign;
	$customer_name = $row->customer_name;
	$fusion_id = $row->fusion_id;
	$open_date = format_date($row->open_date);
	$close_date = format_date($row->close_date);
	$status = $row->status;
	$created_at = $row->created_at;
	$updated_at = $row->updated_at;
	$comments = $row->comments;
	$edit_form ='';
	$user_id = $_SESSION['user_id'];

	if(is_owner($row->owner_id, $user_id ))
	{
		if(case_editable($updated_at, $status)){
			$edit_form = "
				<form id='edit_case' class='appnitro' action='edit_case.php' method='post' >
					<input type='hidden' name='case_id' value='$case_id'>
					<span style='padding-left:0px'><input class='button' type='submit' name='edit_case' value='Edit Case'/></span>
					<span style='padding-left:50px'><input class='button' type='submit' name='change_owner' value='Change Case Owner'/></span>
				</form>";
		}
		else{
			$edit_form = '<div id="error_message" > This case cannot be modified as its been closed for 10 or more days </div>';
		}
	}
	require("./html/view_form.html");
}
else{
	header("Location: home.php");	
}

function is_owner($owner_id, $user_id){
	return strval($owner_id) == strval($user_id);
}

function case_editable($updated_at, $status){
	if($status == "Pend Working"){
		return true;
	}
	
	$last_updated = date_create($updated_at);
	$today = date_create(date("Y-m-d"));
	$interval = date_diff($today, $last_updated);
	return $interval->days < 11;
}
