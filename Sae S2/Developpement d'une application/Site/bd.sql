CREATE TABLE login (
    id_user INTEGER PRIMARY KEY,
    nom VARCHAR NOT NULL,
    prenom VARCHAR NOT NULL,
    username VARCHAR NOT NULL,
    password VARCHAR NOT NULL);
    
    
    
INSERT INTO login VALUES (12213097, 'BELMESSAOUD', 'Imran', 'imran.belmessaoud@edu.univ-paris13.fr', 'root');

INSERT INTO login VALUES (12208158, 'ATICI', 'Michael', 'michael.atici@edu.univ-paris13.fr', 'root95');

INSERT INTO login VALUES (12207851, 'ABELARD', 'Rodlens', 'rodlens.abelard@edu.univ-paris13.fr', 'rootcergy');

INSERT INTO login VALUES (12103751, 'LADDADA', 'Anis', 'anis.laddada@edu.univ-paris13.fr', 'root94');

INSERT INTO login VALUES (12121212, 'MANSEUR', 'Nassim', 'nassim.manseur@edu.univ-paris13.fr', 'rootneuille');

INSERT INTO login VALUES (12001200, 'HEBERT', 'David', 'hebert.iut@gmail.com', 'WILZOIdechiffreravecLEFLOP');

INSERT INTO personne (id_personne, nom, prenom, email, motDePasse) VALUES (120, 'RAOUL', 'Mani', 'mani.raoul@edu.univ-paris13.fr', 'root50');
INSERT INTO personne (id_personne, nom, prenom, email, motDePasse) VALUES (121, 'PARKER', 'Peter', 'peter.parker@edu.univ-paris13.fr', 'root51');
INSERT INTO personne (id_personne, nom, prenom, email, motDePasse) VALUES (122, 'MACHIN', 'Rate', 'rate.machin@edu.univ-paris13.fr', 'root52');
INSERT INTO personne (id_personne, nom, prenom, email, motDePasse) VALUES (123, 'HASOUL', 'Chef', 'chef.hasoul@edu.univ-paris13.fr', 'root53');
INSERT INTO personne (id_personne, nom, prenom, email, motDePasse) VALUES (124, 'RAMI', 'Adil', 'adil.rami@edu.univ-paris13.fr', 'root54');
INSERT INTO personne (id_personne, nom, prenom, email, motDePasse) VALUES (125, 'HATAY', 'Garcon', 'garcon.hatay@edu.univ-paris13.fr', 'root55');
INSERT INTO personne (id_personne, nom, prenom, email, motDePasse) VALUES (126, 'PETIT', 'Kirikou', 'kirikou.petit@edu.univ-paris13.fr', 'root56');
INSERT INTO personne (id_personne, nom, prenom, email, motDePasse) VALUES (127, 'COUTEAU', 'Ziak', 'ziak.couteau@edu.univ-paris13.fr', 'root57');
INSERT INTO personne (id_personne, nom, prenom, email, motDePasse) VALUES (128, 'ZEBI', 'Macoupe', 'macoupe.zebi@edu.univ-paris13.fr', 'root58');
INSERT INTO personne (id_personne, nom, prenom, email, motDePasse) VALUES (129, 'RONALDO', 'Christiano', 'christiano.ronaldo@edu.univ-paris13.fr', 'root59');


INSERT INTO categorie (id_categorie, sigleCat, libelleCat, serviceStatutaire, serviceComplementaireReferentiel, ServiceComplementaireEnseignement) VALUES (126, 'CDD', 'Contrat à Durée Déterminée', 10, E'\\x228552', 7);
INSERT INTO categorie (id_categorie, sigleCat, libelleCat, serviceStatutaire, serviceComplementaireReferentiel, ServiceComplementaireEnseignement) VALUES (127, 'CDI', 'Contrat à Durée Indéterminée', 16, E'\\x221627', 9);
INSERT INTO categorie (id_categorie, sigleCat, libelleCat, serviceStatutaire, serviceComplementaireReferentiel, ServiceComplementaireEnseignement) VALUES (128, 'CDD', 'Contrat à Durée Déterminée', 12, E'\\x222852', 7);
INSERT INTO categorie (id_categorie, sigleCat, libelleCat, serviceStatutaire, serviceComplementaireReferentiel, ServiceComplementaireEnseignement) VALUES (129, 'CDI', 'Contrat à Durée Indéterminée', 16, E'\\x259627', 9);

INSERT INTO enseignant (id_enseignant, id_discipline, id_categorie, AA) VALUES (120, 2, 120, 2024);
INSERT INTO enseignant (id_enseignant, id_discipline, id_categorie, AA) VALUES (121, 2, 121, 2024);
INSERT INTO enseignant (id_enseignant, id_discipline, id_categorie, AA) VALUES (122, 2, 122, 2024);
INSERT INTO enseignant (id_enseignant, id_discipline, id_categorie, AA) VALUES (123, 2, 123, 2024);
INSERT INTO enseignant (id_enseignant, id_discipline, id_categorie, AA) VALUES (124, 2, 124, 2024);
INSERT INTO enseignant (id_enseignant, id_discipline, id_categorie, AA) VALUES (125, 2, 125, 2024);
INSERT INTO enseignant (id_enseignant, id_discipline, id_categorie, AA) VALUES (126, 2, 126, 2024);
INSERT INTO enseignant (id_enseignant, id_discipline, id_categorie, AA) VALUES (127, 2, 127, 2024);
INSERT INTO enseignant (id_enseignant, id_discipline, id_categorie, AA) VALUES (128, 2, 128, 2024);
INSERT INTO enseignant (id_enseignant, id_discipline, id_categorie, AA) VALUES (129, 2, 129, 2024);

