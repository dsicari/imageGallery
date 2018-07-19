<?php   
    include 'init.php';
    if(!logged_in()){
        header('Location: index.php');
        exit();
    }    
    if(!isset($_GET['album_id']) || empty($_GET['album_id']) || album_check($conn, $_SESSION['user_id'], $_GET['album_id']) == false){
        header('Location: albums.php');
        exit();
    }
    include 'template/header.php';
?>

    <h3>Edit album</h3>    

<?php
    $album_id = $_GET['album_id'];
    $album_data = album_data($conn, $album_id, array($_SESSION['user_id'], 'name', 'description'));
    if(isset($_POST['album_name'], $_POST['album_description'])){
        $album_name = $_POST['album_name'];
        $album_description = $_POST['album_description'];
    
        $errors = array();

        if(empty($album_name) || empty($album_name)){
            $errors[] = 'Album name and description required';
        }
        else if(strlen($album_name) > 55 || strlen($album_description) > 255){
                $errors[] = 'One or more fields contains too many characters';        
        }

        if(!empty($error)){
            foreach($errors as $error){
                echo $error, '<br>';
            }
        }
        else{
            edit_album($conn, $_SESSION['user_id'], $album_id, $album_name, $album_description);
            header('Location: albums.php');
            exit();
        }
    }
?>
    <form action="?album_id=<?php echo $album_id; ?>" method="post">
        <p>Name:<br><input type="text" name="album_name" maxlength="55" value="<?php echo $album_data['name']; ?>" /></p>
        <p>Description:<br><textarea name="album_description" rows="6" cols="35" maxlength="255"><?php echo $album_data['description']; ?></textarea></p>
        <p><input type="submit" value="Edit" /></p>
    </form>
<?php
    include 'template/footer.php';
?>