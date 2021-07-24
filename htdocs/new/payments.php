<?php
session_start();
require_once "pdo.php";
$id=session_id();
    if(isset($_SESSION['name']) && isset($_SESSION['email_id'])&& isset($_SESSION['userID']))
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
      else {echo("ACCESS DENIED!! Please LOGIN FIRST");
      sleep(2);
      header( 'Location: login.php' ) ;
      return;
    }

     if(isset($_POST["txn1"]))
     {
     	$target_dir = "Payment_screenshots/";
//$target_file = $target_dir .basename($_FILES["fileToUpload"]["name"]);
     	$sql1 = "SELECT CURRENT_TIMESTAMP();";
     	$stmt1 = $pdo->prepare($sql1);
        $stmt1->execute();
        $time = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        $time1=str_replace(":","",$time[0]['CURRENT_TIMESTAMP()']);
$extn=strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
$target_file = $target_dir .basename($_SESSION['name'].'_'.$_SESSION['Unique_tripID'].'_'.$time1.'.'.$extn);
$_FILES["fileToUpload"]["name"]=$_SESSION['name'].'_'.$_SESSION['Unique_tripID'].'_'.$time1.'.'.$extn;
$uploadOk = 1;
$_SESSION['txn_id']=$_POST['txn1'].$_POST['txn2'].$_POST['txn3'];
$_SESSION['paymeth']=$_POST['pay'];
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "<script>alert('Sorry, file already exists.');</script>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "<script>alert('Sorry, your file is too large.');</script>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<script>alert('Sorry, your file was not uploaded.".'\n'."Please try Again!!');</script>";
    //header( 'Location: payments.php') ;
    // return;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file  has been uploaded.";
        $string2="From=".$_GET['From']."&"."To=".$_GET['To']."&"."Cost=".$_GET['Cost']."&"."date=".$_GET['date']."&"."Time=".$_GET['Time'];
        $_SESSION['fileLoc']=$_SESSION['name'].'_'.$_SESSION['Unique_tripID'].'_'.$time1.'.'.$extn;
      header( 'Location: upload.php?'.$string2 ) ;
      return;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
     }
     else if(isset($_POST['pay'])&& ($_POST['pay']=='cash'))
     {$_SESSION['paymeth']=$_POST['pay'];
      $_SESSION['fileLoc']=null;
      $_SESSION['txn_id']=0;
      $string2="From=".$_GET['From']."&"."To=".$_GET['To']."&"."Cost=".$_GET['Cost']."&"."date=".$_GET['date']."&"."Time=".$_GET['Time'];
      header( 'Location: upload.php?'.$string2 ) ;
      return;



     }
     if(isset($_POST['txn1']) || isset($_POST['From']) || isset($_GET['From']))
     {  if(isset($_POST['txn1']) || isset($_POST['txn2']) || isset($_POST['txn3']))
            {
              if($_POST['txn1']==false || isset($_POST['txn1'])==false || isset($_POST['txn1'])==false)
              {header( 'Location: book2.php') ;
                 return;

              }
            }

     }
     else{
      header( 'Location: book2.php') ;
      return;
     }


    // till here into any page after login.

?>
<html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<head>
	 <script type="text/javascript" src="jquery.min.js"></script>
<title>Confirm_Booking</title>
</head>
<style>
.w3-bar {font-family: "Montserrat", sans-serif}
@import url(https://fonts.googleapis.com/css?family=Lato:400, 700,300);
body {
  background-color: #301934	;
  font-family: lato, 'helvetica-light';
  position: relative;
  text-transform: uppercase;
  padding: 20px 0;
 opacity: 0.7px;
}

input[pattern]:invalid{
  color:red;
}

#amount {
  font-size: 12px;
}
#amount strong {
  font-size: 14px;
}
#card-back {
  top: 40px;
  right: 0;
  z-index: -2;
}
#card-btn {
  background-color: #00FA9A;
  color: black;
  position: absolute;
  bottom: -55px;
  right: 0;
  width: 150px;
  border-radius: 8px;
  height: 42px;
  font-size: 12px;
  font-family: lato, 'helvetica-light', 'sans-serif';
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 400;
  outline: none;
  border: none;
  cursor: pointer;
}
#card-btn:hover {
  background-color: rgba(251, 251, 251, 1);
}

