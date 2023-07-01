<?php 
    if(isset($_POST['lusername'])) {
        $lusername = $_POST['lusername'];
    } if (isset($_POST['lpassword'])) {
        $lpassword = $_POST['lpassword'];
    }

    $lusermessage = "";
    $lpasswordmessage = "";
    $con = mysqli_connect('localhost','root','','usersdb');
    if($con->connect_error) {
        echo "$con->connect_error";
    } else {
        if (isset($_POST['lsubmit'])) {
            $lusermessage = "";
            $lpasswordmessage = "";
            $flag = true;
            $lustring = mysqli_real_escape_string($con,$_POST['lusername']);
            $lusql = "select * from users where username = '$lustring'";
            $luserresult = mysqli_query($con,$lusql);
            $lucount =  mysqli_num_rows($luserresult);
            if ($lucount == 0) {
                $lusermessage = "<p style='color:#ff1818;font-size:0.9em;'>Username does not exist!</p>";
                $flag = false;
            }
            $luserresult->close();
            if ($flag) {
                $lpstring = mysqli_real_escape_string($con,$_POST['lpassword']);
                $lpsql = "select * from users where username = '$lustring' and passcode = '$lpstring'";
                $lpresult = mysqli_query($con,$lpsql);
                $lpcheck = mysqli_num_rows($lpresult);
                if ($lpcheck == 0) {
                    $lpasswordmessage = "<p style='color:#ff1818;font-size:0.9em;'>Password is incorrect!</p>";
                    $flag = false;
                }
            }
            if ($flag) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $lusername;
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
    <form action="" method="post" id="loginForm">
        <div class="rinput">
            <input type="text" id="lusername" name="lusername" required><br>
            <label>Username</label>
            <span><?php echo $lusermessage ?></span>
        </div>
        <div class="rinput">
            <input type="password" id="lpassword" name="lpassword" required><br>
            <label>Password</label>
            <span><?php echo $lpasswordmessage ?></span>
        </div>
      <input type="submit" name="lsubmit" id="submit" value="Login" class="btn">
      <span style="color:#fff;font-size:0.9em;font-weight:300;">Don't have an Account?</span>
      <button type="button" onclick="location.href='register.php'" class="btn"><b>Make an Account</b></button>
    </form>
  </div>
</body>
</html>
