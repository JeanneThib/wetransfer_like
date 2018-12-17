<?php
// require_once "../model/connect.php";
require_once "../model/mdl_upload.php";
require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../view');
$twig = new Twig_Environment($loader);

$erreur = "";


// echo '</br>' . $ms;


$_FILES['fichier']['name'];     //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
$_FILES['fichier']['type'];     //Le type du fichier. Par exemple, cela peut être « image/png ».
$_FILES['fichier']['size'];     //La taille du fichier en octets.
$_FILES['fichier']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
$_FILES['fichier']['error'];    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.

if ($_FILES['fichier']['size'] == 0 || $_FILES['fichier']['size'] > $_POST['MAX_FILE_SIZE']){
    echo 'Taille de fichier invalide';
} else {
    
    // Récupération de la date de d'upload
    echo $date = date('Y-m-d');
    
    // Numéro de semain en fonction de la date d'upload
$week = strtotime ($date);
echo '</br>Semaine : '.date('W',$week);

// Nom complet du fichier
$fullName = $_FILES['fichier']['name'];

// Extension du fichier
$ext = strtolower(  substr(  strrchr($_FILES['fichier']['name'], '.')  ,1)  );

// Nom du fichier sans l'extension
$name = substr($_FILES['fichier']['name'], 0, -strlen($ext)-1 );

// Taille du fichier
$fileSize = $_FILES['fichier']['size'];

// Taille maximale autorisée en octets (1Mo)
$maxSize = 2048576;


    echo '</br>';
    echo '<b>Nom brut : </b>'.$fullName.'</br>';
    echo '<b>Nom sans extension : </b>'.$name.'</br>';
    echo '<b>Extension : </b>'.$ext.'</br>';
    echo '<b>Taille en Octets : </b>'.$fileSize.'</br>';
    echo '</br>';
    
    echo ini_get('upload_max_filesize');
    
    // if ($_FILES['fichier']['error'] > 0) $erreur = "Erreur lors du transfert";
    // if ($_FILES['fichier']['size'] > $maxSize) $erreur = "Le fichier est trop gros";

    if ($_FILES['fichier']['size'] > $maxSize) {
        $erreur = "Le fichier est trop gros";
    }
    // $image_sizes = getimagesize($_FILES['fichier']['tmp_name']);
    // if ($image_sizes[0] > $maxWidth OR $image_sizes[1] > $maxHeight) $erreur = "Image trop grande";
    
    
    // Créer un identifiant difficile à deviner
$ms = round(microtime(true) * 1000);
$nom = sha1(uniqid(rand(), true));
$full = $ms . '-' . $nom;

// echo '</br>' . $full . '</br>';

// chmod("../cloud", 0777);
// if (!file_exists('cloud')) {
    // mkdir('cloud', 0777, true);
    // }

    $filename = $_SERVER["DOCUMENT_ROOT"].'/'.'wetransfer_like/cloud/' .$full.'.'.$ext;
    
    // echo '</br>' . !file_exists($filename) . '</br>';
if(!file_exists($filename)) {
$resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/".'wetransfer_like/cloud/' .$full.'.'.$ext);
} else {
    while(file_exists($_SERVER["DOCUMENT_ROOT"]."/".'wetransfer_like/cloud/' .$full.'.'.$ext)) {
        $ms = round(microtime(true) * 1000);
        $nom = sha1(uniqid(rand(), true));
        $full = $ms . '-' . $nom;
    }
    $resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/".'wetransfer_like/cloud/' .$full.'.'.$ext);
}

var_dump($_FILES);

// Si $resultat = true
if ($resultat){
    echo "Transfert réussi </br>";
    $url = 'cloud/' .$nom.'.'.$ext;
};

// ===== ENVOI BDD =====
insertDB($name, $url, $date, $fileSize, $ext);

// ====== ENVOI MAIL =====

ini_set( 'display_errors', 1 );

error_reporting( E_ALL );

$from = "test.form@gmail.com";

$to = $_POST["destinataire"].', '.$_POST["destinataire2"].', '."jules.p@codeur.online";


$subject = "Vérification PHP mail";


// Déclaration du message en HTML
$message_html = $twig->render('mail.twig',array("url" => $url));
// Passage à la ligne
$passage_ligne = "\n";
// Création de la boundary
$boundary = "-----=".md5(rand());
// Création du header de l'email
$header = "From: \"Moi-même\"<".$from.">".$passage_ligne;
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

// Envoi de l'email
mail($to,$subject,$message_html, $header);

}
?>