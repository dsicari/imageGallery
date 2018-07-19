 <?php
    include 'init.php';
    if(!logged_in()){
        header('Location: index.php');
        exit();
    } 
    if(image_check($conn, $_SESSION['user_id'], $_GET['image_id']) == false){
        header('Location: albums.php');
        exit();
    }
    if(isset($_GET['image_id']) || empty($_GET['image_id'])){
        delete_image($conn, $_SESSION['user_id'], $_GET['image_id']);        
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit();
    }
 ?>