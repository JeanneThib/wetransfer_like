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
    
    // Requete SQL avec identifiant du fichier
    $file = getFile (substr(  strrchr($_SERVER['REQUEST_URI'], '/')  ,1));
    
        // Boucle pour parcourir le tableau de tableaux et récupérer les données de la BDD
        foreach ($file as $key) {
            $nom = $key['name'];
            $extension = $key['extension'];
            $link_id = $key['link_id'];
        }
    
    echo $lien = $link_id.'.'.$extension;

    // Chemin du fichier à télécharger
    $filepath = $_SERVER['DOCUMENT_ROOT'].'/wetransfer_like/cloud/'.$link_id.'.'.$extension;

    // Render twig de la page
    echo $twig->render('view_download.twig', array('chemin'=> '../../cloud/'.$lien));
    
    // Quand interaction avec le input name="bouton"
        if(isset($_POST['bouton'])){

            // Code pour téléchargement
            header('Content-Disposition: attachmeshow/1545059594455-998b65c4b23ecf215083806abaa4c019c360af7bnt; filename="'.basename($filepath).'"');
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
}


// function myFunction() {
//     global $twig;
//     $test = "test";
//     echo $twig->render('view_download.twig',
//     array('test' => $test));
// };


?>