<?php
session_start();
$Err = "";
if(isset($_POST['set_password'])) {

    require_once "config.php";

    $username = $_SESSION['f_username'];

    $password = $_POST['user_password'];
    $conf_password = $_POST['conf_user_password'];

    if($password == $conf_password){
        $sql = "UPDATE `users` SET `Password` = ? WHERE Username = ?";

        if($stmt = mysqli_prepare($conn, $sql)) {
            $hased_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ss", $hased_password, $username);

            if(mysqli_stmt_execute($stmt)) {
                mysqli_close($conn);
                $_SESSION["user"] = $username;
                header("Location: index.php?password_changed=success");
                exit();
            } else {
                $Err = "There was some issue regarding updating your password. We'll look into it. Please try again later.";
            }
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
    <link rel="stylesheet" href="../CSS_Files/theme_login.css">
    <title>forgot password OTP</title>
</head>
 
<body>
    <div class="opaque" style="position: fixed; top: 35%; left: 50%; transform: translate(-50%, -50%);">
    <h2 style="text-align: left; font-weight: 500;">Reset Your Password</h2><hr style="background-color: grey;">
    <div class="errortext" style="width: 100%; text-align: center;"><?php echo $Err; ?></div>
        <form method="POST" autocomplete="off" class="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> ">
            <table>
                <tr>
                    <td>New password : </td>
                    <td><input type="password" name="user_password" required autofocus placeholder="Enter a new password"></td>
                </tr>

                <tr>
                    <td>Confirm password : </td>
                    <td><input type="password" name="conf_user_password" required autofocus placeholder="Retype your password"></td>
                </tr>

                <tr>
                    <td><input type="submit" name="set_password" value="Submit"></td>
                    <td><input type="reset" value="Clear"></td>
                </tr>

                  
            </table>

        </form>
        <p style="font-size: x-large; text-align: center;"><a href="index.php" style="text-decoration: none;">Back to Home page</a></p>
    </div>
</body>

</html>