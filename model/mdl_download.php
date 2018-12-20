<?php

require_once 'connect.php';

function getFileDB($url){

    global $bdd;
    $sql = "SELECT name, extension, size, link_id FROM file_upload WHERE link_id = :url" ;

    $response = $bdd->prepare( $sql );
    $response->bindParam(':url',$url,PDO::PARAM_STR);
    $response->execute();
    $affichage = $response->fetchAll(PDO::FETCH_ASSOC);
    return $affichage;
}

function insertDownload($extension, $link_id, $curr_date){

    global $bdd;
    $sql = "INSERT INTO file_download (extension,file_upload_id,download_date) VALUES (:extension,:link_id,:curr_date)" ;

    $response = $bdd->prepare( $sql );
    $response->bindParam(':extension',$extension,PDO::PARAM_STR);
    $response->bindParam(':link_id',$link_id,PDO::PARAM_STR);
    $response->bindValue(':curr_date',$curr_date,PDO::PARAM_STR);
    $response->execute();
    $affichage = $response->fetchAll(PDO::FETCH_ASSOC);
    return $affichage;
}

?>