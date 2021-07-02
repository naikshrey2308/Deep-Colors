<?php
session_start();
require_once "../Main/config.php";
 $username =  $_POST['username'];
 $cloth_id = $_POST['cloth_id'];
 $new_string ="";

$sql ="SELECT `Items in Cart` FROM `cart` WHERE `Username` = ?";

if($stmt = mysqli_prepare($conn , $sql)) {
    mysqli_stmt_bind_param($stmt , "s" , $username );
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);
    $string = $row['Items in Cart'];

    $string_arr = explode("," , $string );

    if(strpos($string ,",") === false){
        
        $sql_for_delete = "DELETE FROM `cart` WHERE `cart`.`Username` = ? ";

        if($stmt = mysqli_prepare($conn , $sql_for_delete)) {
            mysqli_stmt_bind_param($stmt , "s" , $username );
            mysqli_stmt_execute($stmt);
            unset($_SESSION["$username"]);
            unset($_SESSION[$username."set".$cloth_id]);
            unset($_SESSION["$username"."_sizes"]);
            unset($_SESSION[$username."_sizes_set".$cloth_id]);
            header("Location:Cart.php?delete=success");
            exit(0);
        }
        

    }
    else if( $cloth_id == end($string_arr) ) {
        // $string .= ",";
        // echo substr($string , -1);
        // echo "hii";
        $new_string = str_replace( "," . $cloth_id , "" , $string);
    }
    else if($cloth_id == $string_arr[0] ) {
        $new_string = str_replace( $cloth_id . "," , "" , $string);
    }
    else {
        $new_string = str_replace($cloth_id . "," , "" , $string);
    }


    $sql1 = "UPDATE `cart` SET `Items in Cart`= ? WHERE `Username` = ?";

    if($stmt = mysqli_prepare($conn , $sql1)) {
        mysqli_stmt_bind_param($stmt , "ss" , $new_string , $username );

        if(mysqli_stmt_execute($stmt)) {
            unset($_SESSION["$username"][$cloth_id]);
            unset($_SESSION[$username."set".$cloth_id]);
            header("Location:Cart.php?delete=success");
            exit(0);
        } else {
            header("Location:Cart.php?delete=error");
            exit(0);
        }

    } else {
        header("Location:Cart.php?delete=error");
        exit(0);
    }

} 
else {
    header("Location:Cart.php?delete=error");
    exit(0);
}

?>