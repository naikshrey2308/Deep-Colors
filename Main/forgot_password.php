<?php
session_start();
require_once "config.php";

$Err = "";

if(isset($_POST['submit'])) {
    
    $username  = mysqli_real_escape_string($conn , $_POST['username']) ;
    $email = mysqli_real_escape_string($conn , $_POST['useremail']);

    $_SESSION['f_username'] = $username;
    $_SESSION['f_email'] = $email;

    $sql = "SELECT * FROM users WHERE Username = ? AND Email = ?";

    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);

        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) > 0){
                header("Location:forgot_password_otp.php");
                exit(0);
            }
            else {
                $Err = "No such user found.";
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
    <title>forgot password</title>
</head>

<body>
    <div class="opaque">
        <h2 style="text-align: left; font-weight: 500;">Forgot Password</h2><hr style="background-color: grey;">
        <div style="text-align: center; width: 100%;" class="errortext"><?php echo $Err; ?></div>
        <form method="POST" autocomplete="off" class="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> ">
            <table>
                <tr>
                    <td>Username : </td>
                    <td><input type="text" name="username" required autofocus></td>
                </tr>

                <tr>
                    <td>Email : </td>
                    <td><input type="email" name="useremail" required autofocus></td>
                </tr>

                <tr>
                    <td><input type="submit" name="submit" value="Get OTP"></td>
                    <td><input type="reset" value="Clear"></td>
                </tr> 

                  
            </table>

        </form>
        <p style="font-size: x-large; text-align: center;"><a href="index.php" style="text-decoration: none;">Back to Home page</a></p>
    </div>
</body>

</html>