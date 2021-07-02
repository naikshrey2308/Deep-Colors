<?php
    session_start();

    if(isset($_SESSION["user"])) {
        header("Location: Logout.php");
        exit();
    }
 
    $usernameErr = $passErr = $error_db = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["username"]) && isset($_POST["userpass"])) {
            $username = $_POST["username"];
            $pass = $_POST["userpass"];
        }
        else 
            $usernameErr = "The fields cannot be empty.";

        if($usernameErr == "" && $passErr == "") {
            require_once 'config.php';
            $login = "SELECT * FROM `users` WHERE Username=?";

            if($stmt = mysqli_prepare($conn, $login)) {
                mysqli_stmt_bind_param($stmt, "s", $username);
                if(mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($result)) {
                        if(!password_verify($pass, $row["Password"])) 
                            $passErr = "Incorrect Password. Please try again.";
                        else {
                            mysqli_close($conn);
                            $_SESSION["user"] = $username;
                            if($username == "admin") {
                                header("Location: admin.php");
                                exit();
                            }
                            else {
                                header("Location: index.php");
                                exit();
                            }
                        }
                    } else $usernameErr = "No such user found.";
                } else {
                    $usernameErr = "Error passing information. Please try again.";
                }
            } else {
                $error_db = "Could not connect to the database. Please try again later.";
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
        <link rel="stylesheet" href="../CSS_Files/theme_login.css">
        <title>Login Page</title>
    </head>
    <style>
        body{ background-image: url("../Pictures/Background_Images/b-4.jpg"); }
    </style> 
    <body>
        <div class="opaque" style="position: fixed; top: 30%; left: 60%; transform: translate(-50%, -50%)">
            <h2>Login to our Website</h2>
            <?php
                echo "<span class='errortext'>$error_db</span>"
            ?>
            <form method="POST" autocomplete="off" class="register">
                <table>
                    <tr>
                        <td>Username : </td>
                        <td><input type="text" name="username" required autofocus></td>
                        <td><?php echo $usernameErr; ?></td>
                    </tr>
                    <tr>
                        <td>Password : </td>
                        <td><input type="password" name="userpass" required></td>
                        <td><?php echo $passErr; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Login"><div style="display: inline-block;width: 20%;"></div>
                        <input type="reset" value="Clear"></td>
                    </tr>
                </table>
                <p style="font-size: x-large; text-align: center;"><a href="Register.php" style="text-decoration: none;">Don't have an account? Register Here.</a></p>
                <p style="font-size: x-large; text-align: center;"><a href="forgot_password.php" style="text-decoration: none;">Forgot Password</a></p>
            </form>
        </div>
    </body>
</html>