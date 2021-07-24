<?php
require_once "pdo.php";
session_start();

//unset($_SESSION['name']);
//unset($_SESSION['user_id']);
if(isset($_SESSION['email_id'])){
	$id=0;
$sql = "UPDATE customer_details SET session_id=:id WHERE email_id=:email_id";
           //echo("<pre>\n".$sql."\n</pre>\n");
           $stmt = $pdo->prepare($sql);
           $stmt->execute(array(':id' => $id,':email_id' =>$_SESSION['email_id']));
session_unset();
header('Location: home.php?logout=success');
return;
  }
  else
  {
  	header('Location: home.php?logout=no_user_loggedin');
  	return;
  }
