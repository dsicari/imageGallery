<?php   
    include 'init.php';
    if(!logged_in()){
        header('Location: index.php');
        exit();
    } 
    if(!isset($_GET['album_id']) || empty($_GET['album_id'])){
        header('Location: albums.php');
        exit();
    }  
    if(album_check($conn, $_SESSION['user_id'], $_GET['album_id']) == false){
        header('Location: albums.php');
        exit();
    }
    include 'template/header.php';

    $album_id = $_GET['album_id'];

    $album_data = album_data($conn, $album_id, array($_SESSION['user_id'], 'name', 'description'));

    echo '<h3>',$album_data['name'],'</h3>';
    echo '<p>',$album_data['description'],'</p>';
    
    $images = get_images($conn, $_SESSION['user_id'], $album_id);
    //print_r($images);
    if(empty($images)){
        echo 'Sorry, no images to display';
    }
    else{
       foreach($images as $image){
           echo '<a href="./uploads/albums/',$image['album'],'/',$image['id'],'.',$image['ext'],'">
                    <img src="./uploads/thumbs/',$image['album'],'/',$image['id'],'.',$image['ext'],'" title="Uploaded ',date('M D Y / h:i',$image['timestamp']),'" alt="" />
                </a> 
                [<a href="delete_image.php?image_id=',$image['id'],'">x</a>]';
       }
    }
    include 'templates/footer.php';
?>