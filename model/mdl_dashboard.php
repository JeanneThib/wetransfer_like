<?php

require_once "model/connect.php";

    function bdd_displayWeek($week){

        global $bdd;
        
        $sql = "SELECT DAYOFWEEK(upload_date) AS day, COUNT(DAYOFWEEK(upload_date)) AS nbr 
        FROM file_upload WHERE (WEEK(upload_date) = :week AND DAYOFWEEK(upload_date) != 1 ) OR (WEEK(upload_date) = :week + 1 AND DAYOFWEEK(upload_date) = 1)
        GROUP BY DAYOFWEEK(upload_date)";
        
        $response = $bdd->prepare( $sql );
        $response->bindParam(':week', $week, PDO::PARAM_INT);
        // $response->bindValue(':date', $date, PDO::PARAM_STR);
        
        $response->execute();

        return $response->fetchAll(PDO::FETCH_ASSOC);


}

?>