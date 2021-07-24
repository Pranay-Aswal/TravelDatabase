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
        <title>Bookings</title>
        <script type="text/javascript" src="jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


       </head>
       <style type="text/css">

.head{
text-align: center;
color: black;
padding: 64px;
height: 15px;

}
.forms{
font-size: 15px;
color: black;
padding-left: 100px;
}
body{
background-image: url("https://free4kwallpapers.com/uploads/originals/2015/09/25/plain-backgrounds.jpg");

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
       </style>
       <body>
<div >
  <div>
  <button class="w3-bar-item w3-button w3-padding-large w3-text-black" onclick="document.location.href = 'home.php'">Home</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-text-black" onclick="document.location.href = 'login.php'">Login</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-text-black"onclick="document.location.href = 'bookings.php'">View Bookings</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-text-black"onclick="document.location.href = 'view_routes.php'">View Routes</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-text-black" onclick="document.location.href = 'view_trips.php'">View Trips</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-text-black" onclick="document.location.href = 'add_trips.php'">Add Trips</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-text-black" onclick="document.location.href = 'add_routes.php'">Add Routes</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-text-black" onclick="document.location.href = 'add_admin.php'">Add Admin</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-text-black" onclick="document.location.href = 'logout.php'">Logout</button>
</div>
  </div>

   <div class="head" >
      <h1><b>View Bookings</b></h1>
   </div>


<div class="forms">
<br>
<form id="form" method="POST">
<div class="route">
<br>
Date-wise:
<input type="radio" id="datewise" name="methsel" value="datewise"><br>
upcoming Bookings:
<input type="radio" id="upcoming" name="methsel" value="upcoming"><br>
Past Bookings:
<input type="radio" id="past" name="methsel" value="past"><br>
By Trip ID:
<input type="radio" id="tripid" name="methsel" value="tripid"><br>
<div id="sel">

</div>
<div id="sel1">

</div>
<div id="spl">
 <br><br>
 <p id="Etrip">Enter trip ID:<input type="text" name="trip_id" value="" id="trip_id"></p>
 <p id="Dsel">All:
<input type="radio" id="all" name="dispsel" value="all"><br>
Approved Bookings:
<input type="radio" id="A" name="dispsel" value="A"><br>
Rejected Bookings:
<input type="radio" id="R" name="dispsel" value="R"><br>
Pending Approvals:
<input type="radio" id="P" name="dispsel" value="P"><br>
</p>
</div>
</div>
</form>
</div>
<div id="data" class="scrolling-wrapper">
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





</script>
