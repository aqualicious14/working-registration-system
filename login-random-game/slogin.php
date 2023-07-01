<?php 
    if(isset($_POST['slusername'])) {
        $slusername = $_POST['slusername'];
    } if (isset($_POST['slpassword'])) {
        $slpassword = $_POST['slpassword'];
    }

    $slusermessage = "";
    $slpasswordmessage = "";
    $successmessage = "<p style='color: #28ff00;font-size: 1.1em;font-weight: 500;'>Successfully Created Account!</p>";
    $con = mysqli_connect('localhost','root','','usersdb');
    if($con->connect_error) {
        echo "$con->connect_error";
    } else {
        if (isset($_POST['slsubmit'])) {
            $slusermessage = "";
            $slpasswordmessage = "";
            $successmessage = "";
            $flag = true;
            $slustring = mysqli_real_escape_string($con,$_POST['slusername']);
            $slusql = "select * from users where username = '$slustring'";
            $sluserresult = mysqli_query($con,$slusql);
            $slucount =  mysqli_num_rows($sluserresult);
            if ($slucount == 0) {
                $slusermessage = "<p style='color:#ff1818;font-size:0.9em;'>Username does not exist!</p>";
                $flag = false;
            }
            $sluserresult->close();
            if ($flag) {
                $slpstring = mysqli_real_escape_string($con,$_POST['slpassword']);
                $slpsql = "select * from users where username = '$slustring' and passcode = '$slpstring'";
                $slpresult = mysqli_query($con,$slpsql);
                $slpcount = mysqli_num_rows($slpresult);
                if ($slpcount == 0) {
                    $slpasswordmessage = "<p style='color:#ff1818;font-size:0.9em;'>Password is incorrect!</p>";
                    $flag = false;
                }
            }
            if ($flag) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $slusername;
                header('Location: home.php');
            }
        }
    }

?>


<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="container">
    <br><br><br>
    <h1 style="color:#d9e8e8;" >Login Page</h1>
    <form  action="" method="post" id="loginForm">
        <div class="rinput">
            <input type="text" id="username" name="slusername" required><br>
            <label>Username</label>
            <span><?php echo $slusermessage; ?></span>
        </div>
        <div class="rinput">
            <input type="password" id="password" name="slpassword" required><br>
            <label>Password</label>
            <?php echo $slpasswordmessage; ?></span>
        </div>
      <input type="submit" id="submit" value="Login" name="slsubmit" class="btn">
      <span style="color:#fff;font-size:0.9em;font-weight:300;">Don't have an Account?</span>
      <button type="button" onclick="location.href='register.php'" class="btn"><b>Make an Account</b></button>
    </form>
    <br><br><br>
    <center>
        <span><?php echo $successmessage; ?></span>
    </center>
  </div>
</body>
</html>
