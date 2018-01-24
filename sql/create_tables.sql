CREATE TABLE Kayttaja(
id SERIAL PRIMARY KEY,
tunnus varchar(20) NOT NULL,
salasana varchar(20) NOT NULL
);

CREATE TABLE Trilogia(
id SERIAL PRIMARY KEY,
kayttaja_id INTEGER REFERENCES Kayttaja(id),
nimi varchar(50) NOT NULL,
arvio INTEGER NOT NULL,
media varchar(15) NOT NULL,
sanallinen_Arvio varchar(300)
);

CREATE TABLE Trilogian_osa(
id SERIAL PRIMARY KEY,
trilogia_id INTEGER REFERENCES Trilogia(id),
kayttaja_id INTEGER REFERENCES Kayttaja(id),
nimi varchar(50) NOT NULL,
monesko_osa INTEGER NOT NULL,
arvio INTEGER NOT NULL,
media varchar(15) NOT NULL,
julkaistu DATE NOT NULL,
sanallinen_Arvio varchar(300)
);

CREATE TABLE Genre(
id SERIAL PRIMARY KEY,
nimi varchar(15)
);

CREATE TABLE GenreLiitos_trilogia(
trilogia_id INTEGER REFERENCES Trilogia(id),
genre_id INTEGER REFERENCES Genre(id)
);

CREATE TABLE GenreLiitos_osa(
osa_id INTEGER REFERENCES Trilogian_osa(id),
genre_id INTEGER REFERENCES Genre(id)
);
