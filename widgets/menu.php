<a href="index.php">Home</a> /
<?php
    if(!logged_in()){
?>
        <a href="register.php">Register</a>
<?php
    }
    else{
?>
        <a href="./widgets/logout.php">Logout</a> / 
        <a href="create_album.php">Create Album</a> /
        <a href="albums.php">Albums</a> / 
        <a href="upload_image.php">Upload Image</a>
<?php
    }
?>
