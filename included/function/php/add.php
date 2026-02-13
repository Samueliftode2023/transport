<?php
    $obj_labels = [
        [
            "name" => "judet",
            "title" => "Numar de imatriculare",
            "type" => "text",
            "class-label" => "default-label numar-inmatriculare",
            "function" => "maxlength='2' placeholder='B'",
            "after-code" => "<input maxlength='3' placeholder='123' id='numar' name='numar'><input maxlength='3' id='litere' placeholder='VJV' name='litere'>"
        ],
        [
            "name" => "asigurare",
            "title" => "RCA - data de expirare",
            "type" => "date",
            "class-label" => "default-label",
            "function" => "",
            "after-code" => ""
        ],
        [
            "name" => "inspectia",
            "title" => "ITP - data de expirare",
            "type" => "date",
            "class-label" => "default-label",
            "function" => "",
            "after-code" => ""
        ],
        [
            "name" => "vigneta",
            "title" => "Taxa de drum (vigneta)",
            "type" => "date",
            "class-label" => "default-label",
            "function" => "",
            "after-code" => ""
        ],
        [
            "name" => "numar-km",
            "title" => "Numar de km",
            "type" => "number",
            "class-label" => "default-label",
            "function" => "value='0' min='0'",
            "after-code" => ""
        ],
        [
            "name" => "ulei-km",
            "title" => "Schimb de ulei km",
            "type" => "number",
            "class-label" => "default-label",
            "function" => "min='0' value='10000'",
            "after-code" => ""
        ],
        [
            "name" => "pretul",
            "title" => "Pretul vehiculului (€)",
            "type" => "number",
            "class-label" => "default-label",
            "function" => "min='0' value='0'",
            "after-code" => ""
        ]
    ];

    $categorie_permis = [
        "MOTOCICLETĂ (A)",
        "AUTOTURISM (B)",
        "AUTOCAMION (C)",
        "AUTOBUZ (D)",
        "AUTOTURISM CU REMORCĂ (BE)",
        "AUTOCAMION CU REMORCĂ (CE)",
        "AUTOBUZ CU REMORCĂ (DE)",
        "MOTOCICLETĂ UȘOARĂ (A1)",
        "QUADRICICLU (B1)",
        "CAMION UȘOR (C1)",
        "MICROBUZ (D1)",
        "CAMION UȘOR CU REMORCĂ (C1E)",
        "MICROBUZ CU REMORCĂ (D1E)",
        "NEDEFINITĂ"
    ];

    $judete = [
        "AB", "AR", "AG", "BC", "BH", "BN",
        "BR", "BT", "BV", "BZ", "CL", "CS",
        "CJ", "CT", "CV", "DB", "DJ", "GL",
        "GR", "GJ", "HR", "HD", "IL", "IS",
        "IF", "MM", "MH", "MS", "NT", "OT",
        "PH", "SM", "SJ", "SB", "SV", "TR",
        "TM", "TL", "VS", "VL", "VN", "B"
    ];

    $tip_transport = [
        "NEDEFINITĂ", 
        "TAXI", 
        "ȘCOALĂ DE ȘOFERI",
        "TRANSPORT MARFĂ", 
        "TRANSPORT PERSOANE",
        "TRANSPORT PUBLIC", 
        "VEHICUL PERSONAL"
    ];

    $vechime = [
        'ÎNTRE 0 ȘI 3 ANI',
        'ÎNTRE 4 ȘI 12 ANI',
        'MAI MULT DE 12 ANI',
        'NEDEFINITĂ'
    ];

    $campuri = [
        "categorie-vehicule",
        "vechime-masina",
        "tip-transport",
        "judet",
        "numar",
        "litere",
        "asigurare",
        "inspectia",
        "vigneta",
        "numar-km",
        "ulei-km",
        "pretul"
    ];

    function este_data($string) {
        $formate = ['Y-m-d', 'd-m-Y', 'd/m/Y', 'd.m.Y'];

        foreach ($formate as $format) {
            $d = DateTime::createFromFormat($format, $string);
            if ($d && $d->format($format) === $string) {
                return true;
            }
        }
        return false;
    }

    function check_date_vehicul($conectareDB){
        global $campuri, $categorie_permis, $judete, $tip_transport, $vechime;
        
        for ($i=0; $i < count($campuri); $i++) { 
            if(!isset($_POST[$campuri[$i]])){
                echo 'A aparut o eroare campul: "' . $campuri[$i] . '"!';
                return false;
            }
            else{
                $_POST[$campuri[$i]] =  mysqli_real_escape_string($conectareDB, InlocuireCharactere(mb_strtoupper($_POST[$campuri[$i]], 'UTF-8')));

                if($campuri[$i] == "categorie-vehicule"){
                    if(!in_array($_POST[$campuri[$i]], $categorie_permis)){
                        echo 'A aparut o eroare campul: "' . $campuri[$i] . '"!';
                        return false;
                    }
                }
                if($campuri[$i] == "judet"){
                    if(!in_array($_POST[$campuri[$i]], $judete)){
                        echo 'Prescurtarea de judet "' . $_POST[$campuri[$i]] . '" nu exista!';
                        return false;
                    }
                }
                if($campuri[$i] == "numar"){
                    if (!ctype_digit($_POST[$campuri[$i]])) {
                        echo 'Numarul de pe placuta de inmatriculare nu respecta formatul aprobat de lege!';
                        return false;
                    }

                    $lungime = strlen($_POST[$campuri[$i]]);

                    if ($lungime > 3 || $lungime < 2) {
                        echo 'Numarul de pe placuta de inmatriculare nu respecta formatul prevazut de lege!';
                        return false;
                    }
                }
                if($campuri[$i] == "litere"){
                    if (strlen($_POST[$campuri[$i]]) !== 3) {
                        echo 'Literele de pe placuta de inmatriculare nu respecta formatul prevazut de lege!';
                        return false;
                    }

                    if (!preg_match('/^[A-Z]{3}$/', $_POST[$campuri[$i]])) {
                        echo 'Literele de pe placuta de inmatriculare nu respecta formatul prevazut de lege!';
                        return false;
                    } 
                }
                if($campuri[$i] == "vechime-masina"){
                    if(!in_array($_POST[$campuri[$i]], $vechime)){
                        echo 'A aparut o eroare la campul ' . $_POST[$campuri[$i]] . '';
                        return false;
                    }
                }
                if($campuri[$i] == "tip-transport"){

                    if(!in_array($_POST[$campuri[$i]], $tip_transport)){
                        echo 'A aparut o eroare la campul ' . $_POST[$campuri[$i]] . '';
                        print_r($tip_transport);
                        return false;
                    }
                }
                if(in_array($campuri[$i], ["asigurare", "inspectia", "vigneta"])){
                    if($_POST[$campuri[$i]] == ''){
                        $_POST[$campuri[$i]] = 'NEDEFINITĂ';
                    }
                    else if(!este_data($_POST[$campuri[$i]])){
                        echo 'Acest format de data este invalid: ' . $_POST[$campuri[$i]] . '';
                        return false;
                    }
                }
                if(in_array($campuri[$i], ["numar-km", "ulei-km", "pretul"])){
                    if($_POST[$campuri[$i]] == ''){
                        $_POST[$campuri[$i]] = 0;
                    }
                    else if($_POST[$campuri[$i]] < 0 || $_POST[$campuri[$i]] > 10000000000){
                        echo 'Acest format de data este invalid: ' . $_POST[$campuri[$i]] . '';
                        return false;
                    }
                    else if (!ctype_digit($_POST[$campuri[$i]])) {
                        echo 'Eroare la campul '. $campuri[$i];
                        return false;
                    }
                }
            }
        }
        return true;
    }

    function check_id($id){
        return true;
    }

    function check_date_edit_vehicul($conectareDB, $id){
        global $campuri, $categorie_permis, $judete, $tip_transport, $vechime;

        foreach ($_POST as $key => $value) {
            $_POST[$key] = mysqli_real_escape_string(
                $conectareDB,
                InlocuireCharactere(
                    mb_strtoupper($value, 'UTF-8')
                )
            );
        }

        if(check_id($id)){
            if(isset($_POST['judet-editabil'], $_POST['numar-editabil'], $_POST['litere-editabile'])){
                if(!in_array($_POST['judet-editabil'], $judete)){
                    echo 'Prescurtarea de judet "' . $_POST['judet-editabil'] . '" nu exista!';
                    return false;
                }

                if (!ctype_digit($_POST['numar-editabil'])) {
                    echo 'Numarul de pe placuta de inmatriculare nu respecta formatul aprobat de lege!';
                    return false;
                }

                $lungime = strlen($_POST['numar-editabil']);

                if ($lungime > 3 || $lungime < 2) {
                    echo 'Numarul de pe placuta de inmatriculare nu respecta formatul prevazut de lege!';
                    return false;
                }

                if (strlen($_POST['litere-editabile']) !== 3) {
                    echo 'Literele de pe placuta de inmatriculare nu respecta formatul prevazut de lege!';
                    return false;
                }

                if (!preg_match('/^[A-Z]{3}$/', $_POST['litere-editabile'])) {
                    echo 'Literele de pe placuta de inmatriculare nu respecta formatul prevazut de lege!';
                    return false;
                } 
                $tableName = $_SESSION['username'] . '_vehicule';
                $_POST['numar'] = $_POST['judet-editabil'] . '-' . $_POST['numar-editabil'] . '-' . $_POST['litere-editabile'];
                
                $sql = 'SELECT * FROM ' . $tableName . ' 
                    WHERE numar = "' . $_POST['numar'] . '"
                ';
                $query =  mysqli_query($conectareDB, $sql);
                $exist_user = mysqli_num_rows($query);

                if($exist_user > 0){
                    echo 'Acest numar de inmatriculare exista in baza de date!';
                    return false;
                }

                unset($_POST['judet-editabil'], $_POST['numar-editabil'], $_POST['litere-editabile']);
            }
            else if(isset($_POST['vechime'])){
                if(!in_array($_POST['vechime'], $vechime)){
                    echo 'A aparut o eroare la campul ' . $_POST[$campuri[$i]] . '';
                    return false;
                }
            }
            else if(isset($_POST['tip_transport'])){
                if(!in_array($_POST['tip_transport'], $tip_transport)){
                    echo 'A aparut o eroare la campul ' . $_POST['tip_transport'] . '';
                    print_r($tip_transport);
                    return false;
                }
            }
            else if(isset($_POST['categorie_vehicul'])){
                if(!in_array($_POST['categorie_vehicul'], $categorie_permis)){
                    echo 'A aparut o eroare la campul: "' . $_POST['categorie_vehicul'] . '"!';
                    return false;
                }
            }
            $date_limita = ['inspectie_tehnica', 'vigneta', 'asigurare'];
            $km_contuar = ["numar-km", "schimb_ulei", "pret_euro"];
            for ($i=0; $i < count($date_limita); $i++) { 
                if(isset($_POST[$date_limita[$i]])){
                    if($_POST[$date_limita[$i]] == ''){
                        $_POST[$date_limita[$i]] = 'NEDEFINITĂ';
                    }
                    else if(!este_data($_POST[$date_limita[$i]])){
                        echo 'Acest format de data este invalid: ' . $_POST[$date_limita[$i]] . '';
                        return false;
                    }
                }
            }
            
            for ($i=0; $i < count($km_contuar); $i++) { 
                if(isset($_POST[$km_contuar[$i]])){
                    if($_POST[$km_contuar[$i]] == ''){
                        $_POST[$km_contuar[$i]] = 0;
                    }
                    else if($_POST[$km_contuar[$i]] < 0 || $_POST[$km_contuar[$i]] > 10000000000){
                        echo 'Acest format de data este invalid: ' . $_POST[$km_contuar[$i]] . '';
                        return false;
                    }
                    else if (!ctype_digit($_POST[$km_contuar[$i]])) {
                        echo 'Eroare la campul '. $km_contuar[$i];
                        return false;
                    }
                }
            }
        }
        return true;
    }

    function dublura_sql($conectareDB){
        $_POST['numar-inmatriculare'] = $_POST["judet"]. '-' . $_POST["numar"] .'-' . $_POST["litere"];
        $tableName = $_SESSION['username'] . '_vehicule';

        $sql = 'SELECT * FROM ' . $tableName . ' 
                WHERE numar = "' . $_POST['numar-inmatriculare'] . '"
            ';
        $query =  mysqli_query($conectareDB, $sql);
        $exist_user = mysqli_num_rows($query);

        if($exist_user > 0){
            echo 'Acest numar de inmatriculare exista in baza de date!';
            return false;
        }
        return true;
    }

    function check_db($conectareDB){
        $tableName = $_SESSION['username'] . '_vehicule';
        $query = "SHOW TABLES LIKE '" . $tableName . "'";
        $result = mysqli_query($conectareDB, $query);

        if (!mysqli_num_rows($result) > 0) {
            $sql = "
                CREATE TABLE IF NOT EXISTS " . $tableName . " (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    numar VARCHAR(50) NOT NULL,
                    categorie_vehicul VARCHAR(255) NOT NULL,
                    vechime VARCHAR(255) NOT NULL,
                    tip_transport VARCHAR(100) NOT NULL,
                    asigurare VARCHAR(100) NOT NULL,
                    inspectie_tehnica VARCHAR(100) NOT NULL,
                    vigneta VARCHAR(100) NOT NULL,
                    numar_km VARCHAR(100) NOT NULL,
                    schimb_ulei VARCHAR(100) NOT NULL,
                    pret_euro VARCHAR(100) NOT NULL,
                    data_adaugarii VARCHAR(100) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ";
            if(!mysqli_query($conectareDB, $sql)){
                echo 'eroare';
                return false;
            }
        }   
        else{
            read_table_vehicles($conectareDB);
        }
    }

    function read_table_vehicles($conectareDB){
        $name_table = $_SESSION['username'] . '_vehicule';
        $sql = 'SELECT * FROM '.$name_table.'';
        $result = mysqli_query($conectareDB, $sql);
        $date = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $date[] = $row;
        }

        echo json_encode($date);
    }

    function adaugare_vehicul($conectareDB){
        $name_table = $_SESSION['username'] . '_vehicule';

        $columns = "numar, categorie_vehicul, vechime, tip_transport, asigurare,
        inspectie_tehnica, vigneta, numar_km, schimb_ulei, pret_euro, data_adaugarii";
        
        $value = "'".$_POST["numar-inmatriculare"]."','".$_POST["categorie-vehicule"]."','".
        $_POST["vechime-masina"]."','".$_POST["tip-transport"]."','".
        $_POST["asigurare"]."','".$_POST["inspectia"]."','".
        $_POST["vigneta"]."','".$_POST["numar-km"]."','".
        $_POST["ulei-km"]."','" . $_POST["pretul"]."','" . date('d-m-Y') . "'";

        insert_data($conectareDB, $name_table, $columns, $value);
        echo 'ok';
    }

    function edit_table($conectareDB){
        unset($_POST['edite-table']);
        $keys = array_keys($_POST);
        $tableName = $_SESSION['username'] . '_vehicule';

        for ($i=0; $i < count($keys); $i++) { 
            if($keys[$i] !== 'id'){
                $key = $keys[$i];
            }
        }

        $sql = 'UPDATE ' . $tableName . ' 
                SET ' . $key . ' =  "' . $_POST[$key] . '" 
                WHERE id = "' . $_POST['id'] . '"';
        
        if(mysqli_query($conectareDB, $sql)){
            echo 'ok';
        }
        else{
            echo 'Ceva nu a functionat. Te rugam sa reincerci!';
        }
    }

    function delete_row($id, $conectareDB){
        $tableName = $_SESSION['username'] . '_vehicule';
        $id =  mysqli_real_escape_string($conectareDB, InlocuireCharactere($id));;

        $sql = 'SELECT * FROM ' . $tableName . ' 
                WHERE id = "' . $id . '"
            ';
        $query =  mysqli_query($conectareDB, $sql);
        $exist_user = mysqli_num_rows($query);

        if($exist_user == 0){
            echo 'A aparut o eroare';
            return false;
        }
        else{
            $sql = "DELETE FROM " . $tableName . " WHERE id = " . $id . "";

            if(mysqli_query($conectareDB, $sql)){
                echo 'ok';
            }
        }
    }
?>