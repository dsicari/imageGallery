<?php 

    function upload_image($conn, $user_id, $image_temp, $image_ext, $album_id){
        $album_id = (int)$album_id;
        $query = mysqli_query($conn, "INSERT INTO images VALUES('', '$user_id', $album_id, UNIX_TIMESTAMP(), '$image_ext', 0, 0)");
        
        $image_id = mysqli_insert_id($conn);

        $image_file = $image_id . '.' . $image_ext;

        move_uploaded_file($image_temp, './uploads/albums/' . $album_id . '/' . $image_file);

        create_thumb('./uploads/albums/' . $album_id . '/', $image_file, './uploads/thumbs/' . $album_id . '/');
        
    }

    function get_images($conn, $user_id, $album_id){
        $album_id = (int)$album_id;
        $images = array();
        $query = mysqli_query($conn, "SELECT image_id, album_id, timestamp, ext FROM images WHERE album_id=$album_id and user_id='$user_id'");
        while($images_row = mysqli_fetch_assoc($query)){
            $images[] = array('id' => $images_row['image_id'],
                              'album' => $images_row['album_id'],
                              'timestamp' => $images_row['timestamp'],
                              'ext' => $images_row['ext']);
        }
        return $images;
    }

    function image_check($conn, $user_id, $image_id){
        $image_id = (int)$image_id;        
        $query = mysqli_query($conn, "SELECT image_id FROM images WHERE image_id=$image_id and user_id='$user_id'");
        $num_row 	= mysqli_num_rows($query);
        if ($num_row > 0){
            return true;
        }
        else{
            return false;
        }
    }

    function delete_image($conn, $user_id, $image_id){
        $image_id = (int)$image_id;
        
        $query_image = mysqli_query($conn, "SELECT album_id, ext FROM images WHERE image_id=$image_id and user_id='$user_id'");
        $query_image_result = mysqli_fetch_assoc($query_image);

        $album_id = $query_image_result['album_id'];
        $image_ext = $query_image_result['ext'];

        unlink('./uploads/albums/'.$album_id.'/'.$image_id.'.'.$image_ext);
        unlink('./uploads/thumbs/'.$album_id.'/'.$image_id.'.'.$image_ext);

        mysqli_query($conn, "DELETE FROM images WHERE image_id=$image_id and user_id='$user_id'");
    }

?>