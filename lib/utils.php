<?php

function save_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments){
	$user_id = $_SESSION["user_id"];
	$user_name = $_SESSION["user"];
	
	if($closed_date == ""){
		$closed_date = "null";
	}
	else{
		$closed_date = "'".$closed_date."'";
	}
	
	$sql = "INSERT INTO case_details (user_id, user_name, campaign, customer_name, fusion_id, open_date, status, close_date, comments, updated_by) VALUES ($user_id, '$user_name', '$campaign', '$customer_name', '$fusion_id', '$open_date', '$status', $closed_date, '$comments', '$user_name')";
	$result= mysql_query($sql) or die(mysql_error());
}

function search_cases($search_criteria){
	$sql = "SELECT user_name, fusion_id, campaign, customer_name, open_date, close_date, status, created_at, updated_at FROM case_details WHERE fusion_id LIKE '%$search_criteria%' OR customer_name LIKE '%$search_criteria%' ORDER BY updated_at DESC";
	
	$result = mysql_query($sql) or die(mysql_error());
	return $result;
	
}

function update_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments, $id){
	$user_name = $_SESSION["user"];
	
	if($closed_date == ""){
		$closed_date = "null";
	}
	else{
		$closed_date = "'".$closed_date."'";
	}
	
	$sql = "UPDATE case_details SET campaign='$campaign', customer_name='$customer_name', fusion_id='$fusion_id', open_date='$open_date', status='$status', close_date=$closed_date, comments='$comments', updated_by='$user_name' WHERE id=$id";
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
		
	if($error_message != NULL){
		$error_message .= " cannot be empty. ";
		$error_message = str_replace(":", "/", $error_message);
	}



	$sql = "SELECT id from case_details where fusion_id = '$fusion_id'";
	$result= mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result) != 0)
		$error_message .= " Fusion ID : " . $fusion_id . " already exists"; 
	
	return $error_message;
}
	
?>