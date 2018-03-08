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
    
    public function tallenna() {
        $kysely = DB::connection()->prepare('INSERT INTO Genreliitos_trilogia (trilogia_id, genre_id) VALUES (:trilogia_id, :genre_id)');
        $kysely->execute(array('trilogia_id' => $this->trilogia_id, 'genre_id' => $this->genre_id));
    }
}

