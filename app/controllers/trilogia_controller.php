<?php

class TrilogiaController extends BaseController {

    public static function listaaTrilogiat() {
        $trilogiat = Trilogia::kaikki();
        View::make('suunnitelmat/listaus.html', array('trilogiat' => $trilogiat));
    }

    public static function esittely($id) {
        $trilogia = Trilogia::hae_id($id);
        $osat = trilogian_osa::hae_trilogialla($id);
        View::make('suunnitelmat/esittelyT.html', array('trilogia' => $trilogia, 'osat' => $osat));
    }

    public static function lisaa() {
        $par = $_POST;
        $trilogia = new Trilogia(array('nimi' => $par['tnimi'],
            'arvio' => $par['tarvio'], 'media' => $par['tmedia'],
            'sanallinen_arvio' => $par['tsanallinen']));
        $trilogia -> tallenna();
        $osa1 = new trilogian_osa(array('trilogia_id' => $trilogia->id, 'nimi' => $par['1nimi'], 'arvio' => $par['1arvio'],
            'monesko_osa' => $par['1osa'], 'media' => $par['1media'], 'julkaistu' => $par['1julkaistu'],
            'sanallinen_arvio' => $par['1sanallinen']));
        $osa2 = new trilogian_osa(array('trilogia_id' => $trilogia->id, 'nimi' => $par['2nimi'], 'arvio' => $par['2arvio'],
            'monesko_osa' => $par['2osa'], 'media' => $par['2media'], 'julkaistu' => $par['2julkaistu'],
            'sanallinen_arvio' => $par['2sanallinen']));
        $osa3 = new trilogian_osa(array('trilogia_id' => $trilogia->id, 'nimi' => $par['3nimi'], 'arvio' => $par['3arvio'],
            'monesko_osa' => $par['3osa'], 'media' => $par['3media'], 'julkaistu' => $par['3julkaistu'],
            'sanallinen_arvio' => $par['3sanallinen']));
        $osa1->tallenna($trilogia->id);
        $osa2->tallenna($trilogia->id);
        $osa3->tallenna($trilogia->id);
        Redirect::to('/esittelyTrilogia/'.$trilogia->id);
    }

    public static function lisays() {
        View::make('suunnitelmat/lisays.html');
    }

}
