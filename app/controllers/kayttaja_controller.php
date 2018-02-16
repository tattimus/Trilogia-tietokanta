<?php
class KayttajaController extends BaseController {
    
    public static function etusivu() {
        View::make('kayttaja/etusivu.html');
    }
    
    public static function kirjaudu() {
        $par = $_POST;
        $kayttaja = Kayttaja::todennus($par['tunnus'], $par['salasana']);
        if(!$kayttaja) {
            View::make('kayttaja/etusivu.html', array('error' => 'Tunnus tai salasana väärin!', 'tunnus' => $par['tunnus']));
        } else {
            $_SESSION['user'] = $kayttaja->id;
            Redirect::to('/listaus', array('viesti' => 'Well hello there :)'));
        }
    }
    
    public static function ulos() {
        $_SESSION['user'] = null;
        Redirect::to('/kirjaudu');
    }
}

