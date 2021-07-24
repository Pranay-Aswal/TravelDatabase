<?php //SELECT DISTINCT `From`,`To` FROM trip_details WHERE `Date`="2020-05-24"
//INSERT INTO `trip_details`(`From`, `To`, `Availability`, `Date`, `Start_time`, `Cost`, `route_id`) VALUES ("RGIA","Delhi",55,"20200524",153000,799,3)
//?>
<?php
require_once "pdo.php";
session_start();
if ( !isset($_POST['date']) )
 return;
//echo('present'.$_POST['date']);
$go=false;
$selected_date=$_POST['date'];
$sql="SELECT DISTINCT `From` FROM trip_details WHERE `Date`=:selected_date";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':selected_date' => $selected_date));
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($row as $r) {
    if(!($r['From']=="RGIA" || strtolower($r['From'])=='RGIA' ))
    	{$go=true;
    	  }
    	  else{
    	  	//do nothing
    	  }
 }


if($go){
$sql="SELECT DISTINCT stop_name FROM `schedule` INNER JOIN trip_details ON schedule.route_id=trip_details.route_id where trip_details.Date=:selected_date";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':selected_date' => $selected_date));
$row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
if($row1==false)
{//echo('<script>alert("Sorry!! NO trips found for selection made.");</script>');
 //echo('<script>location.reload();</script>');
}

else{
echo('<option disabled selected value> -- select an option -- </option>');
foreach ($row1 as $r) {
	//var_dump($r['To']);
	echo("<option value=\"".$r['stop_name']."\">".$r['stop_name'].'</option>');
}
}
}
$sql = "SELECT DISTINCT `From` FROM trip_details WHERE `Date`=:selected_date";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':selected_date' => $selected_date));
$row2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($row2==false && $row1==false)
{echo('<script>alert("Sorry!! NO trips found for selection made.");</script>');
 echo('<script>location.reload();</script>');}

else{
if(!$go)echo('<option disabled selected value> -- select an option -- </option>');
foreach ($row2 as $r) {
	//var_dump($r['From']);
	$str=$r['From'];
	echo("<option value=\"".$r['From']."\">".$r['From'].'</option>');
}
}
//echo('<option disabled selected value> -- select an option -- </option>');
