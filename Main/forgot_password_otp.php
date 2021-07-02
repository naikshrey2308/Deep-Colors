<?php
    session_start();

    $username = $_SESSION['f_username'];
    $email = $_SESSION['f_email'];

    $Err = "";

    if(!isset($_COOKIE["otp_for_$username"]) || isset($_POST["Resend_OTP"])) {
        $otp = rand(10000, 99999);
        setcookie("otp_for_$username", $otp, time() + 300);
     
    $to = "$email";
    $subject = "OTP for forgot password By Deep Colors";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <colorsdeep0205@gmail.com>' . "\r\n";
    
    // -------------------------    EDITED MAIL     ------------------------------------
    $message = "
    <html>
    <head>
        <style>
            .main {
                border: 5px solid royalblue;
                background-image: url(https://i.pinimg.com/originals/01/51/21/01512156d102cdc037317ae884588dbe.png);
                background-size: 100% 100%;
                background-repeat: no-repeat;
                background-attachment: fixed;
                font-size: medium;
                color: black;
                font-family: Calibri, 'Times New Roman';
                padding: 15px;
            }
            span { font-family: 'Comic Sans MS', Calibri, 'Times New Roman'; color: tomato; }
            p {
                text-align: justify;
                width: 100%;
            }
            mark {
                background-color: yellow;
                font-weight: 600;
            }
            .logo img{
                width: 250px; 
                display: block; 
                margin: auto;
                cursor: pointer;
            }
            div.logo {
                background-color: rgb(53,56,57);
                border-bottom: 4px solid lightgray;
                align-self: flex-start;
            }
            a.contact {
                display: inline-block;
                background-color: tomato;
                padding: 10px;
                margin: 10px;
                color: white;
                cursor: pointer;
                text-decoration: none;
            }
        </style>
    </head>
    <body><div class='main'>
        <h3>Dear <span>$username</span>,</h3><br>
        <p>As per your request to reset the password, you have been given an OTP. The OTP for resetting the password is <mark>$otp</mark>. Type this OTP in the browser window where asked to proceed to new password page.</p>
        <p><strong style='color: tomato;'>NOTE:</strong> This OTP will be valid for only the next 5 minutes.</p>
        <p>If you are still facing any problems then click on the contact button to contact us.<br><a class='contact' href='mailto:colorsdeep0205@gmail.com?cc=naikshrey2308@gmail.com,msmistry07@gmail.com'>CONTACT</a></p><br>
        <p style='font-size: medium; font-style: italic; color: grey;'>&copy; Deep Colors 2021-22</p>
        <br><br><br><br><br>
    </body></div>
    </html>";
    // ----------------------------------------------------------------------------------

    if(!mail($to, $subject, $message, $headers)) {
        $Err = "Some error occured while sending an e-mail. Please try again later.";
    }

    if(isset($_POST["Resend_OTP"]))
        unset($_POST["Resend_OTP"]);
}
    else {
        if (isset($_POST["set"])) {
            if($_POST["user_otp"] === $_COOKIE["otp_for_$username"]){
                setcookie("otp_for_$username", false, time() - 3600);
                header("Location: set_new_password.php");
                exit();
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
    <link rel="stylesheet" href="../CSS_Files/theme_register.css">
    <title>Forgot Password OTP</title>
</head>

<body>
    <div class="opaque" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <h2 style="text-align: left; font-weight: 500;">OTP</h2><hr style="background-color: darkgrey;">
        <form method="POST" autocomplete="off" class="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> ">
            <table>
                <tr>
                    <td>OTP : </td>
                    <td><input type="number" name="user_otp" autofocus placeholder="Enter your OTP"></td>
                    <td><span style="text-align: center;" class="errortext"><?php echo $Err; ?></span></td>
                </tr>

                <tr>
                    <td><input type="submit" name="set" value="Submit"></td>
                    <td style="text-align: center;"><button class="contrast" name="Resend_OTP">Resend OTP</button></td>
                    <td><input type="reset" value="Clear"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center;"><a href="index.php" style="text-decoration: none;">Back to Home page</a></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>