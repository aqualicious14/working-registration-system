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
            <br><br>
            <h3 style="color:#d9e8e8;" >Nothing to do here!...Yet!</h4>
            <br>
            <form action="" method="post" >
                <input type="submit" name="logout" id="logout" class="btn" value="Logout" >
            </form>
        </center>
    </div>
</body>
</html>