<?php

require_once 'model/connect.php';


function bdd_authentication($login, $pass) {
    global $bdd;
    $request = "SELECT count(id) AS nombre FROM admin WHERE admin.login = :login AND password = :pass";
    
    $response = $bdd->prepare( $request );
    $response->bindParam(':login', $login, PDO::PARAM_STR);
    $response->bindParam(':pass', $pass, PDO::PARAM_STR);
    $response->execute();
    return $response->fetch(PDO::FETCH_ASSOC);
}

?>