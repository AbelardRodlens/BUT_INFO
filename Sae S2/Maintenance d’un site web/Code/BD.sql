DROP TABLE IF EXISTS estDans CASCADE;
DROP TABLE IF EXISTS dirige CASCADE;  
DROP TABLE IF EXISTS DEMI_JOUR CASCADE; 
DROP TABLE IF EXISTS JOUR CASCADE; 
DROP TABLE IF EXISTS PLAGE_HORAIRE CASCADE;
DROP TABLE IF EXISTS NB_HEURE CASCADE; 
DROP TABLE IF EXISTS ACTIVITE CASCADE; 
DROP TABLE IF EXISTS BON_DE_LIVRAISON CASCADE; 
DROP TABLE IF EXISTS MISSION CASCADE; 
DROP TABLE IF EXISTS COMPOSANTE CASCADE; 
DROP TABLE IF EXISTS Adresse CASCADE; 
DROP TABLE IF EXISTS TypeVoie CASCADE; 
DROP TABLE IF EXISTS Localite CASCADE;  
DROP TABLE IF EXISTS GESTIONNAIRE CASCADE ;
DROP TABLE IF EXISTS ADMINISTRATEUR CASCADE ; 
DROP TABLE IF EXISTS COMMERCIAL CASCADE ; 
DROP TABLE IF EXISTS INTERLOCUTEUR CASCADE ; 
DROP TABLE IF EXISTS CLIENT CASCADE ;
DROP TABLE IF EXISTS PRESTATAIRE CASCADE; 
DROP TABLE IF EXISTS PERSONNE CASCADE;
DROP TABLE IF EXISTS Rattache CASCADE;


CREATE TABLE PERSONNE(
   id_personne SERIAL PRIMARY KEY,
   prenom VARCHAR(50) NOT NULL,
   nom VARCHAR(50) NOT NULL,
   email VARCHAR(50),
   mdp VARCHAR(50),
   UNIQUE(email)
);

