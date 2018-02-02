<?php

class Trilogia extends BaseModel {

    public $id, $kayttaja_id, $nimi, $arvio, $media, $sanallinen_arvio;

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

    public static function hae_kayttajalla($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Trilogia WHERE kayttaja_id = :id');
        $kysely->execute(array('id' => $id));
        $rivit = $kysely->fetchAll();
        $trilogiat = array();
        if ($rivit) {
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
        return null;
    }
    
    public function tallenna() {
        $kysely = DB::connection()->prepare('INSERT INTO Trilogia (kayttaja_id, nimi, arvio, media, sanallinen_arvio) '
                . 'VALUES (:kayttaja_id, :nimi, :arvio, :media, :sanallinen_arvio) RETURNING id');
        $kysely->execute(array('kayttaja_id' => 1, 'nimi' => $this -> nimi, 'arvio' => $this -> arvio, 
            'media' => $this -> media, 'sanallinen_arvio' => $this -> sanallinen_arvio));
        $rivi = $kysely->fetch();
        $this->id = $rivi['id'];
        
    }

}
