<?php
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
$current_user_id = $_SESSION['user_id'];

$sql = "SELECT campaign, customer_name, fusion_id, open_date, close_date, status, comments, updated_by, created_at, updated_at from case_details where user_id = $current_user_id";
$result = mysql_query($sql);
while($row = mysql_fetch_row($result)){
	echo ""
}


?>