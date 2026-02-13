<?php

    $obj_vehicule = [
        "name" => "camion",
        "title" => "Alege camionul",
        "class-label" => "default-label",
        "function" => "",
        "after-code" => "" 
    ];

    $obj_deplasare = [
        [
            "name" => "sofer",
            "title" => "Nume sofer:",
            "type" => "text",
            "class-label" => "default-label",
            "function" => "",
            "after-code" => ""
        ],
        [
            "name" => "decontare",
            "title" => "Numar decont:",
            "type" => "number",
            "class-label" => "default-label",
            "function" => "value='0' min='0'",
            "after-code" => ""
        ],
        [
            "name" => "data-plecare",
            "title" => "Data plecarii:",
            "type" => "date",
            "class-label" => "default-label",
            "function" => "",
            "after-code" => ""
        ],        [
            "name" => "data-sosirii",
            "title" => "Data sosirii:",
            "type" => "date",
            "class-label" => "default-label",
            "function" => "",
            "after-code" => ""
        ],
        [
            "name" => "km-plecare",
            "title" => "Kilometraj plecare:",
            "type" => "number",
            "class-label" => "default-label",
            "function" => "value='0' min='0'",
            "after-code" => ""
        ],
        [
            "name" => "km-sosire",
            "title" => "Kilometraj sosire:",
            "type" => "number",
            "class-label" => "default-label",
            "function" => "value='0' min='0'",
            "after-code" => ""
        ],
        [
            "name" => "combustibil-plecare",
            "title" => "Combustibul plecare:",
            "type" => "number",
            "class-label" => "default-label",
            "function" => "value='0' min='0'",
            "after-code" => ""
        ],
        [
            "name" => "combustibil-sosire",
            "title" => "Combustibul sosire:",
            "type" => "number",
            "class-label" => "default-label",
            "function" => "value='0' min='0'",
            "after-code" => ""
        ]
    ];

    $obj_document = [
        [
            "name" => "foaie-parcurs",
            "title" => "Foaie de parcurs nr.:",
            "type" => "number",
            "class-label" => "default-label",
            "function" => "min='0' value='0'",
            "after-code" => ""
        ],
        [
            "name" => "ordin-deplasare",
            "title" => "Ordin de deplasare:",
            "type" => "text",
            "class-label" => "default-label",
            "function" => "",
            "after-code" => ""
        ],
        [
            "name" => "bani-cash",
            "title" => "Bani primiti (cash):",
            "type" => "number",
            "class-label" => "default-label select-input-line",
            "function" => "value='0' min='0'",
            "after-code" => "<select name='moneda-cash'><option value='ron'>RON</option><option value='eur'>EURO</option></select>"
        ],
        [
            "name" => "bani-card",
            "title" => "Bani primiti (card):",
            "type" => "number",
            "class-label" => "default-label select-input-line",
            "function" => "value='0' min='0'",
            "after-code" => "<select name='moneda-card'><option value='ron'>RON</option><option value='eur'>EURO</option></select>"
        ],
        [
            "name" => "observatie-bani",
            "title" => "Observatii:",
            "type" => "text",
            "class-label" => "default-label",
            "function" => "",
            "after-code" => ""            
        ]
    ];

    $obj_alimentare = [
        [
            "name" => "localitate-alimentare-0",
            "title" => "Localitate",
            "type" => "text",
            "class-label" => "default-label",
            "function" => "",
            "after-code" => ""
        ],
        [
            "name" => "data-alimentare-0",
            "title" => "Data alimentarii",
            "type" => "date",
            "class-label" => "default-label",
            "function" => "",
            "after-code" => ""
        ],        
        [
            "name" => "km-alimentare-0",
            "title" => "Kilometraj",
            "type" => "number",
            "class-label" => "default-label",
            "function" => "value='0' min='0'",
            "after-code" => ""
        ],
        [
            "name" => "litri-alimentare-0",
            "title" => "Litri",
            "type" => "number",
            "class-label" => "default-label",
            "function" => "value='0' min='0'",
            "after-code" => ""
        ],
        [
            "name" => "observatii-alimentare-0",
            "title" => "Observatii",
            "type" => "text",
            "class-label" => "default-label",
            "function" => "",
            "after-code" => ""
        ]        
    ];

    // FUNCTIE DE CREARE A TABELULUI
        function create_table_raport($conectareDB){
            $table_rapoarte = $_SESSION['username'] . '_rapoarte';
            $query = "SHOW TABLES LIKE '" . $table_rapoarte . "'";
            $result = mysqli_query($conectareDB, $query);

            if(mysqli_num_rows($result) === 0){
                $sql_rapoarte = "
                    CREATE TABLE IF NOT EXISTS " . $table_rapoarte . " (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        fisa_id INT NOT NULL,
                        vehicul_id INT NOT NULL,
                        categorie VARCHAR(100) NOT NULL,
                        valoare TEXT NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                ";
                if(!mysqli_query($conectareDB, $sql_rapoarte)){
                    echo 'eroare';
                    return false;
                }
                else{
                    echo '0';
                    return true;
                }      
            }
            else{
                $sql = "SELECT MAX(fisa_id) AS fisa_max FROM " . $_SESSION['username'] . "_rapoarte";
                $result = mysqli_query($conectareDB, $sql);

                if($row = mysqli_fetch_assoc($result)){
                    if(is_null($row['fisa_max'])){
                        echo 0;
                    }
                    else{
                        echo $row['fisa_max'] = $row['fisa_max'] + 1;
                    }
                }
            }
        }
    //

    // FUNCTII DE VERIFICARE A DATEI
        function intervale_timp($vehicul_id, $conectareDB){
            $vehicul_id = mysqli_real_escape_string($conectareDB, $vehicul_id);
            $sql = "SELECT * FROM " . $_SESSION['username'] . "_rapoarte
            WHERE vehicul_id = '" . $vehicul_id . "'";
            $date = [];
            $result = mysqli_query($conectareDB, $sql);
            $exist = mysqli_num_rows($result);

            if($exist != 0){
                while($row = mysqli_fetch_assoc($result)){
                    if ($row['categorie'] === 'data-plecare' ||
                        $row['categorie'] === 'data-sosirii' ||
                        $row['categorie'] === 'km-plecare' ||
                        $row['categorie'] === 'km-sosire'
                    ) 
                    {
                        $date[$row['fisa_id']][$row['categorie']] = $row['valoare'];
                    }
                }
            }
            else{
                return false;
            }
            return $date;
        }   
    //

    function creaza_fisa($obj, $conectareDB){
        if(count($obj) > 501){
            echo 'EROARE - 500 INPUT';
            return false;
        }
        foreach ($obj as $key => $value) {                    
            $obj[$key] = InlocuireCharactere($value);
        }  
        if($obj['camion'] == '...'){
            echo 'Alege un camion!';
            return false;
        }

        $tabel_vehicule = $_SESSION['username'] . '_vehicule';
        $tabel_rapoarte = $_SESSION['username'] . '_rapoarte';
        $tabel_vehicule = mysqli_real_escape_string($conectareDB, $tabel_vehicule);
        $tabel_rapoarte = mysqli_real_escape_string($conectareDB, $tabel_rapoarte);
        $obj['camion'] = mysqli_real_escape_string($conectareDB, $obj['camion']);

        $sql = 'SELECT "vehicul_id" FROM ' . $tabel_vehicule . ' 
        WHERE id = "' . $obj['camion'] . '"';

        $query =  mysqli_query($conectareDB, $sql);
        $exist_user = mysqli_num_rows($query);

        if($exist_user == 0){
            echo 'Acest numar de inmatriculare nu exista in baza de date!';
            return false;
        }

        //  NUME SOFER
            if(isset($obj['sofer'])){
                if(strlen($obj['sofer']) > 100){
                    echo 'Numele soferului este prea lung';
                    return false;
                }
                if(strlen($obj['sofer']) < 1){
                    echo 'Numele soferului este prea scurt';
                    return false;
                }
            }
            else{
                echo 'Lipseste numele soferului!';
                return false;
            }
        //

        // CONDITII DE VERIFICARE A DATEI
            $date = ['data-plecare', 'data-sosirii'];

            for ($i=0; $i < count($date); $i++) { 
                if(empty($obj[$date[$i]])){
                    echo 'Alege ' . $date[$i] . '!';
                    return false;
                }
                if(!verifica_data_format($obj[$date[$i]])){
                    echo 'Format dată invalid';
                    return false;
                }
            }

            $d1 = new DateTime($obj['data-plecare']);
            $d2 = new DateTime($obj['data-sosirii']);

            if ($d1 > $d2) {
                echo 'Data de plecare trebuie să fie mai mică decât data sosirii';
                return false;
            }

            if ($data_fisa = intervale_timp($obj['camion'], $conectareDB)){
                foreach ($data_fisa as $cheie => $interval) { 
                    $d3 = new DateTime($interval['data-plecare']);
                    $d4 = new DateTime($interval['data-sosirii']);

                    if ($d1 < $d4 && $d2 > $d3) {
                        echo 'Intervalul de timp se intersectează cu intervalul altei fișe!';
                        return false;
                    }
                }
            }
        //

            // VERIFICARE KILOMETRAJ, COMBUSTIBUL, BANI PLECARE SI SOSIRE
                $arr = ['km-plecare', 'km-sosire', 'combustibil-plecare',
                    'combustibil-plecare', 'combustibil-sosire', 'bani-cash',
                    'bani-card', 'decontare', 'foaie-parcurs'
                ];

                for ($i=0; $i < count($arr); $i++) { 
                    if(!is_numeric($obj[$arr[$i]]) || $obj[$arr[$i]] > 10000000000000000){
                        echo $arr[$i] . ' trebuie sa fie format doar din cifre 
                            si nu trebuie mai mult de 17 caractere!';
                        return false;
                    }
                }
            //

            // KILOMETRAJ
                if($obj[$arr[0]] >= $obj[$arr[1]]){
                    echo 'Kilometrajul de sosire trebuie sa fie mai mare decat cel de plecare!';
                    return false;
                }

                $km_inregistrare = (int)tabel_valori($obj['camion'], $tabel_vehicule, 'numar_km', $conectareDB);
                $km_plecare = (int)$obj[$arr[0]];
                $km_sosire = (int)$obj[$arr[1]];

                if($km_inregistrare > $km_plecare){
                    echo 'Kilometrajul de plecare este mai mic decat kilometrajul cu care
                    a fost inregistrat vehiculul (' . $km_inregistrare . ' > ' .  $km_plecare . ')';
                    return false;
                }
                
                if ($data_fisa = intervale_timp($obj['camion'], $conectareDB)){                
                    foreach ($data_fisa as $key => $interval) {
                        $d3 = new DateTime($interval['data-plecare']);
                        $d4 = new DateTime($interval['data-sosirii']);
                        $km1 = (int)$interval['km-plecare'];
                        $km2 = (int)$interval['km-sosire'];

                        if($km_plecare < $km2 && $km_sosire > $km1){
                            echo 'Kilometrii din aceasta fisa se intersecteaza cu 
                            kilometrii din fisa: ' . $key;
                            return false;
                        }

                        if($km_plecare == $km2 && $km_sosire == $km1){
                            echo 'Kilometrii din aceasta fisa se intersecteaza cu 
                            kilometrii din fisa: ' . $key;
                            return false;
                        }

                        if($d2 <= $d3 && $d1 < $d3){
                            if($km_plecare > $km2){
                                echo 'Data si kilometrajul se intersecteaza cu data si 
                                kilometrajul fisei: ' . $key;
                                return false;
                            }
                        }

                        if($d1 >= $d4 && $d2 > $d4){
                            if($km_sosire < $km1){
                                echo 'Data si kilometrajul se intersecteaza cu data si 
                                kilometrajul fisei: ' . $key;
                                return false;
                            }
                        }
                    }
                }    
            //

            // COMBUSTIBUL 
                $ultima_alimentare = 0;
                foreach($obj as $key => $value){
                    if(str_contains($key, 'localitate-alimentare-')){
                        $numar_alimentare = explode('-', $key)[2];
                        $alimentare = [
                            'localitate-alimentare-' . $numar_alimentare . '',
                            'data-alimentare-' . $numar_alimentare . '',
                            'km-alimentare-' . $numar_alimentare . '',
                            'litri-alimentare-' . $numar_alimentare . '',
                            'observatii-alimentare-' . $numar_alimentare . ''
                        ];

                        if(
                            strlen($obj[$alimentare[0]]) > 0 || 
                            verifica_data_format($obj[$alimentare[1]]) || 
                            $obj[$alimentare[2]] > 0 || 
                            $obj[$alimentare[3]] > 0 
                        )
                        {
                            if(strlen($obj[$alimentare[0]]) < 1){
                                echo 'Completeaza localitatea de la combustibul 
                                la combustibil ' . $numar_alimentare . '!';
                                return false;
                            }
                            if(!verifica_data_format($obj[$alimentare[1]])){
                                echo 'Alege o data valida la combustibil ' . $numar_alimentare . '!';
                                return false;
                            }

                            $d1 = new DateTime($obj['data-plecare']);
                            $d2 = new DateTime($obj['data-sosirii']);
                            $d3 = new DateTime($obj[$alimentare[1]]);

                            if($d3 > $d2 || $d3 < $d1){
                                echo 'Data alimentarii (' . $numar_alimentare . ') trebuie sa fie cuprinsa 
                                intre intervalul data plecarii si data sosirii!';
                                return false;
                            }
                            if($obj[$alimentare[2]] == 0 || !is_numeric($obj[$alimentare[2]])){
                                echo 'Kilometrajul trebuie sa fie mai mare de 0 la combustibil!';
                                return false;
                            }
                            if(
                                $obj[$alimentare[2]] < $obj['km-plecare'] || 
                                $obj[$alimentare[2]] > $obj['km-sosire']
                            )
                            {
                                echo 'Kilometrajul de plecare nu poate fi mai mare decat 
                                kilometrajul la alimentare, iar kilometreajul de sosire
                                nu poate fi mai mic!';
                                return false;
                            }
                            if($obj[$alimentare[3]] == 0 || !is_numeric($obj[$alimentare[3]])){
                                echo 'Litri trebuie sa fie mai mult de 0 la combustibil!';
                                return false;
                            }
                            if($numar_alimentare != 0 && isset($obj['km-alimentare-' . $ultima_alimentare])){
                                $d4 = new DateTime($obj['data-alimentare-' . $ultima_alimentare]);

                                if($obj[$alimentare[2]] < $obj['km-alimentare-' . $ultima_alimentare]){
                                    echo 'Alimentarea ' . $numar_alimentare . ' nu poate fi mai mica sau 
                                    egala cu alimentrea ' . $ultima_alimentare . '';
                                    return false;
                                }
                                if($d4 > $d3){
                                    echo 'Data de alimentare trebuie sa fie mai mare sau 
                                    egala cu cea anterioara (eroare la 
                                    c:' . $numar_alimentare . ' > c:' . $ultima_alimentare .')';
                                    return false;
                                }
                                $ultima_alimentare = $numar_alimentare;
                            }
                        }
                        else{
                            foreach ($alimentare as $key) {
                                unset($obj[$key]);
                            }
                        }
                    }
                    if(str_contains($key, 'tur-actiune-') || str_contains($key, 'retur-actiune-')){
                        $sectiune = explode('-', $key);
                        $tur_retur = [
                            $sectiune[0] . '-actiune-' . $sectiune[2] . '', 
                            $sectiune[0] . '-nume-firma-'. $sectiune[2] . '',
                            $sectiune[0] . '-nume-localitate-'. $sectiune[2] . '',
                            $sectiune[0] . '-observatii-'. $sectiune[2] . ''
                        ];

                        if(
                            $obj[$tur_retur[0]] == 0 &&
                            strlen($obj[$tur_retur[1]]) == 0 &&
                            strlen($obj[$tur_retur[2]]) == 0 &&
                            strlen($obj[$tur_retur[3]]) == 0
                        ){
                            foreach ($tur_retur as $key) {
                                unset($obj[$key]);
                            }
                        }
                    }
                }
            //

            
            $sql = "SELECT MAX(fisa_id) AS fisa_max FROM " . $tabel_rapoarte;
            $result = mysqli_query($conectareDB, $sql);

            if($row = mysqli_fetch_assoc($result)){
                if(is_null($row['fisa_max'])){
                    $row['fisa_max'] = 0;
                }
                else{
                    $row['fisa_max'] = $row['fisa_max'] + 1;
                }
                foreach ($obj as $key => $value) {
                    if($key != 'camion'){
                        $key = mysqli_real_escape_string($conectareDB, $key);
                        $value = mysqli_real_escape_string($conectareDB, $value);

                        $columns = "fisa_id, vehicul_id, categorie, valoare";
                        $value = "'" . $row['fisa_max'] . "','" . $obj['camion']
                                    . "','" . $key . "','" . $value  . "'";
                        
                        insert_data($conectareDB, $tabel_rapoarte, $columns, $value);
                    }                
                }
                echo 'ok';
            }
                    
    }
?>
