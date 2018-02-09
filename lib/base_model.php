<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            $nimi = $validator;
            $error = $this->{$nimi}();
            $errors = array_merge($errors, $error);
        }

        return $errors;
    }

    public function validoi_nimi() {
        $errors = array();
        if (strlen($this->nimi) < 4 || $this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Nimen pituuden tulee olla vähintään 4 merkkiä!';
        } elseif (strlen($this->nimi) > 50) {
            $errors[] = 'Nimi saa olla korkeintaan 50 merkkiä pitkä!';
        }
        return $errors;
    }

    public function validoi_media() {
        $errors = array();
        if (strlen($this->media) < 3 || $this->media == '' || $this->media == null) {
            $errors[] = 'Median tulee olla vähintään 3 merkkiä pitkä!';
        } elseif (strlen($this->media) > 15) {
            $errors[] = 'Media saa olla korkeintaan 15 merkkiä pitkä!';
        }
        return $errors;
    }

    public function validoi_sanallinen() {
        $errors = array();
        if (strlen($this->sanallinen_arvio) > 300) {
            $errors[] = 'Sanallinen arvio saa olla korkeintaan 300 merkkiä pitkä!';
        }
        return $errors;
    }

    public function validoi_genrenimi() {
        $errors = array();
        if ($this->nimi == null || $this->nimi == '' || strlen($this->nimi) < 3) {
            $errors[] = 'Genren nimi tulee olla vähintään kolme merkkiä pitkä!';
        } elseif (strlen($this->nimi) > 15) {
            $errors[] = 'Genren nimi saa olla korkeintaan 15 merkkiä pitkä!';
        }
        return $errors;
    }

    public function validoi_tunnus() {
        $errors = array();
        if ($this->tunnus == '' || $this->tunnus == null || strlen($this->tunnus) < 3) {
            $errors[] = 'Tunnuksesi tulee olla vähintään kolme merkkiä pitkä.';
        } elseif (strlen($this->tunnus) > 20) {
            $errors = 'Tunnuksesi saa olla korkeintaan 20 merkkiä pitkä.';
        }
        return $errors;
    }

    public function validoi_ss() {
        $errors = array();
        if ($this->salasana == '' || $this->salasana == null || strlen($this->salasana) < 4) {
            $errors[] = 'Salasanasi tulee olla vähintään neljä merkkiä pitkä.';
        } elseif (strlen($this->salasana) > 20) {
            $errors[] = 'Salasanasi voi olla korkeintaan 20 merkkiä pitkä';
        }
        return $errors;
    }

    public function validoi_pvm() {
        $errors = array();
        $pvm = explode('.', $this->julkaistu);
        if (checkdate($pvm[1], $pvm[0], $pvm[2]) == false) {
            $errors[] = 'Anna päivämäärä muodossa päivä.kuukausi.vuosi.';
        }
        return $errors;
    }

}
