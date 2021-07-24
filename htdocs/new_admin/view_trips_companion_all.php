<?php 
//SELECT * FROM trip_details WHERE date >= CURDATE();
require_once "pdo.php";
session_start();
//if ( !isset($_POST['datesel']) )
 //return;
//echo('present'.$_POST['date']);
$go=false;
$sql="SELECT * FROM trip_details";
$stmt = $pdo->prepare($sql);
$stmt->execute(array());
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($row as $r) {
    $sql="SELECT `Time` FROM route WHERE route_id=:rid";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':rid'=>$r['route_id']));
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo('<div style="display:inline-block;"><form>');
echo('Trip ID: <input type="text" readonly="true" name="trip_id" value="');echo($r['Unique_tripID']);echo('">');
echo('From: <input type="text" readonly="true" name="From" value="');echo($r['From']);echo('">');
echo('To: <input type="text" readonly="true" name="To" value="');echo($r['To']);echo('">');
echo('Date: <input type="text" readonly="true" name="date" value="');echo($r['Date']);echo('"><br>');
echo('Start time: <input type="text" readonly="true" name="Start_time" value="');echo($row[0]['Time']);echo('">');
echo('Availability: <input type="text" readonly="true" name="Availability" value="');echo($r['Availability']);echo('">');
echo('Cost: <input type="text"  readonly="true" name="Cost" value="');echo($r['Cost']);echo('">');
echo('Route id: <input type="text" readonly="true" name="route_id" value="');echo($r['route_id']);echo('">');
echo('</form></div><hr>');
}
    