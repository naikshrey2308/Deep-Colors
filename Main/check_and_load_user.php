<?php
    session_start();

    if(isset($_SESSION["user"])) {
        $image = $_SESSION["user"];
        if(file_exists("../Pictures/Users/".$image.".png")) {
            $image .= ".png";
        } 
        else if(file_exists("../Pictures/Users/".$image.".jpeg"))
            $image .= ".jpeg";
        else 
            $image = "Profile_no_dp.png";
    }

?>