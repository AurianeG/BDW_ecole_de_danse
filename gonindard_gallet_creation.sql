/*Auriane GONINDARD p2101407 - Nicolas GALLET p2101620*/

CREATE TABLE Adresse(
   IdAd INT AUTO_INCREMENT ,
   Num_voie INT,
   Rue VARCHAR(80),
   Complement_rue VARCHAR(80),
   Boite_postale VARCHAR(80),
   Numero_cedex INT,
   Code_postal VARCHAR(6),
   Nom_ville VARCHAR(80),
   Nom_pays VARCHAR(80),
   PRIMARY KEY(IdAd)
);

CREATE TABLE Employé(
   IdEmp INT AUTO_INCREMENT ,
   Nom VARCHAR(80),
   Prenom VARCHAR(80),
   PRIMARY KEY(IdEmp)
);

CREATE TABLE Cours(
   IdCours INT AUTO_INCREMENT ,
   CodeC INT,
   Libellé VARCHAR(80),
   Categorie_age VARCHAR(80),
   PRIMARY KEY(IdCours)
);

CREATE TABLE Eveil_à_la_danse(
   IdCours INT,
   PRIMARY KEY(IdCours),
   FOREIGN KEY(IdCours) REFERENCES Cours(IdCours)
);
ALTER TABLE Eveil_à_la_danse ADD CONSTRAINT fk_Eveil_à_la_danse_Cours FOREIGN KEY (IdCours) REFERENCES Cours(IdCours) ;

CREATE TABLE Zumba(
   IdCours INT,
   Ambiance VARCHAR(80),
   PRIMARY KEY(IdCours),
   FOREIGN KEY(IdCours) REFERENCES Cours(IdCours)
);
ALTER TABLE Zumba ADD CONSTRAINT fk_Zumba_Cours FOREIGN KEY (IdCours) REFERENCES Cours(IdCours) ;

CREATE TABLE Danse(
   IdCours INT,
   Categorie VARCHAR(80),
   PRIMARY KEY(IdCours),
   FOREIGN KEY(IdCours) REFERENCES Cours(IdCours)
);
ALTER TABLE Danse ADD CONSTRAINT fk_Danse_Cours FOREIGN KEY (IdCours) REFERENCES Cours(IdCours) ;

CREATE TABLE Style_de_danse(
   IdDanse INT,
   Nom VARCHAR(150),
   PRIMARY KEY(IdDanse)
);

CREATE TABLE Adherent(
   Num_license INT,
   Nom VARCHAR(80),
   Prenom VARCHAR(80),
   Date_naiss DATE,
   Date_Certifi_med VARCHAR(80),
   IdAd INT NOT NULL,
   PRIMARY KEY(Num_license),
   FOREIGN KEY(IdAd) REFERENCES Adresse(IdAd)
);
ALTER TABLE Adherent ADD CONSTRAINT fk_Adherent_Adresse FOREIGN KEY (IdAd) REFERENCES Adresse(IdAd) ;


CREATE TABLE Séance(
   IdCours INT,
   IdS VARCHAR(80),
   Jour VARCHAR(80),
   Creneau TIME,
   PRIMARY KEY(IdCours, IdS),
   FOREIGN KEY(IdCours) REFERENCES Cours(IdCours)
);
ALTER TABLE Séance ADD CONSTRAINT fk_Séance_Cours FOREIGN KEY (IdCours) REFERENCES Cours(IdCours) ;

CREATE TABLE Fédération(
   idFed INT AUTO_INCREMENT,
   NomF VARCHAR(80),
   Sigle VARCHAR(80),
   NomPresident VARCHAR(80),
   IdAd INT ,
   PRIMARY KEY(idFed)
);

CREATE TABLE Comité(
   IdCom INT AUTO_INCREMENT,
   Code VARCHAR(3),
   Nom VARCHAR(80),
   Niveau VARCHAR(80),
   IdAd INT NOT NULL,
   idFed INT NOT NULL,
   IdCom_1 INT,
   PRIMARY KEY(IdCom),
   FOREIGN KEY(idFed) REFERENCES Fédération(idFed),
   FOREIGN KEY(IdCom_1) REFERENCES Comité(IdCom)
);
ALTER TABLE Comité ADD CONSTRAINT fk_Comité_Fédération FOREIGN KEY (idFed) REFERENCES Fédération(idFed);
ALTER TABLE Comité ADD CONSTRAINT fk_Comité_Comité FOREIGN KEY (IdCom_1) REFERENCES Comité(IdCom) ;

CREATE TABLE Compétition(
   Code VARCHAR(5)  ,
   Libellé VARCHAR(80),
   Niveau VARCHAR(80),
   PRIMARY KEY(Code)
);

CREATE TABLE Structure_sportive(
   IdSP INT AUTO_INCREMENT ,
   Nom VARCHAR(80),
   Type VARCHAR(80),
   IdAd INT NOT NULL,
   PRIMARY KEY(IdSP),
   FOREIGN KEY(IdAd) REFERENCES Adresse(IdAd)
);
ALTER TABLE Structure_sportive ADD CONSTRAINT fk_Structure_sportive_Adresse FOREIGN KEY (IdAd) REFERENCES Adresse(IdAd) ;

