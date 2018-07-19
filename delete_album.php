<?php   
    include 'init.php';
    if(!logged_in()){
        header('Location: index.php');
        exit();
    }    
    if(album_check($conn, $_SESSION['user_id'], $_GET['album_id']) == false){
        header('Location: albums.php');
        exit();
    }
    if(isset($_GET['album_id'])){
        $album_id = $_GET['album_id'];
        delete_album($conn, $_SESSION['user_id'], $album_id);
        header('Location: albums.php');
        exit();
    }
    include 'template/header.php';
?>