#card-front,
#card-back {
  position: absolute;
  background-color:#301934;
  width: 390px;
  height: 250px;
  border-radius: 6px;
  padding: 20px 30px 0;
  box-sizing: border-box;
  font-size: 10px;
  letter-spacing: 1px;
  font-weight: 300;
  color: white;
}

#card-stripe {
  width: 100%;
  height: 55px;
  background-color: #301934;
  position: absolute;
  right: 0;
}


#cvc-container {
  position: absolute;
  width: 110px;
  right: -115px;
  bottom: -10px;
  padding-left: 20px;
  box-sizing: border-box;
}

#form-container {
  margin: auto;
  width: 500px;
  height: 290px;
  top: 160px;
 left: 300px;
  position: relative;
}

#image-container {
  width: 100%;
  position: relative;
  height: 55px;
  margin-bottom: 5px;
  line-height: 55px;
}

#image-container img {
  position: absolute;
  right: 0;
  top: 0;
}


label {
  display: block;
  margin: 0 auto 7px;
}

#shadow {
  position: absolute;
  right: 0;
  width: 284px;
  height: 214px;
  top: 36px;
  background-color: #000;
  z-index: -1;
  border-radius: 8px;
  box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.1);
  -moz-box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.1);
  -webkit-box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.1);
}
.mov{
font-size:15px;
width: 100%;
bottom: 0px;
left: 50px;
}
.forms{
 position: relative;
 top: -65px;
 left: -620px;
 background-color: #DCDCDC;
opacity: 0.8;
width: 100%;
height: 420px;
border-style: solid;
 border-color: black;
}
.head{
color: black;
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
  bottom: 30px;
  right: 650px;
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
.center {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 50px;

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

<div id="form-container">
  <div id="card-front">


    <div id="image-container">
      <span id="card-image">
        </span>
<div class="mov">
	<?php
	 if(isset($_POST['From']))
	 	$string1="From=".$_POST['From']."&"."To=".$_POST['To']."&"."Cost=".$_POST['Cost']."&"."date=".$_POST['date']."&"."Time=".$_POST['Time'];

	?>

<form id="f1" action="payments.php?<?php if(isset($_POST['From']))echo($string1);?>" method="POST" enctype="multipart/form-data">

    PayTm:<input type="radio" id="paytm" name="pay" value="paytm">
	Gpay:<input type="radio" id="gpay" name="pay" value="gpay">
	PhonePe:<input type="radio" id="phoepe" name="pay" value="phonepe">
	Cash:<input type="radio" id="cash" name="pay" value="cash">
    <div id="payshot" style="background-color: lightgreen">

    </div>
    </form>
    <p style="color: white; font-size: 20; ">Pay at: <br><b> PayTm: 9592555233 <br> Gpay: 9592555233 <br> PhonePay: 9592555233</b> <br></p>
</div>
    </div>
        <div id="cvc-container">
      <button type="button" onclick="back()" >BACK</button>
    </div>
  </div>
  <div id="card-back">
    <div id="card-stripe">
    </div>
  </div>
  <input type="text" id="card-token" />

<button  type="submit" id="card-btn" onclick="twoforms()">Confirm Booking</button>

<div class="forms">
<br>
<form id="f2">
 <label for="from">From: </label>
<input type="text"  name="From"  value="<?php if(isset($_POST['From']))echo($_POST['From']); else echo($_GET['From'])?>" size="25" readonly="true" >
<label for="to">To: </label>
<input type="text"  name="To" value="<?php if(isset($_POST['To']))echo($_POST['To']); else echo($_GET['To'])?>" size="25" readonly="true" >
<div class="test">
<label for="date">On: </label>
<input type="text"  name="date" value="<?php if(isset($_POST['From']))echo($_POST['date']); else echo($_GET['date'])?>" size="25" readonly="true" >
 <label for="time">At: </label>
<input type="text"  name="Time" value="<?php if(isset($_POST['From']))echo($_POST['Time']); else echo($_GET['Time'])?>" size="25" readonly="true" >
</div><br>
<label for="cost">Cost: </label>
<input type="text"  name="Cost" size="7" value="<?php if(isset($_POST['From']))echo($_POST['Cost']); else echo($_GET['Cost'])?>" readonly="true">

</form>
<div class="center">
<button class="open-button" onclick="openTC()" style="width: 220px; height: 50px;"><span>Terms & Conditions</span></button>
<div class="form-popup" id="myForm">
  <form class="form-container">
  <h1><u>T & C</u> </h1>
   <p> 1)  Any changes required after booking is not permissible <br>
          2)  Please ensure to book tickets at correct and right time<br>
          3)  Its your duty to stay at location on time<br>
          4)  In case of any bus misses we are not responsibility regarding tickets<br>
  </p>
   <button type="button" class="btn cancel" onclick="closeTC()">Close</button>
  </form>
