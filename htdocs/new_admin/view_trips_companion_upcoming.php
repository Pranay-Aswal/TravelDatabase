<?php 
//SELECT * FROM trip_details WHERE date >= CURDATE();
require_once "pdo.php";
session_start();
//if ( !isset($_POST['datesel']) )
 //return;
//echo('present'.$_POST['date']);
$go=false;
$sql="SELECT * FROM trip_details WHERE `date` >= CURDATE();";
$stmt = $pdo->prepare($sql);
$stmt->execute(array());
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($row as $r) {
	 $sql="SELECT `Time` FROM route WHERE route_id=:rid";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':rid'=>$r['route_id']));
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo('<form>');
echo('Trip ID: <input type="text" name="trip_id" readonly="true" value="');echo($r['Unique_tripID']);echo('">');
echo('From: <input type="text" name="From" readonly="true" value="');echo($r['From']);echo('">');
echo('To: <input type="text" name="To" readonly="true" value="');echo($r['To']);echo('">');
echo('Date: <input type="text" name="date" readonly="true" value="');echo($r['Date']);echo('"><br>');
echo('Start time: <input type="text" readonly="true" name="Start_time" value="');echo($row[0]['Time']);echo('">');
echo('Availability: <input type="text" readonly="true" name="Availability" value="');echo($r['Availability']);echo('">');
echo('Cost: <input type="text" name="Cost" readonly="true" value="');echo($r['Cost']);echo('">');
echo('Route id: <input type="text" readonly="true" name="route_id" value="');echo($r['route_id']);echo('">');
echo('</form><hr>');
}
    