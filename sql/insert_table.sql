INSERT INTO Departements(DepartementID, NomFormation) VALUES
(1, 'Math'), (2, 'Info'), (3, 'SVT'), (4, 'Chimie');

INSERT INTO Promotions(NomPromotion, DepartementID) VALUES
('L1-MATH', 1), ('L1-INFO', 2), ('L1-SVT', 3), ('L1-CHIMIE', 4),
('L2-MATH', 1), ('L2-INFO', 2), ('L2-SVT', 3), ('L2-CHIMIE', 4),
('L3-MATH', 1), ('L3-INFO', 2), ('L3-SVT', 3), ('L3-CHIMIE', 4);

INSERT INTO Rangs(RangID, NomRang) VALUES
(1, 'Etudiant'), (2, 'Enseignant'), (3, 'Admin');

INSERT INTO Usagers(UsagerID, MotDePasse, Nom, Prenom, RangID) VALUES
('root_root', '$2y$10$ELIrDcMQzQgWujKGLkLfNusgJ52qhaEPB0x..dLT4nog4jihziol.', 'Root', 'Root', 3),
/** INFO */
('anne_parrain', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Parrain', 'Anne', 2),
('karim_tabia', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Tabia', 'Karim', 2),
('tiago_delima', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'de Lima', 'Tiago', 2),
('johan_koitka', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Koitka', 'Johan', 2),
('said_jabbour', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Jabbour', 'Said', 2),
('daniel_leberre', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'le Berre', 'Daniel', 2),
('thibault_lietard', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Lietard', 'Thibault', 2),
('zied_bouraoui', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Bouraoui', 'Zied', 2),

/** MATH */
('jerome_buresi', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Buresi', 'Jerome', 2),
('baptiste_calmes', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Calmes', 'Baptiste', 2),
('fatma_jeeawock', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Jeeawock', 'Fatma', 2),
('etienne_matheron', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Matheron', 'Ethienne', 2),
('fabrice_derrien', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Derrien', 'Fabrice', 2),

/** SVT */
('rachel_desfeux', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Desfeux', 'Rachel', 2),
('sylvie_berger', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Berger', 'Sylvie', 2),
('anne_marchyllie', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Marchyllie', 'Anne', 2),
('laurence_brehon', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Brehon', 'Laurence', 2),
('fabien_gosselet', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Gosselet', 'Fabien', 2),
('sebastien_leroy', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Leroy', 'Sebastien', 2),

/** CHIMIE */
('virginie_thery', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Thery', 'virginie', 2),
('herve_bricout', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Bricourt', 'Herve', 2),
('bastien_leger', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Leger', 'Bastien', 2),
('sebastien_tilloy', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Tilloy', 'Sebastien', 2),
('pascale_boizumault', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Boizumault', 'Pascale', 2),
('frederic_boizumault', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Boizumault', 'Frederic', 2),

/** AUTRES */
('julien_caronboily', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Caron-Boily', 'Julien', 2),
('catherine_vincent', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Vincent', 'Catherine', 2),

/** ETUDIANTS */
('quentin_carpentier', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Carpentier', 'Quentin', 1),
('pauljoseph_krogulec', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Krogulec', 'Paul-Joseph', 1);


INSERT INTO Salles(SalleID, NomSalle) VALUES
(1, 'S16'),
(2, 'S19'),
(3, 'S23'),
(4, 'S25'),
(5, 'G307'),
(6, 'G309'),
(7, 'G310'),
(8, 'G311'),
(9, 'G312'),
(10, 'E15'),
(11, 'D005');

INSERT INTO TypeCours(TypeID, NomType) VALUES
(1, 'CM'), (2, 'TD'), (3, 'TP');

INSERT INTO Matieres(MatiereID, NomMatiere, CouleurMatiere, PromotionID) VALUES
(1, 'COO', '#E88436', 10),
(2, 'LCPF', '#74568F', 10),
(3, 'Prog Web 2', '#467BAD', 10),
(4, 'Technologies Emergentes', '#A1B9B2', 10),
(5, 'Anglais 6', '#AF4343', 10),
(6, 'Stage', '#339966', 10),
(7, 'Anglais 4 MATHS', '#339966', 5);

INSERT INTO Cours(CourID, DateCour, HeureDebut, HeureFin, TypeID, SalleID, UsagerID, MatiereID) VALUES
(1, '1614556800', '10:15', '11:15', 1, 4, 'karim_tabia', 4),
(2, '1614556800', '11:15', '12:15', 2, 4, 'karim_tabia', 4),
(3, '1614556800', '14:00', '15:30', 1, 3, 'tiago_delima', 2),

(4, '1614643200', '09:30', '10:30', 2, 8, 'johan_koitka', 3),
(5, '1614643200', '14:00', '15:30', 1, 3, 'johan_koitka', 3),
(6, '1614643200', '15:45', '17:30', 2, 3, 'daniel_leberre', 1),

(7, '1614729600', '08:45', '10:45', 3, 5, 'thibault_lietard', 1),
(8, '1614729600', '11:00', '13:00', 3, 5, 'thibault_lietard', 2),
(9, '1614729600', '14:30', '16:30', 2, 10, 'catherine_vincent', 5),

(10, '1614816000', '09:00', '10:30', 2, 7, 'thibault_lietard', 2),
(11, '1614816000', '10:45', '12:45', 3, 5, 'johan_koitka', 3),
(12, '1614816000', '13:45', '15:30', 3, 7, 'karim_tabia', 4),
(13, '1614902400', '14:00', '18:00', 1, 4, 'zied_bouraoui', 6);

INSERT INTO Enseigne(UsagerID, MatiereID) VALUES 
('daniel_leberre', 1), ('tiago_delima', 2), ('johan_koitka', 3),
('karim_tabia', 4), ('catherine_vincent', 5), ('zied_bouraoui', 6), ('julien_caronboily', 7);

INSERT INTO Appartient(UsagerID, PromotionID) VALUES 
('jerome_buresi',1), ('baptiste_calmes',1), ('fatma_jeeawock',1), ('etienne_matheron',1), ('fabrice_derrien',1),
('jerome_buresi',5), ('baptiste_calmes',5), ('fatma_jeeawock',5), ('etienne_matheron',5), ('fabrice_derrien',5),
('jerome_buresi',9), ('baptiste_calmes',9), ('fatma_jeeawock',9), ('etienne_matheron',9), ('fabrice_derrien',9),

('anne_parrain',2), ('karim_tabia',2), ('tiago_delima',2), ('johan_koitka',2), ('said_jabbour',2), ('daniel_leberre',2), ('thibault_lietard',2), ('zied_bouraoui',2),
('anne_parrain',6), ('karim_tabia',6), ('tiago_delima',6), ('johan_koitka',6), ('said_jabbour',6), ('daniel_leberre',6), ('thibault_lietard',6), ('zied_bouraoui',6),
('anne_parrain',10), ('karim_tabia',10), ('tiago_delima',10), ('johan_koitka',10), ('said_jabbour',10), ('daniel_leberre',10), ('thibault_lietard',10), ('zied_bouraoui',10),

('rachel_desfeux',3), ('sylvie_berger',3), ('anne_marchyllie',3), ('laurence_brehon',3), ('fabien_gosselet',3), ('sebastien_leroy',3),
('rachel_desfeux',7), ('sylvie_berger',7), ('anne_marchyllie',7), ('laurence_brehon',7), ('fabien_gosselet',7), ('sebastien_leroy',7),
('rachel_desfeux',11), ('sylvie_berger',11), ('anne_marchyllie',11), ('laurence_brehon',11), ('fabien_gosselet',11), ('sebastien_leroy',11),

('virginie_thery',4), ('herve_bricout',4), ('bastien_leger',4), ('sebastien_tilloy',4), ('pascale_boizumault',4), ('frederic_boizumault',4),
('virginie_thery',8), ('herve_bricout',8), ('bastien_leger',8), ('sebastien_tilloy',8), ('pascale_boizumault',8), ('frederic_boizumault',8),
('virginie_thery',12), ('herve_bricout',12), ('bastien_leger',12), ('sebastien_tilloy',12), ('pascale_boizumault',12), ('frederic_boizumault',12),

('julien_caronboily',1), ('julien_caronboily',2), ('julien_caronboily',3), ('julien_caronboily',4), ('julien_caronboily',5), ('julien_caronboily',6), ('julien_caronboily',7), ('julien_caronboily',8), ('julien_caronboily',9), ('julien_caronboily',10), ('julien_caronboily',11), ('julien_caronboily',12),
('catherine_vincent',1), ('catherine_vincent',2), ('catherine_vincent',3), ('catherine_vincent',4), ('catherine_vincent',5), ('catherine_vincent',6), ('catherine_vincent',7), ('catherine_vincent',8), ('catherine_vincent',9), ('catherine_vincent',10), ('catherine_vincent',11), ('catherine_vincent',12),

('quentin_carpentier',10), ('pauljoseph_krogulec',10);

