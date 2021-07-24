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
 <head><script type="text/javascript" src="jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="jquery.table2excel.js" type="text/javascript"></script></head>
<title>Bookings</title>
<style>
.w3-bar {font-family: "Montserrat", sans-serif}

.head{
text-align: center;
color: black;
padding: 125px;
height: 150px;
}
.image{
background-image: url(https://images.pexels.com/photos/950241/pexels-photo-950241.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940);
	background-repeat: no-repeat;
	background-position: center center;
	background-size: cover;
	background-attachment: fixed;
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;


   opacity: 0.7;

}
.forms{
height: 250px;
width: 100%;
color: black;
font-size: 20px;
}
.datewise{
width: 25%;
float: left;
padding-left: 80px;
}

.upcome{
width: 25%;
float: left;

}
.past{
width: 25%;
float: left;
}
.bytrip{
width: 25%;
float: left;
}
input[type=radio] {
    border: 0px;
    width: 20%;
   height: 1em;
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
  background-color: #f2aa4cff;
color: black;
}
tr:nth-child(odd) {
  background-color: #fcf6f5ff;
color: black;
}
tr:first-child  {
  background-color: #DC143C;
}
.data{
position: static;
 left: 55px;
width: 90%;
height: 200px;
/* max-height: 150px;*/
overflow-y: scroll;

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
<div class="image">
   <div class="head">
      <h1><b>MY BOOKINGS<b></h1>
   </div>
<div class="forms">
<br>
<form id="form" method="POST">
<div class="route">
<br>
<div class="datewise">
Date-wise:
<input type="radio" id="datewise" name="methsel" value="datewise"><br>
</div>
<div class="upcome">
upcoming Bookings:
<input type="radio" id="upcoming" name="methsel" value="upcoming"><br>
</div>
<div class="past">
Past Bookings:
<input type="radio" id="past" name="methsel" value="past"><br>
</div>
<div class="bytrip">
By Trip ID:
<input type="radio" id="tripid" name="methsel" value="tripid"><br>
</div>
<div id="sel">

</div>
<div id="sel1">

</div>
<div id="spl">
 <br><br>
 <p id="Etrip">Enter trip ID:<input type="text" name="trip_id" value="" id="trip_id"></p>

 <p id="Dsel">
  <div class="datewise">All:
<input type="radio" id="all" name="dispsel" value="all"><br>
</div>
<div class="bytrip">
Approved Bookings:
<input type="radio" id="A" name="dispsel" value="A"><br>
</div>
<div class="bytrip">
Rejected Bookings:
<input type="radio" id="R" name="dispsel" value="R"><br>
</div>
<div class="bytrip">
Pending Approvals:
<input type="radio" id="P" name="dispsel" value="P"><br>
</div>
</p>
</div>
</div>
</form>
</div>
<div id="data" class="data">
  </div>

</div>
</body>
</html>
<script type="text/javascript">
  $('#spl').hide();
  $('#Dsel').hide();
  $('#trip_id').hide();
  $('#btnExport').hide();
  $('#Etrip').change(function()
  { $('#Dsel').show();
  });
$('input:radio[name="methsel"]').change(
            function(){
              $('#sel1').empty();
              $('#Etrip').hide();
               $('#spl').hide();
                if ($(this).is(':checked') && $(this).val() == 'past') {
                  $('#data').empty();
                $('#sel').empty();
                $('#spl').hide();

            $.post( 'booking_companion_past.php',
                 function( data ) {
                 window.console && console.log(data);
                   $('#data').empty();
                   $('#data').append(data);

                   $('#btnExport').show();

                  }
              ).error( function() {
                $('#target').css('background-color', 'red');
              alert("Dang!");
                });


        }
        else if($(this).is(':checked') && $(this).val() == 'datewise')
            {
              data='Please Select a Date to display trips.<input type="date" id="date1" name="date1" required><br><br>';
             $('#sel1').empty();
             $('#sel').empty();
              $('#data').empty();
              $('#sel1').append(data);
            }
        else if($(this).is(':checked') && $(this).val() == 'upcoming')
            { $('#Etrip').hide();
          $('#Dsel').show();
            /*$('#data').empty();
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
            });*/
             gm=0;
            data='<br><br>All:\
<input type="radio" id="all" name="dispsel" value="all"><br>\
Approved Bookings:\
<input type="radio" id="A" name="dispsel" value="A"><br>\
Rejected Bookings:\
<input type="radio" id="R" name="dispsel" value="R"><br>\
Pending Approvals:\
<input type="radio" id="P" name="dispsel" value="P"><br>';
             $('#sel').empty();
              $('#data').empty();
              //$('#sel').append(data);
              $('#spl').show();


            }
            else if($(this).is(':checked') && $(this).val() == 'tripid')
            { $('#Dsel').hide();
              $('#Etrip').show();
            /*$('#data').empty();
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
            });*/
            gm=1;
            $('#trip_id').show();
            data='<br><br>All:\
<input type="radio" id="all" name="dispsel" value="all"><br>\
Approved Bookings:\
<input type="radio" id="A" name="dispsel" value="A"><br>\
Rejected Bookings:\
<input type="radio" id="R" name="dispsel" value="R"><br>\
Pending Approvals:\
<input type="radio" id="P" name="dispsel" value="P"><br>';
             $('#sel').empty();
             $('#spl').hide();
              $('#data').empty();
              //$('#sel').append(data);
              $('#spl').show();


            }


    });
$('#sel1').change(function(event) {

    var form = $('#date1');
    var txt = form.val(); //.find('option[id="cars"]') not working
    //alert((txt));
    window.console && console.log(txt);
    $.post( 'booking_companion_date.php', { 'date': txt },
      function( data ) {
          window.console && console.log(data);
            $('#data').empty();
             $('#data').append(data);
          $('#btnExport').show();

      }
    ).error( function() {
      $('#target').css('background-color', 'red');
      alert("Dang!");
  });
  });
//$('#sel').change(function(event) {
$('input:radio[name="dispsel"]').change(
            function(){
              $('#btnExport').show();
              if(gm==0){
              $('#sel1').empty();
                if ($(this).is(':checked') && $(this).val() == 'all')
                {
                    $('#data').empty();
                    $('#sel').empty();
                  $.post( 'booking_companion_upcoming.php', {'all' : 'all'},
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
                else if ($(this).is(':checked') && $(this).val() == 'A')
                {
                   $('#data').empty();
                $('#sel').empty();
            $.post( 'booking_companion_upcoming.php', {'sel' : 'A'},
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
                else if ($(this).is(':checked') && $(this).val() == 'R')
                {
                   $('#data').empty();
                $('#sel').empty();
            $.post( 'booking_companion_upcoming.php', {'sel' : 'R'},
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
                else if ($(this).is(':checked') && $(this).val() == 'P')
                {
                    $('#data').empty();
                $('#sel').empty();
            $.post( 'booking_companion_upcoming.php', {'sel' : 'P'},
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
              }

          else if(gm==1)
              { $('#sel1').empty();
                if ($(this).is(':checked') && $(this).val() == 'all')
                {
                    $('#data').empty();
                    $('#sel').empty();
                    val=$('#trip_id').val();
                  $.post( 'booking_companion_tripid.php', {'all' : 'all', 'trip_id':val},
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
                else if ($(this).is(':checked') && $(this).val() == 'A')
                {
                   $('#data').empty();
                $('#sel').empty();
            $.post( 'booking_companion_tripid.php', {'sel' : 'A', 'trip_id':val},
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
                else if ($(this).is(':checked') && $(this).val() == 'R')
                {
                   $('#data').empty();
                $('#sel').empty();
            $.post( 'booking_companion_tripid.php', {'sel' : 'R', 'trip_id':val},
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
                else if ($(this).is(':checked') && $(this).val() == 'P')
                {
                    $('#data').empty();
                $('#sel').empty();
            $.post( 'booking_companion_tripid.php', {'sel' : 'P', 'trip_id':val},
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

              }
              });
             //});

/*echo('Approve:<form method="POST">
<input type="radio" id="status" name="status" value="A"');if($row['isValidated']=='A') echo('selected');echo('><br>
Reject:
<input type="radio" id="status" name="status" value="R" ');if($row['isValidated']=='R')*/


 $(function () {
        $("#btnExport").click(function () {
            $("#bookingsTable").table2excel({
                //filename: "Table.xls"

                name:"",
                filename:"Bookings",//do not include extension
                fileext:".xls" // file extension

            });
        });
    });


</script>
