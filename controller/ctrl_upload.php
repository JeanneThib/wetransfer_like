<?php
// require_once "../model/connect.php";
require_once "../model/mdl_upload.php";


$_FILES['fichier']['name'];     //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
$_FILES['fichier']['type'];     //Le type du fichier. Par exemple, cela peut être « image/png ».
$_FILES['fichier']['size'];     //La taille du fichier en octets.
$_FILES['fichier']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
$_FILES['fichier']['error'];    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.

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
$maxSize = 1048576;

    echo '</br>';
    echo '<b>Nom brut : </b>'.$fullName.'</br>';
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

// Enregistrement du fichier
$resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],'../cloud/' .$nom.'.'.$ext);

// Si $resultat = true
if ($resultat){
    echo "Transfert réussi </br>";
    // Chemin d'acces du fichier
    $url = $nom.'.'.$ext;
};
echo strlen($url);
// ===== ENVOI BDD =====

insertDB($name, $url, $date, $fileSize, $ext);

// ====== ENVOI MAIL =====

// Déclaration de l'adresse de destination.
$mail = 'antonin.l@codeur.online'; 
//=====Déclaration des messages au format HTML.
$message_html = "<html><head></head><body><div></div><b>Message de test</b><br></body></html>";
//==========
$passage_ligne = "\n";
//=====Création de la boundary
$boundary = "-----=".md5(rand());
//==========

//=====Définition du sujet.
$sujet = "Message provenant de l'avatar";
//=========

//=====Création du header de l'e-mail.
$header = "From: \"Moi-même\"<testdemail@mail.fr>".$passage_ligne;
$header.= "Reply-to: \"WeaponsB\" <weaponsb@mail.fr>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========

//=====Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========

//=====Envoi de l'e-mail.
mail($mail,$sujet,$message,$header);
?>