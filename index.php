<?php
    include 'init.php';
    include 'template/header.php';
    
    if(logged_in()){
        echo 'Welcome, you can now start <a href="create_album.php">create albums</a> and <a href="upload_image.php">upload images</a>';
    }
    else{
        echo '<img src="images/landing.png" alt="Register a free account today" />';
    }
?>