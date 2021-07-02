<?php
include 'check_and_load_user.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>index</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS_Files/theme_home.css">
</head>

<body>
    <?php include 'bar_div.php'; ?>

    <div class="container">
        <!-- <img src="../Pictures/Background_Images/b-3.jpg"style="width:100%;"> -->
        <div class="welcome">Welcome to New 2021 Monsoon Collection</div>
        <div class="slogan"> Choose You, Choose Your Style</div>
        <div class="wardrobe">A great wardrobe starts with your perfect fit. Our Stylists discover clothing for you, hand-selected for your size and style.
        <button class="read_more_btn" id="read_more_btn" onclick="document.location='About.php'">Read More &rarr;</button>
        </div>
    </div>

    <div class="card_container">
        <div>
            <h3>What's There For You?</h3><br>
            <img src="../Pictures/Icons/Clothes.jpg">
            <p>Monsoon Season is here. With the rain outside, it brings the rain inside our brand too. Rain of quality, brilliant designs best-suited for all. Exclusive offers on designs and the quality which is hard to expect elsewhere. All of them at a reasonably cheap price. What are you waiting for?</p><br>
            <p style="text-align: center;"><button onclick="document.location='Categories.php'" class="btn" id="btn-contrast">Shop Now &rarr;</button></p>
        </div>
        <div>
            <h3>Create an Account</h3><br>
            <img src="../Pictures/Icons/Signup.jpg">
            <p><br>Don't miss out on anything. From regular updates to latest fashion deals, we'll provide you all the important information once we have your contact details. From purchase to updates, all with the click of a button through a single account. Sign up for free now!</p><br>
            <?php if(!isset($_SESSION["user"])) { ?>
            <p style="text-align: center;"><button onclick="document.location='Register.php'" class="btn" id="btn-contrast">Sign Up &rarr;</button></p>
            <?php } ?>
        </div>
        <div>
            <h3>Your Ideas Matter</h3><br>
            <img src="../Pictures/Icons/Thoughts.jpg">
            <p>How do we improve and keep ourselves updated? It wouldn't be possible without the wonderful customers we have. Request the latest trends and help us to improve by giving us your reviews about us. Remember, you bring out the best in us.</p><br>
            <p style="text-align: center;"><button onclick="document.location='Feedback.php'" class="btn" id="btn-contrast">Give Feedback &rarr;</button></p>
        </div>
        <div style="background-image: linear-gradient(cornflowerblue, tomato); animation: flip 2s ease-in-out 5s 1;">  
            <img src="../Pictures/Icons/Stamp.png" style="margin-top: 40%; width: 80%; margin-left: 10%; margin-right: 10%;">
        </div>
    </div>
    <br>
    <div class="footer">
        <h3 style="text-align: center; color: gray;">&copy; Deep Colors 2021-22</h3>
    </div>
    <br>
</body>
</html>