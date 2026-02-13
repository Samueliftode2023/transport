<?php
    session_start();
    include_once $root.'included/data-base/index.php';

    function InlocuireCharactere($StringDeCorectat){
        $StringDeCorectat = str_Replace("  "," ",$StringDeCorectat);
         if (strpos($StringDeCorectat, "  ") !== false){
             $StringDeCorectat=InlocuireCharactere($StringDeCorectat);
         };
         //Verificam daca stringul are un spatiu la INCEPUT daca exista il eliminam
         if (substr($StringDeCorectat, 0, 1)===' '){
             $StringDeCorectat=substr($StringDeCorectat, 1, strlen($StringDeCorectat));
             //echo $StringDeCorectat;	
         };
         //Verificam daca stringul are un spatiu la SFARSIT daca exista il eliminam
        if (substr($StringDeCorectat, -1)===' '){
             $StringDeCorectat=substr($StringDeCorectat, 0, -1);
         };
         return $StringDeCorectat;
    };
    // VERIFICAM DACA FISIRIELE EXISTA
        function verify_file($path){
            if(!file_exists($path)){
                file_put_contents($path, '');
            }
        }
    //
    // ORDONAM CODUL SI FACEM PAGINI
        function create_page($scope, $title, $root, $conectareDB){

            $code = array(
                'navigation' => $root.'included/html/body/navigation.php',
                'access-navigation' => $root.'included/html/body/access-navigation.php',
                'css' => $root.'included/function/css/'.$scope.'.css',
                'script' => $root.'included/function/script/'.$scope.'.js',
                'php' =>  $root.'included/function/php/'.$scope.'.php',
                'head' => $root.'included/html/head/'.$scope.'.php',
                'body' => $root.'included/html/body/'.$scope.'.php',
                'exe' => $root.'included/function/exe/'.$scope.'.php',
                'display' => $root.'included/html/body/display.php'
            );

            foreach ($code as $cheie => $valoare) {
                verify_file($valoare);
            }

            $name_folder = dirname($_SERVER['PHP_SELF']);
            $check_root = explode('/',$name_folder);
            $nav = in_array('access', $check_root) ? $code['access-navigation'] : $code['navigation'];
            
            include_once $root.'included/html/composer.php';
        }
    // 
    //  VERIFICAM DACA DATELE USERULUI SUNT IN BD
        function check_user($username, $password, $name_base, $name_file, $data_base, $root){
            $cale_fisier = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $dir_name = basename($cale_fisier);
            
            $sql = 'SELECT * FROM '.$name_base.' WHERE username = "'.$username.'"';
            $query =  mysqli_query($data_base, $sql);
            $exist_user = mysqli_num_rows($query);

            if($exist_user == 0){
                echo 'Acest nume nu exista in baza de date.';
                session_destroy();
                return false;
            }
            else{
                $user_row =  mysqli_fetch_assoc($query);
                if(!password_verify($password, $user_row['password'])){
                    echo 'Parola nu se potriveste.';
                    session_destroy();
                    return false;
                }
                else if($user_row['email'] == 'inactiv' && $dir_name !== 'confirm-email' && $name_file !== 'confirm-email.php'){
                    header('Location:'.$root.'main/confirm-email/');
                    exit;
                }
                if($user_row['email'] !== 'inactiv' && $dir_name == 'confirm-email'){
                    header('Location:'.$root.'main/dashboard/');
                    exit;
                }
            }
            return true;
        }
    // 
    // VERIFICAM DACA SESIUNEA ESTE CORECTA
        function check_session($type_session, $root, $name_file, $conectareDB){
            if($type_session === 'important'){
                if(!isset($_SESSION['username']) && !isset($_SESSION['password'])){
                    header('Location:'.$root.'');
                    exit;
                }
                else{
                    check_user($_SESSION['username'], $_SESSION['password'], 'users', $name_file, $conectareDB, $root);
                }
            }
            else if($type_session === 'unimportant'){
                if(isset($_SESSION['username']) && isset($_SESSION['password'])){
                    header('Location:'.$root.'main/');
                    exit;
                }
            }
        }
    //
    // VERIFICAM ROBOTII
        function check_robot(){
            $secretKey  = '6LevXBAgAAAAAEuIYCKl8V_ED2hw6cu5u1KEmuCu';
            
            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 
                $responseData = json_decode($verifyResponse);         
                if($responseData->success){ 
                    return true;
                }
                else{
                    echo 'Completarea campului NU SUNT ROBOT - este necesara!';
                    return false;
                }
            }
            else{
                echo 'Completarea campului NU SUNT ROBOT - este necesara!';
                return false;
            }
        }
    //
    // INSERT DATA IN TABLE
        function insert_data($data_base, $name_table, $columns, $value){
            $sql = "INSERT INTO ".$name_table." (".$columns.")
            VALUES (".$value.")";
            mysqli_query($data_base, $sql);
        }    
    //
    // SORTARE AFLABETIAC ARRAY CU OBIECTE
        function comparare_alfabetica($a, $b) {
            // $collator = collator_create('ro_RO'); 
            // return $collator->compare($a->nume, $b->nume);
            $a_lower = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $a->nume));
            $b_lower = mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $b->nume));
            return strcasecmp($a_lower, $b_lower);
        }
    //
   // CREATE LABELS
        function create_labels($obj){
            $count_labels = count($obj);

            for ($i=0; $i < $count_labels; $i++) { 
                echo "<label class = '" . $obj[$i]["class-label"] . "'>
                    <div>
                        ".$obj[$i]["title"]."
                    </div>
                    <input 
                        id = '" . $obj[$i]["name"] . "' 
                        type = '" . $obj[$i]["type"] . "' 
                        name = '" . $obj[$i]["name"] . "'
                        " . $obj[$i]["function"] . "
                    >" . $obj[$i]["after-code"] . "
                </label>";
            }
        }
    //
    // FUNCTIE DE CREARE SELECT CU OPTIUNI DIN SQL
        function create_select($obj, $conectareDB){
            $nume_tabel = $_SESSION['username'] . '_vehicule';

            $sql = 'SELECT * FROM '.$nume_tabel.'';
            $query =  mysqli_query($conectareDB, $sql);
            $exist_user = mysqli_num_rows($query);

            echo '<label class="' . $obj["class-label"] . '">' . $obj['title'] . '<select name="' . $obj['name'] . '">';
                echo '<option value="...">...</option>';
                if($exist_user > 0){
                    while($row = mysqli_fetch_assoc($query)){
                        echo '<option value="' . $row['id'] . '">' . $row['numar'] . '</option>';
                    }
                }

            echo '</select></label>';
        }
    //
    // FUNCTIE DE CREARE TABEL
        function create_table($conectareDB){
            $sql = "
                CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    status VARCHAR(100) NOT NULL,
                    data_creation VARCHAR(100) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ";

            // Execută SQL-ul
            if ($conectareDB->query($sql) === TRUE) {
                echo "Tabelul 'users' a fost creat cu succes.";
            } else {
                echo "Eroare la crearea tabelului: " . $conectareDB->error;
            }

            $conectareDB->close();
        }
    // 
    // GOOGLE ICONS
        function google_icons($icon){
            for ($i=0; $i < count($icon); $i++) { 
                echo '<span class="material-symbols-outlined">
                    ' . $icon[$i] . '
                </span>';
            }
        }
    //
    // FUNCTIE DE VERIFICARE A DATEI SI FORMATULUI
        function verifica_data_format($data){
            // Lista de formate acceptate
            $formate = [
                'Y-m-d',   // 2026-01-29
                'd/m/Y',   // 29/01/2026
                'm-d-Y',   // 01-29-2026
                'd-m-Y',   // 29-01-2026
                'Y/m/d',   // 2026/01/29
                'd.m.Y',   // 29.01.2026
                'm.d.Y',   // 01.29.2026
                'Y.m.d'    // 2026.01.29
            ];

            foreach ($formate as $format) {
                $d = DateTime::createFromFormat($format, $data);
                if ($d && $d->format($format) === $data) {
                    return true; 
                }
            }

            return false;
        }    
    //

    //  FUNCTII EXTRACTIE DE DATE
        function tabel_valori($id, $tabelul, $coloana, $conectareDB){
            $id = mysqli_real_escape_string($conectareDB, $id);
            $tabelul = mysqli_real_escape_string($conectareDB, $tabelul);

            $sql = 'SELECT * FROM ' . $tabelul . '
            WHERE id="' . $id . '"';
            $query =  mysqli_query($conectareDB, $sql);
            $exist_user = mysqli_num_rows($query);

            if($exist_user !== 0){
                $row = mysqli_fetch_assoc($query);
                return $row[$coloana];
            }

            return 0;
        }

    //
?>