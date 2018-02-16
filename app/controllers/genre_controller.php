<?php
class GenreController extends BaseController {
    
    public static function genreCheck($genre1, $genre2, $trilogia_id) {
        $id1 = Genre::get_id($genre1);
        if ($id1) {
            $uusiLiitos1 = new Genreliitos_trilogia(array('trilogia_id' => $trilogia_id, 'genre_id' => $id1->id));
            $uusiLiitos1->tallenna();
        } else {
            $uusiGenre1 = new Genre(array('nimi' => $genre1));
            $uusiGenre1->tallenna($trilogia_id);
        }
        $id2 = Genre::get_id($genre2);
        if($id2) {
            $uusiLiitos2 = new Genreliitos_trilogia(array('trilogia_id' => $trilogia_id, 'genre_id' => $id2->id));
            $uusiLiitos2->tallenna();
        } else {
            $uusigenre2 = new Genre(array('nimi' => $genre2));
            $uusigenre2->tallenna($trilogia_id);
        }
    }
}


