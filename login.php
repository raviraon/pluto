<?php
require(__DIR__ . "/lib/dbconnect.php");
session_start();
if ( $_POST['Login'] ){
	$db = new Database();
	$db->connect();
	
	$username = mysql_real_escape_string(stripslashes($_POST['uname']));
	$password = mysql_real_escape_string(stripslashes($_POST['paswd']));
	login($username, md5($password));
}
else{
	$error_message="";
	if( array_key_exists('failed', $_GET )){
		$error_message =  "Please login to use the system";
	}
	if( array_key_exists('logout', $_GET )){
		$error_message =  "Successfully logged out";
	}

	show_login_page($error_message);
}

function login($username, $password){
	if ( is_valid_user($username, $password) ){
		$_SESSION['logged_in'] = true;
		$_SESSION["user"] = $username;
		$_SESSION['timeout'] = time();
		
		header("location:home.php");
	}
	else {
		$error_message =  "Wrong Username or Password";
		show_login_page($error_message);
	}
}

function is_valid_user($username, $password){
	$sql = "SELECT * FROM users WHERE username='$username' and password='$password'";
	$result= mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result) == 1){
		$row = mysql_fetch_object($result);
		$_SESSION["user_id"] = $row->id;
		return true;
	}
	return false;
}

function show_login_page($error_message=""){
	include(__DIR__ .'/html/login.html');	
}
?>