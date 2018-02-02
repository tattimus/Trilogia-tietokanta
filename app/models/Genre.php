<?php

class Genre extends BaseModel {
    
    public $id ,$nimi;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
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
            $genre = new Genre(array('is' => $rivi['id'], 'nimi' => $rivi['nimi']));
            return $genre;
        }
        return null;
    }
}
