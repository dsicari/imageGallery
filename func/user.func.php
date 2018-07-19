<?php
    
    function logged_in(){
        return isset($_SESSION['user_id']);
    }

    function login_check($conn, $email, $password){
        $email = mysqli_real_escape_string($conn, $email);
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='".md5($password)."'");
        $num_row 	= mysqli_num_rows($query);
        if ($num_row > 0){
            $row = mysqli_fetch_array($query);
            return $row['user_id'];  
        }
        else{
            return false;
        }
    }
    
    function user_data($conn, $args){
        // args[0]: user_id to look for
        // args[1]: name
        // args[2]: email
        // ...
        $query = mysqli_query($conn, "SELECT $args[1] FROM users WHERE user_id='$args[0]'");
        $num_row 	= mysqli_num_rows($query);
        if ($num_row > 0){
            $row = mysqli_fetch_array($query);
            return $row['name'];
        }
        else{
            return false;
        }
    }

    function user_register($conn, $email, $name, $password){
        $email = mysqli_real_escape_string($conn, $email);
        $name = mysqli_real_escape_string($conn, $name);
        $query = mysqli_query($conn, "INSERT INTO users VALUES('', '$email', '$name', '".md5($password)."')");
        return mysqli_insert_id($conn);
    }

    function user_exists($conn, $email){
        $email = mysqli_real_escape_string($conn, $email);
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        $num_row 	= mysqli_num_rows($query);
        if ($num_row > 0){
            return true;
        }
        else{
            return false;
        }
    }

?>