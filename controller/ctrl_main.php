<?php

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);


function myFunction() {
    global $twig, $base_url;
    echo $twig->render('view_main.twig',
    array('base_url'=>$base_url));
};

myFunction();



?>
