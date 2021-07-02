<?php
    session_start();
    if(!isset($_SESSION["user"])) {
        echo "<span style='font-size: x-large;'>Please login first to access this page.</span>";
        ?> <button style="background-color: tomato; color: white; font-size: x-large; padding: 15px 25px; border:none; border-radius: 50px; cursor:pointer;" onclick="document.location='index.php'">Back</button> <?php
        return;
    }

    if($_SESSION["user"] != "admin") {
        echo "<span style='font-size: x-large;'>The access to this page is strictly prohibited.</span>";
        ?> <button style="background-color: tomato; color: white; font-size: x-large; padding: 15px 25px; border:none; border-radius: 50px; cursor:pointer;" onclick="document.location='index.php'">Back</button> <?php
        return;
    }

$Cloth_id = $_GET['Cloth_id'];
$Name = $_GET['Name'];
$Price = $_GET['Price'];
$Category = $_GET['Category'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View</title>
    <link rel="stylesheet" href="../CSS_Files/theme_cart.css">
    <link rel="stylesheet" href="../CSS_Files/theme_confirm_purchase.css">
    
    <style>
     *{
         font-size: 20px;
     }
     body{
        background-image: url("../Pictures/Background_Images/View.jpg");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
     }
     img{
         width:11rem;
         height: 12.5rem;
     }
     .confirm_container {
        width: 50%;
        min-height: 500px;
        border: 2px solid cornflowerblue;
        border-radius: 5px;
     }
     .confirm_container img {
        width: 60%;
        height: auto;
     }
     .confirm_detail p {
         font-size: x-large;
         width: 100%;
         margin: 15px;
     }
    </style>
</head>

<body>
    <div class="confirm_container">
        <img src="../Pictures/Categories/<?php echo $Category . "/" . $Name . ".jpg"; ?>" alt="image">

        <div class="confirm_detail">
            <p>Name : <?php echo $Name ?></p>
            <p>Price :<span style="font-size: 26px;">&#8377;</span> <?php echo $Price ?></p>
            <p>Category : <?php echo $Category ?></p>
        </div>

        <p style="text-align: center;"><button onclick="document.location='admin.php'" class="btn" id="btn-contrast">&larr; Back to Records</button></p>
    </div>
    <br><br>
</body>

</html>