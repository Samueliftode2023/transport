<?php
    $obj_labels = [
        [
            "name" => "email",
            "title" => "Email",
            "type" => "email",
            "class-label" => "email-class post-rel default-label",
            "function" => "",
            "after-code" => "<button onclick='sendEmail()'>Verifica</button>"
        ],
        [
            "name" => "cod-email",
            "title" => "<br>Te rugam sa introduci codul de 6 cifre primit pe email!",
            "type" => "text",
            "class-label" => "cod-label post-rel default-label",
            "function" => 'inputmode="numeric" autocomplete="one-time-code" maxlength="6"',
            "after-code" => ""
        ]
    ];

    function email_sql($email, $conectareDB){
        $sql = 'SELECT * FROM users WHERE email = "'.$email.'"';
        $query = mysqli_query($conectareDB, $sql);
        $num_row = mysqli_num_rows($query);

        if($num_row !== 0){
            return true;
        }
        return false;
    }

    function check_email($email, $conectareDB){

        if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
            echo "Email invalid!";
            return false;
        } 
        else if (email_sql($email, $conectareDB)){
            echo "Acest email a fost deja inregistrat!";
            return false;
        }
        else if (isset($_SESSION['last-request'])){
            $time_request = time() - $_SESSION['last-request'];
            if($time_request < 60){
                echo "Pentru a cere un cod nou de verificare, trebuie sa astepti " . 60 - $time_request . " de secunde!";
                return false;
            }
        }
        return true;
    }

    function confirm_email($email){
        $cod = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $_SESSION['timp-verificare'] = time();
        $_SESSION['last-request'] = time();
        $_SESSION['code'] = $cod;
        $_SESSION['email'] = $email;

        mail($email, "Codul tău de confirmare", "Codul tău: " . $cod);
    }

    function check_code($code, $email, $conectareDB){
        
        if(!isset($_SESSION['timp-verificare'], $_SESSION['code'], $_SESSION['email'])){
            echo 'Nu ai trimis inca un cod de confirmare pe email!';
            return false;
        }
        if ($email !== $_SESSION['email']) {
            echo 'Emailul din camp nu coresupunda cu emailul la care a fost trimis codul';
            return false;
        }
        if(time() - $_SESSION['timp-verificare'] > 300){
            unset(
                $_SESSION['no-try'], 
                $_SESSION['timp-verificare'],  
                $_SESSION['code'], 
                $_SESSION['email']
            );
            echo 'Codul de confirmare este valid doar 5 minute.';
            return false;
        }
        if(isset($_SESSION['no-try'])){
                if($_SESSION['no-try'] >= 3){
                unset(
                    $_SESSION['no-try'], 
                    $_SESSION['timp-verificare'],  
                    $_SESSION['code'], 
                    $_SESSION['email']
                );
                echo 'Poti incerca maxim de 3 ori, te rugam sa ceri un cod nou!';
                return false;
            }
        }
        if($code != $_SESSION['code']){
            if(isset($_SESSION['no-try'])){
                $_SESSION['no-try'] = $_SESSION['no-try'] + 1;
            }
            else{
                $_SESSION['no-try'] = 1;
            }
            echo 'Codul pe care l-ai introdus nu corespunde cu cel de pe email.';
            return false;
        }
        return true;
    }

    function inesert_email($conectareDB){
        $email = mysqli_real_escape_string($conectareDB, InlocuireCharactere($_SESSION['email']));
        $username = mysqli_real_escape_string($conectareDB, InlocuireCharactere($_SESSION['username']));
        if (email_sql($email, $conectareDB)){
            echo "Acest email a fost deja inregistrat!";
            return false;
        }
        else{
            $sql = 'UPDATE users
                    SET email = "' . $email . '"
                    WHERE username = "' . $username . '" ;';
            if(mysqli_query($conectareDB, $sql)){
                echo 'ok';
                return true;
            }
            else{
                echo 'Ceva nu a functionat';
                return false;
            }
        }
    }    
?>