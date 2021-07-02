<?php
    include 'check_and_load_user.php';
    require_once 'config.php';
    if (!isset($_SESSION["user"])) {
        echo "<span style='font-size: x-large;'>Please login first to access this page.</span>";
    ?> <button style="background-color: tomato; color: white; font-size: x-large; padding: 15px 25px; border:none; border-radius: 50px; cursor:pointer;" onclick="document.location='index.php'">Back</button><?php return; }
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../CSS_Files/theme_index.css">
    <link rel="stylesheet" href="../CSS_Files/theme_cart.css">

</head>
<style>
	input[type=number]{
    width: 5rem;
    border-radius: 10px;
    border-style: inset;
    outline: none;
    background-color: rgb(240, 240, 240);
    border-color: cornflowerblue;
    text-align: center;
    margin-right: 1rem;
	}
</style>
<body>
<?php
    include 'bar_div.php'; 
    if(isset($_GET['delete'])) {
        if($_GET['delete'] == "success")
            echo "<p style='font-size: x-large; background-color:green;color:white;'>One item has been deleted from the cart.</p>";
        else if($_GET['delete'] == "error") 
            echo "<p style='font-size: x-large;background-color:red;color:white;'>There is some error in delete the cart item</p>";
        
    }
?>
<!-- ------------------------------Function Definition-------------------------- -->

<?php    
            function display($image, $category, $name, $price , $cloth_id, $quantity) {
        ?>

    <div class="cloth_container">
        <img src="../Pictures/Categories/<?php echo $category . "/" . $image . ".jpg"; ?>" width="250px" height="300px" style="border-radius: 15px;">

        <div class="cloth_details">
            <p><?php echo "Cloth Name - " . $name; ?></p>
            <p><?php echo "Category - " . $category; ?></p>
            <p><?php echo "Price - "; ?><span style="font-size: 26px;">&#8377;</span><?php echo $price . " "; ?></p>
            <p><?php $username = $_SESSION["user"]; if(isset($_SESSION[$username."set".$cloth_id]) && isset($_SESSION[$username."_sizes_set".$cloth_id])) echo "<span style='color: green; font-weight: 800;'>Quantity has been set.</span>"; else echo "<span style='color: red; font-weight: 800;'>Quantity not set.</span>"; ?></p>

            <form method="POST">
            <p>Quantity - <input type="number" min=0 value="<?php
                if(isset($_SESSION["$username"][$cloth_id]))
                    echo $_SESSION["$username"][$cloth_id];
                else echo 0;
            ?>" name="quan_<?php echo $cloth_id; ?>" max="<?php echo $quantity; ?>">
            Size - <select name="size_<?php echo $cloth_id; ?>" style="margin-right: 25px;">
                <option value="Small" <?php if(isset($_POST["size_$cloth_id"]) && $_POST["size_$cloth_id"] == "Small") echo "selected"; ?>>Small</option>
                <option value="Medium" <?php if(isset($_POST["size_$cloth_id"]) && $_POST["size_$cloth_id"] == "Medium") echo "selected"; ?>>Medium</option>
                <option value="Large" <?php if(isset($_POST["size_$cloth_id"]) && $_POST["size_$cloth_id"] == "Large") echo "selected"; ?>>Large</option>
                <option value="X-Large" <?php if(isset($_POST["size_$cloth_id"]) && $_POST["size_$cloth_id"] == "X-Large") echo "selected"; ?>>X-Large</option>
            </select>
            <input type="submit" value="Set" class="btn" style="border: 2px solid cornflowerblue; color: cornflowerblue; font-size: x-large; padding: 5px 25px;"></p>
            </form>
            <div class="forms">
                <div class="form1" >
                    <form method="POST" class="submit_buttons" action="confirm_purchase.php">
                        <input type='hidden' name='id' value="<?php echo $cloth_id ?>">
                        <input type='hidden' name='name' value="<?php echo $name ?>">
                        <input type='hidden' name='price' value="<?php echo $price ?>">
                        <input type='hidden' name='category' value="<?php echo $category ?>">
                        <input type='hidden' name='image' value="<?php echo $image ?>">

                        <button type="submit" class="btn" id="btn-contrast" name="buy_now">Buy Now</button>
                    </form>
                </div>

                <div class="form2">
                    <form method="POST" class="submit_buttons" action="delete_cart_items.php">
                        <input type='hidden' name='username' value="<?php echo $_SESSION['user'] ?>">
                        <input type='hidden' name='cloth_id' value="<?php echo $cloth_id ?>">
                        <button type="submit" class="btn" id="btn-simple">Delete From Cart</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
<?php } ?>


<?php
    static $total;
    $total = 0;
    $username = $_SESSION["user"];

    $sql = "SELECT `Items in cart` FROM cart WHERE `Username` = ?";

    if($stmt = mysqli_prepare($conn , $sql)){
        mysqli_stmt_bind_param($stmt , "s" , $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result) > 0) {
            $items_in_cart =  $row['Items in cart'];
//------------------------ fetch items to be display in add to cart -----------------------

            $sql1 = "SELECT * FROM clothes WHERE Cloth_id IN( $items_in_cart) ";

            if($result1 = mysqli_query($conn , $sql1)) {

                if(mysqli_num_rows($result) > 0)
                while($row  = mysqli_fetch_assoc($result1)) {
                    if(!empty($_POST["quan_".$row["Cloth_id"]])) {
                        if($_POST["quan_".$row["Cloth_id"]] <= $row["Quantity"] && preg_match(" /^[0-9]+$/", $_POST["quan_".$row["Cloth_id"]])) {
                            $_SESSION["$username"][$row["Cloth_id"]] = $_POST["quan_".$row["Cloth_id"]];
                            $_SESSION[$username."set".$row["Cloth_id"]] = "True";
                        }
                        $_SESSION["$username"."_sizes"][$row["Cloth_id"]] = $_POST["size_".$row["Cloth_id"]];
                        $_SESSION[$username."_sizes_set".$row["Cloth_id"]] = "True";
                    }
                    // -------------- function Call ---------------
                    display($row["Name"], $row["Category"], $row["Name"], $row["Price"] , $row['Cloth_id'], $row["Quantity"]);

                } else {
                    echo "There are no items in your cart";
                }
            } else {
                echo "There are no items in your cart";
            }

        } else {
            ?><center><img src="../Pictures/Background_Images/Cart_Empty.jpg"></center><?php      
        }
    } else {
        echo "error";
    }
    
	if(isset($_SESSION["$username"])) {
		foreach($_SESSION["$username"] as $key => $item) {
			$get_price = "SELECT Price FROM clothes WHERE Cloth_id=?";
			if($stmt = mysqli_prepare($conn, $get_price)) {
				mysqli_stmt_bind_param($stmt, "i", $key);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				$row = mysqli_fetch_assoc($result);
				$total += $row["Price"] * $item;
			}
		}
	}

    mysqli_close($conn); 
?>

<?php if (isset($_SESSION["$username"])) { ?>
<div style="text-align: center;">
<form method="POST" action="payment.php"
    Total Amount = <span style="font-size: 26px;">&#8377;</span><input style="text-align: center;" type="number" value="<?php echo $total; ?>" disabled>
    <button class="btn" style="background-color: <?php if($total != 0) echo "cornflowerblue"; else echo "grey"; ?>;" <?php if($total == 0) echo "disabled"; ?>>Proceed to Payment</button>
</form>
</div>
<?php } ?>

</body>
</html>