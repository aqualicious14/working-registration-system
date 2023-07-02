<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: login.php');
        exit();
    }
    if (isset($_POST['logout'])) {
        session_start();
        session_destroy();
        header('Location: login.php');
        exit();
    }
    if (isset($_POST['guess'])) {
        $guess = intval($_POST['guess']);
    }
    $fusername = $_SESSION['username'];
    $levelmessage = "";
    $xpmessage = "";
    $correctmessage = "";
    $con = mysqli_connect('localhost','root','','usersdb');
    if($con->connect_error) {
        echo "$con->connect_error";
        die('Conneection failed  : '.$con->connect_error);
    } else {
        $levelmessage = "";
        $xpmessage = "";
        $correctmessage = "";
        $levelsql = "select level from users where username='$fusername'";
        $xpsql = "select xp from users where username='$fusername'";
        $levelresult = mysqli_query($con,$levelsql);
        $levelrow = $levelresult->fetch_assoc();
        $level = (int) $levelrow['level'];
        $levelresult->close();
        $xpresult = mysqli_query($con,$xpsql);
        $xprow = $xpresult->fetch_assoc();
        $xp = (int) $xprow['xp'];
        $xpresult->close();
        $levelmessage = "<p style='color:#fff;font-size: 1.1em;font-weight: 500;' >Level: $level</p>";
        $xpmessage = "<p style='color:#fff;font-size: 1.1em;font-weight: 500;'    >XP:    $xp/10</p>";
        if (isset($_POST['gsubmit'])) {
            if ($guess == rand(1,10)) {
                $correctmessage = "<p style='color:#28ff00;font-size: 1.1em;font-weight: 500;'>That is Correct! You gained XP!</p>";
                $xp = $xp + 1;
                if ($xp == 10) {
                    $xp = 0;
                    $level = $level + 1;
                }
                //input int mysql new values of level and xp
                $updatesql = "update users set level = '$level',xp = '$xp' where username='$fusername'";
                $updateresult = mysqli_query($con,$updatesql);
            } else {
                $correctmessage = "<p style='color:#ff1818;font-size: 1.1em;font-weight: 500;'>That is Incorrect! Try again!</p>";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container" >
        <br><br>
        <center>
            <h1 style="color:#d9e8e8;">Home Page</h2>
            <span class="levelmessage" ><?php echo $levelmessage; ?></span>
            <span class="xpmessage" ><?php echo $xpmessage; ?></span>
            <br><br>
            <h3 style="color:#fff;" >Welcome to the guessing game!</h3>
            <h3 style="color:#fff;" >Guess the number between 1 and 10!</h3>
            <br>
            <form action="" method="post" >
                <div class="rinput">
                    <input type="text" id="guess" name="guess"><br>
                    <label>Guess</label>
                </div>
                <span><?php echo $correctmessage ?></span>
                <br>
                <input type="submit" name="gsubmit" id="submit" class="btn" value="Submit" >
                <br><br>
                <input type="submit" name="reset" id="reset" class="btn" value="Refresh" >
                <br><br>
                <input type="submit" name="logout" id="logout" class="btn" value="Logout" >
            </form>
        </center>
    </div>
</body>
</html>
