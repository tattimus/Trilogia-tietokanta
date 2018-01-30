<?php

class Trilogia extends BaseModel {

    public $id, $kayttaja_id, $nimi, $arvio, $media, $sanallinen_Arvio;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function kaikki() {
        $kysely = DB::connection()->prepare('SELECT * FROM Trilogia');
        $kysely->execute();
        $rivit = $kysely->fetchAll();
        $trilogiat = array();
        foreach ($rivit as $rivi) {
            $trilogiat[] = new Trilogia(array('id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'nimi' => $rivi['nimi'],
                'arvio' => $rivi['arvio'],
                'media' => $rivi['media'],
                'sanallinen_arvio' => $rivi['sanallinen_arvio']));
        }
        return $trilogiat;
    }

    public static function hae_id($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Trilogia WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));
        $rivi = $kysely->fetch();
        if ($rivi) {
            $trilogia = new Trilogia(array('id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'nimi' => $rivi['nimi'],
                'arvio' => $rivi['arvio'], 
                'media' => $rivi['media'],
                'sanallinen_arvio' => $rivi['sanallinen_arvio']));
            return $trilogia;
        }
        return null;
    }

}