CREATE TABLE Période(
   Année VARCHAR(80),
   PRIMARY KEY(Année)
);

CREATE TABLE Ecole_de_Danse(
   IdE INT AUTO_INCREMENT ,
   Nom_ecole VARCHAR(80),
   Noms_Fondateurs VARCHAR(80),
   idFed INT NOT NULL,
   IdAd INT NOT NULL,
   PRIMARY KEY(IdE),
   FOREIGN KEY(idFed) REFERENCES Fédération(idFed),
   FOREIGN KEY(IdAd) REFERENCES Adresse(IdAd)
);
ALTER TABLE Ecole_de_Danse ADD CONSTRAINT fk_Ecole_de_Danse_Fédération FOREIGN KEY (idFed) REFERENCES Fédération(idFed) ;
ALTER TABLE Ecole_de_Danse ADD CONSTRAINT fk_Ecole_de_Danse_Adresse FOREIGN KEY (IdAd) REFERENCES Adresse(IdAd) ;

CREATE TABLE Salle(
   IdE INT,
   Numero INT,
   Nom_salle VARCHAR(80) NOT NULL,
   Superficie DECIMAL(15,2),
   PRIMARY KEY(IdE, Numero),
   FOREIGN KEY(IdE) REFERENCES Ecole_de_Danse(IdE)
);
ALTER TABLE Salle ADD CONSTRAINT fk_Salle_Ecole_de_Danse FOREIGN KEY (IdE) REFERENCES Ecole_de_Danse(IdE) ;

CREATE TABLE Espace_de_dance(
   IdE INT,
   Numero INT,
   Type_d_aeration VARCHAR(80),
   Type_chauffage VARCHAR(80),
   PRIMARY KEY(IdE, Numero),
   FOREIGN KEY(IdE, Numero) REFERENCES Salle(IdE, Numero)
);
ALTER TABLE Espace_de_dance ADD CONSTRAINT fk_Espace_de_dance_Salle FOREIGN KEY (IdE, Numero) REFERENCES Salle(IdE, Numero) ;

CREATE TABLE Vestiaire(
   IdE INT,
   Numero INT,
   Mixtes BOOLEAN,
   Douches BOOLEAN,
   PRIMARY KEY(IdE, Numero),
   FOREIGN KEY(IdE, Numero) REFERENCES Salle(IdE, Numero)
);
ALTER TABLE Vestiaire ADD CONSTRAINT fk_Vestiaire_Salle FOREIGN KEY (IdE, Numero) REFERENCES Salle(IdE, Numero) ;

CREATE TABLE Edition(
   Code VARCHAR(5),
   Année INT,
   Ville_organisatrice VARCHAR(80),
   IdSP INT,
   PRIMARY KEY(Code, Année),
   FOREIGN KEY(Code) REFERENCES Compétition(Code),
   FOREIGN KEY(IdSP) REFERENCES Structure_sportive(IdSP)
);
ALTER TABLE Edition ADD CONSTRAINT fk_Edition_Compétition FOREIGN KEY (Code) REFERENCES Compétition(Code) ;
ALTER TABLE Edition ADD CONSTRAINT fk_Edition_Structure_sportive FOREIGN KEY (IdSP) REFERENCES Structure_sportive(IdSP) ;

CREATE TABLE Groupe(
   Num_license_1 INT,
   Num_license_2 INT,
   Nom VARCHAR(80),
   Genre VARCHAR(80),
   PRIMARY KEY(Num_license_1, Num_license_2),
   FOREIGN KEY(Num_license_1) REFERENCES Adherent(Num_license),
   FOREIGN KEY(Num_license_2) REFERENCES Adherent(Num_license)
);

CREATE TABLE travaille(
   IdE INT,
   IdEmp INT,
   Année VARCHAR(80),
   fonction VARCHAR(80),
   PRIMARY KEY(IdE, IdEmp, Année),
   FOREIGN KEY(IdE) REFERENCES Ecole_de_Danse(IdE),
   FOREIGN KEY(IdEmp) REFERENCES Employé(IdEmp),
   FOREIGN KEY(Année) REFERENCES Période(Année)
);
ALTER TABLE travaille ADD CONSTRAINT fk_travaille_Ecole_de_Danse FOREIGN KEY (IdE) REFERENCES Ecole_de_Danse(IdE) ;
ALTER TABLE travaille ADD CONSTRAINT fk_travaille_Employé FOREIGN KEY (IdEmp) REFERENCES Employé(IdEmp) ;
ALTER TABLE travaille ADD CONSTRAINT fk_travaille_Période FOREIGN KEY (Année) REFERENCES Période(Année) ;

CREATE TABLE Cours_de(
   IdCours INT AUTO_INCREMENT,
   IdDanse INT,
   PRIMARY KEY(IdCours, IdDanse),
   FOREIGN KEY(IdCours) REFERENCES Danse(IdCours),
   FOREIGN KEY(IdDanse) REFERENCES Style_de_danse(IdDanse)
);
ALTER TABLE Cours_de ADD CONSTRAINT fk_Cours_de_Cours FOREIGN KEY (IdCours) REFERENCES Cours(IdCours) ;
ALTER TABLE Cours_de ADD CONSTRAINT fk_Cours_de_Style_de_danse FOREIGN KEY (IdDanse) REFERENCES Style_de_danse(IdDanse) ;


