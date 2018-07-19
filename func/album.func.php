<?php

    function album_data($conn, $album_id, $args){
        // args[0]: user_id to look for
        // args[1]: 'name' of album
        // args[2]: 'description' of album
        // ...
        $album_id = (int)$album_id;
        $query = mysqli_query($conn, "SELECT $args[1],$args[2] FROM albums WHERE album_id=$album_id and user_id='$args[0]'");
        $num_row 	= mysqli_num_rows($query);
        if ($num_row > 0){
            $query_result = mysqli_fetch_assoc($query);
            foreach($args as $field){
                $args[$field] = $query_result[$field];
            }
            return $args;
        }
        else{
            return false;
        }
    }

    function album_check($conn, $user_id, $album_id){
        $album_id = (int)$album_id;
        $query = mysqli_query($conn, "SELECT album_id FROM albums WHERE album_id=$album_id and user_id='$user_id'");
        $num_row 	= mysqli_num_rows($query);
        if ($num_row > 0){
            return true;
        }
        else{
            return false;
        }
    } 

    function get_albums($conn, $user_id){
        $albums = array();
        $query = mysqli_query($conn, "SELECT albums.album_id, 
                                             albums.timestamp, 
                                             albums.name, 
                                             LEFT(albums.description, 50) as description, 
                                             COUNT(images.image_id) as image_count
                                             FROM albums
                                             LEFT JOIN images
                                             ON albums.album_id = images.album_id
                                             WHERE albums.user_id='$user_id'
                                             GROUP BY albums.album_id");
        
        while($albums_row = mysqli_fetch_assoc($query)){
            $albums[] = array('id' => $albums_row['album_id'],
                              'timestamp' => $albums_row['timestamp'],
                              'name' => $albums_row['name'],
                              'description' => $albums_row['description'],
                              'count' => $albums_row['image_count']);
        }

        return $albums;
    }

    function create_album($conn, $album_name, $album_description, $user_id){
        $album_name = mysqli_real_escape_string($conn, htmlentities($album_name));
        $album_description = mysqli_real_escape_string($conn, htmlentities($album_description));
        $query = mysqli_query($conn, "INSERT INTO albums VALUES('', '$user_id', UNIX_TIMESTAMP(), '$album_name', '$album_description')");
        // mkdir tested on windows 10
        mkdir('./uploads/albums/' . mysqli_insert_id($conn), 0744);
        mkdir('./uploads/thumbs/' . mysqli_insert_id($conn), 0744);
    }

    function edit_album($conn, $user_id, $album_id, $album_name, $album_description){
        $album_id = (int)$album_id;  
        $album_name = mysqli_real_escape_string($conn, htmlentities($album_name));
        $album_description = mysqli_real_escape_string($conn, htmlentities($album_description));
        $query = mysqli_query($conn, "UPDATE albums SET name='$album_name', description='$album_description' WHERE album_id='$album_id' and user_id='$user_id'");
        $num_row 	= mysqli_num_rows($query);
        if ($num_row > 0){
            return true;
        }
        else{
            return false;
        }
    }

    function delete_album($conn, $user_id, $album_id){
        $album_id = (int)$album_id;
        $query_delete_album = mysqli_query($conn, "DELETE FROM albums WHERE album_id=$album_id and user_id='$user_id'");
        $query_delete_images = mysqli_query($conn, "DELETE FROM images WHERE album_id=$album_id and user_id='$user_id'");
    }

?>