<?php

class Genre extends BaseModel {
    
    public $id ,$nimi;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validoi_genrenimi');
    }
    
    public static function hae_id($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Genre WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));
        $rivi = $kysely->fetch();
        if ($rivi) {
            $genre = new Genre(array('id' => $rivi['id'], 'nimi' => $rivi['nimi']));
            return $genre;
        }
        return null;
    }
    
    public static function get_id($nimi) {
        $kysely = DB::connection()->prepare('SELECT * FROM Genre WHERE nimi = :nimi LIMIT 1');
        $kysely->execute(array('nimi' => $nimi));
        $rivi = $kysely->fetch();
        if ($rivi) {
            $genre = new Genre(array('id' => $rivi['id'], 'nimi' => $rivi['nimi']));
            return $genre;
        }
        return null;
    }
    
    public static function hae_trilogialla($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Genre JOIN Genreliitos_trilogia ON Genre.id = Genreliitos_trilogia.genre_id WHERE trilogia_id = :id');
        $kysely->execute(array('id' => $id));
        $rivit = $kysely->fetchAll();
        $genret = array();
        foreach ($rivit as $rivi) {
            $genret[] = new Genre(array('nimi' => $rivi['nimi']));
        }
        return $genret;
    }


    public function tallenna($trilogia_id) {
        $kysely = DB::connection()->prepare('INSERT INTO Genre (nimi) VALUES (:nimi)');
        $kysely->execute(array('nimi' => $this->nimi));
        $rivi = Genre::get_id($this->nimi);
        $genre_id = $rivi->id;
        $genreliitos = new Genreliitos_trilogia(array('trilogia_id' => $trilogia_id, 'genre_id' => $genre_id));
        $genreliitos->tallenna();
    }
}
