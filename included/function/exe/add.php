<?php
    $name_file = basename(__FILE__);
    $root = '../../../'; 
    $type_session = 'important';
    include_once $root.'included/function/php/common.php';
    include_once $root.'included/function/php/add.php';
    check_session($type_session, $root, $name_file, $conectareDB);

    if(isset($_POST['edite-table'])){
        if(check_date_edit_vehicul($conectareDB, $_POST['edite-table'])){
            edit_table($conectareDB,);
        }
    }
    else if(isset($_POST['judet'])){
        if(check_date_vehicul($conectareDB)){
            if(dublura_sql($conectareDB)){
                adaugare_vehicul($conectareDB);
            }
        }
    }
    else if(isset($_POST['check-base-date'])){
        check_db($conectareDB);
    }
    else if(isset($_POST['id-delete'])){
        delete_row($_POST['id-delete'], $conectareDB);
    }
    else{
        header('Location:'.$root.'');
        exit;
    }
?>