<?php

require_once "model/mdl_admin.php";

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);

// echo $twig->render('view_admin.twig');

$test = "Un test";

function funcTest() {
    global $twig, $test;

    echo $twig->render('view_admin.twig',
    array('test' => $test));
};

funcTest();

?>