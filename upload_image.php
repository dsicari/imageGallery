<?php   
    include 'init.php';
    if(!logged_in()){
        header('Location: index.php');
        exit();
    } 
    /*   
    if(album_check($conn, $_SESSION['user_id'], $_GET['album_id']) == false){
        header('Location: albums.php');
        exit();
    }
    if(isset($_GET['album_id'])){
        $album_id = $_GET['album_id'];
        delete_album($conn, $_SESSION['user_id'], $album_id);
        header('Location: albums.php');
        exit();
    }*/
    include 'template/header.php';
?>

    <h3>Upload images</h3>

<?php   
    if(isset($_FILES['image'], $_POST['album_id'])){
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_temp = $_FILES['image']['tmp_name'];

        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        $image_ext = strtolower(end(explode('.', $image_name)));
        
        $album_id = $_POST['album_id'];
        
        $errors = array();

        if(empty($image_name) || empty($album_id)){
            $errors[] = 'Something is missing';
        }
        else{ 
            if(in_array($image_ext, $allowed_ext) == false){
                $errors[] = 'File type not allowed';
            }
            // Verificar tamanho a ser enviado no apache
            if($image_size > 2097152 || $image_size == 0){
                $errors[] = 'Maximum file size is 2mb';
            }
            if(album_check($conn, $_SESSION['user_id'], $album_id) == false){
                $erros[] = 'Couldn\'t upload to that album';
            }  
        } 
        if(!empty($errors)){
            foreach($errors as $error){
                echo $error, '<br>';
            }
        }
        else{
            upload_image($conn, $_SESSION['user_id'], $image_temp, $image_ext, $album_id);
            header('Location: view_album.php?album_id='.$album_id);
            exit();
        }

    }

    $albums = get_albums($conn, $_SESSION['user_id']);
    if(empty($albums)){
        echo 'You don\'t have any albums. <a href="create_album.php">Create an Album</a></p>';
    }
    else{
?>
    <form action="" method="post" enctype="multipart/form-data">
        <p>Choose a file:<br><input type="file" name="image" /></p>
        <p>Choose an album:<br>
        <select name="album_id">
            <?php
                foreach($albums as $album){
                    echo '<option value="',$album['id'],'">',$album['name'],'</option>';
                }
            ?>
        </select>
        </p>
        <input type="submit" value="Upload" />
    </form>

<?php
    }   
    include 'templates/footer.php';
?>