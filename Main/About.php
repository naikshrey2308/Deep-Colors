<?php
    include 'check_and_load_user.php';
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS_Files/theme_index.css">
        <title>About Us</title>
    </head>    
    <body>
        <?php include 'bar_div.php'; ?>

        <div class="content">
            <link rel="stylesheet" href="../CSS_Files/theme_login.css">    
            <style>
                body {
                    background-image: url("../Pictures/Background_Images/hanger_pic.jpeg");
                }

                .opaque > div > h2 {
                    font-weight: 500;
                    color: darkblue;
                }

                .opaque > div {
                    margin-bottom: 10px;
                    background-color: rgb(255, 255, 255, 0.75);
                    padding: 25px;
                    box-shadow: 2px 2px 2px lightgrey;
                }

                #opaque_2 {
                    display: flex;
                    flex-wrap: nowrap;
                    flex-direction: row;
                    background-color: transparent;
                    padding: 0px;
                    box-shadow: none;
                }

                #opaque_2 > table {
                    width: 33.33%;
                    margin: 5px;
                    background-color: rgb(255, 255, 255, 0.75);
                    box-sizing: border-box;
                    box-shadow: 2px 2px 2px lightgrey;
                }

                #opaque_2 > table  a {
                    color: royalblue;
                    text-decoration: none;
                }
                
                #headings {
                    background-color: rgba(180, 180, 180, 0.75);
                }

            </style> 
            <div class="opaque" style="width: 100%; margin-top: 10px; border-radius: 5px; background-color: transparent;">
            <div id="opaque_1">
                <h2>About Deep Colors</h2>
                <br><p>Deep Colors makes it easier for you to shop your favorite clothes online at home with just a click of a button hence making your task a lot more simpler. You can find hundreds of items to choose from designed by brilliant designers and its all for you! What are you waiting for? Join us now by registering if you have not. We would highly appreciate any suggestions from you regarding our website. If you have any doubts ask us directly via these contacts.</p>
            </div>
            <div id="opaque_2">
                <br><table id="phone">
                    <tr>
                        <td id="headings"><img src="../Pictures/Icons/Phone.png" width="40px" style="vertical-align: middle;">&Tab;Phone</td>
                    </tr>
                    <tr>
                        <td><b>Shrey Naik</b> : +91 79840 22120</td>
                    </tr>
                    <tr>
                        <td><b>Manav Mistry</b> : +91 91731 99146</td>
                    </tr>
                </table>
                <br><table id="phone">
                    <tr>
                        <td id="headings"><img src="../Pictures/Icons/Gmail.png" width="40px" style="vertical-align: middle;">&Tab;Gmail</td>
                    </tr>
                    <tr>
                        <td><a href="mailto:naikshrey2308@gmail.com" target="_blank"><strong>Shrey Naik</strong> : naikshrey2308@gmail.com </a></td>
                    </tr>
                    <tr>
                        <td><a href="mailto:msmistry07@gmail.com" target="_blank"><strong>Manav Mistry</strong> : msmistry07@gmail.com </a></td>
                    </tr>
                </table>
                <br><table id="phone">
                    <tr>
                        <td id="headings"><img src="../Pictures/Icons/Linkedin.png" width="40px" style="vertical-align: middle;">&Tab;Linkedin</td>
                    </tr>
                    <tr>
                        <td><a href="https://in.linkedin.com/in/shrey-naik-52b395202" target="_blank">Shrey Naik</a></td>
                    </tr>
                    <tr>
                        <td><a href="https://www.linkedin.com/in/manav-mistry-91603a213" target="_blank">Manav Mistry</a></td>
                    </tr>
                </table>
            </div>
            <div>
                <h2>Feedback</h2>
                <br><p style="text-align: center;">Any issues or suggestions? You can also reach out to us via the <a href="Feedback.php">Feedback Form</a>.</p>
            </div>
            <div>
                <p style="text-align: center; font-weight: 800;">&copy; Deep Colors 2021-22</p>
            </div>
        </div>
    </body>
</html>