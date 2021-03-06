<?php
require_once 'model/mdl_upload.php';
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);

$erreur = "";


switch ($action) {
    case 'result':
        verifUpload();
        break;
    default:
        showUpload();
        break;
}

function showUpload() {
    global $twig, $base_url;
    echo $twig->render('view_main.twig',
    array('base_url'=>$base_url));
}

function verifUpload(){
    global $twig, $base_url;

    $_FILES['fichier']['name'];     //Le idnom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
    $_FILES['fichier']['type'];     //Le type du fichier. Par exemple, cela peut être « image/png ».
    $fileSize = $_FILES['fichier']['size'];     //La taille du fichier en octets.
    $_FILES['fichier']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
    $_FILES['fichier']['error'];    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.

    // Taille maximale autorisée en octets (2Mo)
    $maxSize = 2048576;

    if ((($fileSize > 0) && ($fileSize < 2048576)) == 1){

        $fileSize = $_FILES['fichier']['size'];
        $fileSize /= 1000;
        // Récupération de la date de d'upload
        $date = date('Y-m-d');

        // Numéro de semain en fonction de la date d'upload
        $week = strtotime ($date);

        // idNom complet du fichier
        $fullName = $_FILES['fichier']['name'];

        // Extension du fichier
        $ext = strtolower(  substr(  strrchr($_FILES['fichier']['name'], '.')  ,1)  );

        // idNom du fichier sans l'extension
        $name = substr($_FILES['fichier']['name'], 0, -strlen($ext)-1 );
        

        // if ($_FILES['fichier']['error'] > 0) $erreur = "Erreur lors du transfert";
        // if ($_FILES['fichier']['size'] > $maxSize) $erreur = "Le fichier est trop gros";

        if ($_FILES['fichier']['size'] > $maxSize) {
            $erreur = "Le fichier est trop gros";
        }
        // $image_sizes = getimagesize($_FILES['fichier']['tmp_name']);
        // if ($image_sizes[0] > $maxWidth OR $image_sizes[1] > $maxHeight) $erreur = "Image trop grande";


        // Créer un identifiant difficile à deviner
        $ms = round(microtime(true) * 1000);
        $id = sha1(uniqid(rand(), true));
        $full = $ms . '-' . $id;

        $filename = $_SERVER["DOCUMENT_ROOT"].'/'.'wetransfer_like/cloud/' .$full.'.'.$ext;

        if(!file_exists($filename)) {
        $resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/".'wetransfer_like/cloud/' .$full.'.'.$ext);
    } else {
        while(file_exists($_SERVER["DOCUMENT_ROOT"]."/".'wetransfer_like/cloud/' .$full.'.'.$ext)) {
            $ms = round(microtime(true) * 1000);
            $id = sha1(uniqid(rand(), true));
            $full = $ms . '-' . $id;
        }
        $resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/".'wetransfer_like/cloud/' .$full.'.'.$ext);
    }

        // Si $resultat = true
        if ($resultat){

           

            $dlLink = 'https://antoninl.promo-23.codeur.online/wetransfer_like/download/show/' . $full;

        };

        // ===== ENVOI BDD =====

        if (insertDB($name, $full, $date, $fileSize, $ext) != false) {

        // ====== ENVOI MAIL =====
            
        ini_set( 'display_errors', 1 );

        error_reporting( E_ALL );
        
        $from = "PushYourFiles@file.com";

        if (($_POST["destinataire"] != "") && (filter_var($_POST["destinataire"], FILTER_VALIDATE_EMAIL))){

            $to = $_POST["destinataire"];

            if (($_POST["destinataire2"] != "") && (filter_var($_POST["destinataire2"], FILTER_VALIDATE_EMAIL))){

                $to = $_POST["destinataire"].', '.$_POST["destinataire2"];
            
            }

        } else {

            $to = '"';
        
        }

        $subject = "Push Your Files : Un fichier est à votre disposition";

        // Déclaration du message en HTML
        $message_html = $twig->render('mail.twig',array("url" => $dlLink));
        // Passage à la ligne
        $passage_ligne = "\n";
        // Création de la boundary
        $boundary = "-----=".md5(rand());
        // Création du header de l'email
        $header = "From: \"Push Your Files\"<".$from.">".$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header .= "Content-Type: text/html; charset=\"UTF8\"";
        // Création du message
        $message = $passage_ligne."--".$boundary.$passage_ligne;
        
        $message.= $passage_ligne."--".$boundary.$passage_ligne;
        // Ajout du message au format HTML
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_html.$passage_ligne;
        //==========
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        //==========

        if (mail($to,$subject,$message_html, $header) === false){

            $verifMail = false;
        } else {
            $verifMail = true;

        }

        if ($verifMail){

            global $twig, $base_url;
            echo $twig->render('view_verifUpload.twig',
            array('base_url'=>$base_url,'titre' => 'Transfert réussi !', 'nom' => $fullName, 'taille' => $fileSize, 'lien' => $dlLink));
            
        } else {          
            
            global $twig, $base_url;
            echo $twig->render('view_verifUpload.twig',
            array('base_url'=>$base_url,'titre' => 'Un problème est survenu.', 'description' => "L'envoi du mail a échoué."));
            
        }
        
    } else {
            
        global $twig, $base_url;
        echo $twig->render('view_verifUpload.twig',
        array('base_url'=>$base_url,'titre' => 'Un problème est survenu.', 'description' => "Il semblerait que l'enregistrement de votre fichier n'est pas fonctionné "));
    }

} else {
            
    global $twig, $base_url;
    echo $twig->render('view_verifUpload.twig',
    array('base_url'=>$base_url,'titre' => 'Un problème est survenu.', 'description' => "La taille de votre fichier est trop importante ( supérieure à 2Mo) ou votre fichier est vide."));

}


}
