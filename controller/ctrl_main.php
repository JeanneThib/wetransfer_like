<?php

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);

echo $twig->render('view_main.twig');

