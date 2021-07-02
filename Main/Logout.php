<?php
    session_start();
    if(!isset($_SESSION["user"])) {
        header("Location: Login.php");
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["Logout"])) {
            unset($_SESSION["user"]);
            header("Location: index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS_Files/theme_register.css">
        <title>Logout</title>
    </head>
    <style>
        button.contrast {
            color: tomato;
            border: 2px solid tomato;
        }
        button.contrast:hover {
            background-color: tomato;
            color: white;
        }
        body {
            background-image: url("../Pictures/Background_Images/b-4.jpg");
        }
    </style>
    <body> 
        <div class="opaque" style="position: fixed; top: 50%; left: 60%; transform: translate(-50%, -50%);">
            <form method="POST" class="register">
                <p style="font-size: x-large;">Dear <?php echo $_SESSION["user"]; ?>, Are you sure you wanna logout?</p>
                <table>
                    <tr>
                        <td><input type="submit" name="Logout" value="Logout"></td>
                        <td><button class="contrast" type="button" onclick="document.location='index.php'">Cancel</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>