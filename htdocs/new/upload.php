<?php
session_start();
require_once "pdo.php";
$id=session_id();
    if(isset($_SESSION['name']) && isset($_SESSION['email_id']) && isset($_SESSION['userID']))
    {  $sql = "SELECT session_id FROM customer_details WHERE email_id=:id";
        //echo($_SESSION['email_id']);
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $_SESSION['email_id']));
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($row[0]['session_id']==$id)
        {
            //var_dump($row);
        }
        else
        {
      echo("Multiple Logins From Same User Detected...Latest can continue. You are being LOGGED-OUT.");
      sleep(2);
      session_unset();
      header( 'Location: logout.php' ) ;
      return;
        }

    }
      else {echo("ACCESS DENIED!! Please LOGIN FIRST");
      sleep(2);
      header( 'Location: login.php' ) ;
      return;
    }

$sql="start transaction;";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$sql1 = "SELECT CURRENT_TIMESTAMP();";
        $stmt1 = $pdo->prepare($sql1);
           $stmt1->execute();
           $time = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$sql="INSERT INTO bookings (`timestamp`,`From`,`To`,txn_id,img_ref,payment_method,user_uniqueID,unique_tripID) values (:ts,:selected_from,:selected_to,:txn_id,:img_ref,:paymeth,:user,:trip)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':ts'=>$time[0]['CURRENT_TIMESTAMP()'],':selected_from' => $_GET['From'], ':selected_to' => $_GET['To'],':txn_id'=>$_SESSION['txn_id'],':img_ref'=>$_SESSION['fileLoc'],':paymeth'=>$_SESSION['paymeth'],':user'=>$_SESSION['userID'],':trip'=>$_SESSION['Unique_tripID']));


$sql = "UPDATE trip_details SET Availability=Availability-1 WHERE Unique_tripID=:trip";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':trip'=>$_SESSION['Unique_tripID']));

$sql="commit;";
$stmt = $pdo->prepare($sql);
$stmt->execute();

    //$_SESSION['success_msg']="Ticket Booked Successfully.";
	header( 'Location: thankyou.html' ) ;
	return;

?>
