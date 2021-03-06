<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        $lotr = new trilogian_osa(array(
            'nimi' => 'l',
            'arvio' => '5',
            'media' => 'elokuvaelokuvaelokuva',
            'sanallinen_arvio' => 'super jees',
            'julkaistu' => '13.13.2001'
        ));
        
        $errors = $lotr->errors();
        Kint::dump($errors);
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
