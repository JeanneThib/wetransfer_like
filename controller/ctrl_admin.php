<?php

   
    require_once 'model/mdl_admin.php';
    
    require_once 'vendor/autoload.php';
    
    $loader = new Twig_Loader_Filesystem('view');
    $twig = new Twig_Environment($loader);

    $methode = 'aes-256-cbc';
    $mdp = 'skW6UZx7t54n3i3F5NqzcL8H3Qx79W3e3StuREMp3BsH556trV';
    $iv = 'Q3G43Qci7v9ZhQ9f';

    // $curr_login = "root";
    // $curr_pass = "online@2017";

    
    $auth = 0;
    
    echo $twig->render('view_admin.twig',
    array('auth' => $auth));
    
    function ctrl_authentication() {
        
        global $twig, $base_url, $methode, $iv, $mdp, $curr_login, $curr_pass;

        $curr_login_encr = openssl_encrypt($curr_login,$methode,$mdp,0,$iv);

        
        $auth = bdd_authentication($curr_login_encr);

        if($auth != NULL) {
        
            // if(isset($auth) && $auth != NULL) {

            $crypt_login = openssl_decrypt($auth[0]["login"],$methode,$mdp,0,$iv);
            $crypt_pass = openssl_decrypt($auth[0]["password"],$methode,$mdp,0,$iv);

            
            $isLogin = !empty($crypt_login);
            $isPassword = !empty($crypt_pass);
            

            if($curr_login === $crypt_login && $curr_pass === $crypt_pass && $isLogin && $isPassword) {

                session_start();

                $_SESSION["authenticated"] = 'true';
                $_SESSION["login"] = $curr_login;
                header('Location: dashboard'); 

                // if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
                //     header('Location: ctrl_admin.php');
                // }

                // echo $twig->render('view_dashboard.twig',
                // array('auth' => $auth));

            } else {
                true;
            }
        } else {
            true;
        }

    };
    ctrl_authentication();


?>

