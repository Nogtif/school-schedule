/* Table des Promotions. 
    -- PromotionID : l'id de la promo (clé primaire).
    -- NomPromotion : le nom du role.
    -- FormationID : l'id de la formation.
    (clée étrangère associant la promotion à une formation : FormationID)
*/
DROP TABLE IF EXISTS Departements;
CREATE TABLE Departements (
    DepartementID INTEGER  PRIMARY KEY AUTOINCREMENT,
    NomFormation VARCHAR(25) NOT NULL
);

/* Table des Promotions. 
    -- PromotionID : l'id de la promo (clé primaire).
    -- NomPromotion : le nom du role.
    -- FormationID : l'id de la formation.
    (clée étrangère associant la promotion à une formation : FormationID)
*/
DROP TABLE IF EXISTS Promotions;
CREATE TABLE Promotions (
    PromotionID INTEGER  PRIMARY KEY AUTOINCREMENT,
    NomPromotion VARCHAR(25) NOT NULL,
    DepartementID INTEGER NOT NULL,
    CONSTRAINT formation_fk FOREIGN KEY (DepartementID) REFERENCES Departements(DepartementID) ON DELETE CASCADE
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
    -- TypeID : l'id du type du cour (clé primaire).
    -- NomType : le nom du type du cour.
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
    CONSTRAINT matiere_promo_fk FOREIGN KEY (PromotionID) REFERENCES Promotions(PromotionID) ON DELETE CASCADE
);

/* Table des Cours. 
    -- CourID : l'id du cour (clé primaire).
    -- DateCour : la date du cour.
    -- HeureDebut : l'heure de début du cour.
    -- HeureFin : l'heure de fin du cour.
    -- TypeID : le type (Cours, TD, TP).
    (clée étrangère associant un cour à son type : TypeID)
    -- SalleID : l'id de la salle.
    (clée étrangère associant un étudiant à sa promotion : SalleID)
    -- UsagerID : l'id de l'enseignant.
    (clée étrangère associant un cour à son enseignant : UsagerID)
    -- MatiereID : l'id de la matière.
    (clée étrangère associant un cour à sa matière : MatiereID)
*/
DROP TABLE IF EXISTS Cours;
CREATE TABLE Cours (
    CourID INTEGER PRIMARY KEY AUTOINCREMENT,
    DateCour VARCHAR(30) NOT NULL,
    HeureDebut time NOT NULL,
    HeureFin time NOT NULL,
    TypeID INTEGER NOT NULL,
    SalleID INTEGER NOT NULL,
    UsagerID INTEGER NOT NULL,
    MatiereID INTEGER NOT NULL,
    CONSTRAINT cour_type_fk FOREIGN KEY (TypeID) REFERENCES TypeCours(TypeID) ON DELETE CASCADE,
    CONSTRAINT cour_salle_fk FOREIGN KEY (SalleID) REFERENCES Salles(SalleID) ON DELETE CASCADE
    CONSTRAINT cour_enseignant_fk FOREIGN KEY (UsagerID) REFERENCES Usagers(UsagerID) ON DELETE CASCADE,
    CONSTRAINT cour_matiere_fk FOREIGN KEY (MatiereID) REFERENCES Matieres(MatiereID) ON DELETE CASCADE
);

/* Association entre les usagers (enseignants) et leurs matières.
    -- UsagerID : l'id de l'usager (clé primaire).
    -- MatiereID : l'id de la matière (clé primaire).
    (clés étrangères associant l'id d'un usager avec la table Usagers et l'id d'une matière à la table Matieres).
*/
DROP TABLE IF EXISTS Enseigne;
CREATE TABLE Enseigne (
    UsagerID VARCHAR(30) REFERENCES Usagers(UsagerID) ON DELETE CASCADE,
    MatiereID INTEGER REFERENCES Matieres(MatiereID) ON DELETE CASCADE,
    CONSTRAINT enseigne_pk PRIMARY KEY (UsagerID, MatiereID)
);

/* Association entre les usagers et les promotions.
    -- UsagerID : l'id de l'usager (clé primaire).
    -- PromotionID : l'id de la promotion (clé primaire).
    (clés étrangères associant l'id d'un usager avec la table Usagers et l'id d'une promotion à la table Promotions).
*/
DROP TABLE IF EXISTS Appartient;
CREATE TABLE Appartient (
    UsagerID VARCHAR(30) REFERENCES Usagers(UsagerID) ON DELETE CASCADE,
    PromotionID INTEGER REFERENCES Promotions(PromotionID) ON DELETE CASCADE,
    CONSTRAINT appartient_pk PRIMARY KEY (UsagerID, PromotionID)
);