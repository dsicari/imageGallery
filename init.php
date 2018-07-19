<?php
    ob_start();
    session_start();   

    include 'func/album.func.php';
    include 'func/image.func.php';
    include 'func/user.func.php';
    include 'func/thumb.func.php';
    
    $servername = "localhost";
    $username = "root";
    $password = "root";  
    $database = "galeria";

    try{  
        $conn = new mysqli($servername, $username, $password, $database);
    }
    catch (Exception $e){
        echo "FAILS";
    }
?>