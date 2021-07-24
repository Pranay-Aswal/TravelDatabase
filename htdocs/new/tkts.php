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
<head>
  <title>Ticket</title>
  <link href='https://fonts.googleapis.com/css?family=Lobster|Kreon:400,700' rel='stylesheet' type='text/css'>
</head>
<style>
  body {
    margin: 0;
    color: black;
    font-family: "Kreon", serif;
    font-weight: 400;
    font-size: 25px;
  }

.main{
  background-image: url(https://images.megapixl.com/530/5309690.jpg);
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
  .container {
    width: 795px;
    margin: 0 auto;
position: relative;
top:90px;
height: 200px;
  }

  section {
    position: relative;
    float: left;
    width: 685px;
  }
  section .special {
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    position: relative;
    height: 47px;
    width: 200px
    padding: 200px 150px 0px;
    background-color: #fc766aff;
    color: #fff;
    text-align: center;
  }
  section .special:nth-child(1) {
    background-color: #5b84b1ff;
  }
  section .special:nth-child(6), section .special:nth-child(7) {
    z-index: 1;
  }

  aside {
    float: right;
    width: 110px;
  }
  aside figure {
    height:50%;
    margin: 0;
    text-align: center;
  left: 280px;

  }
  aside figure img {
    margin-top: -40px;
position: relative;
left: -290px;


  }
.route{
width: 50%;
float: left;
 color: black;

}

.from{
width: 50%;
float: left;
 color: black;

}
.to{
width: 50%;
float: left;
 color: black;
}
.date{
width: 60%;
float: left;
 color: black;
}
.time{
width: 50%;
float: left;
 color: black;
}
.fig{

}
</style>

<body>
  <div class="main">
  <div class="w3-top">
  <div class="w3-bar w3-purple w3-card w3-left-align w3-large">
   <button class="w3-bar-item w3-button w3-padding-large w3-white" onclick="document.location.href = 'home.php'">Home</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'login.php'">Login</button>
         <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'Profile.php'">My Profile</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white"onclick="document.location.href = 'Routes3.php'">Routes</button>
     <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'myBookings.php'">My Bookings</button>

    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = 'logout.php'">Logout</button>
    <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" onclick="document.location.href = '../new_admin/login.php'" style="float: right;">Admin Login</button>
    </div>
  </div>
  <div class="container">
    <section>

      <div class="circle">
        <div class="title"><br><br>CityBus Ticket</div>
      <div class="special">
        <div class="seats">
          <span class="label"></span><span></span>
        </div>
      </div>

   <div class="special"><div class="from">
<label for="From"> Name : </label>
<input type="text"  id="from" size="25" readonly="true" value="<?php echo($_GET['name'])?>" >
</div><div class="to">
<label for="To">Date : </label>
<input type="text"  id="availability" size="25" readonly="true" value="<?php echo($_GET['date'])?>">
</div></div>
<div class="special"><div class="from">
<label for="From"> From : </label>
<input type="text"  id="from" size="25" readonly="true" value="<?php echo($_GET['from'])?>">
</div><div class="to">
<label for="To">To : </label>
<input type="text"  id="availability" size="25" readonly="true" value="<?php echo($_GET['to'])?>">
</div></div>
<div class="special"><div class="route">
<label for="rn">Amount : </label>
<input type="text"  id="from" size="25" readonly="true" value="<?php echo($_GET['amt'])?>">
</div><div class="time">
 <label for="time">Through : </label>
<input type="text"  id="availability" size="25" readonly="true" value="<?php echo($_GET['thru'])?>">
</div></div>
      </div>
    </section>
      <aside>
    </aside>
  </div>

</body>

</html>
