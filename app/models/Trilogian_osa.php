<?php

class trilogian_osa extends BaseModel {

    public $id, $trilogia_id, $kayttaja_id, $nimi, $monesko_osa, $arvio, $media, $julkaistu, $sanallinen_arvio;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validoi_nimi', 'validoi_media', 'validoi_sanallinen', 'validoi_pvm');
    }

    public static function kaikki() {
        $kysely = DB::connection()->prepare('SELECT * FROM Trilogian_osa');
        $kysely->execute();
        $rivit = $kysely->fetchAll();
        $osat = array();
        foreach ($rivit as $rivi) {
            $osat[] = new trilogian_osa(array('id' => $rivi['id'],
                'trilogia_id' => $rivi['trilogia_id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'nimi' => $rivi['nimi'],
                'monesko_osa' => $rivi['monesko_osa'],
                'arvio' => $rivi['arvio'],
                'media' => $rivi['media'],
                'julkaistu' => $rivi['julkaistu'],
                'sanallinen_arvio' => $rivi['sanallinen_arvio']));
        }
        return $osat;
    }

    public static function hae_id($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Trilogian_osa WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));
        $rivi = $kysely->fetch();
        if ($rivi) {
            $osa = new trilogian_osa(array('id' => $rivi['id'],
                'trilogia_id' => $rivi['trilogia_id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'nimi' => $rivi['nimi'],
                'monesko_osa' => $rivi['monesko_osa'],
                'arvio' => $rivi['arvio'],
                'media' => $rivi['media'],
                'julkaistu' => $rivi['julkaistu'],
                'sanallinen_arvio' => $rivi['sanallinen_arvio']));
            return $osa;
        }
        return null;
    }

    public static function hae_kayttajalla($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Trilogian_osa WHERE kayttaja_id = :id');
        $kysely->execute(array('id' => $id));
        $rivit = $kysely->fetchAll();
        $osat = array();
        if ($rivit) {
            foreach ($rivit as $rivi) {
                $osat[] = new trilogian_osa(array('id' => $rivi['id'],
                    'trilogia_id' => $rivi['trilogia_id'],
                    'kayttaja_id' => $rivi['kayttaja_id'],
                    'nimi' => $rivi['nimi'],
                    'monesko_osa' => $rivi['monesko_osa'],
                    'arvio' => $rivi['arvio'],
                    'media' => $rivi['media'],
                    'julkaistu' => $rivi['julkaistu'],
                    'sanallinen_arvio' => $rivi['sanallinen_arvio']));
            }
            return $osat;
        }
        return null;
    }

    public static function hae_trilogialla($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Trilogian_osa WHERE trilogia_id = :id');
        $kysely->execute(array('id' => $id));
        $rivit = $kysely->fetchAll();
        $osat = array();

        foreach ($rivit as $rivi) {
            list($v, $k, $p) = explode('-', $rivi['julkaistu']);
            $uusi = $p . '.' . $k . '.' . $v;
            $julkaistu = array();
            $julkaistu[] = $uusi;
            $osat[] = new trilogian_osa(array('id' => $rivi['id'],
                'trilogia_id' => $rivi['trilogia_id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'nimi' => $rivi['nimi'],
                'monesko_osa' => $rivi['monesko_osa'],
                'arvio' => $rivi['arvio'],
                'media' => $rivi['media'],
                'julkaistu' => $julkaistu[0],
                'sanallinen_arvio' => $rivi['sanallinen_arvio']));
        }
        return $osat;
    }

    public static function trilogia_id($id) {
        $kysely = DB::connection()->prepare('SELECT DISTINCT trilogia_id FROM Trilogian_osa WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));
        $rivi = $kysely->fetch();
        $trilogia_id = $rivi['trilogia_id'];
        return $trilogia_id;
    }

    public function tallenna($id) {
        $kysely = DB::connection()->prepare('INSERT INTO Trilogian_osa (trilogia_id, kayttaja_id, nimi, arvio, monesko_osa, media, julkaistu, sanallinen_arvio) '
                . 'VALUES (:trilogia_id, :kayttaja_id, :nimi, :arvio, :monesko_osa, :media, :julkaistu, :sanallinen_arvio) RETURNING id');
        $kysely->execute(array('trilogia_id' => $id, 'kayttaja_id' => $this->kayttaja_id, 'nimi' => $this->nimi, 'arvio' => $this->arvio,
            'monesko_osa' => $this->monesko_osa, 'media' => $this->media, 'julkaistu' => $this->julkaistu, 'sanallinen_arvio' => $this->sanallinen_arvio));
        $rivi = $kysely->fetch();
        $this->id = $rivi['id'];
    }

    public function muokkaa() {
        $kysely = DB::connection()->prepare('UPDATE Trilogian_osa SET nimi = :nimi, arvio = :arvio, media = :media, julkaistu = :julkaistu, sanallinen_arvio = :sanallinen_arvio WHERE id = :id');
        $kysely->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'arvio' => $this->arvio, 'media' => $this->media, 'julkaistu' => $this->julkaistu, 'sanallinen_arvio' => $this->sanallinen_arvio));
    }

    public function poista() {
        $kysely = DB::connection()->prepare('DELETE FROM Trilogian_osa WHERE trilogia_id = :id');
        $kysely->execute(array('id' => $this->trilogia_id));
    }

}
