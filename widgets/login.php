<?php
    if(logged_in()){
        echo 'Hello ';
        echo user_data($conn, array($_SESSION['user_id'], 'name'));        
    }
    else{
?>
        <form action="" method="post">
            <p>
                E-mail: <input type="text" name="login_email" />
                Password: <input type="password" name="login_password" />
                <input type="submit" value="Log in">
            </p>
        </form>
<?php
    }

    if(isset($_POST['login_email'], $_POST['login_password'])){
        $login_email = $_POST['login_email'];
        $login_password = $_POST['login_password'];
    }

    $errors = array();

    if(empty($login_email) || empty($login_password)){
        $errors[] = 'Email and password required';
    }
    else{
        $login = login_check($conn, $login_email, $login_password);
        if($login == false){
            $errors[] = 'Unable to log you in'; 
        }
        else{
            $_SESSION['user_id'] = $login;
            header('Location: index.php');
            exit();
        }        
    }
    /*if(!empty($errors)){
        foreach($errors as $error){
            echo $error, '<br>';
        }                
    }*/
?>