<?php
    $fileErr = "";
    session_start();
    if(!isset($_SESSION["user"]) || !isset($_COOKIE["one_time_use"])) {
        echo "<span style='font-size: x-large;'>Please fill the basic information.</span>";
        ?> <button style="background-color: tomato; color: white; font-size: x-large; padding: 15px 25px; border:none; border-radius: 50px; cursor:pointer;" onclick="document.location='index.php'">Back</button> <?php
        return;
    } 
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["userpic"])) {
            $name = $_FILES["userpic"]["name"];
            $type = $_FILES["userpic"]["type"];

            if($type == "image/png")
                $type = "png";
            elseif($type == "image/jpeg")
                $type = "jpeg";

            if(!empty($_FILES["userpic"])) {
                if($type == "png" || $type == "jpeg") {
                    $location = "../Pictures/Users/";
                    if(!move_uploaded_file($_FILES["userpic"]["tmp_name"], $location.$_SESSION["user"].".$type"))
                        $fileErr = "Couldn't upload your pic right now. Please try again later.";
                    else {
                        setcookie("one_time_use", 0, time() - 3600);
                        header("Location: index.php");
                        exit();
                    }
                }
                else
                    $fileErr = "Incompatible picture format. (Try using .png or .jpeg)";
            }
        }
        else {
            $fileErr = "Please select a profile picture.";
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
        <title>Register</title>
    </head>
    <body>
        <div class="opaque">
            <h2>Register to our Website</h2>
            <progress value="100" max="100"></progress>
            <p>You're half-way through! You just need to set a profile picture.</p>
            <?php
                echo "<span class='errortext'>$fileErr</span>";
            ?>
            <form method="POST" autocomplete="off" class="register" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Profile Photo:</td>
                        <td><input type="file" name="userpic"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <input type="submit" value="Register" style="margin-right: 50px;">
                            <button class="contrast" type="button" onclick="document.location='index.php'">Skip</button>
                            <input type="reset" value="Clear">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>