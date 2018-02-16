<?php

class TrilogiaController extends BaseController {

    public static function listaaTrilogiat() {
        $trilogiat = Trilogia::kaikki();
        $kayttaja = Kayttaja::etsi_kayttaja($_SESSION['user']);
        View::make('Trilogia/listaus.html', array('trilogiat' => $trilogiat, 'kayttaja' => $kayttaja));
    }

    public static function esittely($id) {
        $trilogia = Trilogia::hae_id($id);
        $genret = Genre::hae_trilogialla($id);
        $osat = trilogian_osa::hae_trilogialla($id);
        View::make('Trilogia/esittelyT.html', array('trilogia' => $trilogia, 'osat' => $osat, 'genret' => $genret));
    }

    public static function lisaa() {
        $par = $_POST;
        $attribuutit = array('kayttaja_id' => $_SESSION['user'], 'nimi' => $par['tnimi'], 'arvio' => $par['tarvio'], 'media' => $par['tmedia'], 'sanallinen_arvio' => $par['tsanallinen']);
        $trilogia = new Trilogia($attribuutit);
        $genret = array('genre1' => $par['genre1'], 'genre2' => $par['genre2']);
        $genre1 = new Genre(array('nimi' => $genret['genre1'])); $genre2 = new Genre(array('nimi' => $genret['genre2']));
        $gE1 = $genre1->errors(); $gE2 = $genre2->errors();
        $attribuutit1 = array('kayttaja_id' => $_SESSION['user'], 'trilogia_id' => $trilogia->id, 'nimi' => $par['1nimi'], 'arvio' => $par['1arvio'], 'monesko_osa' => $par['1osa'], 'media' => $par['1media'], 'julkaistu' => $par['1julkaistu'], 'sanallinen_arvio' => $par['1sanallinen']);
        $attribuutit2 = array('kayttaja_id' => $_SESSION['user'], 'trilogia_id' => $trilogia->id, 'nimi' => $par['2nimi'], 'arvio' => $par['2arvio'], 'monesko_osa' => $par['2osa'], 'media' => $par['2media'], 'julkaistu' => $par['2julkaistu'], 'sanallinen_arvio' => $par['2sanallinen']);
        $attribuutit3 = array('kayttaja_id' => $_SESSION['user'], 'trilogia_id' => $trilogia->id, 'nimi' => $par['3nimi'], 'arvio' => $par['3arvio'], 'monesko_osa' => $par['3osa'], 'media' => $par['3media'], 'julkaistu' => $par['3julkaistu'], 'sanallinen_arvio' => $par['3sanallinen']);
        $osa1 = new trilogian_osa($attribuutit1); $osa2 = new trilogian_osa($attribuutit2); $osa3 = new trilogian_osa($attribuutit3);
        $errorst = $trilogia->errors(); $errors1 = $osa1->errors(); $errors2 = $osa2->errors(); $errors3 = $osa3->errors();
        $errors = array_merge($errorst, $errors1, $errors2, $errors3, $gE1, $gE2);
        if (count($errorst) + count($errors1) + count($errors2) + count($errors3) + count($gE1) + count($gE2) == 0) {
            $trilogia->tallenna();
            $osa1->tallenna($trilogia->id);
            $osa2->tallenna($trilogia->id);
            $osa3->tallenna($trilogia->id);
            GenreController::genreCheck($par['genre1'], $par['genre2'], $trilogia->id);
            Redirect::to('/esittelyTrilogia/' . $trilogia->id);
        } else {
            View::make('Trilogia/lisays.html', array('errors' => $errors, 'attribuutit' => $attribuutit, 'attribuutit1' => $attribuutit1, 'attribuutit2' => $attribuutit2, 'attribuutit3' => $attribuutit3, 'genret' => $genret));
        }
    }

    public static function lisays() {
        View::make('Trilogia/lisays.html');
    }
    
    public static function muokkaa($id) {
        $trilogia = Trilogia::hae_id($id);
        View::make('Trilogia/muokkausT.html', array('attribuutit' => $trilogia));
    }
    
    public static function paivita($id) {
        $par = $_POST;
        $attribuutit = array('id' => $id, 'nimi' => $par['nimi'], 'arvio' => $par['arvio'], 'media' => $par['media'], 'sanallinen_arvio' => $par['sanallinen_arvio']);
        $trilogia = new Trilogia($attribuutit);
        $errors = $trilogia->errors();
        if (count($errors) > 0) {
            View::make('Trilogia/muokkausT.html', array('errors'=>$errors, 'attribuutit' => $attribuutit));
        } else {
            $trilogia->muokkaa();
            Redirect::to('/esittelyTrilogia/' . $trilogia->id, array('message' => 'Muokkaus onnistui!'));
        }
        
    }
    
    public static function poista($id) {
        $poistettava = new Trilogia(array('id' => $id));
        $genreliitos = new Genreliitos_trilogia(array('trilogia_id' => $id));
        $genreliitos->poista();
        $poistettava_osa = new trilogian_osa(array('trilogia_id' => $id));
        $poistettava_osa->poista();
        $poistettava->poista();
        Redirect::to('/listaus', array('message' => 'Kohde poistettu.'));
    }

}
