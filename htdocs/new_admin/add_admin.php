<?php
    require_once "pdo.php";
    session_start();

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

    

    if ( isset($_POST["guest_admin_id"]) && isset($_POST["guest_pw"]) && isset($_POST["guest_name"]) && isset($_POST["guest_ph_no"])) {
         //unset($_SESSION["email_id"]); // Logout current user
         $salt = '_SSRam_203';
        
        $Gadmin_id=htmlentities($_POST["guest_admin_id"]);
        $Gph_no=htmlentities($_POST["guest_ph_no"]);
        $stmt = $pdo->prepare('SELECT admin_id FROM admin_details WHERE admin_id = :email_id');
        $stmt->execute(array( ':email_id' => $Gadmin_id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare('SELECT ph_no FROM admin_details WHERE ph_no = :ph_no');
        $stmt->execute(array( ':ph_no' => $Gph_no));
        $row1 = $stmt->fetch(PDO::FETCH_ASSOC); 

        if($row===false && $row1===false)
        { 
        
        $Gname=htmlentities($_POST["guest_name"]);
        $Gpassword= htmlentities(hash('md5',$salt.$_POST["guest_pw"]));
        if (strlen($Gph_no) <10 || strlen($Gph_no) > 10  )
        {   
            $_SESSION['error2']="Mobile number Format is incorrect...please try again.";
             header( 'Location: login.php' ) ;
              return;
        }
        $sql = "INSERT INTO admin_details(name,admin_id,password,ph_no) VALUES(:name,:email_id,:password,:ph_no) ";
        echo("<pre>\n".$sql."\n</pre>\n");
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':email_id' => $Gadmin_id,':ph_no' => $Gph_no,':password' => $Gpassword,':name' => $Gname));
        //$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       // echo("<pre>\n".$_POST['pw']."\n</pre>\n");
       // echo("<pre>\n".var_dump($row)."\n</pre>\n");
        $_SESSION['success_msg']="Successfully added Admin....";
         header( 'Location: home.php' ) ;
         return;
       
       }
       else
       {
       $_SESSION['error2']="Account already exists. Please Login In directly.";
             header( 'Location: login.php' ) ;
              return; 
       }
 } 

}
      else {echo("ACCESS DENIED!! LOGIN FIRST");
      sleep(2);
      header( 'Location: login.php' ) ;
      return;
    }
    
?>

<!DOCTYPE html>
<title>Add Admin</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-wrench,.fa-gears,.fa-info-circle{font-size:200px}
html {
  scroll-behavior: smooth;
}

.bgcolor1 {
background-color: #C0C0C0;
}
.bgcolor2 {
background-color: #C8C8C8;
}
.bgcolor3 {
background-color: #D0D0D0;
}
div.opaque {
  opacity: 0.6;
}
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
 bottom: 23px;
  right: 28px;
  width: 280px;
 float: middle;
 margin-left: 40px;
}.open-button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}.open-button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}.open-button:hover span {
  padding-right: 25px;
}.open-button:hover span:after {
  opacity: 1;
  right: 0;
}
.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 25px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: #FFFFFF;
}
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}
.form-container .cancel {
  background-color: red;
}
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
.gotop {
  list-style: none;
  float: right;
  padding-left: 0px;
  margin-top: 0px;
   bottom: 0;
}
.image{
background-image: url("https://cdn.hipwallpaper.com/i/46/78/UyfmZ0.jpg");
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
  background-attachment: fixed;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
           



}
.headings{
color: black;
width: 100%;
}
.name{
width: 25%;
float: left;
position: relative;
left: 520px;
padding-left: 75px;

}
.aid{
width: 25%;
float: left;
position: relative;
left: 520px;
padding-left: 75px;


}
.pas{
width: 25%;
float: left;
position: relative;
left: 520px;
padding-left: 75px;


}
.mob{
width: 25%;
float: left;
position: relative;
left: 520px;
padding-left: 75px;


}
.sign{
width: 25%;
float: left;
position: relative;
left: 585px;
padding-left: 75px;


}
.for{
position: relative;
left: 50px;
}
.head{
text-align: center;
color: black;
padding: 64px;

}
</style>
<body>
<div class="image">
<div class="headings">
  <button class="w3-bar-item w3-button w3-padding-large w3-white" onclick="document.location.href = 'home.php'">Home</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'login.php'">Login</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white"onclick="document.location.href = 'bookings.php'">View Bookings</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white"onclick="document.location.href = 'view_routes.php'">View Routes</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'view_trips.php'">View Trips</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'add_trips.php'">Add Trips</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'add_routes.php'">Add Routes</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'add_admin.php'">Add Admin</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'logout.php'">Logout</button>
