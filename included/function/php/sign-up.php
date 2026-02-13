<?php
    $obj_labels = [
        [
            "name" => "username",
            "title" => "Nume",
            "type" => "text",
            "class-label" => "post-rel default-label",
            "function" => "",
            "after-code" => ""
        ],
        [
            "name" => "password",
            "title" => "Parola",
            "type" => "password",
            "class-label" => "post-rel default-label",
            "function" => "",
            "after-code" => ""           
        ],
        [
            "name" => "password-repeat",
            "title" => "Confirma parola",
            "type" => "password",
            "class-label" => "post-rel default-label",
            "function" => "",
            "after-code" => ""
        ],
        [
            "name" => "condition",
            "title" => " Accept <a title='terms and conditions' href='terms-of-service/'>termenii si conditiile</a>",
            "type" => "checkbox",
            "class-label" => "post-rel default-label termeni-conditii",
            "function" => "",
            "after-code" => ""
        ]
    ];

    // VERIFICAM FORMATUL DATELOR
        function check_data_access($username, $password, $password_check, $conectareDB){
            $sql = 'SELECT * FROM users WHERE username = "'.$username.'"';
            $query = mysqli_query($conectareDB, $sql);
            $num_row = mysqli_num_rows($query);

            if($num_row !== 0){
                echo 'Acest nume exista in baza de date, te ruga sa alegi alt nume.';
                return false;
            }
            if(!isset($_POST['condition'])){
                echo 'Termenii si conditiile sunt obligatorii!';
                return false;
            }
            if(strlen($username) <= 4 || strlen($username) >= 41){
                $str_length = strlen($username);
                echo 'Numele introdus are: '.$str_length.' caractere. 
                Este necesar ca acesta sa aiba intre 5 - 40 de caractere';
                return false;
            }
            if(strpos($username, " ") !== false){
                echo 'Numele introdus continue spatii.';
                return false;
            }
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                echo "Numele poate conține doar litere, cifre și _";
                return false;
            }
            if(strlen($password) <= 7 || strlen($password) >= 41){
                $str_length = strlen($password);
                echo 'Parola introdusa are: '.$str_length.' caractere. Este necesar ca acesta sa aiba intre 8 - 40 de caractere.';
                return false;
            }
            if(!preg_match('`[A-Z]`',$password) || !preg_match('`[a-z]`',$password) || !preg_match('`[0-9]`',$password)){
                echo 'Parola trebuie sa contita o litera mare, una mica si cel putin o cifra.';
                return false;
            }
            if(strpos($password, " ") !== false){
                echo 'Parola nu trebuie sa contina spatii!';
                return false;
            }
            if($password !== $password_check){
                echo 'Parola nu a fost confirmata!';
                return false;
            }
            return true;
        }
    // 
    // CREATE NEW ACCOUNT
        function create_new_account($username, $password, $conectareDB){
            $real_password = mysqli_real_escape_string($conectareDB, $password);
            $columns = "username, password, email, status, data_creation";
            $username = strtolower($username); 
            $password = password_hash($real_password, PASSWORD_DEFAULT); 
            $email = 'inactiv';
            $status = 'inactiv';
            $date_creation = date("y-m-d");

            $value = "'" . $username . "','" . $password . "','" . 
            $email . "','" . $status . "','" . $date_creation . "'";

            insert_data($conectareDB, 'users', $columns, $value);

            $_SESSION['username'] = $username;
            $_SESSION['password'] = $real_password;
            echo 'ok';  
        }
    // 
?>


