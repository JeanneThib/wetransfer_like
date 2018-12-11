<?php


if(!empty($_POST)) {
    
    require_once '../model/mdl_admin.php';
    require_once '../vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem('../view');
    $twig = new Twig_Environment($loader);

} else {     

require_once 'model/mdl_admin.php';
require_once 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);

    var_dump($_POST);
    function ctrl_authentication() {
        global $twig, $base_url;
        $auth = 'bdd_authentication()';
    
        echo $twig->render('view_admin.twig',
        array('auth' => $auth));
    };
    ctrl_authentication();
}
?>

