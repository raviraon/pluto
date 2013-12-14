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
	
	$sql = "INSERT INTO case_details (owner_id, owner_name, campaign, customer_name, fusion_id, open_date, status, close_date, comments, created_by) VALUES ($user_id, '$user_name', '$campaign', '$customer_name', '$fusion_id', '$open_date', '$status', $closed_date, '$comments', '$user_name')";
	$result= mysql_query($sql) or die(mysql_error());
}

function search_cases($search_criteria='', $is_wiki='false' , $colums_to_load=''){
	if(empty($colums_to_load)){ return '';}
	$columns = implode(',', $colums_to_load);
	if($is_wiki == 'true'){
		$sql = "SELECT $columns FROM wiki WHERE name LIKE '%$search_criteria%' ORDER BY name";		
	}
	else{
		$sql = "SELECT $columns FROM case_details WHERE fusion_id LIKE '%$search_criteria%' OR customer_name LIKE '%$search_criteria%' ORDER BY updated_at DESC LIMIT 300";
	}
	
	$result = mysql_query($sql) or die(mysql_error());
	return $result;	
}

function format_date($originalDate){
	if(!isset($originalDate) || empty($originalDate))
		return $originalDate;
		
	$formatted_date = date("d-m-Y", strtotime($originalDate));
	return $formatted_date;
}

function update_form($campaign, $customer_name, $fusion_id, $open_date, $status, $closed_date, $comments, $id){
	$user_name = $_SESSION["user"];
	
	if($closed_date == ""){
		$closed_date = "null";
	}
	else{
		$closed_date = "'".$closed_date."'";
	}
	$current_datetime = date('Y-m-d H:i:s');
	$sql = "UPDATE case_details SET campaign='$campaign', customer_name='$customer_name', fusion_id='$fusion_id', open_date='$open_date', status='$status', close_date=$closed_date, comments='$comments', updated_by='$user_name', updated_at='$current_datetime' WHERE id=$id";
	$result= mysql_query($sql) or die(mysql_error());
}


function check_for_empty_fields($customer_name, $fusion_id, $open_date, $campaign){
    $error_message = NULL;
	
	if($customer_name == NULL)
		$error_message .= "Campaign : ";

	if($campaign == NULL)
		$error_message .= "Fusion ID : ";
	
	if($fusion_id == NULL)
		$error_message .= "Customer Name : ";

	if($open_date == NULL)
		$error_message .= "Open Date  ";
	
	if($error_message != NULL){
		$error_message .= " cannot be empty. ";
		$error_message = str_replace(":", "/", $error_message);
	}
	
	return $error_message;
}

function validate_form($customer_name, $fusion_id, $open_date, $campaign){
	$error_message = check_for_empty_fields($customer_name, $fusion_id, $open_date, $campaign);
	if($error_message == null){
		$sql = "SELECT id from case_details where fusion_id = '$fusion_id'";
		$result= mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($result) != 0)
			$error_message .= " Fusion ID : " . $fusion_id . " already exists"; 		
	}
	
	return $error_message;
}

function validate_form_during_update($customer_name, $fusion_id, $open_date, $case_unique_id, $campaign){
	$error_message = check_for_empty_fields($customer_name, $fusion_id, $open_date, $campaign);

	$sql = "SELECT id from case_details where fusion_id = '$fusion_id' AND id != $case_unique_id";
	$result= mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result) != 0)
		$error_message .= " Fusion ID : " . $fusion_id . " already exists"; 
	
	return $error_message;
}

	
?>