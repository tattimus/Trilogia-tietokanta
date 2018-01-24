-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja(
  id SERIAL PRIMARY KEY,
  tunnus varchar(20) NOT NULL,
  salasana varchar(20) NOT NULL,
);

CREATE TABLE Trilogia(
  id SERIAL PRIMARY KEY,
  kayttaja_id INTEGER REFERENCES Kayttaja(id),
  nimi varchar(50) NOT NULL,
  arvio DECIMAL(1,1) NOT NULL,
  media varchar(15) NOT NULL,
  sanaArvio varchar(300)
);

CREATE TABLE TrilogianOsa(
  id SERIAL PRIMARY KEY,
  trilogia_id INTEGER REFERENCES Trilogia(id),
  kayttaja_id INTEGER REFERENCES Kayttaja(id),
  nimi varchar(50) NOT NULL,
  arvio DECIMAL(1,1) NOT NULL,
  media varchar(15) NOT NULL,
  julkaistu DATE NOT NULL,
  sanaArvio varchar(300)
);

CREATE TABLE Genre(
  id SERIAL PRIMARY KEY,
  nimi varchar(15)
);

CREATE TABLE GenreLiitosT(
  trilogia_id INTEGER REFERENCES Trilogia(id),
  genre_id INTEGER REFERENCES Genre(id)
);

CREATE TABLE GenreLiitosO(
  osa_id INTEGER REFERENCES TrilogianOsa(id),
  genre_id INTEGER REFERENCES Genre(id)
);
