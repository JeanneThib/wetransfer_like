<?php

require_once 'model/mdl_download.php';
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);

switch ($action) {
    case 'show':
        showDownload();
        break;

    case 'download':
        getFile();
        break;
    
    default:
        show404();
        break;
}

function show404() {
    global $twig , $base_url;
    echo $twig->render('view_404.twig',
    array('base_url'=>$base_url));
}

function showDownload() {

    global $twig , $base_url;
    
    // Requete SQL avec identifiant du fichier
    $file = getFileDB (substr(  strrchr($_SERVER['REQUEST_URI'], '/')  ,1));
    
        // Boucle pour parcourir le tableau de tableaux et récupérer les données de la BDD
        foreach ($file as $key) {
            $nom = $key['name'];
            $extension = $key['extension'];
            $link_id = $key['link_id'];
        }

    // Chemin du fichier à télécharger
    $filepath = $_SERVER['DOCUMENT_ROOT'].'/wetransfer_like/cloud/'.$link_id.'.'.$extension;

    // Render twig de la page
    echo $twig->render('view_download.twig', array('base_url'=>$base_url ,'chemin'=> 'download/download/'.$link_id));
}

function getFile(){
       
    // Requete SQL avec identifiant du fichier
    $file = getFileDB (substr(  strrchr($_SERVER['REQUEST_URI'], '/')  ,1));
    
        // Boucle pour parcourir le tableau de tableaux et récupérer les données de la BDD
        foreach ($file as $key) { 
            $extension = $key['extension'];
            $link_id = $key['link_id'];
            $curr_date = date('Y-m-d');
        }

    insertDownload($extension, $link_id, $curr_date);

    // Chemin du fichier à télécharger
    $filepath = $_SERVER['DOCUMENT_ROOT'].'/wetransfer_like/cloud/'.$link_id.'.'.$extension;

        // Code pour téléchargement
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Cache-Control: must-revalidate');
        header('Content-Type: application/octet-stream');
        header('Content-Length: '.filesize($filepath));
        header('Expires: 0');
        flush(); // Flush system output buffer
        header('Pragma: public');
        ob_clean();
        readfile($filepath);
        exit();
    
}

// function myFunction() {
//     global $twig;
//     $test = "test";
//     echo $twig->render('view_download.twig',
//     array('test' => $test));
// };


?>