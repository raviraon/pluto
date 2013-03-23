<?php
session_start();

if ($_SESSION['logged_in'] != 1){
    header("location:login.php?failed");
}

//Session expires after 24 hours
if ($_SESSION['timeout'] + 1440 * 60 < time()) {
    session_destroy();
} 
?>