<?php
    include 'check_and_load_user.php';
    if (!isset($_SESSION["user"])) {
        echo "<span style='font-size: x-large;'>Please login first to access this page.</span>";
    ?> <button style="background-color: tomato; color: white; font-size: x-large; padding: 15px 25px; border:none; border-radius: 50px; cursor:pointer;" onclick="document.location='index.php'">Back</button><?php return; } ?>  

<?php
    if(!isset($_POST["name"])) {
        setcookie("Error", "Unable to connect to the servers.");
        header("Location: Categories.php");
        exit();
    }

    $username = $_SESSION["user"];
    require_once 'config.php';
    $name = $_POST["name"];

    $get_id = "SELECT `Cloth_id` FROM `clothes` WHERE Name=?";
    if($stmt = mysqli_prepare($conn, $get_id)) {
        mysqli_stmt_bind_param($stmt, "s", $name);
        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $id = $row["Cloth_id"];
        }
        else {
            mysqli_close($conn);
            setcookie("Error", "Unable to connect to the servers.");
            header("Location: Categories.php");
            exit();
        }
    }

    $find_user = "SELECT * FROM `cart` WHERE Username=?";
    if($stmt = mysqli_prepare($conn, $find_user)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            if(strchr($row["Items in Cart"], (string)$id)) {
                mysqli_close($conn);
                header("Location: Categories.php");
                exit();
            }
            if(mysqli_num_rows($result) > 0) {
                $add_item = "UPDATE `cart` SET `Items in Cart`=? WHERE Username=?";
                $id_former = $row["Items in Cart"].",";
                $id = $id_former.$id;
            }
            else {
                $add_item = "INSERT INTO `cart`(`Items in Cart`, `Username`) VALUES (?, ?)";
            }
        }
    }

    if($stmt = mysqli_prepare($conn, $add_item)) {
        mysqli_stmt_bind_param($stmt, "ss", $id, $username);
        if(mysqli_stmt_execute($stmt)) {
            mysqli_close($conn);
            header("Location: Categories.php");
            exit();
        }
        else {
            setcookie("Error", "Unable to connect to the servers.");
            mysqli_close($conn);
            header("Location: Categories.php");
            exit();
        }
    }
?>