/* Table des Salles. 
    -- id_usager : l'id de l'usager (clé primaire).
    -- identifiant : l'identifiant prenom_nom.
    -- mot_de_passe : le mot de passe.
    -- type_usager : son type (Etudiant, Enseignant, Admin)
    (clée étrangère associé la l'id_role de la table RoleUsagers)
*/
DROP TABLE IF EXISTS Usagers;
CREATE TABLE Usagers (
    id_usager INTEGER PRIMARY KEY AUTOINCREMENT,
    identifiant VARCHAR(25) NOT NULL,
    mot_de_passe VARCHAR NOT NULL,
    type_usager INTEGER NOT NULL DEFAULT 1,
    CONSTRAINT usager_type_fk FOREIGN KEY (type_usager) REFERENCES RoleUsagers(id_role) ON DELETE CASCADE
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
    -- id_salle : l'id de la salle (clé primaire).
    -- nom_salle : le nom de la salle.
*/
DROP TABLE IF EXISTS Salles;
CREATE TABLE Salles (
    id_salle INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_salle VARCHAR(25) NOT NULL
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

/* Table des types de cours. 
    -- id_type : l'id du type du cour (clé primaire).
    -- nom_type : le nom du type du cour.
*/
DROP TABLE IF EXISTS TypeCours;
CREATE TABLE TypeCours (
    id_type INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_type VARCHAR(25) NOT NULL
);

/* Association entre les cours et leurs enseignants.
    -- id_cour : l'id du cour (clé primaire).
    -- id_usager : l'id de l'étudiant (clé primaire).
    (clés étrangères associant l'id d'un cour avec la table Cours et l'id de l'étudiant avec la table Usagers).
*/
DROP TABLE IF EXISTS Etudier;
CREATE TABLE Etudier (
    id_cour INTEGER REFERENCES Cours(id_cour) ON DELETE CASCADE,
    id_etudiant INTEGER REFERENCES Usagers(id_usager) ON DELETE CASCADE,
    CONSTRAINT etudier_pk PRIMARY KEY (id_cour, id_etudiant)
);