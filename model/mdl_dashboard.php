<?php

require_once "connect.php";
function getUpload(){

    global $bdd;
    
    $sql = "INSERT INTO file_upload (name,path,link_id,upload_date,size,extension) VALUES (:name,'../cloud/',:url,:date,:fileSize,:ext)";
    
    $response = $bdd->prepare( $sql );
    // $response->bindParam(':name', $name, PDO::PARAM_STR);
    // $response->bindValue(':date', $date, PDO::PARAM_STR);
    
    $response->execute();
}

?>