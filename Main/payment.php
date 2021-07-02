<?php
    include 'check_and_load_user.php';
    if (!isset($_SESSION["user"])) {
        echo "<span style='font-size: x-large;'>Please login first to access this page.</span>";
    ?> <button style="background-color: tomato; color: white; font-size: x-large; padding: 15px 25px; border:none; border-radius: 50px; cursor:pointer;" onclick="document.location='index.php'">Back</button><?php return; }  

    $username = $_SESSION["user"];

    if(isset($_POST["Home"])) {
        $cond = false;
        require_once 'config.php';
        $delete_all = "DELETE FROM `cart` WHERE Username='$username'";
        if(mysqli_query($conn, $delete_all)) {
            unset($_SESSION["$username"]);
            unset($_SESSION["$username"."_sizes"]);
            header("Location: Cart.php");
            exit();
       }
    }

    if(!isset($_SESSION["$username"])) {
        echo "<span style='font-size: x-large;'>Please fill the cart first to access this page.</span>";
    ?> <button style="background-color: tomato; color: white; font-size: x-large; padding: 15px 25px; border:none; border-radius: 50px; cursor:pointer;" onclick="document.location='index.php'">Back</button><?php return;
    }

    require_once 'config.php';
    $get_data = "SELECT * FROM `users` WHERE Username='$username'";
    if($result = mysqli_query($conn, $get_data)) {
        $row = mysqli_fetch_assoc($result);
        $name = $row["Name"];
        $email = $row["Email"];
    }

    $Err = "";
    $cond = true;
    $can_generate_bill = false;

    // new
    if(isset($_POST['cvv']))
        $cvv = $_POST['cvv'];

    function encrypt($field) {
        $field = trim($field);
        $field = stripslashes($field);
        $field = htmlspecialchars($field);
        return $field;
    }

    function setfield($field) {
        if(isset($_POST["$field"]) && !empty($_POST["$field"])) {
            global $$field;
            $$field = encrypt($_POST["$field"]);
        }
        else {
            $GLOBALS["cond"] = false;
            $GLOBALS["Err"] = "Some of the fields were empty. Please try again.";
        }
    }

    if (isset($_POST["gen_bill"])) {
        setfield("u_name");
        setfield("u_email");
        setfield("u_address");
        setfield("u_city");
        setfield("u_country");

        if($_POST['mode'] == "Net Banking") {
            setfield("card");
            setfield("u_card_no");
            setfield("u_card_exp");
            setfield("cvv");
        }
        

        if(!preg_match(" /^[a-zA-Z ]*$/", $_POST["u_name"]))
            $Err = "Invalid characters in the name.";
        if(!filter_var($_POST["u_email"], FILTER_VALIDATE_EMAIL))
            $Err = "Invalid e-mail format.";
        if(preg_match(" /[0-9]-/", $_POST["u_city"]) || preg_match(" /[0-9]/", $_POST["u_country"]))
            $Err = "Digits are not allowed in city or country name.";


        // ---------card info -------------
        if($_POST['mode'] == "Net Banking") {
            if(!preg_match(" /^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$/", $_POST["u_card_no"]))
                $Err = "Invalid Credit Card Number.";
            if(!preg_match(" /^[0-9-]*$/", $_POST["u_card_exp"]) || strlen($_POST["u_card_exp"]) != 10)
                $Err = "Invalid date supplied.";
            // New
            if(!preg_match(" /^[0-9]{3}$/", $_POST["cvv"]) )
            $Err = "Invalid CVV supplied.";
        }
        //-------- end of card info------------


        if($Err == "")
            $can_generate_bill = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS_Files/theme_payment.css">
        <title>Payment</title>
    </head>
    <style>
        button.contrast {
            background-color: transparent;
            padding: 15px 25px;
            font-size: x-large;
            border: 2px solid black;
            color: black;
            cursor: pointer;
            transition: 0.5s;
        }

        button.contrast:hover {
            color: white;
            background-color: black;
        }

        button.contrast > img {
            filter: brightness(0);
            transition: 0.5s;
        }

        button.contrast:hover > img {
            filter: brightness(0) invert(1);
        }
    </style>
    <body>
        <?php if($can_generate_bill == false) { ?>
        <div class="opaque" style="width: 59%; margin-top: 0px; margin-left: 0px; box-sizing: border-box; padding: 15px; border-radius: 0px;">
        <h2 style="font-size: 40px;">Billing Area</h2>
            <form style="width: 100%;" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="register">
                <table style="width: 100%; margin-left: 0px;">
                    <tr><td colspan="2"><span class="errortext"><?php echo $Err; ?></span></td></tr>
                    <tr><td colspan="2"><h2>User Information</h2></td></tr>
                    <tr>
                        <td>Name : </td>
                        <td><input type="text" name="u_name" value="<?php echo $name; ?>" readonly required></td>
                    </tr>
                    <tr>
                        <td>E-Mail : </td>
                        <td><input type="email" name="u_email" value="<?php echo $email; ?>" readonly required></td>
                    </tr>
                    <tr>
                        <td><img src="../Pictures/Icons/Home.png"> Shipping Address : </td>
                        <td><textarea name="u_address" required><?php if(isset($_POST["u_address"])) echo $_POST["u_address"]; ?></textarea></td>
                    </tr>
                    <tr>
                        <td><img src="../Pictures/Icons/Location.png"> City : </td>
                        <td><input type="text" name="u_city" value="<?php if(isset($_POST["u_city"])) echo $_POST["u_city"]; ?>" required></td>
                    </tr>
                    <tr>
                        <td><img src="../Pictures/Icons/Country.png"> Country : </td>
                        <td><input type="text" value="<?php if(isset($_POST["u_country"])) echo $_POST["u_country"]; ?>" name="u_country" required></td>
                    </tr>
                    <tr id="showMe0"><td colspan="2"><h2>Card Details</h2></td></tr>
                    <tr>
                        <td>Payment Method : </td>
                        <td><select name="mode" id="mode">
                            <option value="Net Banking" selected>Net Banking</option>
                            <option value="Cash On Delivery">Cash On Delivery</option>
                        </select></td>
                    </tr>
                    <tr id="showMe1">
                        <td><img src="../Pictures/Icons/Credit_Card.png"> Credit Card : </td>
                        <td>
                        <input type="radio" name="card" value="MasterCard" ><img src="../Pictures/Icons/MasterCard.png" style="width: 100px; height: 50px;">
                        <input type="radio" name="card" value="Visa"><img src="../Pictures/Icons/Visa.png" style="width: 100px; height: 50px;">
                        </td>
                    </tr>
                    <tr id="showMe2">
                        <td>Credit Card No. : </td>
                        <td><input type="text" placeholder="XXXX-XXXX-XXXX-XXXX" value="<?php if(isset($_POST["u_card_no"])) echo $_POST["u_card_no"]; ?>" name="u_card_no" ></td>
                    </tr>
                    <tr id="showMe3">
                        <td>Card Expiry Date : </td>
                        <td><input type="date" name="u_card_exp" ></td>
                    </tr>
                    <tr id="showMe4">
                        <td>CVV :</td>
                        <td><input type="number" name="cvv" ></td>
                    </tr>
                    
                    <tr><td><br></td></tr>
                    <tr>
                        <td style="text-align: center;"><input type="submit" name="gen_bill" value="Generate Bill"></td>
                        <td style="text-align: center;"><input type="reset" value="Cancel" onclick="document.location='index.php'"></td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="opaque" style="width: 40%; box-sizing: border-box; margin-top: 0px; border-radius: 0px;">
            <h2>Items in Cart</h2>
            <form style="width: 100%;" class="register">
            <table style="border: 2px solid cornflowerblue; border-collapse: collapse;">
                <tr style="border: 2px solid cornflowerblue; border-collapse: collapse;">
                    <th style="border: 2px solid cornflowerblue; border-collapse: collapse; padding: 10px;">Name of the item</th>
                    <th style="border: 2px solid cornflowerblue; border-collapse: collapse; padding: 10px">Quantity</th>
                    <th style="border: 2px solid cornflowerblue; border-collapse: collapse; padding: 10px;">Price per piece</th>
                </tr>
                <?php
                    $total = 0;
                    foreach($_SESSION["$username"] as $id=>$value) {
                        $sql = "SELECT * FROM `clothes` WHERE `Cloth_id`=$id";
                        if($result = mysqli_query($conn, $sql)) {
                            $row = mysqli_fetch_assoc($result);
                            ?> 
                            <tr>
                                <td style="border: 2px solid cornflowerblue; border-collapse: collapse;"><?php echo $row["Name"]; ?></td>
                                <td style="border: 2px solid cornflowerblue; border-collapse: collapse;"><?php echo $_SESSION["$username"][$id]."(".$_SESSION["$username"."_sizes"][$id].")"; ?></td>
                                <td style="border: 2px solid cornflowerblue; border-collapse: collapse;">&#8377; <?php echo $row["Price"]; ?></td>
                            </tr>
                            <?php $total += $row["Price"] * $_SESSION["$username"][$id];
                        }
                    }
                ?>
                <tr>
                    <td colspan="2">Total</td>
                    <td>&#8377; <?php echo $total; ?></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="reset" value="Back to Cart" onclick="document.location='Cart.php'"></td>
                </tr>
            </table>
            </form>
        </div>
        <?php } else { ?>
            <div class="opaque" style="width: 60%; margin-top: 0px;">
            <img src="../Pictures/Icons/Logo.png" style="width: 50%; margin-left: 25%;">
            <form class="register" method="POST">    
                <table style="width: 100%; border: 2px solid cornflowerblue; border-collapse: collapse;">
                    <tr>
                        <td>Name : </td>
                        <td><?php echo $name; ?></td>
                    </tr>
                    <tr>
                        <td>E-Mail : </td>
                        <td><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td>Address : </td>
                        <td><?php echo $_POST["u_address"].", ";
                                  echo $_POST["u_city"].", ";
                                  echo $_POST["u_country"]; ?></td>
                    </tr>
                    
                    <tr>
                        <td>Payment Mode : </td>
                        <td><?php echo $_POST["mode"]; ?></td>
                    </tr>
                </table>
                <br>
                <table style="width: 100%; border: 2px solid cornflowerblue; border-collapse: collapse;">
                <tr style="border: 2px solid cornflowerblue; border-collapse: collapse;">
                    <th style="border: 2px solid cornflowerblue; border-collapse: collapse; padding: 10px;">Name of the item</th>
                    <th style="border: 2px solid cornflowerblue; border-collapse: collapse; padding: 10px">Quantity</th>
                    <th style="border: 2px solid cornflowerblue; border-collapse: collapse; padding: 10px;">Price per piece (&#8377;)</th>
                    <th style="border: 2px solid cornflowerblue; border-collapse: collapse; padding: 10px;">Amount (&#8377;)</th>
                </tr>
                <?php
                    $total = 0;
                    foreach($_SESSION["$username"] as $id=>$value) {
                        $sql = "SELECT * FROM `clothes` WHERE `Cloth_id`=$id";
                        if($result = mysqli_query($conn, $sql)) {
                            $row = mysqli_fetch_assoc($result);
                            ?> 
                            <tr>
                                <td style="border: 2px solid cornflowerblue; border-collapse: collapse;"><?php echo $row["Name"]; ?></td>
                                <td style="border: 2px solid cornflowerblue; border-collapse: collapse;"><?php echo $_SESSION["$username"][$id]."(".$_SESSION["$username"."_sizes"][$id].")"; ?></td>
                                <td style="border: 2px solid cornflowerblue; border-collapse: collapse;"><?php echo $row["Price"]; ?></td>
                                <td style="border: 2px solid cornflowerblue; border-collapse: collapse;"><?php echo ($row["Price"] * $value); ?></td>
                            </tr>
                            <?php $total += $row["Price"] * $_SESSION["$username"][$id];
                        }
                    }
                ?>
                    <tr>
                        <td colspan="2"></td>
                        <td style="border-left: 2px solid cornflowerblue;">Total</td>
                        <td>&#8377; <?php echo $total; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td style="border-left: 2px solid cornflowerblue;">(+18% GST)</td>
                        <td>&#8377; <?php echo ($total * 0.18); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td style="border: 2px solid cornflowerblue;"><strong>Grand Total</strong></td>
                        <td style="border: 2px solid cornflowerblue;"><strong>&#8377; <?php echo ($total * 1.18); ?></strong></td>
                    </tr>
                </table><br><br>

                <h2>Terms & Conditions :</h2> 
                <ul style="list-style-type: disc;">
                    <li>The defected goods can be returned within <strong>7 days</strong> of purchase only. We will not be responsible if the goods are not returned within the given time limit.</li>
                    <li>Have a copy of your bill with you as a proof to exchange items.</li>
                    <li>GST is calculated using the rate applicable for the date or period of the charge. The GST rate used for discounts and rebates is based on the GST rate applied to the original charge.</li>
                    <li>Other service charges of maximum &#8377; 200 may apply.</li>
                </ul>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%;"></td>
                        <td style="width: 50%; text-align: right;">Deep Colors, <br><br><img src="../Pictures/Icons/Stamp.png" style="width: 100px; height: 100px; opacity: 75%;"></td>
                    </tr>
                </table>
                <hr>
            
            <table>
                    <tr>
                        <td><button type="button" class="contrast" onclick="window.print();">Print Recipt <img src="../Pictures/Icons/Download.png" style="width: 30px; vertical-align: middle;"></button></td>
                        <td><input type="submit" name="Home" value="Home"></td>
                    </tr>
            </table>
            </form>
            </div>
        <?php } ?>

        <script>
            var elem = document.getElementById("mode");
            elem.onchange = function(){
                var hiddenDiv0 = document.getElementById("showMe0");
                var hiddenDiv1 = document.getElementById("showMe1");
                var hiddenDiv2 = document.getElementById("showMe2");
                var hiddenDiv3 = document.getElementById("showMe3");
                var hiddenDiv4 = document.getElementById("showMe4");

                if(elem.value == "Cash On Delivery") {
                    hiddenDiv0.style.display = "none";
                    hiddenDiv1.style.display = "none";
                    hiddenDiv2.style.display = "none";
                    hiddenDiv3.style.display = "none";
                    hiddenDiv4.style.display = "none";
            } else {
                    hiddenDiv0.style.display = "block";
                    hiddenDiv1.style.display = "block";
                    hiddenDiv2.style.display = "block";
                    hiddenDiv3.style.display = "block";
                    hiddenDiv4.style.display = "block";
            }
    };
        
        </script>
    </body>
</html>