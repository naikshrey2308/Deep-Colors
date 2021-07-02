<?php

require_once "config.php";
//echo $_GET['Cloth_id'];
$Cloth_id = mysqli_real_escape_string($conn, $_GET['Cloth_id']);
//echo $Cloth_id;

$sql = "SELECT * FROM `clothes` WHERE `Cloth_id`=$Cloth_id";
if($result = mysqli_query($conn, $sql)) {
    $row = mysqli_fetch_assoc($result);
    if(file_exists("../Pictures/Categories/".$row["Category"]."/".$row["Name"].".png"))
        unlink("../Pictures/Categories/".$row["Category"]."/".$row["Name"].".png");
    elseif(file_exists("../Pictures/Categories/".$row["Category"]."/".$row["Name"].".jpg"))
        unlink("../Pictures/Categories/".$row["Category"]."/".$row["Name"].".jpg");
    elseif(file_exists("../Pictures/Categories/".$row["Category"]."/".$row["Name"].".jpeg"))
        unlink("../Pictures/Categories/".$row["Category"]."/".$row["Name"].".jpeg"); 
    else
        header("Location: admin.php?delete=unsuccess");
}

$sql = "DELETE FROM `clothes` WHERE `Cloth_id` = $Cloth_id";

if($result = mysqli_query($conn, $sql)) {
    header("Location:admin.php?delete=success");
    exit(0);
} else {
    header("Location:admin.php?delete=unsuccess");
    exit(0);
}


?>