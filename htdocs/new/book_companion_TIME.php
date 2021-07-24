<?php //SELECT DISTINCT `From`,`To` FROM trip_details WHERE `Date`="2020-05-24"
//INSERT INTO `trip_details`(`From`, `To`, `Availability`, `Date`, `Start_time`, `Cost`, `route_id`) VALUES ("RGIA","Delhi",55,"20200524",153000,799,3)
//?>
<?php
require_once "pdo.php";
session_start();
if ( !isset($_POST['date']) )
 return;
echo('present'.$_POST['date']);
$selected_date=$_POST['date'];
$selected_from=$_POST['from'];
$selected_to=$_POST['to'];
echo('present2'.$selected_from);
echo('present3'.$_POST['to']);
/*$sql = "SELECT DISTINCT `Start_time` FROM trip_details WHERE `Date`=:selected_date and `From`=:selected_from ";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':selected_date' => $selected_date, ':selected_from'=>$selected_from));
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
if($row==false)
{echo('<script>alert("Sorry!! NO trips found for selection made.");</script>');
 echo('<script>location.reload();</script>');}

else{
echo('<option disabled selected value> -- select an option -- </option>');
foreach ($row as $r) {
	//var_dump($r['Start_time']);
	echo('<option value='.$r['Start_time'].'>'.$r['Start_time'].'</option>');
}
}*/
if($selected_from=="RGIA" || strtolower($selected_from)=="RGIA")
{
//$sql = "SELECT DISTINCT `Start_time` FROM trip_details WHERE `Date`=:selected_date and `From`=:selected_from ";
$sql = "SELECT DISTINCT schedule.route_id FROM `schedule` INNER JOIN trip_details ON schedule.route_id=trip_details.route_id where trip_details.Date=:selected_date and stop_name=:selected_to and `From`=:selected_from";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':selected_date' => $selected_date,':selected_from'=>$selected_from,							':selected_to'=>$selected_to));
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
if($row==false)
{echo('<script>alert("Sorry!! NO trips found for selection made.");</script>');
 echo('<script>location.reload();</script>');}

else{
$sql="SELECT * FROM route WHERE route_id=:rid ";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':rid'=>$row[0]['route_id']));
$row2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo('<option disabled selected value> -- select an option -- </option>');
foreach ($row2 as $r) {
	//var_dump($r['Start_time']);
	echo("<option value=\"".$r['Time']."\">".$r['Time'].'</option>');
}
}

}
else
{
	 //SELECT DISTINCT `To` FROM `schedule` INNER JOIN trip_details ON schedule.route_id=trip_details.route_id where trip_details.Date=20200430

//$sql = "SELECT DISTINCT `Start_time` FROM trip_details WHERE `Date`=:selected_date and `From`=:selected_from ";
$sql = "SELECT DISTINCT `Time` FROM `schedule` INNER JOIN trip_details ON schedule.route_id=trip_details.route_id where trip_details.Date=:selected_date and stop_name=:selected_from and `To`=:RGIA";
//or `From`=:selected_from )
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':selected_date' => $selected_date, ':selected_from'=>$selected_from,':RGIA'=>"RGIA"));
$row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo('<option disabled selected value> -- select an option -- </option>');
if($row1==false)
{//echo('<script>alert("Sorry!! NO trips found for selection made.");</script>');
 //echo('<script>location.reload();</script>');
}

else{

foreach ($row1 as $r) {
	//var_dump($r['Start_time']);
	echo("<option value=\"".$r['Time']."\">".$r['Time'].'</option>');
}
}
$sql = "SELECT DISTINCT schedule.route_id FROM `schedule` INNER JOIN trip_details ON schedule.route_id=trip_details.route_id where trip_details.Date=:selected_date and `From`=:selected_from and `To`=:RGIA";
//or  )
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':selected_date' => $selected_date, ':selected_from'=>$selected_from,':RGIA'=>"RGIA"));
$row2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
if($row2==false && $row1==false)
{echo('<script>alert("Sorry!! NO trips found for selection made.");</script>');
 echo('<script>location.reload();</script>');}

else{
	$sql="SELECT * FROM route WHERE route_id=:rid ";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':rid'=>$row2[0]['route_id']));
$row23 = $stmt->fetchAll(PDO::FETCH_ASSOC);
//echo('<option disabled selected value> -- select an option -- </option>');
foreach ($row23 as $r) {
	//var_dump($r['Start_time']);
	echo("<option value=\"".$r['Time']."\">".$r['Time'].'</option>');
}
}


}
