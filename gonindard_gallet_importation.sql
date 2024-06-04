/*Auriane GONINDARD p2101407 - Nicolas GALLET p2101620*/



INSERT INTO Adresse (Num_voie, Rue, Code_postal, Nom_ville, Nom_pays)
SELECT DISTINCT adr_fede_numVoie, adr_fede_rue, adr_fede_cp, adr_fede_ville, 'France'
FROM donnees_fournies.instances1
UNION
SELECT DISTINCT adr_comite_reg_numVoie, adr_comite_reg_rue, adr_comite_reg_cp, adr_comite_reg_ville, 'France'
FROM donnees_fournies.instances1
UNION
SELECT DISTINCT adr_comite_dept_numVoie, adr_comite_dept_rue, adr_comite_dept_cp, adr_comite_dept_ville, 'France'
FROM donnees_fournies.instances1
UNION
SELECT DISTINCT adr_ecole_numVoie, adr_ecole_rue, adr_ecole_cp, adr_ecole_ville, 'France'
FROM donnees_fournies.instances3
UNION
SELECT DISTINCT adr_danseur_numVoie, adr_danseur_rue, adr_danseur_cp, adr_danseur_ville, 'France'
FROM donnees_fournies.instances4;

INSERT INTO Fédération (NomF, Sigle, NomPresident, IdAd)
SELECT DISTINCT fede_nom, fede_sigle, fede_dirigeant, Adresse.IdAd 
FROM donnees_fournies.instances1, Adresse 
WHERE Adresse.Num_voie = donnees_fournies.instances1.adr_fede_numVoie
AND Adresse.Rue = donnees_fournies.instances1.adr_fede_rue
AND Adresse.Code_postal = donnees_fournies.instances1.adr_fede_cp
AND Adresse.Nom_ville = donnees_fournies.instances1.adr_fede_ville;

INSERT INTO Comité (Code, Nom, Niveau, IdAd, IdFed,IdCom_1)
SELECT DISTINCT comite_reg_code_reg, comite_reg_nom, comite_reg_niveau, Adresse.IdAd , Fédération.IdFed, NULL
FROM donnees_fournies.instances1, Adresse, Fédération
WHERE Adresse.Num_voie = donnees_fournies.instances1.adr_comite_reg_numVoie
AND Adresse.Rue = donnees_fournies.instances1.adr_comite_reg_rue
AND Adresse.Code_postal = donnees_fournies.instances1.adr_comite_reg_cp
AND Adresse.Nom_ville = donnees_fournies.instances1.adr_comite_reg_ville
AND Fédération.NomF = donnees_fournies.instances1.fede_nom
AND comite_reg_niveau="reg";

INSERT INTO Comité (Code, Nom, Niveau, IdAd, IdFed,IdCom_1)
SELECT DISTINCT comite_reg_code_dept, comite_dept_nom, comite_dept_niveau, Adresse.IdAd, Fédération.IdFed, Comité.IdCom
FROM donnees_fournies.instances1, Adresse ,Fédération, Comité
WHERE Adresse.Num_voie = donnees_fournies.instances1.adr_comite_dept_numVoie
AND Adresse.Rue = donnees_fournies.instances1.adr_comite_dept_rue
AND Adresse.Code_postal = donnees_fournies.instances1.adr_comite_dept_cp
AND Adresse.Nom_ville = donnees_fournies.instances1.adr_comite_dept_ville
AND Fédération.NomF = donnees_fournies.instances1.fede_nom
AND comite_dept_niveau="dept"
AND Comité.Code=comite_reg_code_reg;

INSERT INTO Adherent (Num_license, Nom, Prenom, Date_naiss, IdAd)
SELECT DISTINCT danseur_numLicence, danseur_nom, danseur_prenom, danseur_date_naissance, IdAd 
FROM donnees_fournies.instances4, Adresse 
WHERE adr_danseur_numVoie = Num_voie AND adr_danseur_rue = Rue AND adr_danseur_cp = Code_postal AND adr_danseur_ville = Nom_ville;

INSERT INTO Ecole_de_Danse ( Nom_ecole, Noms_Fondateurs, IdFed,IdAd)
SELECT DISTINCT  ecole_nom, ecole_fondateur,Fédération.IdFed, Adresse.IdAd
FROM donnees_fournies.instances3, Fédération, Adresse 
WHERE adr_ecole_numVoie = Num_voie 
AND adr_ecole_rue = Rue 
AND adr_ecole_cp = Code_postal 
AND adr_ecole_ville = Nom_ville
AND Fédération.NomF=donnees_fournies.instances3.fede_nom;

INSERT INTO Compétition (Code, Libellé, Niveau)
SELECT DISTINCT compet_code, compet_libellé, compet_niveau 
FROM donnees_fournies.instances2;

INSERT INTO Edition (Code, Année, Ville_organisatrice)
SELECT DISTINCT compet_code, edition_année, edition_ville_orga
FROM donnees_fournies.instances2;

INSERT INTO Groupe (Num_license_1, Num_license_2)
SELECT donnees_fournies.instances2.danseur_numLicence1, donnees_fournies.instances2.danseur_numLicence2
FROM donnees_fournies.instances2;

INSERT INTO participe_à (Num_license_1, Num_license_2, Code, Année, RangFinal)
SELECT DISTINCT danseur_numLicence1, danseur_numLicence2, compet_code, edition_année, rang_final 
FROM donnees_fournies.instances2;

INSERT INTO Cours (CodeC, Libellé, Categorie_age)
SELECT DISTINCT cours_code, cours_libellé, cours_categorie_age FROM donnees_fournies.instances3;

INSERT INTO Employé (Nom, Prenom)
SELECT DISTINCT cours_resp_nom, cours_resp_prénom
FROM donnees_fournies.instances3;

INSERT INTO Style_de_danse (IdDanse, Nom)
SELECT DISTINCT idD, type_danse
FROM donnees_fournies.type_danse;

INSERT INTO enseigne (IdE, IdEmp, IdCours)
SELECT DISTINCT IdE, IdEmp, IdCours
FROM donnees_fournies.instances3 
JOIN Ecole_de_Danse ON (Ecole_de_Danse.Nom_ecole=ecole_nom AND ecole_fondateur=Noms_Fondateurs)
JOIN Employé ON cours_resp_nom = Nom AND cours_resp_prénom = Prenom
JOIN Cours ON (CodeC=cours_code AND Libellé=cours_libellé AND Categorie_age=cours_categorie_age);

INSERT INTO est_inscrit_à(IdE, Num_license, annee )
SELECT DISTINCT E.IdE, I4.danseur_numLicence, I4.annee_inscription
FROM donnees_fournies.instances4 I4 , Ecole_de_Danse E JOIN Adresse A ON E.IdAd = A.IdAd
WHERE E.Nom_ecole = I4.ecole_nom AND  A.Nom_ville = adr_ecole_ville;
