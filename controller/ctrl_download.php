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
    global $base_url;
    $filepath = $base_url.'cloud/'.substr(  strrchr($_SERVER['REQUEST_URI'], '/')  ,1);
    echo $filepath;
    
    // Code pour téléchargement
    if(file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        exit;
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