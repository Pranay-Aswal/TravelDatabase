<?php //SELECT DISTINCT `From`,`To` FROM trip_details WHERE `Date`="2020-05-24"
//INSERT INTO `trip_details`(`From`, `To`, `Availability`, `Date`, `Start_time`, `Cost`, `route_id`) VALUES ("RGIA","Delhi",55,"20200524",153000,799,3)
//SELECT DISTINCT stop_name FROM `schedule` INNER JOIN trip_details ON schedule.route_id=trip_details.route_id where trip_details.Date=20200424
//SELECT DISTINCT `To` FROM `schedule` INNER JOIN trip_details ON schedule.route_id=trip_details.route_id where trip_details.Date=20200430
?>
<?php
require_once "pdo.php";
session_start();
if ( !isset($_POST['date']) )
 return;
echo('present'.$_POST['date']);
$selected_date=$_POST['date'];
$selected_from=$_POST['from'];
//$sql = "SELECT DISTINCT `To` FROM trip_details WHERE `Date`=:selected_date and `From`=:selected_from";
if($selected_from==="RGIA" || strtolower($selected_from)=="RGIA")
{
$sql="SELECT DISTINCT stop_name FROM `schedule` INNER JOIN trip_details ON schedule.route_id=trip_details.route_id where trip_details.Date=:selected_date and trip_details.From=:selected_from";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':selected_date' => $selected_date, ':selected_from'=>$selected_from));
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
if($row==false)
{echo('<script>alert("Sorry!! NO trips found for selection made.");</script>');
 echo('<script>location.reload();</script>');}

else{
echo('<option disabled selected value> -- select an option -- </option>');
foreach ($row as $r) {
	//echo('<script>alert('.var_dump($r['stop_name']).');</script>');
	//var_dump($r['stop_name']);
	echo("<option value=\"".$r['stop_name']."\">".$r['stop_name'].'</option>');
}
}
}
else
{   $RGIA="RGIA";
echo('<option disabled selected value> -- select an option -- </option>');
	echo('<option value='.$RGIA.'>'.$RGIA.'</option>');
}
