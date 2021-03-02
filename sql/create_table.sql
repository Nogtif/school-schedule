/* Table des Promotions. 
    -- PromotionID : l'id de la promo (clé primaire).
    -- NomPromotion : le nom du role.
    -- FormationID : l'id de la formation.
    (clée étrangère associant la promotion à une formation : FormationID)
*/
DROP TABLE IF EXISTS Promotions;
CREATE TABLE Promotions (
    PromotionID INTEGER  PRIMARY KEY AUTOINCREMENT,
    NomPromotion VARCHAR(25) NOT NULL
);

/* Table des roleUsager. 
    -- RangID : l'id du role (clé primaire).
    -- NomRang : le role de l'usager.
*/
DROP TABLE IF EXISTS Rangs;
CREATE TABLE Rangs (
    RangID INTEGER PRIMARY KEY AUTOINCREMENT,
    NomRang VARCHAR(25) NOT NULL
);

/* Table des Salles. 
    -- UsagerID : l'id de l'usager (clé primaire).
    -- IdentifiantLogin : l'identifiant prenom_nom.
    -- MotDePasse : le mot de passe.
    -- Nom : son nom.
    -- Prenom : son prénom.
    -- RangID : son rang (Etudiant, Enseignant, Admin)
    (clée étrangère associant un usager à son rang : RangID)
    -- PromotionID : sa promo (L3-INFO, L2-MATH, ...)
    (clée étrangère associant un étudiant à sa promotion : PromotionID)
*/
DROP TABLE IF EXISTS Usagers;
CREATE TABLE Usagers (
    UsagerID VARCHAR(30) PRIMARY KEY NOT NULL,
    MotDePasse VARCHAR(255) NOT NULL,
    Nom VARCHAR(15) NOT NULL,
    Prenom VARCHAR(20) NOT NULL,
    RangID INTEGER NOT NULL,
    CONSTRAINT usager_rang_fk FOREIGN KEY (RangID) REFERENCES Rangs(RangID) ON DELETE CASCADE
);

/* Table des Salles. 
    -- SalleID : l'id de la salle (clé primaire).
    -- NomSalle : le nom de la salle.
*/
DROP TABLE IF EXISTS Salles;
CREATE TABLE Salles (
    SalleID INTEGER PRIMARY KEY AUTOINCREMENT,
    NomSalle VARCHAR NOT NULL
);

/* Table des types de cours. 
    -- id_type : l'id du type du cour (clé primaire).
    -- nom_type : le nom du type du cour.
*/
DROP TABLE IF EXISTS TypeCours;
CREATE TABLE TypeCours (
    TypeID INTEGER PRIMARY KEY AUTOINCREMENT,
    NomType VARCHAR NOT NULL
);

/* Table des Matières. 
    -- MatiereID : l'id de l'usager (clé primaire).
    -- NomMatiere : le nom du cours.
    -- CouleurMatiere : la couleur d'affrichage.
    -- PromotionID : l'id de la promotion
    (clée étrangère associant une matière à sa promotion : PromotionID)
*/
DROP TABLE IF EXISTS Matieres;
CREATE TABLE Matieres (
    MatiereID INTEGER PRIMARY KEY AUTOINCREMENT,
    NomMatiere VARCHAR(25) NOT NULL,
    CouleurMatiere VARCHAR(10) NOT NULL,
    PromotionID INTEGER NOT NULL,
    CONSTRAINT cour_promo_fk FOREIGN KEY (PromotionID) REFERENCES Promotions(PromotionID) ON DELETE CASCADE
);

/* Table des Cours. 
    -- PromotionID : l'id de la promo (clé primaire).
    -- CourID : l'id du cour (clé primaire).
    (clés étrangères associant PromotionID avec la table Promotions et CourID avec la table Cours).
    -- DateCour : la date du cour.
    -- HeureDebut : l'heure de début du cour.
    -- HeureFin : l'heure de fin du cour.
    -- UsagerID : l'id de l'enseignant.
    (clée étrangère associant un cour à son enseignant : UsagerID)
    -- TypeID : le type (Cours, TD, TP).
    (clée étrangère associant un cour à son type : TypeID)
    -- SalleID : l'id de la salle.
    (clée étrangère associant un étudiant à sa promotion : SalleID)
*/
DROP TABLE IF EXISTS Cours;
CREATE TABLE Cours (
    CourID INTEGER PRIMARY KEY AUTOINCREMENT,
    MatiereID INTEGER NOT NULL,
    DateCour VARCHAR(30) NOT NULL,
    HeureDebut time NOT NULL,
    HeureFin time NOT NULL,
    UsagerID INTEGER,
    TypeID INTEGER,
    SalleID INTEGER,
    CONSTRAINT cour_matiere_fk FOREIGN KEY (MatiereID) REFERENCES Matieres(MatiereID) ON DELETE CASCADE,
    CONSTRAINT cour_enseignant_fk FOREIGN KEY (UsagerID) REFERENCES Usagers(UsagerID) ON DELETE CASCADE,
    CONSTRAINT cour_type_fk FOREIGN KEY (TypeID) REFERENCES TypeCours(TypeID) ON DELETE CASCADE,
    CONSTRAINT cour_salle_fk FOREIGN KEY (SalleID) REFERENCES Salles(SalleID) ON DELETE CASCADE
);

DROP TABLE IF EXISTS Promotions_Usager;
CREATE TABLE Promotions_Usager(
    UsagerID VARCHAR(30) NOT NULL,
    PromotionID INTEGER NOT NULL,
    PRIMARY KEY (UsagerID,PromotionID),
    CONSTRAINT promotions_usager_fk FOREIGN KEY (UsagerID) REFERENCES Usagers(UsagerID) ON DELETE CASCADE,
    CONSTRAINT usager_promotions_fk FOREIGN KEY (PromotionID) REFERENCES Promotions(PromotionID) ON DELETE CASCADE
);