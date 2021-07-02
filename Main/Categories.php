<?php
    include 'check_and_load_user.php';
    function display($image, $category, $name, $price, $id): void {
?>
    <div class="cloth_container">
        <img src="../Pictures/Categories/<?php echo $category . "/" . $image . ".jpg"; ?>" width="250px" height="300px" style="border-radius: 15px;">

        <div class="cloth_details">
            <p><?php echo "Cloth Name - " . $name; ?></p>
            <p><?php echo "Category - " . $category; ?></p>
            <p><?php echo "Price - "; ?><span style="font-size: 26px;">&#8377;</span><?php echo $price . " "; ?></p>

            <div class="forms">
                <div class="form1" >
                    <form method="POST" class="submit_buttons" action="confirm_purchase.php">
                        <input type='hidden' name='id' value="<?php echo $id ?>">
                        <input type='hidden' name='name' value="<?php echo $name ?>">
                        <input type='hidden' name='price' value="<?php echo $price ?>">
                        <input type='hidden' name='category' value="<?php echo $category ?>">
                        <input type='hidden' name='image' value="<?php echo $image ?>">

                        <button type="submit" class="btn" id="btn-contrast" name="buy_now">Buy Now</button>
                    </form>
                </div>

                <div class="form2">
                    <form method="POST" class="submit_buttons" action="add_to_cart.php">
                        <input type='hidden' name='name' value="<?php echo $name ?>">
                        <input type='hidden' name='price' value="<?php echo $price ?>">
                        <input type='hidden' name='category' value="<?php echo $category ?>">
                        <input type='hidden' name='image' value="<?php echo $image ?>">
                        <button type="submit" class="btn" id="btn-simple">Add to cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS_Files/theme_categories.css">
        <title>Categories</title>
    </head> 
    <body>
        <?php include 'bar_div.php'; ?>
        <details class="filter_details" open>
            <summary>Filters</summary>
            <div class="filter" style="width: 100%;">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"> 
                    <table>
                        <tr>
                            <td><input type="checkbox" name="category[]" value="Men" id="Men"><label for="Men">Men</label></td>
                            <td><input type="checkbox" name="category[]" value="Women" id="Women"><label for="Women">Women</label></td>
                            <td><input type="checkbox" name="category[]" value="Kids" id="Kids"><label for="Kids">Kids</label></td>
                            <td><input type="checkbox" name="category[]" value="Masks" id="Masks"><label for="Masks">Masks</label></td>
                            <td><input type="number" name="min_price" placeholder="Min Price"></td>
                            <td><input type="number" name="max_price" placeholder="Max Price"></td>
                            <td><input type="submit" value="Filter"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </details>
        <?php if(isset($_COOKIE["Error"])) { echo "<span class='errortext'>".$_COOKIE["Error"]."</span>"; setcookie("Error", "0", time()-3600); } ?>
        <?php
            require_once 'config.php';
            $category = array("Men", "Women", "Kids", "Masks");
            if(isset($_POST["category"])) {
                $category = $_POST["category"];
            }
            
            $cloth_data = "SELECT * FROM `clothes` WHERE Category IN (";
            foreach($category as $item)
                $cloth_data .= "'$item',";
            $cloth_data = substr_replace($cloth_data, "", -1);
            $cloth_data .= ")";

            if(isset($_POST["min_price"]) && !empty($_POST["min_price"])) {
                $min_price = $_POST["min_price"];
                $cloth_data .= " AND Price >= $min_price";
                unset($_POST["min_price"]);
            }
            if(isset($_POST["max_price"]) && !empty($_POST["max_price"])) {
                $max_price = $_POST["max_price"];
                $cloth_data .= " AND Price <= $max_price";
                unset($_POST["max_price"]);
            }

            if($result = mysqli_query($conn, $cloth_data)) {
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        display($row["Name"], $row["Category"], $row["Name"], $row["Price"], $row["Cloth_id"]);
                    }
                }
            }
        ?>
    </body>
</html>