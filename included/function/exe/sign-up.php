<?php
    $name_file = basename(__FILE__);
    $root = '../../../'; 
    $type_session = 'unimportant';
    include_once $root.'included/function/php/common.php';
    include_once $root.'included/function/php/sign-up.php';
    check_session($type_session, $root, $name_file, $conectareDB);

    if(isset($_POST['username']) && isset($_POST['password'])){
        if(check_robot()){
            $username = mysqli_real_escape_string($conectareDB, $_POST['username']);
            $password = mysqli_real_escape_string($conectareDB, $_POST['password']);
            $password_check = mysqli_real_escape_string($conectareDB, $_POST['password-repeat']);
            
            if(check_data_access($username, $password, $password_check, $conectareDB)){
                create_new_account($username, $password, $conectareDB);
            }
        }
    }
    else{
        header('Location:'.$root.'');
        exit;
    }
?>