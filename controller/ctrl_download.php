<?php

require_once "model/mdl_download.php";

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);



function myFunction() {
    global $twig;

    echo $twig->render('view_download.twig',
    array('test' => $test));
};

myFunction();

?>