<?php

class Trilogia extends BaseModel {

    public $id, $kayttaja_id, $nimi, $arvio, $media, $sanallinen_arvio, $genre1, $genre2;

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
            $kysely = DB::connection()->prepare('SELECT nimi FROM Genre JOIN Genreliitos_trilogia ON Genre.id = Genreliitos_trilogia.genre_id WHERE trilogia_id = :id');
            $kysely->execute(array('id' => $rivi['id']));
            $genret = $kysely->fetchAll();
            $genre = array();
            foreach ($genret as $gen) {
                $genre[] = $gen['nimi'];
            }
            $trilogiat[] = new Trilogia(array('id' => $rivi['id'],
                'kayttaja_id' => $rivi['kayttaja_id'],
                'nimi' => $rivi['nimi'],
                'arvio' => $rivi['arvio'],
                'media' => $rivi['media'],
                'sanallinen_arvio' => $rivi['sanallinen_arvio'], 'genre1' => $genre[0],
                'genre2' => $genre[1]));
            
            
            
            
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
    
    public static function haku($parametrit) {
        if (!isset($parametrit['nimi']) && !isset($parametrit['media']) && !isset($parametrit['genre']) && $parametrit['nimi'] != '' && $parametrit['media'] != '' && $parametrit['genre'] != '') {
            return Trilogia::kaikki();
        }
        $options = array(); $options['kayttaja_id'] = $_SESSION['user'];
        if (isset($parametrit['genre'])) {
            $kysely = 'SELECT DISTINCT Trilogia.id AS id, Trilogia.nimi AS nimi, arvio AS arvio, media AS media FROM Trilogia JOIN Genreliitos_trilogia ON Trilogia.id = Genreliitos_trilogia.trilogia_id JOIN Genre ON Genreliitos_trilogia.genre_id = Genre.id WHERE kayttaja_id = :kayttaja_id AND Genre.nimi LIKE :genre';
            $options['genre'] = '%' . $parametrit['genre'] . '%';
        } else {$kysely = 'SELECT * FROM Trilogia'; $kysely .= ' WHERE kayttaja_id = :kayttaja_id';}
        if (isset($parametrit['nimi'])) {$kysely .= ' AND Trilogia.nimi LIKE :nimi'; $options['nimi'] = '%' . $parametrit['nimi'] . '%';}
        if (isset($parametrit['media'])) {$kysely .= ' AND media LIKE :media'; $options['media'] = '%' . $parametrit['media'] . '%';}
        $query = DB::connection()->prepare($kysely); $query->execute($options); $rivit = $query->fetchAll(); $trilogiat = array();
        foreach ($rivit as $rivi) {
            $genret = Genre::hae_trilogialla($rivi['id']);
            $genre1 = $genret[0]->nimi; $genre2 = $genret[1]->nimi;
            $rivi['genre1'] = $genre1; $rivi['genre2'] = $genre2;
            $trilogiat[] = new Trilogia($rivi);
        }
        return $trilogiat;
    }

}
