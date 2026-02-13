<?php
    $name_file = basename(__FILE__);
    $root = '../../../'; 
    $type_session = 'important';
    include_once $root.'included/function/php/common.php';
    include_once $root.'included/function/php/confirm-email.php';
    check_session($type_session, $root, $name_file, $conectareDB);

    if(isset($_POST['email'])){
        $email = mysqli_real_escape_string($conectareDB, InlocuireCharactere($_POST['email']));
        if(check_email($email, $conectareDB)){
            confirm_email($email);
        }
    }
    else if(isset($_POST['code-email']) && isset($_POST['confirm-email'])){
        $email = mysqli_real_escape_string($conectareDB, InlocuireCharactere($_POST['confirm-email']));
        $code = mysqli_real_escape_string($conectareDB, InlocuireCharactere($_POST['code-email']));
        $code = (float)$code;

        if(check_code($code, $email, $conectareDB)){
            inesert_email($conectareDB);
        }
    }
    else{
        header('Location:'.$root.'');
        exit;
    }
?>