<?php
    $nameErr = $passErr = $emailErr = $usernameErr = "";
    $username = $pass = $cpass = $email = $name = "";

    function encrypt($field) {
        $field = trim($field);
        $field = stripslashes($field);
        $field = htmlspecialchars($field);
        return $field;
    }

    function setfield($field) { // Let $field = test
        if(isset($_POST["$field"]) && !empty($_POST["$field"])) {
            global $$field; // $test (global)
            $$field = encrypt($_POST["$field"]); // $test = its value
        }
        else {
            $field = $field."Err"; // $testErr
            global $$field;
            $$field = "This field cannot be empty."; // $testErr = its value
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        setfield("username");
        setfield("name");
        setfield("pass");
        setfield("cpass");
        setfield("email");

        if ($pass != $cpass) {
            $passErr = "The passwords don't match.";
        }

        if(strchr($username, " ")) {
            $usernameErr = "The username seems to be invalid.";
        }

        if(!preg_match(" /^[a-zA-Z ]*$/ ", $name)) {
            $nameErr = "The name seems to be invalid.";
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "The email seems to be invalid.";
        }

        $proceeding_condition = ($usernameErr == "") && ($nameErr == "") && ($passErr == "") && ($emailErr == "");

        if($proceeding_condition) {
            require_once 'config.php';
            $add = "INSERT INTO `users`(`Username`, `Name`, `Password`, `Email`) VALUES (?,?,?,?)";

            if($stmt = mysqli_prepare($conn, $add)) {
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ssss", $username, $name, $hashed_pass, $email);
                if(!mysqli_stmt_execute($stmt)) {
                    $error_exists = "Oops! Seems like the user already exists.";
                    $proceeding_condition = false;
                }
                else {
                    session_start();
                    $_SESSION["user"] = $username;
                    setcookie("one_time_use", 0);
                    mysqli_close($conn);
                    header("Location: Register_photo.php");
                    exit();
                }
            }   else {
                $error_exists = "Unable to connect to the database. Please try again later.";
                $proceeding_condition = false;
            }
            mysqli_close($conn);
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
            <progress value="50" max="100"></progress>
            <form method="POST" autocomplete="off" class="register" enctype="multipart/form-data">
            <?php
                if (isset($error_exists)) 
                    echo "<span class='errortext'>$error_exists</span>";
            ?>
                <table>
                    <tr>
                        <td><label for="uname">Username: </label></td>
                        <td><input type="text" name="username"required autofocus></td>
                        <td><?php echo $usernameErr; ?></td>
                    </tr>
                    <tr>
                        <td><label for="name">Name:</label></td>
                        <td><input type="text" name="name" required></td>
                        <td><?php echo $nameErr; ?></td>
                    </tr>
                    <tr>
                        <td><label for="upasswd">Password: </label></td>
                        <td><input type="password" name="pass" required></td>
                        <td><?php echo $passErr; ?></td>
                    </tr>
                    <tr>
                        <td><label for="confpasswd">Confirm Password: </label></td>
                        <td><input type="password" name="cpass" required></td>
                    </tr>
                    <tr>
                        <td><label for="uemail">Email: </label></td>
                        <td><input type="email" name="email" required></td>
                        <td><?php $emailErr; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <input type="submit" value="Next" style="margin-right: 50px;">
                            <input type="reset" value="Clear">
                        </td>
                    </tr>
                </table>
                <p><a href="Login.php">Already have an account? Sign In Here.</a></p>
            </form>
        </div>
    </body>
</html>