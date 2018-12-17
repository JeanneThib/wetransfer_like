<?php

require_once 'connect.php';

function getFile($url){
    global $bdd;
$sql = "SELECT name, extension, size, link_id FROM file_upload WHERE link_id = :url" ;

$response = $bdd->prepare( $sql );
$response->bindParam(':url',$url,PDO::PARAM_STR);
$response->execute();
$affichage = $response->fetchAll(PDO::FETCH_ASSOC);
return $affichage;
}
?>