</div>
    <br><br><br><br>



<div class="head">
<h1><b>ADD ADMIN</b></h1>
</div>
<div class="for">
<form method="post">
<div class="name">
<input type="text" placeholder="Name" name="guest_name" size="30"required/>
</div><br><br>
<div class="aid">
<input type="email" placeholder="Email-id" name="guest_admin_id" size="30"required/>
</div><br><br>
<div class="pas">
<input type="password" placeholder="Password" name="guest_pw" size="30"required/>
</div><br><br>
<div class="mob">
<input type="tel" placeholder="Mobile-no" name="guest_ph_no" pattern="[0-9]{10}" size="30"required/>
</div><br><br><br>
<div class="sign">
<button class="btn_sign_up" onclick="cambiar_sign_up()">SIGN UP</button>
</div>
</form>
</div>
</div>
</body>
</html>



<!DOCTYPE html>
<title>Add Admin</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-wrench,.fa-gears,.fa-info-circle{font-size:200px}
html {
  scroll-behavior: smooth;
}

.bgcolor1 {
background-color: #C0C0C0;
}
.bgcolor2 {
background-color: #C8C8C8;
}
.bgcolor3 {
background-color: #D0D0D0;
}
div.opaque {
  opacity: 0.6;
}
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
 bottom: 23px;
  right: 28px;
  width: 280px;
 float: middle;
 margin-left: 40px;
}.open-button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}.open-button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}.open-button:hover span {
  padding-right: 25px;
}.open-button:hover span:after {
  opacity: 1;
  right: 0;
}
.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 25px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: #FFFFFF;
}
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}
.form-container .cancel {
  background-color: red;
}
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
.gotop {
  list-style: none;
  float: right;
  padding-left: 0px;
  margin-top: 0px;
   bottom: 0;
}
.image{
background-image: url("https://cdn.hipwallpaper.com/i/46/78/UyfmZ0.jpg");
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
  background-attachment: fixed;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
           



}
.headings{
color: black;
width: 100%;
}
.name{
width: 25%;
float: left;
position: relative;
left: 520px;

}
.aid{
width: 25%;
float: left;
position: relative;
left: 520px;

}
.pas{
width: 25%;
float: left;
position: relative;
left: 520px;

}
.mob{
width: 25%;
float: left;
position: relative;
left: 520px;

}
.sign{
width: 25%;
float: left;
position: relative;
left: 585px;

}
.for{
position: relative;
left: 50px;
}
.head{
text-align: center;
color: black;
padding: 64px;

}
</style>
<body>
<div class="image">
<div class="headings">
  <button class="w3-bar-item w3-button w3-padding-large w3-white" onclick="document.location.href = 'home.php'">Home</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'login.php'">Login</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white"onclick="document.location.href = 'bookings.php'">View Bookings</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white"onclick="document.location.href = 'view_routes.php'">View Routes</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'view_trips.php'">View Trips</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'add_trips.php'">Add Trips</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'add_routes.php'">Add Routes</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'add_admin.php'">Add Admin</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'logout.php'">Logout</button>
</div>
    <br><br><br><br>



<div class="head">
<h1><b>ADD ADMIN</b></h1>
</div>
<div class="for">
<form method="post">
<div class="name">
<input type="text" placeholder="Name" name="guest_name" size="30"required/>
</div><br><br>
<div class="aid">
<input type="email" placeholder="Email-id" name="guest_admin_id" size="30"required/>
</div><br><br>
<div class="pas">
<input type="password" placeholder="Password" name="guest_pw" size="30"required/>
</div><br><br>
<div class="mob">
<input type="tel" placeholder="Mobile-no" name="guest_ph_no" pattern="[0-9]{10}" size="30"required/>
</div><br><br><br>
<div class="sign">
<button class="btn_sign_up" onclick="cambiar_sign_up()">SIGN UP</button>
</div>
</form>
</div>
</div>
</body>
</html>

