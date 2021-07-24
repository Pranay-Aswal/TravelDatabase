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

    if(isset($_POST['Time']))
    {
     header( 'Location: payments.php' ) ;
      return;
    }

    // till here into any page after login.
?>

<html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
 <head>
  <script type="text/javascript" src="jquery.min.js"></script>
 <title>Book_page</title>
 </head>
<style>
.w3-bar {font-family: "Montserrat", sans-serif}
.hero-image {
  background-image: url("https://www.wallpapertip.com/wmimgs/44-446344_hyderabad-wallpaper.jpg");
  background-color: #cccccc;
  height: 710px;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
  opacity: 0.9;
}

.hero-text {
  text-align: center;
  position: absolute;
  top: 25%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
}
.hi {
top: 400px;
left: 500px;
}
html {
  scroll-behavior: smooth;
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
  position: absolute;
  bottom: 0px;
  right: 20px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: #696969;
 color: black;
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
  background-color: #FF69B4;
}
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
.button1 {
 background-color: #FF69B4;
  border: none;
  color: white;
  padding: 7px 15px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 15px;
  margin: 12px 8px;
  cursor: pointer;
  border-radius: 8px;
}
.button2{
 background-color: #FFB6C1;
  border: none;
  color: white;
  padding: 7px 15px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 15px;
  margin: 12px 8px;
  cursor: pointer;
  border-radius: 8px;
}
.hi:hover .button1 {background-color: #FFB6C1;}
.hi:hover .button2 {background-color: #FF69B4;}

.form{
  position: relative;
 top: 320px;
  left: 480px;
 background-color: #DCDCDC;
opacity: 0.8;
width: 30%;
height: 310px;
border-style: solid;
  border-color: black;
}
.button3{

 top: 350px;
  right: 490px;
color: white;
  text-align: center;
 padding: 7px 15px;
 font-size: 15px;
}
.from{
 top: 350px;
  left: 20px;
}
.to{
}
.time{
}
.con{
 left: 420px;
}
.footer{
 width: 100%;
  height: 350px;
 background-color: #282828;
}
.extra{
  width: 100%;
  height: 27px;
 background-color: white;
color: red;
font-size: 20px;
opacity: 0.7px;
 text-align: center
}
footer {
  padding: 7em 0; }

.footer {
  background: #272727;
  padding-bottom: 0; }
  .footer .border-top {
    border-color: #1a1a1a !important;
    background: #1a1a1a; }
  .footer .footer-heading {
    font-size: 20px;
    color: #fff;
    margin-bottom: 30px;
    font-weight: 500;
    font-family: "Poppins", Arial, sans-serif; }
    .footer .footer-heading .logo {
      color: #fff; }
  .footer p {
    color: rgba(255, 255, 255, 0.3); }
  .footer a {
    color: #fd7792; }
  .footer .ftco-footer-social li a {
    color: #fff; }
  .footer .tagcloud a {
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #fff; }
  .footer .list-unstyled li a {
    color: rgba(255, 255, 255, 0.7); }
  .footer .list-unstyled a {
    color: rgba(255, 255, 255, 0.7); }
  .footer .ftco-footer-social li a {
    border-radius: 4px;
    border: 1px solid rgba(255, 255, 255, 0.1); }
  .footer .subscribe-form .form-group {
    position: relative;
    margin-bottom: 0;
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    -ms-border-radius: 0;
    border-radius: 0; }
    .footer .subscribe-form .form-group input {
      background: rgba(255, 255, 255, 0.05) !important;
      border: none !important;
      outline: none !important;
      color: rgba(255, 255, 255, 0.3) !important;
      font-size: 16px;
      -webkit-border-radius: 0;
      -moz-border-radius: 0;
      -ms-border-radius: 0;
      border-radius: 0; }
      .footer .subscribe-form .form-group input::-webkit-input-placeholder {
        /* Chrome/Opera/Safari */
        color: rgba(255, 255, 255, 0.3) !important; }
      .footer .subscribe-form .form-group input::-moz-placeholder {
        /* Firefox 19+ */
        color: rgba(255, 255, 255, 0.3) !important; }
      .footer .subscribe-form .form-group input:-ms-input-placeholder {
        /* IE 10+ */
        color: rgba(255, 255, 255, 0.3) !important; }
      .footer .subscribe-form .form-group input:-moz-placeholder {
        /* Firefox 18- */
        color: rgba(255, 255, 255, 0.3) !important; }
      .footer .subscribe-form .form-group input:focus {
        outline: none !important;
        -webkit-box-shadow: none;
        box-shadow: none; }
    .footer .subscribe-form .form-group .submit {
      color: #fff !important;
      display: block;
      width: 52px;
      height: 52px;
      font-size: 16px;
      background: #fd7792 !important;
      border: none;
      -webkit-border-radius: 0;
      -moz-border-radius: 0;
      -ms-border-radius: 0;
      border-radius: 0; }
      .footer .subscribe-form .form-group .submit:hover, .footer .subscribe-form .form-group .submit:focus {
        text-decoration: none !important;
        outline: none !important; }
  .footer .copyright a {
    color: rgba(255, 255, 255, 0.5); }

.ftco-footer-social li {
  list-style: none;
  margin: 0 10px 0 0;
  display: inline-block; }
  .ftco-footer-social li a {
    height: 40px;
    width: 40px;
    display: block;
    float: left;
    border-radius: 50%;
    position: relative; }
    .ftco-footer-social li a span {
      position: absolute;
      font-size: 20px;
      top: 50%;
      left: 50%;
      -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%); }
    .ftco-footer-social li a:hover {
      color: #fff; }

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
<div class="hero-image">
  <div class="hero-text">
    <h1 style="font-size:60px"><b>Book Your Ride</b></h1>
    <h3>Start exploring the city of Hyderabad.</h3>
<div class="hi">
</div>
  </div>

<div class="form">
<br>
<form id="form" method="POST">
  <label for="date">Date: </label>
  <input type="date" id="date" name="date" required><br><br>

<label for="From">From: </label>
<select id="From" name="From" required>
</select><br/><br>

<label for="To">To: </label>
<select id="To" name="To" required>
</select>
 <br><br>
<label for="Time">Time: </label>
<select id="Time" name="Time"required>
</select>
 <br><br>
<label for="Name">Availability: </label>
<input type="text" name="Availability" id="availability" size="3" readonly="true" >

<label for="Name">Cost: </label>
<input type="text" name="Cost" id="cost" size="1" readonly="true"><br/>
<br><br>
  <input type="submit" value="Book Now" formaction="payments.php" class="btn btn-primary py-3 px-4">
</form>

<div id="availability"></div>
</div>
</div>
<div class="extra">
</div>

<div class="container">

<div class="row">

<script>
function openTC() {
  document.getElementById("myForm").style.display = "block";
}

function closeTC() {
  document.getElementById("myForm").style.display = "none";
}
var today = new Date();
var tomorrow=new Date();
tomorrow.setDate(today.getDate()+1);

//alert(tomorrow);
document.getElementsByName("date")[0].setAttribute('min', tomorrow.toISOString().split('T')[0]);

</script>
</body>
</html>
<script type="text/javascript">


$('#date').change(function(event) {
    var form = $('#date');
    var txt = form.val(); //.find('option[id="cars"]') not working
    //alert(typeof(txt));
    window.console && console.log(txt);
    $.post( 'book_companion_FROM.php', { 'date': txt },
      function( data ) {
          window.console && console.log(data);
          $('#From').empty().append(data);
          $('#To').empty();
          $('#Time').empty();
          $('#availability').empty();

      }
    ).error( function() {
      $('#target').css('background-color', 'red');
      alert("Dang!");
  });
  });
$('#From').hover(function(event) {
    //sleep(1);
    var code = {};
    //echo("entered");
$("select[name='From'] > option").each(function () {
    if(code[this.text]) {
        $(this).attr('hidden',true);
    } else {
        code[this.text] = this.value;
    }
});
});
    $('#From').change(function(event) {
      var form = $('#date');
      var txt1 = form.val();
      var from=$('#From');
      var txt2=from.val();
      //alert(txt2);
    $.post( 'book_companion_TO.php', { 'date': txt1 , 'from': txt2 },
      function( data ) {
          window.console && console.log(data);
          $('#To').empty().append(data);
          $('#Time').empty();
          $('#availability').empty();

      }
    ).error( function() {
      $('#target').css('background-color', 'red');
      alert("Dang!");
  });
  });

     $('#To').change(function(event) {
      var form = $('#date');
      var txt1 = form.val();
      var from=$('#From');
      var txt2=from.val();
      var to=$('#To');
      var txt3=to.val();
      //alert(txt2);
    $.post( 'book_companion_TIME.php', { 'date': txt1 , 'from': txt2, 'to': txt3 },
      function( data ) {
          window.console && console.log(data);
          $('#Time').empty().append(data);
          $('#availability').empty();

      }
    ).error( function() {
      $('#target').css('background-color', 'red');
      alert("Dang!");
  });
  });

     $('#Time').change(function(event) {
      var form = $('#date');
      var txt1 = form.val();
      var from=$('#From');
      var txt2=from.val();
      var to=$('#To');
      var txt3=to.val();
      var time=$('#Time');
      var txt4=time.val();
      //alert(txt2);
    $.post( 'book_companion_AVBL.php', { 'date': txt1 , 'from': txt2,'to':txt3, 'time':txt4 },
      function( data ){
          window.console && console.log(data);
          var res=data.split(",");
          if(res[0]==0)
          {
            alert("Sorry!! NO Seats available for this trip.");
            location.reload();
          }
          else{
          $('#availability').val(res[0]);
          $('#cost').val(res[1]);
        }

      }
    ).error( function() {
      $('#target').css('background-color', 'red');
      alert("Dang!");
  });
  });
</script>
