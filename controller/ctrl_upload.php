<?php
// require_once "model/connect.php";
require_once "../model/mdl_upload.php";
echo $date = date('Y-m-d');
$good_format=strtotime ($date);
echo '</br>Semaine : '.date('W',$good_format);


$_FILES['fichier']['name'];     //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
$_FILES['fichier']['type'];     //Le type du fichier. Par exemple, cela peut être « image/png ».
$_FILES['fichier']['size'];     //La taille du fichier en octets.
$_FILES['fichier']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
$_FILES['fichier']['error'];    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.

$fullName = $_FILES['fichier']['name'];
$ext = strtolower(  substr(  strrchr($_FILES['fichier']['name'], '.')  ,1)  );
$name = substr($_FILES['fichier']['name'], 0, -strlen($ext)-1 );
$fileSize = $_FILES['fichier']['size'];

$maxSize = 1048576;
// $maxWidth = 1200;
// $maxHeight = 700;

    echo '</br>';
    echo '<b>Nom brute : </b>'.$fullName.'</br>';
    echo '<b>Nom sans extension : </b>'.$name.'</br>';
    echo '<b>Extension : </b>'.$ext.'</br>';
    echo '<b>Taille en Octets : </b>'.$fileSize.'</br>';
    echo '</br>';
    
    
    if ($_FILES['fichier']['error'] > 0) $erreur = "Erreur lors du transfert";
    if ($_FILES['fichier']['size'] > $maxSize) $erreur = "Le fichier est trop gros";

    // $image_sizes = getimagesize($_FILES['fichier']['tmp_name']);
    // if ($image_sizes[0] > $maxWidth OR $image_sizes[1] > $maxHeight) $erreur = "Image trop grande";

    
// Créer un identifiant difficile à deviner
$nom = md5(uniqid(rand(), true));


$resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],'../cloud/' .$nom.'.'.$ext);
if ($resultat) echo "Transfert réussi </br>";

// ====== ENVOI MAIL =====


ini_set( 'display_errors', 1 );

error_reporting( E_ALL );

$from = "test.form@gmail.com";

$to = $_POST["destinataire"];

$subject = "Vérification PHP mail";

$message = "";

$headers = "From:" . $from;

mail($to,$subject,$message, $headers);

// ===== SQL =====
global $bdd;

$sql = "INSERT INTO file_upload (name,path,link_id,upload_date,size,extension) VALUES (:name,'../cloud/',:url,:date,:fileSize,:ext)" ;

$response = $bdd->prepare( $sql );
$response->bindParam(':name', $name, PDO::PARAM_STR);
$response->bindParam(':url', $url, PDO::PARAM_STR);
$response->bindParam(':date', $date, PDO::PARAM_STR);
$response->bindParam(':fileSize', $fileSize, PDO::PARAM_STR);
$response->bindParam(':ext', $ext, PDO::PARAM_STR);
$response->execute();
// $response->fetchAll(PDO::FETCH_ASSOC);

?>