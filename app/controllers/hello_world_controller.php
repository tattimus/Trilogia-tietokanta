<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        $kayttaja = Kayttaja::kaikki();
        $kayttaja_haku = Kayttaja::etsi_kayttaja(1);
        $trilogia = Trilogia::kaikki();
        $trilogia_haku = Trilogia::hae_id(2);
        $trilogia_kayttajahaku = Trilogia::hae_kayttajalla(1);
        Kint::dump($kayttaja);
        Kint::dump($kayttaja_haku);
        Kint::dump($trilogia);
        Kint::dump($trilogia_haku);
        Kint::dump($trilogia_kayttajahaku);
    }

    public static function etusivu() {
        View::make('suunnitelmat/etusivu.html');
    }
    
    public static function esittelyOsa() {
        View::make('suunnitelmat/esittelyO.html');
    }
    
    public static function esittelyTrilogia() {
        View::make('suunnitelmat/esittelyT.html');
    }
    
    public static function listaus() {
        View::make('suunnitelmat/listaus.html');
    }
    
    public static function muokkausOsa() {
        View::make('suunnitelmat/muokkausO.html');
    }
    
    public static function muokkausTrilogia() {
        View::make('suunnitelmat/muokkausT.html');
    }
    
    public static function haku() {
        View::make('suunnitelmat/haku.html');
    }

}
