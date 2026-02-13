<?php
    $name_file = basename(__FILE__);
    $root = '../../../'; 
    $type_session = 'important';
    include_once $root.'included/function/php/common.php';
    include_once $root.'included/function/php/raport.php';
    check_session($type_session, $root, $name_file, $conectareDB);

    if(isset($_POST['camion'])){
        creaza_fisa($_POST, $conectareDB);
    }
    else{
        header('Location:'.$root.'');
        exit;
    }
?>