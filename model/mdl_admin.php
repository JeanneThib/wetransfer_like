<?php

require_once 'connect.php';


function bdd_authentication($login) {
    global $bdd;
    $request = "SELECT admin.login, admin.password FROM admin WHERE admin.id = 1";
    
    $response = $bdd->prepare( $request );
    $response->bindParam(':login', $login, PDO::PARAM_STR);
    $response->execute();
    return $response->fetchAll(PDO::FETCH_ASSOC);
}

?>