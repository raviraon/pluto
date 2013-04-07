<?php
// ini_set('display_errors',1); 
// error_reporting(E_ALL);

session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
require(__DIR__ . "/lib/utils.php");

$current_user_id = $_SESSION['user_id'];

$db = new Database();
$db->connect();
$sql = "SELECT fusion_id, campaign, customer_name, open_date, close_date, status, created_at, updated_at FROM case_details WHERE user_id = $current_user_id ORDER BY updated_at DESC";
$result = mysql_query($sql) or die(mysql_error());
show();
while($row = mysql_fetch_object($result)){
	echo ' <tr class="odd gradeA"> ';
	foreach($row as $key => $value){
		if($key == 'fusion_id'){		
			echo "<td> <a href='view_case.php?case_id=$value'> $value </a> </td>";	
		}
		elseif( $key == 'open_date' || $key == 'closed_date'){
			$formatted_date = format_date($value);
			echo "<td>  $formatted_date   </td>";				
		}
		else{
			echo "<td> $value  </td>";	
		}
	}
	echo "</tr>";
}
echo '</tbody></table></div></body>';

function show($errors='', $cases=null){
	require('./html/home.html');
}

?>
