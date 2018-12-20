<?php

require_once "connect.php";
function insertDB($name, $url, $date, $fileSize, $ext){

    global $bdd;
    
    $sql = "INSERT INTO file_upload (name,path,link_id,upload_date,size,extension) VALUES (:name,'../cloud/',:url,:date,:fileSize,:ext)";
    
    $response = $bdd->prepare( $sql );
    $response->bindParam(':name', $name, PDO::PARAM_STR);
    $response->bindParam(':url', $url, PDO::PARAM_STR);
    $response->bindValue(':date', $date, PDO::PARAM_STR);
    $response->bindParam(':fileSize', $fileSize, PDO::PARAM_INT);
    $response->bindParam(':ext', $ext, PDO::PARAM_STR);
    $response->execute();

    if($response) return true;
    else return false;
}

?>