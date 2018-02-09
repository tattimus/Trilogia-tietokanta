<?php

class Genreliitos_trilogia extends BaseModel {
    
    public $trilogia_id, $genre_id;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public function poista() {
        $kysely = DB::connection()->prepare('DELETE FROM Genreliitos_trilogia WHERE trilogia_id = :id');
        $kysely->execute(array('id' => $this->trilogia_id));
    }
}

