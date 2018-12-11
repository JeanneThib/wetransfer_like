<?php

session_start();

// if($_SESSION["authenticated"]) {
//     echo "Vous êtes connecté";
// } else {
//     session_destroy();
//     echo "Vous n'êtes pas connecté";
// }

// var_dump($_SESSION["authenticated"]);

// require_once 'model/mdl_admin.php';

$auth = 0;
    
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);

echo $twig->render('view_dashboard.twig',
array('auth' => $auth));


?>