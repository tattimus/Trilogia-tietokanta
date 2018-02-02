<?php

class OsaController extends BaseController {
    
    public static function Osan_esittely($id) {
        $osa = trilogian_osa::hae_id($id);
        $trilogia = Trilogia::hae_id(trilogian_osa::trilogia_id($id));
        View::make('suunnitelmat/esittelyO.html', array('osa' => $osa, 'trilogia' => $trilogia));
    }
    
}

