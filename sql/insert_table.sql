INSERT INTO Formations(FormationID, NomFormation) VALUES
(1, 'Maths'), (2, 'Info'), (3, 'SVT'), (4, 'Chimie');

INSERT INTO Promotions(PromotionID, NomPromotion, FormationID) VALUES
(1, 'L1-MATH', 1), (2, 'L1-INFO', 2), (3, 'L1-SVT', 3), (4, 'L1-CHIMIE', 4),
(5, 'L2-MATH', 1), (6, 'L2-INFO', 2), (7, 'L2-SVT', 3), (8, 'L2-CHIMIE', 4),
(9, 'L3-MATH', 1), (10, 'L3-INFO', 2), (11, 'L3-SVT', 3), (12, 'L3-CHIMIE', 4);

INSERT INTO Rangs(RangID, NomRang) VALUES
(1, 'Etudiant'), (2, 'Enseignant'), (3, 'Admin');

INSERT INTO Usagers(UsagerID, MotDePasse, Nom, Prenom, RangID, PromotionID) VALUES
('root_root', '$2y$10$ELIrDcMQzQgWujKGLkLfNusgJ52qhaEPB0x..dLT4nog4jihziol.', 'Root', 'Root', 3, NULL),
/** INFO */
('anne_parrain', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Parrain', 'Anne', 2, NULL),
('karim_tabia', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Tabia', 'Karim', 2, NULL),
('tiago_delima', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'de Lima', 'Tiago', 2, NULL),
('johan_koitka', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Koitka', 'Johan', 2, NULL),
('said_jabbour', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Jabbour', 'Said', 2, NULL),
('daniel_leberre', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'le Berre', 'Daniel', 2, NULL),
('thibault_lietard', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Lietard', 'Thibault', 2, NULL),

/** MATH */
('jerome_buresi', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Buresi', 'Jerome', 2, NULL),
('baptiste_calmes', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Calmes', 'Baptiste', 2, NULL),
('fatma_jeeawock', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Jeeawock', 'Fatma', 2, NULL),
('etienne_matheron', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Matheron', 'Ethienne', 2, NULL),
('fabrice_derrien', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Derrien', 'Fabrice', 2, NULL),

/** SVT */
('rachel_desfeux', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Desfeux', 'Rachel', 2, NULL),
('sylvie_berger', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Berger', 'Sylvie', 2, NULL),
('anne_marchyllie', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Marchyllie', 'Anne', 2, NULL),
('laurence_brehon', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Brehon', 'Laurence', 2, NULL),
('fabien_gosselet', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Gosselet', 'Fabien', 2, NULL),
('sebastien_leroy', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Leroy', 'Sebastien', 2, NULL),

/** CHIMIE */
('virginie_thery', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Thery', 'virginie', 2, NULL),
('herve_bricout', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Bricourt', 'Herve', 2, NULL),
('bastien_leger', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Leger', 'Bastien', 2, NULL),
('sebastien_tilloy', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Tilloy', 'Sebastien', 2, NULL),
('pascale_boizumault', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Boizumault', 'Pascale', 2, NULL),
('frederic_boizumault', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Boizumault', 'Frederic', 2, NULL),

/** AUTRES */
('julien_caronboily', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Caron-Boily', 'Julien', 2, NULL),
('catherine_vincent', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Vincent', 'Catherine', 2, NULL),

/** ETUDIANTS */
('quentin_carpentier', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Carpentier', 'Quentin', 1, 10),
('pauljoseph_krogulec', '$2y$10$.UJns9D.TmqZvR3PRXLEPunieZDVwuCksLRhunrTL8tk28xAArIxC', 'Krogulec', 'Paul-Joseph', 1, 10);


INSERT INTO Salles(SalleID, NomSalle) VALUES
(1, 'S16'),
(2, 'S19'),
(3, 'S23'),
(4, 'S25');

INSERT INTO TypeCours(TypeID, NomType) VALUES
(1, 'CM'), (2, 'TD'), (3, 'TP');

INSERT INTO Cours(CourID, NomCour, EnseignantID, CouleurCour) VALUES
(1, 'Technologies Emergentes', 'karim_tabia', '#66FFFF'),
(2, 'Technologies Emergentes', 'karim_tabia', '#66FFFF'),
(3, 'LCPF', 'tiago_delima', '#99CCFF'),
(4, 'Prog Web 2', 'johan_koitka', '#33CCFF'),
(5, 'COO', 'daniel_leberre', '#CCFFFF'),
(6, 'Anglais 6', 'tiago_delima', '#CCCCFF');

INSERT INTO Programmer(PromotionID, CourID, DateCour, HeureDebut, HeureFin, TypeID, SalleID) VALUES
(10, 1, '1613948400', '10:15', '11:15', 1, 4),
(10, 2, '1613948400', '11:15', '12:15', 2, 4),
(10, 3, '1613948400', '14:00', '15:30', 1, 3),
(10, 4, '1614038400', '14:00', '15:30', 1, 3),
(10, 5, '1614038400', '15:45', '17:30', 2, NULL);