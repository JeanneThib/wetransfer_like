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
    if((substr(  strrchr($_SERVER['REQUEST_URI'], '/')  ,1)) == 'show'){
        echo $twig->render('view_download.twig');
}else {



    global $twig;
    
    $file = getFile (substr(  strrchr($_SERVER['REQUEST_URI'], '/')  ,1));
    var_dump($file);
    
    foreach ($file as $key) {
        $nom = $key['name'];
        $extension = $key['extension'];
        $link_id = $key['link_id'];
            var_dump($key['link_id']);
    }
    echo $link_id.'.'.$extension;
    $filepath = $_SERVER['DOCUMENT_ROOT'].'/wetransfer_like/cloud/'.$link_id.'.'.$extension;
    echo $twig->render('view_download.twig', array('chemin' => $link_id));

    if(isset($_POST['bouton'])){

                // // Code pour téléchargement
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: '.filesize($filepath));
                ob_clean();
                flush(); // Flush system output buffer
                readfile($filepath);
                echo $twig->render('view_download.twig', array('chemin' => $link_id));
                exit();
    }
}
}

// function myFunction() {
//     global $twig;
//     $test = "test";
//     echo $twig->render('view_download.twig',
//     array('test' => $test));
// };


?>