CREATE TABLE a_ete_influence_par(
   IdDanse_1 INT,
   IdDanse_2 INT,
   PRIMARY KEY(IdDanse_1, IdDanse_2),
   FOREIGN KEY(IdDanse_1) REFERENCES Style_de_danse(IdDanse),
   FOREIGN KEY(IdDanse_2) REFERENCES Style_de_danse(IdDanse)
);
ALTER TABLE a_ete_influence_par ADD CONSTRAINT fk_a_ete_influence_par_Style_de_danse1 FOREIGN KEY (IdDanse_1) REFERENCES Style_de_danse(IdDanse) ;
ALTER TABLE a_ete_influence_par ADD CONSTRAINT fk_a_ete_influence_par_Style_de_danse2 FOREIGN KEY (IdDanse_2) REFERENCES Style_de_danse(IdDanse) ;


CREATE TABLE est_inscrit_à(
   IdE INT,
   Num_license INT,
   annee INT,
   PRIMARY KEY(IdE, Num_license),
   FOREIGN KEY(IdE) REFERENCES Ecole_de_Danse(IdE),
   FOREIGN KEY(Num_license) REFERENCES Adherent(Num_license)
);
ALTER TABLE est_inscrit_à ADD CONSTRAINT est_inscrit_à_Ecole_de_Danse FOREIGN KEY (IdE) REFERENCES Ecole_de_Danse(IdE) ;
ALTER TABLE est_inscrit_à ADD CONSTRAINT est_inscrit_à_Adherent FOREIGN KEY (Num_license) REFERENCES Adherent(Num_license) ;

CREATE TABLE enseigne(
   IdE INT,
   IdEmp INT,
   IdCours INT,
   PRIMARY KEY(IdE, IdEmp, IdCours),
   FOREIGN KEY(IdE) REFERENCES Ecole_de_Danse(IdE),
   FOREIGN KEY(IdEmp) REFERENCES Employé(IdEmp),
   FOREIGN KEY(IdCours) REFERENCES Cours(IdCours)
);
ALTER TABLE enseigne ADD CONSTRAINT enseigne_Ecole_de_Danse FOREIGN KEY (IdE) REFERENCES Ecole_de_Danse(IdE) ;
ALTER TABLE enseigne ADD CONSTRAINT enseigne_Employé FOREIGN KEY (IdEmp) REFERENCES Employé(IdEmp) ;
ALTER TABLE enseigne ADD CONSTRAINT enseigne_Cours FOREIGN KEY (IdCours) REFERENCES Cours(IdCours) ;


CREATE TABLE gérée_par(
   IdCom INT,
   Code VARCHAR(5),
   PRIMARY KEY(IdCom, Code),
   FOREIGN KEY(IdCom) REFERENCES Comité(IdCom),
   FOREIGN KEY(Code) REFERENCES Compétition(Code)
);
ALTER TABLE gérée_par ADD CONSTRAINT gérée_par_Comité FOREIGN KEY (IdCom) REFERENCES Comité(IdCom) ;
ALTER TABLE gérée_par ADD CONSTRAINT gérée_par_Compétition FOREIGN KEY (Code) REFERENCES Compétition(Code) ;

CREATE TABLE participe_à(
   Num_license_1 INT,
   Num_license_2 INT,
   Code VARCHAR(5),
   Année INT,
   NumPassage INT,
   RangFinal INT,
   PRIMARY KEY(Num_license_1,Num_license_2, Code, Année),
   FOREIGN KEY(Num_license_1, Num_license_2) REFERENCES Groupe(Num_license_1, Num_license_2),
   FOREIGN KEY(Code, Année) REFERENCES Edition(Code, Année)
);
ALTER TABLE participe_à ADD CONSTRAINT participe_à_Groupe FOREIGN KEY (Num_license_1, Num_license_2) REFERENCES Groupe(Num_license_1, Num_license_2) ;
ALTER TABLE participe_à ADD CONSTRAINT participe_à_Edition FOREIGN KEY (Code, Année) REFERENCES Edition(Code, Année) ;

CREATE TABLE a_participé(
   Num_license INT,
   IdCours INT,
   IdS VARCHAR(80),
   PRIMARY KEY(Num_license, IdCours, IdS),
   FOREIGN KEY(Num_license) REFERENCES Adherent(Num_license),
   FOREIGN KEY(IdCours, IdS) REFERENCES Séance(IdCours, IdS)
);
ALTER TABLE a_participé ADD CONSTRAINT a_participé_Adherent FOREIGN KEY (Num_license) REFERENCES Adherent(Num_license) ;
ALTER TABLE a_participé ADD CONSTRAINT a_participé_Séance FOREIGN KEY (IdCours, IdS) REFERENCES Séance(IdCours, IdS) ;
