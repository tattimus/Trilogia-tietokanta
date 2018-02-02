<?php

class TrilogiaController extends BaseController {
    
    public static function listaaTrilogiat() {
        $trilogiat = Trilogia::kaikki();
        View::make('suunnitelmat/listaus.html', array('trilogiat' => $trilogiat));
    }
    
    public static function esittely($id) {
        $trilogia = Trilogia::hae_id($id);
        $osat = trilogian_osa::hae_trilogialla($id);
        View::make('suunnitelmat/esittelyT.html', array('trilogia' => $trilogia), array('osat' => $osat));
    }
}
