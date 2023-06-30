<?php
    if(isset($_POST['username'])) {
        $username = $_POST['username'];
    }if(isset($_POST['email'])) {
        $email = $_POST['email'];
    }if(isset($_POST['password'])) {
        $password = $_POST['password'];
    }if(isset($_POST['conpassword'])) {
        $cpassword = $_POST['conpassword'];
    }   
    $usermessage = "";
    $emailmessage = "";
    $passmessage = "";
    //database connection
    $con = mysqli_connect('localhost','root','','usersdb');
    if($con->connect_error) {
        echo "$con->connect_error";
        die('Conneection failed  : '.$con->connect_error);
    } else {
        if (isset($_POST['submit'])) {
            $usermessage = "";
            $emailmessage = "";
            $passmessage = "";
            $flag = true;
            $userstring = mysqli_real_escape_string($con,$_POST['username']);
            $usersql = "select * from users where username = '$userstring'";
            $ur = mysqli_query($con,$usersql);
            $ucount = mysqli_num_rows($ur);
            if ($ucount > 0) {
                $usermessage =  "<p style='color:#ff1818;'>Username is already in use!</p>";
                $flag = false;
            } 
            $ur->close();
            $emailstring = mysqli_real_escape_string($con,$_POST['email']);
            $emailsql = "select * from users where email = '$emailstring'";
            $er = mysqli_query($con,$emailsql);
            $ecount = mysqli_num_rows($er);
            if ($ecount > 0) {
                $emailmessage = "<p style='color:#ff1818;'>Email is already in use!</p>";
                $flag = false;
            }
            if (strpos($emailstring,"@") == false) {
                $emailmessage = "<p style='color:#ff1818;'>Enter a valid Email ID!</p>";
                $flag = false;
            }
            $er->close();
            if ($password != $cpassword) {
                $passmessage = "<p style='color:#ff1818;'>Passwords do not match!</p>";
                $flag = false;
            }
            if (strlen($password) < 10) {
                $passmessage = "<p style='color:#ff1818;'>Password too short! (Min 10 char)</p>";
                $flag = false;
            }
            if ($flag) {
                $stmt = $con->prepare("insert into users (username, email,passcode,cpasscode) values (?,?,?,?)");
                $stmt->bind_param("ssss",$username,$email,$password,$cpassword);
                $stmt->execute();
                $stmt->close();
                $con->close();
                header('Location: slogin.php');
            }
        } 
    }
?>
<?php 
$stdin = fopen("php://stdin","r");

 ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration Page</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="container">
    
    <h1 style="color: #d9e8e8;">Registration Page</h1>
    <br>
    <form action="" method="post" id="registerForm">
      <div class="rinput">
        <input type="text" id="username" name="username" required><br>
        <label>Username</label>
        <span><?php echo $usermessage;?></span>
      </div>
      <div class="rinput">
        <input type="text" id="email" name="email" required><br>
        <label>Email</label>
        <span><?php  echo $emailmessage;?></span>
      </div>
      <div class="rinput">
        <input type="password" id="password" name="password" required><br>
        <label>Password</label>
      </div>
      <div class="rinput">
        <input type="password" id="confirmpassword" name="conpassword" required><br>
        <label>Confirm Password</label>
        <span><?php  echo $passmessage;?></span>
      </div>
      <input type="submit" name="submit" id="submit" value="Register" class="btn">
      <span style="color:#fff;font-size:0.9em;font-weight:300;">Already have an Account?</span>
      <button type="button" onclick="location.href='login.php'" class="btn"><b>Login</b></button>
      <br>
    </form>
  </div>

</body>
</html>
