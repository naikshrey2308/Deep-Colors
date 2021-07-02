<?php
    include 'check_and_load_user.php';
    if (!isset($_SESSION["user"])) {
        echo "<span style='font-size: x-large;'>Please login first to access this page.</span>";
    ?> <button style="background-color: tomato; color: white; font-size: x-large; padding: 15px 25px; border:none; border-radius: 50px; cursor:pointer;" onclick="document.location='index.php'">Back</button><?php return; } ?>  

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../CSS_Files/theme_index.css">
    <link rel="stylesheet" href="../CSS_Files/theme_confirm_purchase.css">

    <title>Confirm purchase</title>

</head>

<body>

<?php
    include 'bar_div.php';

    $id = $_POST["id"];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image'];
?>

    <div class="confirm_container">

        <img class="image" src="../Pictures/Categories/<?php echo $category . "/" . $image . ".jpg"; ?>">

        <div class="confirm_details">
            <p><?php echo "Product Name - " . $name; ?></p>
            <p><?php echo "Category - " . $category; ?></p>
            <p><?php echo "Price - "; ?><span style="font-size: 26px;">&#8377 </span><?php echo $price . " "; ?></p>
            <br>

            <form  class="form_for_quanitity" action="payment_direct_purchase.php" method="POST">
            <label for="quantity">Quantity :</label>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="number" name="quantity" id="quantity" min="1" max="10" value="1" style="margin-left: 10px;">
            <select style="margin-right: 10px;" name="size">
                <option value="Small" selected>Small</option>
                <option value="Medium">Medium</option>
                <option value="Large">Large</option>
                <option value="X-Large">X-Large</option>
            </select>
            <input class="btn" id="btn-simple" type="submit" name="Buy" value="Buy">
            </form>
        </div>



    </div>


    <div class="read">
    <p style="text-align: center; margin-top:20px;">Read your purchase details properly .</p>
    <p style="text-align: center; margin-top:5px;">Set the quantity and click Buy button to Confirm Your purchase .</p>
    </div>
</body>

</html>