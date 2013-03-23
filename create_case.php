<?php
ob_start();
require(__DIR__ . "/lib/check_user_logged_in.php");

$form_errors = "";
if(array_key_exists('_submit_check',$_POST) ){
	$form_errors = validate_form();
	if(is_null($form_errors)){
		
	}
	else{
		show_form($form_errors);
	}
}


if(array_key_exists('form_submitted', $_POST)){
	process_form();
	
}

function show_form(){
	require(__DIR__ . "/html/form.html");
}

function validate_form(){
	return "";
}

function process_form(){	
	header("Location: show.php");	
}


?>
