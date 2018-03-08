<?php

class OsaController extends BaseController {

    public static function Osan_esittely($id) {
        $osa = trilogian_osa::hae_id($id);
        $pvm = explode('-', $osa->julkaistu);
        $uusi = $pvm[2] . '.' . $pvm[1] . '.' . $pvm[0];
        $julkaistu = array();
        $julkaistu[] = $uusi;
        $trilogia = Trilogia::hae_id(trilogian_osa::trilogia_id($id));
        $genret = Genre::hae_trilogialla(trilogian_osa::trilogia_id($id));
        View::make('Osa/esittelyO.html', array('osa' => $osa, 'trilogia' => $trilogia, 'genret' => $genret, 'julkaistu' => $julkaistu));
    }

    public static function muokkaa($id) {
        $osa = trilogian_osa::hae_id($id);
        $pvm = explode('-', $osa->julkaistu);
        $uusi = $pvm[2] . '.' . $pvm[1] . '.' . $pvm[0];
        $julkaistu = array();
        $julkaistu[] = $uusi;
        View::make('Osa/muokkausO.html', array('attribuutit' => $osa, 'julkaistu' => $julkaistu));
    }

    public static function paivita($id) {
        $par = $_POST;
        $attribuutit = array('id' => $id, 'nimi' => $par['nimi'], 'arvio' => $par['arvio'], 'monesko_osa' => $par['monesko_osa'], 'media' => $par['media'], 'julkaistu' => $par['julkaistu'], 'sanallinen_arvio' => $par['sanallinen_arvio']);
        $osa = new trilogian_osa($attribuutit);
        $errors = $osa->errors();
        if (count($errors) > 0) {
            View::make('Osa/muokkausO.html', array('errors' => $errors, 'attribuutit' => $attribuutit));
        } else {
            $osa->muokkaa();
            Redirect::to('/esittelyOsa/' . $osa->id, array('message' => 'Muokkaus onnistui!'));
        }
    }
    
    public static function poistaOsa($id) {
        $poistettava = trilogian_osa::hae_id($id);
        $poistettava->poista();
        Redirect::to('/esittelyTrilogia/' . $poistettava->trilogia_id, array('message' => 'Osa poistettu'));
    }

    public static function lisays($id) {
        View::make('Osa/lisaysOsa.html', array('trilogia' => Trilogia::hae_id($id)));
    }

    public static function lisaa($id) {
        $par = $_POST;
        $osat = trilogian_osa::hae_trilogialla($id);
        if (count($osat) > 2) {
            View::make('Osa/lisaysOsa.html', array('message' => 'Trilogialla on jo kolme osaa!', 'trilogia' => Trilogia::hae_id($id)));
        } else {
            $attribuutit = array('nimi' => $par['nimi'], 'arvio' => $par['arvio'], 'monesko_osa' => $par['osa'], 'media' => $par['media'], 'julkaistu' => $par['julkaistu'], 'sanallinen_arvio' => $par['sanallinen_arvio']);
            $osa = new trilogian_osa($attribuutit);
            $errors = $osa->errors();
            if (count($errors) > 0) {
                View::make('Osa/lisaysOsa.html', array('errors' => $errors, 'attribuutit' => $attribuutit, 'trilogia' => Trilogia::hae_id($id)));
            } else {
                $osa->tallenna($id);
                Redirect::to('/esittelyOsa/' . $osa->id);
            }
        }
    }

}
