<?php
session_start();
require(__DIR__ . "/lib/check_user_logged_in.php");
require(__DIR__ . "/lib/dbconnect.php");
require(__DIR__ . "/lib/utils.php");

$db = new Database();
$db->connect();

if(isset($_SESSION['case_id'])){
	unset($_SESSION['case_id']);
}

$current_user_id = $_SESSION['user_id'];
$sql = "SELECT fusion_id, campaign, customer_name, open_date, close_date, status FROM case_details WHERE owner_id = $current_user_id ORDER BY updated_at DESC LIMIT 600";

$result = mysql_query($sql) or die(mysql_error());
show_home_page();

echo '			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
				<thead>
					<tr>
						<th>Fusion ID</th>
						<th>Campaign</th>
						<th>Customer Name</th>
						<th>Open Date</th>
						<th>Close Date</th>
						<th>Status</th>
						</tr>
				</thead>
<tbody>
';

while($row = mysql_fetch_object($result)){
	echo ' <tr class="odd gradeA"> ';
	foreach($row as $key => $value){
		if($key == 'fusion_id'){		
			echo "<td> <a href='view_case.php?case_id=$value'> $value </a> - <a href='https://fusion.us.dell.com/Fusion/Core/preview.aspx?id=$value' target='_blank'> Preview </a></td>";
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

echo '</tbody></table></div>

<div style="text-align:right;padding-right:20px;color:BlanchedAlmond">
<a href="mailto:ravi_chandra@dell.com?Subject=Request%20Report%20/%20Submit%20Wiki%20Link%20/%20Feedback&Body=***What%20would%20you%20like%20to%20do%3F***%20%0A%20%0A1%3ERequest%20report%20from%3A%20DD/MM/YYYY%20to%20DD/MM/YYYY.%20%0A%0A2%3EI%20would%20like%20to%20add%20a%20Link%20to%20Wiki%3A%20%0AName%3A%20%0AFor%20Region%3A%0ALanding%20URL%3A%20%0A%0A3%3EFeedback%3A%20%0A">Request Report / Submit Wiki Link / Feedback</a>
</div>

</body>';

function show_home_page($errors='', $cases=null){
	require('./html/home.html');
}

?>
