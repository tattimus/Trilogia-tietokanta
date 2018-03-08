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
        $genre1 = new Genre(array('nimi' => $genret['genre1']));
        $genre2 = new Genre(array('nimi' => $genret['genre2']));
        $gE1 = $genre1->errors();
        $gE2 = $genre2->errors();
        $errorst = $trilogia->errors();
        $errors = array_merge($errorst, $gE1, $gE2);
        if (count($errorst) + count($gE1) + count($gE2) == 0) {
            $trilogia->tallenna();
            GenreController::genreCheck($par['genre1'], $par['genre2'], $trilogia->id);
            Redirect::to('/esittelyTrilogia/' . $trilogia->id);
        } else {
            View::make('Trilogia/lisays.html', array('errors' => $errors, 'attribuutit' => $attribuutit, 'genret' => $genret));
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
            View::make('Trilogia/muokkausT.html', array('errors' => $errors, 'attribuutit' => $attribuutit));
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

    public static function haku() {
        View::make('Trilogia/haku.html');
    }

    public static function tulokset() {
        $par = $_POST;
        $options = array('nimi' => $par['nimi'], 'media' => $par['media'], 'genre' => $par['genre']);
        $trilogiat = Trilogia::haku($options);
        if ($trilogiat) {
            View::make('Trilogia/tulokset.html', array('trilogiat' => $trilogiat));
        } else {
            Redirect::to('/haku', array('viesti' => 'Haulla ei tuloksia'));
        }
    }

}
