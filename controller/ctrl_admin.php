<?php

require_once "model/mdl_admin.php";

$test = "Un test";

function funcTest() {
    global $test;

    echo $twig->render('view_admin.twig',
    array('test' => $test));
};

funcTest();

?>