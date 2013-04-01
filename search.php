<?php
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
require(__DIR__ . "/lib/utils.php");

if(!$_GET['search']) {
	header("Location: home.php");	
}

$db = new Database();
$db->connect();
$search_criteria = mysql_real_escape_string(stripslashes($_GET['search']));

$result = search_cases($search_criteria);
show();
echo '	<div id="form_container">
	<table>';
while($row = mysql_fetch_object($result)){
	echo "<tr> ";
	foreach($row as $key => $value){
		if($key == 'fusion_id'){		
			echo "<td> <a href='view_case.php?case_id=$value'> $value </a> </td>";	
		}
		else{
			echo "<td> <label class='description'>$value </label> </td>";	
		}
	}
	echo "</tr>";
}
echo '</table></div></body>';

function show($errors='', $cases=null){
	require('./html/home.html');
}


?>