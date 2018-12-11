<?php

require_once 'connect.php';

function filmGenre() {
    global $twig, $id, $base_url, $genres, $tri, $select, $isGenre;
    $select = true;
    $isGenre = true;
    if ($id !=0) {
        $tri === 1 ? $genres = bdd_filmGenre($id, 'ASC') : $genres = bdd_filmGenre($id, 'DESC');
    } elseif ($id < 1 || $id > 17) {
        $genres = bdd_filmList(0, 'DESC');
    }
    echo $twig->render('film.twig',
    array('genres' => $genres, "base_url" => $base_url, "select" => $select, "isGenre" => $isGenre, "idGenre" => $id));
}

switch ($action) {
    case 'list':
        filmList();
        break;

    case 'detail':
        filmDetail();
        break;
    
    case 'genre':
        filmGenre();
        break;

    default:
        filmList();
        break;
}

?>