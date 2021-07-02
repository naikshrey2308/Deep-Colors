<style>
    .error_background {
       margin: auto;
       padding: 15px;
       font-size: x-large;
       font-weight: 800;
       color: red;
       text-align: center; 
       background-color: rgba(255, 255, 255, 0.85);
    }

    img.body_image {
        width: 25%;
    }
</style>

<?php

    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'online_shopping');

    function connection_error($errno, $errstr) {
        echo "<br><div class='error_background'>Oops! It seems like there is an error connecting to our servers. Please try again later.<br>";
    }

    set_error_handler("connection_error");
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if($conn === false){
        die("<img src='../Pictures/Background_Images/Connection_Error.png' class='body_image'></img></div>");
    }

    restore_error_handler();
?>