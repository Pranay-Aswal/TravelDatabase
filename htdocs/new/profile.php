<?php
require_once "pdo.php";
    session_start();
   //copy from here till
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
      else {echo("ACCESS DENIED!! LOGIN FIRST");
      sleep(2);
      header( 'Location: login.php' ) ;
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
        <title>MyProfile</title>
       </head>
<style>
.w3-bar {font-family: "Montserrat", sans-serif}
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 450px;
  margin: auto;
  text-align: center;
  font-family: arial;
  height: 500px;
 position: relative;
top: 50px;
background-color: #F8F8F8;
}

.title {
  color: grey;
  font-size: 18px;
}

button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}

button:hover, a:hover {
  opacity: 0.7;
}
.main{
background-color: #92a8d1;
height: 657px;
}
.head{
text-align: center;
color: white;
padding: 53px;
height: 5px;
}
.main{
	background-image: url("https://pub-static.fotor.com/static/web/site/features/backgrounds/images/Fotor-wood-background-image-3.jpg");
	background-repeat: no-repeat;
	background-position: center center;
	background-size: cover;
	background-attachment: fixed;
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
             opacity: 0px;


}
</style>
<body>
<div class="w3-top">
  <div class="w3-bar w3-purple w3-card w3-left-align w3-large">

     <button class="w3-bar-item w3-button w3-padding-large w3-white" onclick="document.location.href = 'home.php'">Home</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'login.php'">Login</button>
              <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'Profile.php'">My Profile</button>

     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white"onclick="document.location.href = 'Routes3.php'">Routes</button>

     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'myBookings.php'">My Bookings</button>

    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'logout.php'">Logout</button>
    </div>
  </div>
<div class="main">
<div class="head">
      <h1 class="w3-text-black"><b>MY PROFILE</b></h1>
   </div>

<div class="card"><br>
  <img src="https://www.pngitem.com/pimgs/m/146-1468479_my-profile-icon-blank-profile-picture-circle-hd.png" alt="John" style="width:50%" ; "height:200px">
  <div class="forms">
<br>
<form id="form" method="POST">
<div class="name">
<label for="name">NAME : </label>
<input type="text"  id="from" size="25" value="<?php echo($_SESSION['name']); ?>" readonly="true" >
</div><br>
<div class="email">
 <label for="email">Email : </label>
<input type="text"  id="availability" size="25" value="<?php echo($_SESSION['email_id']); ?>" readonly="true" >
</div><br>
<div class="ph">
<label for="ph"> PHONE NO : </label>
<input type="number"  id="from" size="30" value="<?php echo($_SESSION['ph_no']); ?>" readonly="true" >
</div><br>
<div class="uniqueid">
<label for="id">UNIQUE ID : </label>
<input type="number"  id="availability" size="20" value="<?php echo($_SESSION['userID']); ?>" readonly="true">
</div><br><br>

</form>
</div>

</div>
</div>
</body>
</html>
