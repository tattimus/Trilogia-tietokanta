<?php

class Kayttaja extends BaseModel {

    public $id, $tunnus, $salasana;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validoi_tunnus', 'validoi_ss');
    }
    
    public static function kaikki() {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $kysely->execute();
        $rivit = $kysely->fetchAll();
        $kayttajat = array();
        foreach ($rivit as $rivi) {
            $kayttajat[] = new Kayttaja(array('id' => $rivi['id'],
                'tunnus' => $rivi['tunnus'], 'salasana' => $rivi['salasana']));
        }
        return $kayttajat;
    }
    
    public static function etsi_kayttaja($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $kysely->execute(array('id'=>$id));
        $rivi = $kysely->fetch();
        if($rivi) {
            $kayttaja = new Kayttaja(array('id' => $rivi['id'],
                'tunnus' => $rivi['tunnus'], 'salasana' => $rivi['salasana']));
            return $kayttaja;
        }
        return null;
    }
    
    public static function etsi_tunnuksella($tunnus) {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE tunnus = :tunnus');
        $kysely->execute(array('tunnus' => $tunnus));
        $rivi = $kysely->fectch();
        if ($rivi) {
            $kayttaja = new Kayttaja(array('id' => $rivi['id'],
                'tunnus' => $rivi['tunnus'], 'salasana' => $rivi['salasana']));
            return $kayttaja;
        }
        return null;
    }
    
    public static function todennus($tunnus, $salasana) {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE tunnus = :tunnus AND salasana = :salasana LIMIT 1');
        $kysely->execute(array('tunnus' => $tunnus, 'salasana' => $salasana));
        $rivi = $kysely->fetch();
        if ($rivi) {
            $kayttaja = new Kayttaja(array('id' => $rivi['id'], 'tunnus' => $rivi['tunnus'], 'salasana' => $rivi['salasana']));
            return $kayttaja;
        }
        return null;
    }
}
