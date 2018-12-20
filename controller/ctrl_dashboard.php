<?php

require_once 'vendor/autoload.php';
require_once 'model/mdl_dashboard.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);

switch ($action) {
    case 'week':
        displayUpload();
        break;
    
    default:
        showDashboard();
        break;
}

function displayUpload() {
    $week = $_POST["week"];
    intval($week);
    $upload_data = bdd_displayUpload($week);
    $extension_upload = bdd_uploadExtension($week);
    $extension_download = bdd_downloadExtension($week);
    $download_data = bdd_displayDownload($week);
    $jsonData = array('upload' => $upload_data, 'upload_extension' => $extension_upload, 'download_extension' => $extension_download, 'download' => $download_data);
    // var_dump($extension_data);
    echo json_encode($jsonData);
    // var_dump($upload_data[0]["day"]);
    // $reponse = array("error"=>"Erreur dans l'identifiant ou le mot de passe");
}

function showDashboard() {
    global $twig;

    session_start();


    if(isset($_SESSION["authenticated"])) {

        if($_SESSION["authenticated"]) {

            echo $twig->render('view_dashboard.twig');
            
        } else {
            echo $twig->render('view_403.twig');
        }
        
    } else {
        echo $twig->render('view_403.twig');
    }

    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
        session_unset();    
        session_destroy(); 
    }
    $_SESSION['last_activity'] = time(); // update last activity time stamp

    // session_regenerate_id(true);

    // if($_SESSION["authenticated"]) {
    //     echo "Vous êtes connecté";
    // } else {
    //     session_destroy();
    //     echo "Vous n'êtes pas connecté";
    // }

    // var_dump($_SESSION["authenticated"]);

    // require_once 'model/mdl_admin.php';

}

    







?>