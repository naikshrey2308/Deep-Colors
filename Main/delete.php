<?php
    session_start();
    if(!isset($_SESSION["user"])) {
        echo "<span style='font-size: x-large;'>Please login first to access this page.</span>";
        ?> <button style="background-color: tomato; color: white; font-size: x-large; padding: 15px 25px; border:none; border-radius: 50px; cursor:pointer;" onclick="document.location='index.php'">Back</button> <?php
        return;
    }

    $err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once 'config.php';
        $delete = "DELETE FROM `users` WHERE Username=?";
        if($stmt = mysqli_prepare($conn, $delete)) {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION["user"]);
            if(!mysqli_stmt_execute($stmt)) {
                $err = "Error connecting to the database.";
            }
        } else $err = "Error connecting to the servers.";

        $delete_cart = "DELETE FROM `cart` WHERE Username=?";
        if($stmt=mysqli_prepare($conn, $delete_cart)) {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION["user"]);
            if(!mysqli_stmt_execute($stmt)) {
                $err = "Error connecting to the cart.";
            }
        } else $err = "Error connecting to the servers.";

        if($err == ""){
            if(@fopen("../Pictures/Users/".$_SESSION["user"].".png", "r")) {
                unlink("../Pictures/Users/".$_SESSION["user"].".png");
            } 
            elseif(@fopen("../Pictures/Users/".$_SESSION["user"].".jpeg", "r")) {
                unlink("../Pictures/Users/".$_SESSION["user"].".jpeg");
            }
        }
         
        mysqli_close($conn);

        if($err == "") {
            unset($_SESSION["user"]);
            header("Location: index.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS_Files/theme_login.css">
        <title>Delete Account</title>
    </head>
    <body style="font-size: x-large;">
        <div class="opaque">
            <?php echo "<span class='errortext'>$err</span>"; ?><br>
            <p>Dear <?php echo $_SESSION["user"]; ?>, are you sure you wanna delete your account?</p>
            <form class="register" method="POST">
                <input type="submit" value="Delete">
                <input type="reset" value="Back" onclick="document.location='profile.php'">
            </form>
        </div>
    </body>
</html>