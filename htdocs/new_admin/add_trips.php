<?php
    require_once "pdo.php";
    session_start();
     //copy from here till
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



    if(isset($_POST['cancel']))
    {
      header( 'Location: home.php' ) ;
      return;
    }
/* <form>
Trip ID: <input type="text"  name="trip_id"><br><br>
From: <input type="text"  name="From" ><br><br>
To: <input type="text"  name="To" ><br><br>
Date: <input type="text"  name="date" ><br><br>
Start time: <input type="text"  name="Start_time" ><br><br>
Availability: <input type="text"  name="Availability" ><br><br>
Cost: <input type="text"  name="Cost" ><br><br>
Route id: <input type="text"  name="route_id" ><br><br>
<input type="submit" value="Add trip">
<input type="submit" name="cancel" value="Cancel">
</form>*/
    if(isset($_POST['From']) && isset($_POST['To']) && isset($_POST['date']) && isset($_POST['Start_time']) && isset($_POST['Availability']) && isset($_POST['Cost']) && isset($_POST['route_id']))
    {  $GO=1;
       $stmt = $pdo->prepare('SELECT * FROM trip_details WHERE `date` = :sel_date');
        $stmt->execute(array( ':sel_date' => $_POST['date'] ));
        $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        $stmt = $pdo->prepare('SELECT * FROM route WHERE route_id = :rid');
        $stmt->execute(array( ':rid' => $_POST['route_id'] ));
        $row2 = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        if($row2===false)
        {  
          $_SESSION['err_msg']="No such route exists...please insert the route first!!";

          header( 'Location: add_trips.php' ) ;
          return;
        }
        else if(strtolower($row2[0]['From'])!=strtolower($_POST['From'])) {
           //$_SESSION['err_msg']="Incorrect route_id input...Please check again!!";
          $_SESSION['err_msg']="hello".$row2[0]['From']."   ".$_POST['From'];
          header( 'Location: add_trips.php' ) ;
          return;
        }

        if($row1===false)
        {
          //$GO=1;
        }
        else if(($row1[0]['From']==$_POST['From']) && ($row1[0]['To']==$_POST['To']) && ($row2[0]['Time']==$_POST['Start_time']) && ($row1[0]['route_id']==$_POST['route_id']))
        {
          $_SESSION['err_msg']="Trip ".$row1[0]['trip_id']." with same details already exists...please check!!";
          $GO=0;
          header( 'Location: add_trips.php' ) ;
          return;
        }

        if($GO===1)
        {
          $sql = "INSERT INTO trip_details(`From`,`To`,`Availability`,`Date`,Cost,route_id) VALUES(:frm,:to,:avbl,:dt,:cost,:rid) ";
        echo("<pre>\n".$sql."\n</pre>\n");
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':frm'=>$_POST['From'],':to'=>$_POST['To'],':avbl'=>$_POST['Availability'],':dt'=>$_POST['date'],':cost'=>$_POST['Cost'],':rid'=>$_POST['route_id']));
          $_SESSION['success_msg']="Trip Inserted Successfully .";
          header( 'Location: home.php' ) ;
          return;

        }

       
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
        <title>Add Trips</title>
        <script type="text/javascript" src="jquery.min.js"></script>
       </head>
       <style>
.w3-bar {font-family: "Montserrat", sans-serif}
.main{
width: 100%;
background-color:#CCFFFF/*#F5F5F5/*#C0C0C0/*#696969*/;
color: #FF0000;
}
.head{
text-align: center;
color: white;
padding: 20px;
padding-right: 500px;
}
.forms{
height: 100px;
width: 100%;
/*color: blue;*/
}
.route{
width: 20%;
float: left;

}

.from{
width: 20%;
float: left;

}
.to{
width: 20%;
float: left;
}
.date{
width: 20%;
float: left;
}
.time{
width: 20%;
float: left;
}

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  height: 100px;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
background-color: #FF9900;
color: black;
}
tr:nth-child(odd) {
background-color: #FF3300/*#FFF0F5*/;
color: black;
}
.move{
position: relative;
 left: 190px;
width: 70%;
height: 300px;
}
.map{
width: 100%;
height: 650px;
background-color: #2E8B57;
}
.head1{
padding: 64px;
color: white;
height: 50px;

}
.foote{
background-color: #FFA500;
color: red;
height: 30px;
}
.add{
background-color: #FFA500;
height: 20px;
}
.relative {
  position: relative;
  left: 250px;
  height: 520px;
  width: 50%;
}
.image{
background-image: url("https://cdn1.vectorstock.com/i/1000x1000/79/15/india-hyderabad-city-skyline-isolated-vector-28137915.jpg");
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
.frame{
width: 85%;
color: black;
padding-left: 250px;

}
.head{
color: black;
height: 15px;
}
.from{
position: relative;
width:30%;
left: 50px;
}
.to{
position: relative;
width:70%
left: 0px;

}
.date{
position: relative;
width:26%;
left: 50px;

}
.start{
position: relative;
width:30%
left: 100px;

}
.avail{
position: relative;
width:30%;
left: 150px;
}
.cost{
position: relative;
width:30%;
left: 190px;
}
.route{
position: relative;
width:30%;
left: 160px;
}

.at{
position: relative;
width: 20%;
left: 160px;
color: black;
}
.c{
position: relative;
width:30%;
left:370px;
top: -24px;
color: black;
}
</style>
 <body>
<div class="image">
<div>
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
 
   <div class="head">
      <h1>ADD TRIPS</h1>
   </div>
 <br><br>
<?php if ( isset($_SESSION['success_msg']))
        { echo($_SESSION['success_msg']);
          unset($_SESSION['success_msg']);
         }
     if( isset($_SESSION['err_msg']) )
      { echo($_SESSION['err_msg']);
             unset($_SESSION['err_msg']);
         }
    
    
  ?>

<div class="forms">
<br>
<form id="form" method="POST"> 
<div >
<br>
<div class="frame">
  <form>
<div class="from">
From: <input type="text"  name="From" required><br><br>
</div>
To: <input type="text"  name="To" required ><br><br><br>
<div class="date">
Date: <input type="date"  name="date" required ><br><br>
</div>
Start time: <input type="text"  name="Start_time" required ><br><br><br>
<div class="avail">
Availability: <input type="text"  name="Availability"  required><br><br><br>
</div>
<div class="cost">
Cost: <input type="text"  name="Cost" required><br><br><br>
</div>
<div class="route">
Route id: <input type="text"  name="route_id" required><br><br>
</div><br><br><br>

<div class="at">
<input type="submit" value="Add trip" >
</div>
<div class="c">
<input type="submit" name="cancel" value="Cancel">
</div>
</form>
</div>
</div>
</body>
</html>