<?php
    include 'init.php';
    if(!logged_in()){
        header('Location: index.php');
        exit();
    }
    include 'template/header.php';
?>
    <h3>Albums</h3>
<?php
    $albums = get_albums($conn, $_SESSION['user_id']);
    if(empty($albums)){
        echo '<p>Sorry, you don\'t have any albums</p>';
    }
    else{
        foreach($albums as $album){
            echo '<p>
                  <a href="view_album.php?album_id=', $album['id'], '">', $album['name'], '</a>
                  (', $album['count'], ' images)
                  <br>', $album['description'], '...<br>
                  <a href="edit_album.php?album_id=',$album['id'],'">Edit</a> / <a href="delete_album.php?album_id=',$album['id'],'">Delete</a>
                  </p>';
        }
    }
    include 'template/footer.php';
?>