/* Table des Formations. 
    -- id_form : l'id de la formation (clé primaire).
    -- nom_form : le nom de la formation.
*/
DROP TABLE IF EXISTS Formations;
CREATE TABLE Formations (
    id_form INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_form VARCHAR(25) NOT NULL
);

/* Table des Promotions. 
    -- id_promo : l'id du role (clé primaire).
    -- nom_promo : le role de l'usager.
*/
DROP TABLE IF EXISTS Promotions;
CREATE TABLE Promotions (
    id_promo INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_promo VARCHAR(25) NOT NULL,
    id_form INTEGER NOT NULL,
    CONSTRAINT promo_formation_fk FOREIGN KEY (id_form) REFERENCES Formations(id_form) ON DELETE CASCADE

);

/* Table des roleUsager. 
    -- id_role : l'id du role (clé primaire).
    -- nom_role : le role de l'usager.
*/
DROP TABLE IF EXISTS RoleUsagers;
CREATE TABLE RoleUsagers (
    id_role INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_role VARCHAR(25) NOT NULL
);

/* Table des Salles. 
    -- id_usager : l'id de l'usager (clé primaire).
    -- identifiant : l'identifiant prenom_nom.
    -- mot_de_passe : le mot de passe.
    -- nom_usager : son nom.
    -- prenom_usager : son prénom.
    -- id_role : son type (Etudiant, Enseignant, Admin)
    (clée étrangère associé la l'id_role de la table RoleUsagers)
    -- id_promo : sa promo (L3-INFO, L2-MATH, ...)
    (clée étrangère associé la l'id_promo de la table Promotions)
*/
DROP TABLE IF EXISTS Usagers;
CREATE TABLE Usagers (
    id_usager INTEGER PRIMARY KEY AUTOINCREMENT,
    identifiant VARCHAR(30) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    nom_usager VARCHAR(15) NOT NULL,
    prenom_usager VARCHAR(20) NOT NULL,
    id_role INTEGER NOT NULL,
    id_promo INTEGER DEFAULT NULL,
    CONSTRAINT usager_type_fk FOREIGN KEY (id_role) REFERENCES RoleUsagers(id_role) ON DELETE CASCADE
);

/* Table des Salles. 
    -- id_salle : l'id de la salle (clé primaire).
    -- nom_salle : le nom de la salle.
*/
DROP TABLE IF EXISTS Salles;
CREATE TABLE Salles (
    id_salle INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_salle VARCHAR NOT NULL
);

/* Table des types de cours. 
    -- id_type : l'id du type du cour (clé primaire).
    -- nom_type : le nom du type du cour.
*/
DROP TABLE IF EXISTS TypeCours;
CREATE TABLE TypeCours (
    id_type INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_type VARCHAR NOT NULL
);

/* Table des Cours. 
    -- id_cour : l'id de l'usager (clé primaire).
    -- nom_cour : le nom du cours.
    -- date_cour : la date du cour.
    -- heure_debut : l'heure de début du cour.
    -- heure_fin : l'heure de fin du cour.
    -- type_cour : le type (Cours, TD, TP).
    (clée étrangère associé la l'id_type de la table TypeCours)
    -- id_enseignant : l'id de l'enseignant.
    (clée étrangère associé la l'id_usager de la table Usagers)
    -- id_salle : l'id de la salle.
    (clée étrangère associé la l'id_salle de la table Salles)
*/
DROP TABLE IF EXISTS Cours;
CREATE TABLE Cours (
    id_cour INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_cour VARCHAR(25) NOT NULL,
    date_cour VARCHAR NOT NULL, 
    heure_debut time NOT NULL,
    heure_fin time NOT NULL,
    type_cour INTEGER NOT NULL,
    id_enseignant INTEGER,
    id_salle INTEGER NOT NULL,
    CONSTRAINT cour_type_fk FOREIGN KEY (type_cour) REFERENCES TypeCours(id_type) ON DELETE CASCADE,
    CONSTRAINT cour_enseignant_fk FOREIGN KEY (id_enseignant) REFERENCES Usagers(id_usager) ON DELETE CASCADE,
    CONSTRAINT cour_salle_fk FOREIGN KEY (id_salle) REFERENCES Salle(id_salle) ON DELETE CASCADE
);