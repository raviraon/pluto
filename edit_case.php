<?php
ob_start();
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
require(__DIR__ . "/lib/utils.php");

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

	$error_msg = validate_form_during_update($customer_name, $fusion_id, $open_date, $case_unique_id, $campaign, $status, $closed_date);

	if($error_msg != NULL){
		show_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments, $error_msg, $case_unique_id);
	}	
	else{
		update_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments, $case_unique_id);
		show_view_case_page($fusion_id);
	}
}
elseif(!$_POST['case_id']) {
	go_to_home_page();
}
elseif($_POST['change_owner']){
	$result = fetch_case_details();

	if(mysql_num_rows($result) != 0){
		show_change_owner_page($result);
	}
	else{
		go_to_home_page();
	}
}
elseif($_POST['edit_case']){
	$result = fetch_case_details();

	if(mysql_num_rows($result) != 0){
		show_edit_form($result);
	}
	else{
		go_to_home_page();
	}
}
else{
	go_to_home_page();
}

function fetch_case_details(){
	$case_id = $_SESSION['case_id'];
	$sql = "SELECT id, fusion_id, campaign, customer_name, open_date, close_date, status, comments, owner_name FROM case_details WHERE fusion_id = '$case_id'";
	
	$result = mysql_query($sql) or die(mysql_error());
	return $result;
}

function show_edit_form($result){
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

function show_change_owner_page($result){	
	$row = mysql_fetch_object($result);
	$campaign = $row->campaign;
	$customer_name = $row->customer_name;
	$fusion_id = $row->fusion_id;
	$open_date = $row->open_date;
	$closed_date = $row->close_date;
	$status = $row->status;
	$comments = $row->comments;
	$case_owner = $row->owner_name;
	$id = $row->id;
	$users = get_all_users();
	$users = json_encode($users);
	
	require("./html/change_owner.html");	
}

function get_all_users(){
	$all_users = mysql_query("SELECT username FROM users") or die(mysql_error());

	while ($row = mysql_fetch_array($all_users, MYSQL_NUM)) {
		$users[] = $row[0];
	}	
	return $users;
}

function show_form($campaign='', $customer_name='', $fusion_id='', $open_date='', $status='', $closed_date='', $comments='', $error_message='', $id=''){
	require(__DIR__ . "/html/form.html");
}

function go_to_home_page(){
	header("Location: home.php");		
}

function show_view_case_page($fusion_id){	
	header("Location: home.php");	
}

