<?php
require_once "pdo.php";
session_start();

//unset($_SESSION['name']);
//unset($_SESSION['user_id']);
if(isset($_SESSION['admin_id'])){
	$id=0;
$sql = "UPDATE admin_details SET session_id=:id WHERE admin_id=:email_id";
           //echo("<pre>\n".$sql."\n</pre>\n");
           $stmt = $pdo->prepare($sql);
           $stmt->execute(array(':id' => $id,':email_id' =>$_SESSION['admin_id']));
session_unset();
header('Location: login.php?logout=success');
return;
  }
  else
  { 
  	header('Location: login.php?logout=no_user_loggedin');
  	return;
  }