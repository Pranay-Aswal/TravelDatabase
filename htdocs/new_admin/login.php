<?php
    require_once "pdo.php";
    session_start();
    if(isset($_POST['cancel']))
    {
       header( 'Location: ../new/home.php' ) ;
           return;
    }
    if ( isset($_POST["admin_id"]) && isset($_POST["pw"]) ) {
         unset($_SESSION["admin_id"]); // Logout current user
         $salt = '_SSRam_203';
         $check = hash('md5', $salt.$_POST['pw']);
        $admin_id=$_POST["admin_id"];
        $sql = "SELECT name,password,unique_id,ph_no FROM admin_details WHERE admin_id=:id";
        echo("<pre>\n".$sql."\n</pre>\n");
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $admin_id));
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
       // echo("<pre>\n".$_POST['pw']."\n</pre>\n");
       // echo("<pre>\n".var_dump($row)."\n</pre>\n");
        if($row==false)
        { $_SESSION["error"]="Sorry!! No such Admin found.";
          header( 'Location: login.php' ) ;
          return;
         
        }
        elseif ( $row[0]['password'] ==/*"Tea@123"*/hash('md5', $salt.$_POST['pw'])) {
           $_SESSION['admin_id']=$admin_id;
           $_SESSION['name']=$row[0]['name'];
           $_SESSION['adminID']=$row[0]['unique_id'];
           $_SESSION['ph_no']=$row[0]['ph_no'];
           echo('<br/><br/><br/>');
           echo($_SESSION['adminID'].'1234');sleep(3);
           $_SESSION["success"] = "Logged in.";
           $id = session_id();
           $sql = "UPDATE admin_details SET session_id=:id WHERE admin_id=:email_id";
           //echo("<pre>\n".$sql."\n</pre>\n");
           $stmt = $pdo->prepare($sql);
           $stmt->execute(array(':id' => $id,':email_id' => $admin_id));

           $sql1 = "SELECT CURRENT_TIMESTAMP();";
           if (!empty($_SERVER['REMOTE_ADDR']) )  
              {
               $ip_address = $_SERVER['REMOTE_ADDR'];
                 }
                  //whether ip is from proxy
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
               {
                  $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
                //whether ip is from remote address
              else
                 {
                $ip_address = $_SERVER['HTTP_CLIENT_IP'];
                }
           //echo("<pre>\n".$sql."\n</pre>\n");
           $stmt1 = $pdo->prepare($sql1);
           $stmt1->execute();
           $time = $stmt1->fetchAll(PDO::FETCH_ASSOC);

           $sql = "INSERT INTO admin_log (time_stamp,ip_address,session_id,admin_unique_id) VALUES(:ts,:ip,:id,:aid) ";
           //echo("<pre>\n".$sql."\n</pre>\n");
           $stmt = $pdo->prepare($sql);
           $stmt->execute(array(':ts' => $time[0]['CURRENT_TIMESTAMP()'] ,':ip' => $ip_address,':id' => $id,':aid' => $row[0]['unique_id']));
            header( 'Location: home.php' ) ;
            return;
           
        } else {
            $_SESSION["error"] = "Incorrect password.";
            header( 'Location: login.php' ) ;
           return;
          
        }
    }

        
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Login Page</title>
</head>
<style>
.imagebg {
  background-image: url("https://c4.wallpaperflare.com/wallpaper/756/935/826/5bd2e471044fa-wallpaper-preview.jpg");
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
  background-attachment: fixed;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
opacity: 1;
     
}
.head{
text-align: center;
color: yellow;
padding: 64px;
height: 80px;
}
.for{
position: relative;
left: 100px;
top: 100px
color: gold;

}

.email{
width: 25%;
float: left;
position: relative;
left: 480px;
font-size: 20px;
color: yellow;

}
.pas{
width: 25%;
float: left;
position: relative;
left: 540px;
font-size: 20px;
color: yellow;

}
.log{
width: 5%;
float: left;
position: relative;
left: 650px;
}
.cancel{
width: 5%;
float: left;
position: relative;
left: 660px;
}
.foo{
width: 1%;
float: left;
position: relative;
left: 150px;
font-size: 25px;
}

</style>
<body>
  <div class="imagebg">
<div class="head">
<h1>Log In</h1>
</div>

 <div class="foo">
<?php 
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}


if ( isset($_GET['logout']))
    {  if($_GET['logout']=='success')
       { echo("<p>Loggedout Succesfully!!</p>");
           unset($_GET['logout']);
         }
         else
         {
          echo("<p>No User Was Logged In.!!</p>");
           unset($_GET['logout']);
         }
    }
?>
</div>
<div class="for">
<form method="POST">
  <div class="email">
<label for="name">Admin Email ID: </label>
<input type="email" name="admin_id" id="name">
</div><br><br><br>
<div class="pas">
<label for="pass">Password</label>
<input type="password" name="pw" id="pass">
</div><br><br><br><br>
<div class="log">
<input type="submit" value="Log In">
</div>
<div class="cancel">
<input type="submit" name="cancel" value="Cancel">
</div>
</form>
</div>
 
</div>

</body>
</html>