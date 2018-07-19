<?php
    include 'init.php';
    if(!logged_in()){
        header('Location: index.php');
        exit();
    }
    include 'template/header.php';
?>

    <h3>Create Album</h3>
<?php
    if(isset($_POST['album_name'], $_POST['album_description'])){
        $album_name = $_POST['album_name'];
        $album_description = $_POST['album_description'];

        $errors = array();

        if(empty($album_name) || empty($album_description)){
            $errors[] = 'Album name and description required';
        }
        else{
            if(strlen($album_name) > 55 || strlen($album_description) > 255){
                $errors[] = 'One or more fields contains many characters';
            }
        }
        if(!empty($errors)){
            foreach($errors as $error){
                echo $error;
                echo '<br>';
            }
        }
        else{
            create_album($conn, $album_name, $album_description, $_SESSION['user_id']);
            header('Location: albums.php');
            exit();
        }
    }
?>
    <form action="" method="post">
        <p>Name:<br><input type="text" name="album_name" maxlength="55" /></p>
        <p>Description:<br><textarea name="album_description" rows="6" cols="35" maxlength="255"></textarea></p>
        <p><input type="submit" value="Create" /></p>
    </form>

<?php
    include 'footer.php';
?>