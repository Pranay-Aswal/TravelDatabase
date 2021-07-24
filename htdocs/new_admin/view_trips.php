<?php
session_start();
require_once "pdo.php";
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

?>

<html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <head>
        <title>View Trips</title>
        <script type="text/javascript" src="jquery.min.js"></script>
       </head>
       <style>
.w3-bar {font-family: "Montserrat", sans-serif}
.main{
width: 100%;
background-color:#388E8E;
color: #388E8E;
}
.head{
text-align: center;
color: black;
padding: 64px;
height: 200px;

}
.forms{
height: 100px;
width: 100%;
font-size: 35px;
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
background-color: #FFF0F5;
color: black;
}
tr:nth-child(odd) {
background-color: #C28285;
color: black;
}
tr:first-child  {
  background-color: #DC143C;
}
.move{
position: relative;
 left: 190px;
width: 70%;
height: 300px;
}

.head1{
padding: 64px;
color: white;
height: 50px;

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
 background-image: url('https://cdn2.vectorstock.com/i/1000x1000/01/21/transport-background-with-town-and-bus-vector-2140121.jpg');
background-repeat: no-repeat;
height: 900px;
/*background-repeat: no-repeat;*/
  position: relative;
  background-size: cover;
  height: 100%;
 

}
.headings{
color: white;
}
input[type=radio] {
    border: 0px;
    width: 20%;
   height: 1em;
}
.dw{
width: 35%;
float: left;
color: red;
font-size: 20px;
padding-left: 100px;
}
.ut{
width: 35%;
float: left;
color: red;
font-size: 20px;
}
.st{
width: 30%;
float: left;
color: red;
font-size: 20px;
}
a {
  color: #2c87f0;
}
a:visited {
  color: #636;
}
a:hover, a:active, a:focus {
  color:#c33;
}
table, th, td {
  border: 1px solid black;
}
.addon{

background-color: #D3D3D3;
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

   <div class="head">
      <h1>TRIPS</h1>
   </div>

<br>
<div class="forms">
<br>
<form id="form" method="POST"> 

<div class="dw">
Date-wise:
<input type="radio" id="datewise" name="datesel" value="datewise">
</div>
<div class="ut">
Show all upcoming trips:
<input type="radio" id="upcoming" name="datesel" value="upcoming">
</div>
<div class="st">
Show all trips:
<input type="radio" id="all" name="datesel" value="all">
</div>
</form>
</div>
</div>
<div id="date">
  </div>
<div class="addon">
<div id="data">
  </div>
</div>
</body>
</html>
<script type="text/javascript">
$('input:radio[name="datesel"]').change(
            function(){
                if ($(this).is(':checked') && $(this).val() == 'all') {
                  $('#data').empty();
                $('#date').empty();
            $.post( 'view_trips_companion_all.php',
                 function( data ) {
                 window.console && console.log(data);
                   $('#data').empty();
                   $('#data').append(data);
         
                  }
              ).error( function() { 
                $('#target').css('background-color', 'red');
              alert("Dang!");
                });

            
        }
        else if($(this).is(':checked') && $(this).val() == 'datewise')
            {
              data='Please Select a Date to display trips.<input type="date" id="date1" name="date1" required><br><br>';
             $('#date').empty();
              $('#data').empty();
              $('#date').append(data);
            }
        else if($(this).is(':checked') && $(this).val() == 'upcoming')
            {$('#data').empty();
              $('#date').empty();
              $.post( 'view_trips_companion_upcoming.php',
             function( data ) {
             window.console && console.log(data);
             $('#data').empty();
             $('#data').append(data);
         
          }
            ).error( function() { 
             $('#target').css('background-color', 'red');
               alert("Dang!");
            });
              
              
            }
            
            
    });
$('#date').change(function(event) {

    var form = $('#date1');
    var txt = form.val(); //.find('option[id="cars"]') not working
    //alert((txt));
    window.console && console.log(txt);
    $.post( 'view_trips_companion_date.php', { 'date': txt },
      function( data ) {
          window.console && console.log(data);
            $('#data').empty();
             $('#data').append(data);
         
         
      }
    ).error( function() { 
      $('#target').css('background-color', 'red');
      alert("Dang!");
  });
  });
  
</script>
