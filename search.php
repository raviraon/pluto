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
$is_wiki = mysql_real_escape_string(stripslashes($_GET['wiki']));
$columns_to_load = '';

// if(strlen($search_criteria) < 3){
// 	header("Location: home.php");		
// }

if($is_wiki == 'true'){
	$columns_to_load = array("name", "description", "data");
}
else{
	$columns_to_load = array("owner_name", "fusion_id", "campaign", "customer_name", "open_date", "close_date", "status", "updated_by");
}

$result = search_cases($search_criteria, $is_wiki, $columns_to_load);
show_home_page();

echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%"> <thead> <tr>';
foreach($columns_to_load as $column ){
	echo "	<th> $column </th>	";
}
					
echo '</tr></thead><tbody>';

while($row = mysql_fetch_object($result)){
	echo ' <tr class="odd gradeA"> ';
	foreach($row as $key => $value){
		if($key == 'fusion_id'){		
			echo "<td> <a href='view_case.php?case_id=$value'> $value </a> </td>";	
		}
		else{
			echo "<td> $value  </td>";	
		}
	}
	echo "</tr>";
}
echo '</tbody></table></div></body>';

function show_home_page($errors='', $cases=null){
	require('./html/home.html');
}

?>