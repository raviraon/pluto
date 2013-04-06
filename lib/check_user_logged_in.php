<?php
session_start();

if (!user_logged_in()){
    header("location:login.php?failed");
}

function user_logged_in(){
	return ((isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) && (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])));
}

//Session expires after 24 hours
if ($_SESSION['timeout'] + 1440 * 60 < time()) {
    session_destroy();
} 
?>