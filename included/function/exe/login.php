<?php
    $name_file = basename(__FILE__);
    $root = '../../../'; 
    $type_session = 'unimportant';
    include_once $root.'included/function/php/common.php';
    include_once $root.'included/function/php/login.php';
    check_session($type_session, $root, $name_file, $conectareDB);

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = strtolower($_POST['username']);
        $username = InlocuireCharactere($username);
        $username = mysqli_real_escape_string($conectareDB, $username);
        $password = $_POST['password'];
        $password = mysqli_real_escape_string($conectareDB, $password);;

        if(check_robot()){
            if(check_data_access($username, $password)){
                if(connect_account('users', $username, $password, $conectareDB, $root)){
                    if(!isset($_POST['reminde'])){
                        setcookie('username', $username, time() - 30 * 24 * 60 * 60, '/');
                        setcookie('password', $password, time() - 30 * 24 * 60 * 60, '/');
                    }
                    else{
                        set_cookie($username, $password, $_POST['reminde']);
                    }
                    create_connect_session($username, $password, $root);
                }
            }
        }
    }
    else{
        header('Location:'.$root.'');
        exit;
    }
?>