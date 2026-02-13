<?php
    $name_file = basename(__FILE__);
    $root = '../../'; 
    $title = 'Confirm email';
    $type_session = 'important';
    include_once $root.'included/function/php/common.php';
    check_session($type_session, $root, $name_file, $conectareDB);
    $scope = basename(__DIR__);
    echo create_page($scope, $title, $root, $conectareDB);
?>