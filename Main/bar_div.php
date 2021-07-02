<div class="logo"><img src="../Pictures/Icons/Logo.png" alt="" onclick="document.location='index.php'"></div>
        <nav>
            <div class="navbar_left">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li class="dropdown_hover">
                    <div class="dropdown">
                        <button class="dropbtn" onclick="document.location='Categories.php'">Categories</button>
                    </li>
                    <li><a href="Login.php">
                        <?php if(!isset($_SESSION["user"]))
                                echo "Login/SignUp";
                            else echo "Logout";    
                        ?>
                    </a></li>
                    <li><a href="About.php">Contact Us</a></li>
                    <?php if(isset($_SESSION["user"]) && $_SESSION["user"] == "admin") { ?>
                        <li><a href="admin.php">Admin</a></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="navbar_right">
                <a href="profile.php"><img src="../Pictures/<?php
                    if (isset($image))
                        echo "Users/$image";
                    else echo "Icons/Profile.png";
                ?>" height="30px" width="30px" style="border-radius: 50%;"></a>
                <a href="Cart.php"><img src="../Pictures/Icons/Cart.png" height="30px" width="30px"></a>
                <a href="Feedback.php"><img src="../Pictures/Icons/Feedback.png" height="30px" width="30px"></a>
            </div>
        </nav>