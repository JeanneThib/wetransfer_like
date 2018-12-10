<?php

if (isset($_GET['envoi'])){

$mail = 'antonin.l@codeur.online'; // Déclaration de l'adresse de destination.
//=====Déclaration des messages au format HTML.
$message_html = "<html><head></head><body><b>Message de ".$_GET['envoi']."</b></body></html>";
//==========
$passage_ligne = "\n";
//=====Création de la boundary
$boundary = "-----=".md5(rand());
//==========
 
//=====Définition du sujet.
$sujet = "WeTranfer";
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
mail('antonin.l@codeur.online','test','message');
}