<?php
    include 'check_and_load_user.php';
    if (!isset($_SESSION["user"])) {
        echo "<span style='font-size: x-large;'>Please login first to access this page.</span>";
        ?> <button style="background-color: tomato; color: white; font-size: x-large; padding: 15px 25px; border:none; border-radius: 50px; cursor:pointer;" onclick="document.location='index.php'">Back</button> <?php
        return;
    }
?>

<link rel="stylesheet" href="../CSS_Files/theme_register.css">

<?php 
    $nameErr = $passErr = $picErr = $new_usernameErr = "";
    $username = $_SESSION["user"];
    require_once 'config.php';

    if(empty($_POST["user_name"]))
        $nameErr = "Name cannot be empty.";
    elseif(empty($_POST["user_password"]))
        $passErr = "Password cannot be empty.";

if (!empty($_POST["user_name"]) && !empty($_POST["user_password"]) && isset($_POST["user_email"])) {
    if (!preg_match(" /^[a-zA-Z ]*$/ ", $_POST["user_name"]))
        $nameErr = "Invalid characters in the name";
    else
        $nameErr = "";

    if(empty($_POST["username"]))
        $new_usernameErr = "Username cannot be empty.";
    else
        $new_username = $_POST["username"];

    if ($_FILES["user_pic"]["size"] != 0) {
        if ($_FILES["user_pic"]["type"] == "image/png" || $_FILES["user_pic"]["type"] == "image/jpeg") {
            $save_at_location = "../Pictures/Users/";
            $user_pic_type = $_FILES["user_pic"]["type"];
            if($user_pic_type == "image/png")
                $type = ".png";
            elseif ($user_pic_type == "image/jpeg")
                $type = ".jpeg";
            
            if (!move_uploaded_file($_FILES["user_pic"]["tmp_name"], $save_at_location.$username.$type)) {
                $picErr = "Error uploading pic.";
            } else {
                $image = $username.$type;
            }
        } else $picErr = "Image should be of type PNG or JPEG only.";
    }

    if ($nameErr == "" && $new_usernameErr == "") {
        $update = "UPDATE users SET Name=?, Password=?, Email=?, Username=? WHERE Username=?";
        if ($stmt = mysqli_prepare($conn, $update)) {
            $password = password_hash($_POST["user_password"], PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sssss", $name, $password, $email, $new_username, $username);
            $name = $_POST["user_name"];
            $email = $_POST["user_email"];

            if(mysqli_stmt_execute($stmt)) {
                if(fopen("../Pictures/Users/$image", "r")) {
                    if(strstr($image, ".png"))
                        $type = ".png";
                    else $type = ".jpeg";
                    rename("../Pictures/Users/$image", "../Pictures/Users/".$new_username.$type);
                }
 // ---------------------------***** Also update the new username in Cart Database *****----------------------------

                $update_username = "UPDATE `cart` SET `Username`= ? WHERE `Username`= ? ";

                if($stmt = mysqli_prepare($conn,$update_username)) {
                    mysqli_stmt_bind_param($stmt , "ss" , $new_username , $username);
                    mysqli_stmt_execute($stmt);
                }

                $_SESSION["user"] = $new_username;
                $username = $new_username;
                //echo "<br>Values have been updated.";
            }
            else {
                echo "<br>Failed to update values.";
            }
        }
        else {
            echo "<br>Unable to update the data. Please try again later.";
        }
    }
}

    $info = "SELECT * FROM users WHERE Username=?";
    if ($stmt = mysqli_prepare($conn, $info)) {
        mysqli_stmt_bind_param($stmt, "s", $username);

        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            $username = $row["Username"];
            $name = $row["Name"];
            $password = $row["Password"];
            $email = $row["Email"];
        }
        else {
            echo "<br>Error connecting to database servers. Please try again later.";
        }
    }
    mysqli_close($conn);
?>
<div class="opaque">
<h2>Update your Profile</h2>
<form method="POST" action="profile.php" enctype="multipart/form-data" class="register">
    <table>
        <tr>
            <td>Name : </td>
            <td><input type="text" value="<?php echo $name; ?>" name="user_name"></td>
            <td rowspan="4"><center><img src="../Pictures/Users/<?php echo $image; ?>" alt="Profile Photo" height="100" width="100" style="border-radius: 50%;"></center></td>
        </tr>
        <tr>
            <td>Username : </td>
            <td><input type="text" value="<?php echo $username; ?>" name="username"></td>
        </tr>
        <tr>
            <td>Password : </td>
            <td><input type="text" name="user_password"></td>
        </tr>
        <tr>
            <td>Email : </td>
            <td><input type="email" value="<?php echo $email; ?>" name="user_email"></td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Update" name="update">
                <input type="reset" value="Delete Account" onclick="document.location='delete.php'">
            </td>
            <td>
                <button class="contrast" type="button" onclick="document.location='index.php'">Back</button>
            </td>
            <td>
                <input type="file" name="user_pic">
            </td>
        </tr>
        <tr>
            <?php if(isset($_POST["update"]) && ($nameErr != "" || $passErr != "" || $picErr != "" || $new_usernameErr != "")) { ?>
            <td><span class="errortext"><?php echo $nameErr; echo "<br>".$passErr; echo "<br>".$picErr; echo "<br>".$new_usernameErr; ?></span></td>
            <?php } elseif(isset($_POST["update"]) && ($nameErr == "" && $passErr == "" && $picErr == "" && $new_usernameErr == "")) { ?> 
            <td><span class="successtext">Your account has been updated successfully.</span></td>
            <?php } ?>
        
        </tr>
    </table>
</form>
</div>