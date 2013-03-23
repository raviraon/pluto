<?php
require("./lib/dbconnect.php");
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
		
		header("location:main.php");
	}
	else {
		$error_message =  "Wrong Username or Password";
		show_login_page($error_message);
	}
}

function is_valid_user($username, $password){
	$sql = "SELECT * FROM users WHERE username='$username' and password='$password'";
	$result= mysql_query($sql) or die(mysql_error());
	return mysql_num_rows($result) == 1;
}

function show_login_page($error_message=""){
	include('./html/login.html');	
}
?>