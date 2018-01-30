INSERT INTO Kayttaja (tunnus, salasana) VALUES ('Demo', 'Demo');
INSERT INTO Trilogia (kayttaja_id, nimi, arvio, media, sanallinen_Arvio) VALUES ('1', 'Mass effect', '4', 'Peli', 'Hyvä ja alkuperäinen tarina. Loistava Trilogia');
INSERT INTO Trilogia (kayttaja_id, nimi, arvio, media, sanallinen_Arvio) VALUES ('1', 'Matrix-trilogia', '5', 'Elokuva', 'Loistava toiminta trilogia mielenkiintoisella tarinalla.');
INSERT INTO Trilogian_osa (nimi, monesko_osa, arvio, media, julkaistu, sanallinen_Arvio) VALUES ('The Matrix', '1', '5', 'Elokuva', '31.3.1999', 'Trilogian ensimmäinen osa on ehdottomasti paras. Hyvin tahditettu ja mukaansa tempaava.');
INSERT INTO Trilogian_osa (nimi, monesko_osa, arvio, media, julkaistu, sanallinen_Arvio) VALUES ('Mass effect 2', '2', '5', 'Peli', '31.3.1999', 'Sarja parhaimmat hahmot ja loistava tarinan jatko ykkösosalle');
INSERT INTO Genre (nimi) VALUES ('Toiminta');
INSERT INTO Genre (nimi) VALUES ('Sci-fi');
