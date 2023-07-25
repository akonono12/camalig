<?php
require_once('connection/conn.php');
function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}




// Select all the rows in the markers table
$query = mysqli_query($conn, "SELECT * FROM evacuation, evacuation_center, barangay WHERE evacuation.type ='Evacuation' and evacuation.evac_type='Landslide' and barangay.brgy_id=evacuation.brgy_id and evacuation_center.ec_id=evacuation.ec_id"); 

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
while ($row = mysqli_fetch_assoc($query)){
  // ADD TO XML DOCUMENT NODE
								
                         
		echo '<marker ';
		echo 'id="' . parseToXML($row['brgy_id']) . '" ';
		echo 'name="' . parseToXML($row['evacuation_name']) . '" ';
		echo 'address="' . parseToXML($row['address']) . '" ';
		echo 'lat="' . $row['latitude'] . '" ';
		echo 'lng="' . $row['longitude'] . '" ';
		echo 'type="' . $row['type'] . '" ';
		echo 'capacity="' . $row['capacity'] . '" ';
		
		$ec_id=$row['ec_id'];
								$sql1 = mysqli_query($conn, "SELECT * FROM evacuee_report_view where ec_id='$ec_id' and status='active'");
									
									if (mysqli_num_rows($sql1)  > 0) {
										while($row1 = mysqli_fetch_assoc($sql1)) {
											$tevac=$row1['tevacuee'];
											$tpreg=$row1['tpreg'];
											$tkid=$row1['tkid'];
											$telder=$row1['telder'];
											$tmale=$row1['tmale'];
											$tfemale=$row1['tfemale'];
											echo 'tevac="' . $tevac . '" ';
											echo 'tpreg="' . $tpreg . '" ';
											echo 'tkid="' . $tkid . '" ';
											echo 'telder="' . $telder . '" ';
											echo 'tmale="' . $tmale . '" ';
											echo 'tfemale="' . $tfemale . '" ';
										}
									}
									else{
										echo 'tevac="0" ';
										echo 'tpreg="0" ';
											echo 'tkid="0" ';
											echo 'telder="0" ';
											echo 'tmale="0" ';
											echo 'tfemale="0" ';
										
									}
		echo 'message="' . $row['message'] . '" ';

  echo '/>';
}

// End XML file
echo '</markers>';

?>