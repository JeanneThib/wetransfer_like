<?php

$base_url = (strstr($_SERVER["HTTP_HOST"],"8080")=== false)?"https://antoninl.promo-23.codeur.online/wetransfer_like/":"https://antoninl.promo-23.codeur.online:8080/wetransfer_like/";
$username = 'root';
$password = 'online@2017';
$database ='db_transfert';
$host = 'localhost';

try{

$bdd = new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8',$username , $password);

}catch (Exception $e){

die('Erreur : ' . $e->getMessage());

}

?>