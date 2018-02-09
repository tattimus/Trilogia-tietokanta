<?php

class Trilogia extends BaseModel {

    public $id, $kayttaja_id, $nimi, $arvio, $media, $sanallinen_arvio;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validoi_nimi','validoi_media','validoi_sanallinen');
    }

    public static function kaikki() {
        $kysely = DB::connection()->prepare('SELECT * FROM Trilogia WHERE kayttaja_id = :kayttaja_id');
        $kysely->execute(array('kayttaja_id' => $_SESSION['user']));
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
        $kysely->execute(array('kayttaja_id' => $this->kayttaja_id, 'nimi' => $this -> nimi, 'arvio' => $this -> arvio, 
            'media' => $this -> media, 'sanallinen_arvio' => $this -> sanallinen_arvio));
        $rivi = $kysely->fetch();
        $this->id = $rivi['id'];
        
    }
    
    public function muokkaa() {
        $kysely = DB::connection()->prepare('UPDATE Trilogia SET nimi = :nimi, arvio = :arvio, media = :media, sanallinen_arvio = :sanallinen_arvio WHERE id = :id');
        $kysely->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'arvio' => $this->arvio, 'media' => $this->media, 'sanallinen_arvio' => $this->sanallinen_arvio));
    }

    public function poista() {
        $kysely = DB::connection()->prepare('DELETE FROM Trilogia WHERE id = :id');
        $kysely->execute(array('id' => $this->id));
    }

}
