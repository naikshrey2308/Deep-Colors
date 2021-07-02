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

require_once "config.php";
$msg = "Name and the File Name should be the same.";
if($_SERVER["REQUEST_METHOD"] == "POST") {

$Name = $_POST['cloth_name'];
$Price = $_POST['cloth_price'];
$Category = $_POST['cloth_category'];
$Quantity = $_POST['cloth_quan'];


$fileName = $_FILES['cloth_image']['name'];
$file_tmp = $_FILES['cloth_image']['tmp_name'];
$file_type = $_FILES['cloth_image']['type'];
$file_size = $_FILES['cloth_image']['size'];

$ext = "";
if($file_type == "image/jpeg"){
    $ext = ".jpg";
}
else if($file_type == "image/png"){
    $ext = ".png";
}
else{
    die("please submit png or jpg/jpeg image");
}

$location = "../Pictures/Categories/". $_POST['cloth_category'] . "/" . $_POST['cloth_name'] ;

if(!move_uploaded_file($file_tmp, $location.$ext))
    die("Couldn't upload image due to some errors.");

$sql = "INSERT INTO `clothes` (`Name`, `Price`, `Category`, `Quantity`) VALUES (?, ?, ?, ?);";

if($stmt = mysqli_prepare($conn, $sql)){
    mysqli_stmt_bind_param($stmt, "sisi", $Name, $Price, $Category, $Quantity);

    if(mysqli_stmt_execute($stmt)){
        $msg = "One item has been added to the Database successfully";
        header("Location: admin.php");
        exit();
    } else{
        $msg = "There is some error in Adding the item to the Database";
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
    <title>Add Cloth</title>
    <link rel="stylesheet" href="../CSS_Files/theme_login.css">
</head>
<style>
    select {
        padding: 3px 25px;
        width: 60%;
        font-size: x-large;
    }
</style>
<body>
    <div class="opaque">
    <div class="errortext" style="width: 100%; text-align: center;"><?php echo $msg; ?></div>
    <form class="register" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Choose Cloth Image: </td>
            <td><input type="file" name="cloth_image" required></td>
        </tr>
        <tr>
            <td>Name : </td>
            <td><input type="text" name="cloth_name" required></td>
        </tr>
        <tr>
            <td>Price: </td>
            <td><input type="number" name="cloth_price" required></td>
        </tr>
        <tr>
            <td>Quantity: </td>
            <td><input type="number" name="cloth_quan" required></td>
        </tr>
        <tr>
            <td>Category: </td>
            <td><select required name="cloth_category">
                <option value="Men">Men</option>
                <option value="Women">Women</option>
                <option value="Kids">Kids</option>
                <option value="Masks">Masks</option>
            </select></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="Submit" value="Submit"></td>
        </tr>
    </table>
    </form>
</div>
</body>
</html>