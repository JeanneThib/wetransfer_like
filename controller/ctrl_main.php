<?php
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);


function myFunction() {
    global $twig, $base_url;
    $test = "test";
    echo $twig->render('view_main.twig',
    array('test' => $test));
};

myFunction();

?>