CREATE TABLE PRESTATAIRE(
   id_personne SERIAL PRIMARY KEY,
   FOREIGN KEY(id_personne) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE CLIENT(
   id_client SERIAL PRIMARY KEY,
   nom_client VARCHAR(50) NOT NULL,
   telephone_client VARCHAR(50)
);

CREATE TABLE INTERLOCUTEUR(
   id_personne SERIAL PRIMARY KEY,
   FOREIGN KEY(id_personne) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE COMMERCIAL(
   id_personne SERIAL PRIMARY KEY,
   FOREIGN KEY(id_personne) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE ADMINISTRATEUR(
   id_personne SERIAL PRIMARY KEY,
   FOREIGN KEY(id_personne) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE GESTIONNAIRE(
   id_personne SERIAL PRIMARY KEY,
   FOREIGN KEY(id_personne) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE Localite(
   id_localite SERIAL PRIMARY KEY,
   cp INT,
   ville VARCHAR(50)
);

CREATE TABLE TypeVoie(
   id SERIAL PRIMARY KEY,
   libelle VARCHAR(50)
);

CREATE TABLE Adresse(
   id_adresse SERIAL PRIMARY KEY,
   numero INT,
   nomVoie VARCHAR(50),
   id INT NOT NULL,
   id_localite INT NOT NULL,
   FOREIGN KEY(id) REFERENCES TypeVoie(id),
   FOREIGN KEY(id_localite) REFERENCES Localite(id_localite)
);

CREATE TABLE COMPOSANTE(
   id_composante SERIAL PRIMARY KEY,
   nom_composante VARCHAR(50),
   id_adresse INT NOT NULL,
   id_client INT NOT NULL,
   FOREIGN KEY(id_adresse) REFERENCES Adresse(id_adresse),
   FOREIGN KEY(id_client) REFERENCES CLIENT(id_client)
);

CREATE TABLE MISSION(
   id_mission SERIAL PRIMARY KEY,
   nom_mission VARCHAR(50),
   date_debut DATE,
   id_composante INT NOT NULL,
   id_personne INT NOT NULL,
   FOREIGN KEY(id_composante) REFERENCES COMPOSANTE(id_composante),
   FOREIGN KEY(id_personne) REFERENCES PRESTATAIRE(id_personne)
);

CREATE TABLE BON_DE_LIVRAISON(
   id_bdl SERIAL PRIMARY KEY,
   annee VARCHAR(50),
   mois VARCHAR(50),
   commentaire VARCHAR(50),
   signatureInterlocuteur VARCHAR(50),
   signaturePrestataire VARCHAR(50),
   id_personne INT NOT NULL,
   id_mission INT NOT NULL,
   FOREIGN KEY(id_personne) REFERENCES INTERLOCUTEUR(id_personne),
   FOREIGN KEY(id_mission) REFERENCES MISSION(id_mission)
);

CREATE TABLE ACTIVITE(
   id_activite SERIAL PRIMARY KEY,
   commentaire VARCHAR(50),
   date_bdl DATE,
   id_bdl INT NOT NULL,
   FOREIGN KEY(id_bdl) REFERENCES BON_DE_LIVRAISON(id_bdl)
);

CREATE TABLE NB_HEURE(
   id_activite SERIAL PRIMARY KEY,
   nb_heure INT,
   FOREIGN KEY(id_activite) REFERENCES ACTIVITE(id_activite)
);

CREATE TABLE PLAGE_HORAIRE(
   id_activite SERIAL PRIMARY KEY,
   heure_debut TIME,
   fin_heure TIME,
   FOREIGN KEY(id_activite) REFERENCES ACTIVITE(id_activite)
);

CREATE TABLE JOUR(
   id_activite SERIAL PRIMARY KEY,
   journee BOOLEAN,
   debut_heure_supp INT,
   fin_heure_supp INT,
   FOREIGN KEY(id_activite) REFERENCES ACTIVITE(id_activite)
);

CREATE TABLE DEMI_JOUR(
   id_activite SERIAL PRIMARY KEY,
   matin BOOLEAN,
   apres_midi BOOLEAN,
   soir BOOLEAN,
   FOREIGN KEY(id_activite) REFERENCES ACTIVITE(id_activite)
);

CREATE TABLE dirige(
   id_composante INT,
   id_personne INT,
   PRIMARY KEY(id_composante, id_personne),
   FOREIGN KEY(id_composante) REFERENCES COMPOSANTE(id_composante),
   FOREIGN KEY(id_personne) REFERENCES INTERLOCUTEUR(id_personne)
);

CREATE TABLE estDans(
   id_composante INT,
   id_personne INT,
   PRIMARY KEY(id_composante, id_personne),
   FOREIGN KEY(id_composante) REFERENCES COMPOSANTE(id_composante),
   FOREIGN KEY(id_personne) REFERENCES COMMERCIAL(id_personne)
);

CREATE TABLE Rattache(
   id_activite INT,
   id_mission INT,
   PRIMARY KEY(id_activite, id_mission),
   FOREIGN KEY(id_activite) REFERENCES ACTIVITE(id_activite),
   FOREIGN KEY(id_mission) REFERENCES MISSION(id_mission)
);


-- Insertion de personnes
INSERT INTO PERSONNE (prenom, nom, email, mdp)
VALUES ('Jean', 'Dupont', 'jean@exemple.com', 'motdepasse1'),
       ('Marie', 'Martin', 'marie@exemple.com', 'motdepasse2'),
       ('Pierre', 'Durand', 'pierre@exemple.com', 'motdepasse3'),
       ('Karim', 'Ahmoud', 'karim@exemple.com', 'motdepasse4'),
       ('David', 'Hébert', 'hebert@exemple.com', 'motdepasse5'),
       ('Franck', 'Butelle', 'butelle@exemple.com', 'motdepasse6'),
       ('Aurelie', 'Nassiet', 'nassiet@exemple.com', 'motdepasse7'),
       ('Vague', 'Kris', 'kris@exemple.com', 'motdepasse8'),
       ('Marya', 'Latif', 'latifmarya@gmail.com', 'mdp'),
       ('Aboubakar', 'Baouchi','aboubakar.baouchi@gmail.com', 'motdepasse10'),
       ('India','Cabo', 'ic@gmail.com', 'hihi'),
       ('Johann','Zidee', 'jz@gmail.com', 'jz');


-- Insertion de prestataires
INSERT INTO PRESTATAIRE (id_personne)
VALUES (1),
       (2),
       (3),
       (4);

-- Insertion de commercial
INSERT INTO COMMERCIAL
VALUES (2), (9);

-- Insertion de gestionnaire
INSERT INTO GESTIONNAIRE (id_personne)
VALUES (9),
	   (10),
       (11);

-- Insertion d'interlocuteurs
INSERT INTO INTERLOCUTEUR (id_personne)
VALUES (5),
       (6),
       (7),
       (8);

--Insertation d'administrateur
INSERT INTO ADMINISTRATEUR (id_personne)
VALUES (12);

-- Insertion de clients
INSERT INTO CLIENT  (nom_client)
VALUES ('Sony Corporation'),
       ('Amazon');

-- insertion adresses
INSERT INTO  LOCALITE (cp, ville)
VALUES ( 95120, 'Ermont'),
	   ( 93800, 'Épinay-sur-Seine');

INSERT INTO TYPEVOIE (libelle)
VALUES ('Avenue'),
	   ('Rue'),
       ('Chemin');
       
INSERT INTO ADRESSE (numero, nomVoie,  id, id_localite)
VALUES (1, 'nomVoie1', 1, 1),
	   (2, 'nomVoie2', 2, 2),
	   (1, 'nomVoie3', 2, 2);

-- Insertion de composantes
INSERT INTO COMPOSANTE ( nom_composante, id_client, id_adresse)
VALUES ('Jeux vidéo', 1, 1),
       ('Services', 2, 2),
       ('Électronique', 2, 3);

-- lien interlocuteurs composantes
INSERT INTO DIRIGE (id_composante, id_personne)
VALUES (1, 5),
	   (2, 6),
       (2, 8),
       (3, 7);

-- lien commercial composantes
INSERT INTO estDans (id_composante, id_personne)
VALUES (1, 2),
	   (2, 2),
       (3, 2);

-- Insertion de missions
INSERT INTO MISSION (nom_mission, id_composante, id_personne)
VALUES ('mission-Jeu', 1, 1),
       ('mission-PrimeVidéo', 2, 2),
       ('mission-Électronique', 3, 3);

INSERT INTO BON_DE_LIVRAISON (annee, mois, id_personne, id_mission)
VALUES ('2024','janvier',5, 1),
	   ('2024','septembre',6, 2),
       ('2024','juillet',7, 3);

INSERT INTO ACTIVITE (commentaire, date_bdl, id_bdl)
VALUES ( 'com1', '2024-01-12', 1),
	   ( 'com2', '2024-09-05', 2),
       ( 'com3', '2024-07-09', 3);


INSERT INTO NB_HEURE (id_activite, nb_heure)
VALUES (1, 70),
	   (2, 67);

INSERT INTO DEMI_JOUR (id_activite, matin, apres_midi, soir)
VALUES (3,FALSE, TRUE, FALSE);

INSERT INTO Rattache(id_activite, id_mission)
VALUES (1, 1),
        (2, 2),
        (3, 3);