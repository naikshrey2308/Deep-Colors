<?php include 'check_and_load_user.php';
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS_Files/theme_index.css">
    <link rel="stylesheet" href="../CSS_Files/theme_admin.css">
    <title>Admin</title>
</head>
<body>
    <?php include 'bar_div.php'; ?>
    <h2>Record Handler</h2>
    <p style="text-align: center; margin: 15px;"><button style="font-size: x-large;" class="btn" id="btn-contrast" onclick="document.location='add_cloth.php'">&plus; Create New Record</button></p>

<?php

require_once "config.php";

if(isset($_GET['delete']) ) {
if($_GET['delete'] == 'success'){
    echo "<p class='success' > One item has been deleted from the Database</p>";
}
else if($_GET['delete'] == 'unsuccess'){
    echo "<p class='unsuccess' >item has not been deleted from the Database</p>";
}
}
$sql = "SELECT * FROM `clothes`";

if ($result = mysqli_query($conn, $sql)) {

    if (mysqli_num_rows($result) > 0) {

    echo '<table class="container">';
        echo '<thead>';
            echo '<tr>';
                echo '<th>Cloth Id</td>';
                echo '<th>Cloth Name</td>';
                echo '<th>Price</td>';
                echo '<th>Category</td>';
                echo '<th>Quantity</td>';
                echo '<th>Action</td>';
            echo '</tr>';
        echo '</thead>';

        echo '<tbody>';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
                echo '<td>'. $row["Cloth_id"] . '</td>';
                echo '<td style="text-align: left;">'. $row["Name"] . '</td>';
                echo '<td>'. $row["Price"] . '</td>';
                echo '<td>'. $row["Category"] . '</td>';
                echo '<td>'. $row["Quantity"] . '</td>';

                echo '<td>';
                echo '<a href="admin_view.php?Cloth_id='. $row['Cloth_id'] .'&Name='. $row['Name'] .'&Price='. $row['Price'] .'&Category='. $row['Category'] .' ">View</a>';
                echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                echo '<a id="delete" href="admin_delete.php?Cloth_id='. $row['Cloth_id'] .' ">Delete</a>';
                echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
    echo '</table>';
    } else{
		echo "<p>No records were found.</p>";
	}
}

?>

</body>
</html>