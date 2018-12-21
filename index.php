<?php 
require_once 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array(
    'cache' => false,
));

$requete = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
$controller = (count($requete) === 1) ? "default" : $requete[1];
$action = (count($requete) < 3)? "default" : $requete[2];
$id = (count($requete) < 4) ? 0 : (int)$requete[3]; 

switch ($controller) {
    
    case 'download':
        require_once('controller/ctrl_download.php');
    break;
    
    case 'admin':
        require_once('controller/ctrl_admin.php');
    break;

    case 'dashboard':
        require_once('controller/ctrl_dashboard.php');
    break;

    default:
        require_once('controller/ctrl_upload.php');
    break;
}
