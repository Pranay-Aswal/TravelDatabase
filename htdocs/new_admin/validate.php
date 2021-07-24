<?php
session_start();
require_once "pdo.php";
if(isset($_POST['back']))
{
   header( 'Location: bookings.php' ) ;
      return;
}
$id=session_id();
    if(isset($_SESSION['name']) && isset($_SESSION['admin_id']) && isset($_SESSION['adminID']))
    {  $sql = "SELECT session_id FROM admin_details WHERE admin_id=:id";
        //echo($_SESSION['email_id']);
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $_SESSION['admin_id']));
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($row[0]['session_id']==$id)
        {
            //var_dump($row);
        }
        else
        {
      echo("Multiple Logins From Same Admin Detected...Latest can continue. You are being LOGGED-OUT.");
      sleep(2);
      session_unset();
      header( 'Location: logout.php' ) ;
      return;
        }

    }
      else {echo("ACCESS DENIED!! LOGIN FIRST");
      sleep(2);
      header( 'Location: login.php' ) ;
      return;
    }

    if(isset($_POST['submit']) && $_POST['status'])
    {
      $status=$_POST['status'];
      $sno=$_POST['sno'];

      $sql = "UPDATE `bookings` SET `isValidated`=:val  WHERE serial_no=:sno";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(':val' => $status,':sno'=>$sno));
      //$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $_SESSION['success_msg']="Status Changed succesfully!!";
      header( 'Location: home.php' ) ;
      return;
    }



if(isset($_GET['img_ref']))
{

}
 else {echo("ACCESS DENIED!! ");
      sleep(2);
      header( 'Location: home.php' ) ;
      return;
}
?>

<html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <head>
        <title>Validate</title>
        <script type="text/javascript" src="jquery.min.js"></script>
       </head>
       <style type="text/css">

/*.image{
background-image: url("https://cdn4.vectorstock.com/i/1000x1000/46/98/nice-background-vector-16234698.jpg");
 /* background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;

  position: relative;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;

}*/
.image{
background-image: url("https://cdn4.vectorstock.com/i/1000x1000/46/98/nice-background-vector-16234698.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  background-attachment: fixed;
  height: 1000px;

}
.tr{
position: relative;
top: 50px;
left: 600px;
}
.im{
position: relative;
top: 40px;
left:550px;
}
.head{
color: black;
height: 10px;
text-align: center;
padding: 34;
}
.opt{
position:relative;
left: 530px;
top: 50px;
font-size: 15px;
}
.bot{
position:relative;
left: 590px;
top: 70px;
}

       </style>
       <body class="bdy">
<div class="image">

   <div class="head">
      <h1><b>VIEW PAYMENT</b></h1>
   </div>
<br>
<div id="vali">
<div class="im">
  <img src="../new/Payment_screenshots/<?php echo($_GET['img_ref'])?>" alt="<?php echo($_GET['img_ref'])?>" height='500px' width='400px'>
</div>
<div id="vali">
  <br>
<div class="tr">
  Transaction ID : <input type="text" name="txn_id" value="<?php echo($_GET['txn_id'])?>" readonly="true">
</div>
  <br>
  <form method="POST">
<div class="opt">
Approve:<input type="radio" id="status" name="status" value="A" <?php if($_GET['status']=='A') echo('checked="true"');?>><br><br>
Reject: <input type="radio" id="status" name="status" value="R" <?php if($_GET['status']=='R') echo('checked="true"');?>><br>
</div><br>
<div class="bot">
  <input type="text" name="sno" value="<?php echo($_GET['sno']) ?>" hidden>
  <input type="submit" name="submit" <?php if(isset($_GET['no_sub'])) echo('hidden');?> value="submit" >
  <input type="submit" name="back"  value="back" >
    </div>
  </form>

</div>
</div>
</body>
</html>
