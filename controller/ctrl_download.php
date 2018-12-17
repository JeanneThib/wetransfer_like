<?php

require_once 'model/mdl_download.php';
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);

switch ($action) {
    case 'show':
        showDownload();
        break;
    
    default:
        show404();
        break;
}

function show404() {
    global $twig;
    echo $twig->render('view_404.twig');
}

function showDownload() {
    global $twig;
    $test =  substr(  strrchr($_SERVER['REQUEST_URI'], '/')  ,1);
$file = getFile($test);
var_dump ($file);

if(isset($_POST['bouton'])){
    // // Code pour téléchargement
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file['link_id'].'.'.$file['extension']).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
    }
    echo $twig->render('view_download.twig');
}
// }

// function myFunction() {
//     global $twig;
//     $test = "test";
//     echo $twig->render('view_download.twig',
//     array('test' => $test));
// };


?>