</div>
</div>
</div>
</div>

</div>

<script>
function openTC() {
  document.getElementById("myForm").style.display = "block";
}

function closeTC() {
  document.getElementById("myForm").style.display = "none";
}


</script>

</body>
</html>
<script type="text/javascript">
	function twoforms()
	{
		document.getElementById('f1').submit();
		//document.getElementById('f2').submit();
	}
	function back()
	{
		window.location.href = "book2.php";
	}
	$('input:radio[name="pay"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'cash') {
            $('#payshot').empty();


        }
        else if($(this).is(':checked') && $(this).val() == 'paytm')
            {
            	data='Please Upload Your Payment ScreenShot Here. 	<input type="file" name="fileToUpload" id="fileToUpload">	<br/> Enter Transaction ID for PayTM:               	<input name="txn1" type="number" pattern="[0-9]{3}" placeholder="####" minlength="3" maxlength="3" aria-label="3-digit area code" size="2"/>)-               	 <input name="txn2" type="number" pattern="[0-9]{4}" placeholder="####" minlength="4" maxlength="4"aria-label="4-digit number" size="3"/> -   	 <input name="txn3" type="number" pattern="[0-9]{4}" placeholder="####" minlength="4" maxlength="4"aria-label="4-digit number" size="3"/>';
            	$('#payshot').empty();
            	$('#payshot').append(data);
            }
            else if($(this).is(':checked') && $(this).val() == 'gpay')
            {
                 data='Please Upload Your Payment ScreenShot Here.	<input type="file" name="fileToUpload" id="fileToUpload">	<br/> Enter Transaction ID for Gpay:    <input name="txn1" type="tel" pattern="[0-9]{4}" placeholder="####" aria-label="4-digit number" size="3"/>)-    <input name="txn2" type="tel" pattern="[0-9]{4}" placeholder="####" aria-label="4-digit number" size="3"/> -     <input name="txn3" type="tel" pattern="[0-9]{4}" placeholder="####" aria-label="4-digit number" size="3"/>';
                 $('#payshot').empty();
            	$('#payshot').append(data);
            }
            else if($(this).is(':checked') && $(this).val() == 'phonepe')
            {
                data='Please Upload Your Payment ScreenShot Here. 	<input type="file" name="fileToUpload" id="fileToUpload">	<br/> Enter Transaction ID for PhonePe:   <input name="txn1" type="text" pattern="[0-9]{8}" placeholder="P1234567" />)-   <input name="txn2" type="tel" pattern="[0-9]{7}" placeholder="1234567" /> -    <input name="txn3" type="tel" pattern="[0-9]{8}" placeholder="12345678" />';
                $('#payshot').empty();
            	$('#payshot').append(data);
            }
    });



</script>
