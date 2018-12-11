<?php

require_once 'connect.php';


function bdd_authentication() {
    global $bdd;
    $request = "SELECT admin.login, admin.password FROM admin WHERE admin.id = 1";
    
    $response = $bdd->prepare( $request );
    // $response->bindParam(':id', $id, PDO::PARAM_INT);
    $response->execute();
    return $response->fetchAll(PDO::FETCH_ASSOC);
}

?>