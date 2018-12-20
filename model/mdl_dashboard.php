<?php

require_once "model/connect.php";

    function bdd_displayUpload($week){

        global $bdd;
        
        $sql = "SELECT DAYOFWEEK(upload_date) AS day, COUNT(DAYOFWEEK(upload_date)) AS nbr 
        FROM file_upload WHERE (WEEK(upload_date) = :week - 1 AND DAYOFWEEK(upload_date) != 1 ) OR (WEEK(upload_date) = :week AND DAYOFWEEK(upload_date) = 1)
        GROUP BY DAYOFWEEK(upload_date)";
        
        $response = $bdd->prepare( $sql );
        $response->bindParam(':week', $week, PDO::PARAM_INT);
        $response->execute();

        return $response->fetchAll(PDO::FETCH_ASSOC);


}

    function bdd_uploadExtension($week){

        global $bdd;
        
        $sql = "SELECT extension, ROUND((Count(extension)* 100 / 
        (SELECT Count(*) FROM file_upload 
        WHERE (WEEK(upload_date) = :week - 1 
        AND DAYOFWEEK(upload_date) != 1 ) 
        OR (WEEK(upload_date) = :week 
        AND DAYOFWEEK(upload_date) = 1)))) 
        AS percent
        FROM file_upload 
        WHERE (WEEK(upload_date) = :week - 1 
        AND DAYOFWEEK(upload_date) != 1 ) 
        OR (WEEK(upload_date) = :week 
        AND DAYOFWEEK(upload_date) = 1)
        GROUP BY extension";
        
        $response = $bdd->prepare( $sql );
        $response->bindParam(':week', $week, PDO::PARAM_INT);
        // $response->bindValue(':date', $date, PDO::PARAM_STR);
        
        $response->execute();

        return $response->fetchAll(PDO::FETCH_ASSOC);


}

function bdd_downloadExtension($week){

    global $bdd;
    
    $sql = "SELECT extension, ROUND((Count(extension)* 100 / 
    (SELECT Count(*) FROM file_download 
    WHERE (WEEK(download_date) = :week - 1 
    AND DAYOFWEEK(download_date) != 1 ) 
    OR (WEEK(download_date) = :week 
    AND DAYOFWEEK(download_date) = 1)))) 
    AS percent
    FROM file_download 
    WHERE (WEEK(download_date) = :week - 1 
    AND DAYOFWEEK(download_date) != 1 ) 
    OR (WEEK(download_date) = :week 
    AND DAYOFWEEK(download_date) = 1)
    GROUP BY extension";
    
    $response = $bdd->prepare( $sql );
    $response->bindParam(':week', $week, PDO::PARAM_INT);
    
    $response->execute();

    return $response->fetchAll(PDO::FETCH_ASSOC);


}

function bdd_displayDownload($week){

    global $bdd;
    
    $sql = "SELECT DAYOFWEEK(download_date) AS day, COUNT(DAYOFWEEK(download_date)) AS nbr 
    FROM file_download WHERE (WEEK(download_date) = :week - 1 AND DAYOFWEEK(download_date) != 1 ) OR (WEEK(download_date) = :week AND DAYOFWEEK(download_date) = 1)
    GROUP BY DAYOFWEEK(download_date)";
    
    $response = $bdd->prepare( $sql );
    $response->bindParam(':week', $week, PDO::PARAM_INT);
    $response->execute();

    return $response->fetchAll(PDO::FETCH_ASSOC);


}




?>