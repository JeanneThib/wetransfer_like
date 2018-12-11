<?php

   
    require_once 'model/mdl_admin.php';
    
    require_once 'vendor/autoload.php';
    
    $loader = new Twig_Loader_Filesystem('view');
    $twig = new Twig_Environment($loader);

    $methode = 'aes-256-cbc';
    $mdp = 'skW6UZx7t54n3i3F5NqzcL8H3Qx79W3e3StuREMp3BsH556trV';
    $iv = 'Q3G43Qci7v9ZhQ9f';

    $curr_login = "root";
    $curr_pass = "online@2017";

    // var_dump(openssl_encrypt($curr_pass,$methode,$mdp,0,$iv));

    // openssl_decrypt($array['crypt'],$methode,$mdp,0,$iv)

    // $crypt_login = openssl_decrypt($curr_login,$methode,$mdp,0,$iv);
    // $crypt_pass = openssl_decrypt($curr_pass,$methode,$mdp,0,$iv);

    // var_dump($crypt_login);
    // var_dump($crypt_pass);

    $auth = 0;

    echo $twig->render('view_admin.twig',
    array('auth' => $auth));
    
    function ctrl_authentication() {

        global $twig, $base_url, $methode, $iv, $mdp, $curr_login, $curr_pass;
        $auth = bdd_authentication();

        $crypt_login = openssl_decrypt($auth[0]["login"],$methode,$mdp,0,$iv);
        $crypt_pass = openssl_decrypt($auth[0]["password"],$methode,$mdp,0,$iv);

        var_dump($crypt_login);
        var_dump($crypt_pass);

        // var_dump($auth[0]["login"]);
        // var_dump($auth[0]["password"]);
        // var_dump(!empty($auth[0]["login"]));
        // var_dump(!empty($auth[0]["password"]));
        

        $isLogin = !empty($crypt_login);
        $isPassword = !empty($crypt_pass);

        if($curr_login === $crypt_login && $curr_pass === $crypt_pass) {

            session_start();

            $_SESSION["authenticated"] = 'true';

            header('Location: dashboard'); 

            // if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
            //     header('Location: ctrl_admin.php');
            // }

            // echo $twig->render('view_dashboard.twig',
            // array('auth' => $auth));

        } else {
            true;
        }

    };
    
    ctrl_authentication();

?>

