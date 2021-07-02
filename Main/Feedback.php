<?php
    include 'check_and_load_user.php';
    $mail_sent = "";

    if(!isset($_SESSION["user"])) {
        echo "<span style='font-size: x-large;'>Please login first to access this page.</span>";
        ?> <button style="background-color: tomato; color: white; font-size: x-large; padding: 15px 25px; border:none; border-radius: 50px; cursor:pointer;" onclick="document.location='index.php'">Back</button> <?php
        return;
    }

    if(isset($_GET["sent"]) && $_GET["sent"] == "true") {
        $mail_sent = "Your feedback has been recieved. Thanks for it!";
    }

    $error = "";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(empty($_POST["feedback"])) {
            $error = "Feedback cannot be empty.";
        }
        else {
            $email = $_POST["feedback"];
            mail("colorsdeep0205@gmail.com", "Feedback from ". $_SESSION["user"], $email);
            header("Location: Feedback.php?sent=true");
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
        <link rel="stylesheet" href="../CSS_Files/theme_index.css">
        <title>Feedback Form</title>
    </head>
    <body>
        <?php include 'bar_div.php'; ?>

        <link rel="stylesheet" href="../CSS_Files/theme_register.css">
        <style>
            input[type=submit] {
                background-image: url("../Pictures/Icons/Send.png");
            }
            body {
                background-image: url("../Pictures/Background_Images/b-4.jpg");
            }
        </style>
        <br><div class="opaque" style="margin-left: 40%; width: 55%; border-radius: 5px; margin-top: 0px;">
            <h2><img src="../Pictures/Icons/Stamp.png" style="width: 50px; vertical-align: middle;"><div style="display: inline-block; width: 50%;"></div>Your Feedback</h2><br><hr style="background-color: grey;">
            <p class="errortext"><?php echo $error; ?></p>
            <p class="successtext"><?php echo "<br>".$mail_sent; ?></p>
            <p style="font-size: large; text-align: left; color: grey;">Your Feedback matters for us. At Deep Colors, we would definitely encourage any feedback and suggestions from your side which would you in turn help to improve our services.</p><br><hr style="background-color: grey;">
            <form class="register" method="POST" enctype="multipart/form-data">
                <table style="width: 100%;">
                    <tr>
                        <td>Please provide your feedback below.<br></td>
                    </tr>  
                    <tr>
                        <td colspan="2"><textarea name="feedback" style="border-radius: 5px;" autofocus></textarea></td>
                    </tr>
                    <tr>
                        <td style="color: grey; font-style: italic; font-size: large;">&copy; Deep Colors 2021-22</td>
                        <td style="text-align: right;"><input type="submit" style="padding: 5px 40px;" value="Send Feedback"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>