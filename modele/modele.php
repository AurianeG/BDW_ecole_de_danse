<!--Auriane GONINDARD p2101407 - Nicolas GALLET p2101620-->
<?php 

/*
Structure de données permettant de manipuler une base de données :
- Gestion de la connexion
----> Connexion et déconnexion à la base
- Accès au dictionnaire
----> Liste des tables et statistiques
- Accès aux données
---> ecoles
---> cours
---> federations
---> comites
---> competitions
	-edition
	-structure sportive

*/



function executer_un_requete()	{

global $connexion;

	// récupération des informations sur la table (schema + instance)
	$requete = "SELECT * FROM $nomTable";  
 	$res = mysqli_query($connexion, $requete);  

 	// extraction des informations sur le schéma à partir du résultat précédent
	$infos_atts = mysqli_fetch_fields($res); 

	// filtrage des information du schéma pour ne garder que le nom de l'attribut
	$schema = array();
	foreach( $infos_atts as $att ){
		array_push($schema , array( 'nom' => $att->{'name'} ) );
		// récupération des données (instances) de la table
		}
		return $stats;
	}




////////////////////////////////////////////////////////////////////////
///////    Gestion de la connxeion   ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

/**
 * Initialise la connexion à la base de données courante (spécifiée selon constante 
	globale SERVEUR, UTILISATEUR, MOTDEPASSE, BDD)			
 */
function open_connection_DB() {
	global $connexion;

	$connexion = mysqli_connect(SERVEUR, UTILISATEUR, MOTDEPASSE, BDD);
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
}

/**
 *  	Ferme la connexion courante
 * */
function close_connection_DB() {
	global $connexion;

	mysqli_close($connexion);
}


////////////////////////////////////////////////////////////////////////
///////   Accès au dictionnaire       ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

/**
 *  Retourne la liste des tables définies dans la base de données courantes
 * */
function get_tables() {
	global $connexion;

	$requete = "SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE '". BDD ."'";

	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}


/**
 *  Retourne les statistiques sur la base de données courante
 * */
function get_statistiques() {
	global $connexion;

	$requete0 = 'SELECT COUNT(DISTINCT F.IdFed) AS nbFed, COUNT(DISTINCT C1.IdCom) AS nbCR, COUNT(DISTINCT C2.IdCom) AS nbCD  FROM Fédération F, Comité C1, Comité C2 
	WHERE C1.Niveau = "reg" AND C2.Niveau = "dept";';

	$requete1 = 'SELECT SUBSTRING(A.Code_postal,1,2) AS Code_dept, COUNT(DISTINCT E.IdE) AS nbEcoles FROM Adresse A JOIN Ecole_de_Danse E ON A.IdAd = E.IdAd
	WHERE SUBSTRING(A.Code_postal,1,2) != "97" GROUP BY Code_dept
	UNION
	SELECT SUBSTRING(A.Code_postal,1,3) AS Code_dept, COUNT(DISTINCT E.IdE) AS nbEcoles FROM Adresse A JOIN Ecole_de_Danse E ON A.IdAd = E.IdAd
	WHERE SUBSTRING(A.Code_postal,1,2) = "97" GROUP BY Code_dept;';
	
	$requete2 = 'SELECT C.Nom FROM Comité C JOIN Fédération F ON C.IdFed = F.IdFed
	WHERE F.NomF = "Fédération Française de Danse" AND C.Niveau = "reg"
	ORDER BY C.Nom DESC;';
	
	$requete3 = 'SELECT E.Nom_ecole, A.Nom_ville, COUNT(DISTINCT I.Num_license) AS Nb_Adherents FROM Ecole_de_Danse E JOIN est_inscrit_à I On E.IdE =I.IdE JOIN Adresse A ON E.IdAd=A.IdAd
	WHERE I.annee =2022 GROUP BY E.IdE
	ORDER BY Nb_Adherents DESC LIMIT 5;';

$res0 = mysqli_query($connexion, $requete0);
$instances0 = mysqli_fetch_all($res0, MYSQLI_ASSOC);
$res1 = mysqli_query($connexion, $requete1);
$instances1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
$res2 = mysqli_query($connexion, $requete2);
$instances2 = mysqli_fetch_all($res2, MYSQLI_ASSOC);
$res3 = mysqli_query($connexion, $requete3);
$instances3 = mysqli_fetch_all($res3, MYSQLI_ASSOC);

$stats = array($instances0,$instances1, $instances2, $instances3);

	return $stats;
}


//////////////ecoles////////////////////
/**
 *  Retourne la liste des fondateurs sur la base de données courante
 * */
function get_fondateurs() {
	global $connexion;

	$requete0 = 'SELECT Noms_Fondateurs FROM Ecole_de_Danse ORDER BY Noms_Fondateurs;';

$res0 = mysqli_query($connexion, $requete0);
$instances0 = mysqli_fetch_all($res0, MYSQLI_ASSOC);

	return $instances0;
}

/**
 *  Retourne le nom et l'adresse de l'ecole fondée par la personne
 * */
function get_info_ecole($fondateur){
	global $connexion;
	

	$requete0 = 'SELECT IdE, Nom_ecole, Noms_Fondateurs, Num_voie ,Rue ,Complement_rue , Code_postal, Nom_ville , Nom_pays, Boite_postale, Numero_cedex
	FROM Ecole_de_Danse E JOIN Adresse A ON E.IdAd=A.IdAd 
	WHERE E.Noms_Fondateurs ="'.str_ireplace('+', ' ', $fondateur).'";';

	$res0 = mysqli_query($connexion, $requete0);
	$instances0 = mysqli_fetch_all($res0, MYSQLI_ASSOC);
	if (!$res0) {
		printf("Error: %s\n", mysqli_error($connexion));
		print $requete0;
		exit();
	}

	return $instances0;
}

//retourne la listes des employés
function get_employes($IdEcole) {
	global $connexion;

	$requete0 = 'SELECT DISTINCT E.IdEmp, E.Nom, E.Prenom 
	FROM Employé E JOIN enseigne T ON E.IdEmp=T.IdEmp
	WHERE T.IdE='.$IdEcole. ';' ;

	$res0 = mysqli_query($connexion, $requete0);
	$instances0 = mysqli_fetch_all($res0, MYSQLI_ASSOC);
	return $instances0;
}

//retourne le nombre d'adherent
function get_nb_adherent($IdEcole) {
	global $connexion;

	$requete0 = 'SELECT COUNT(DISTINCT I.Num_license) AS Nb_Adherents FROM Ecole_de_Danse E JOIN est_inscrit_à I On E.IdE =I.IdE
	WHERE I.annee =2022 AND E.IdE='.$IdEcole.';' ;

	$res0 = mysqli_query($connexion, $requete0);
	$instances0 = mysqli_fetch_all($res0, MYSQLI_ASSOC);
	return $instances0;
}

//retourne la liste des cours
function get_cours($ecole)	{
	global $connexion;

	$requete0 = 'SELECT DISTINCT  C.IdCours, C.CodeC , C.Libellé , C.Categorie_age, Emp.Nom, Emp.Prenom
	FROM enseigne E JOIN Cours C ON E.IdCours=C.IdCours JOIN Employé Emp ON E.IdEmp=Emp.IdEmp
	WHERE E.IdE='.$ecole.';' ;

	$res0 = mysqli_query($connexion, $requete0);
	$instances0 = mysqli_fetch_all($res0, MYSQLI_ASSOC);
	return $instances0;
}

//retourne le nb d'adherent ayant participé à une competition
function get_adh_comp($ecole)	{
	global $connexion;

	$requete0 = 'SELECT COUNT(DISTINCT I.Num_license) AS Nb_Adherents
	FROM est_inscrit_à I , participe_à P 
	WHERE  I.IdE='.$ecole.' AND I.Num_license IN (P.Num_license_1, P.Num_license_2);' ;

	$res0 = mysqli_query($connexion, $requete0);
	$instances0 = mysqli_fetch_all($res0, MYSQLI_ASSOC);
	return $instances0;
}


//////////////////////////////modif ecole/////////////////////////////////

//modifie le fondateur de l'ecole
function modifFond($ecole, $val)	{
	global $connexion;
	$requete = 'UPDATE Ecole_de_Danse SET Noms_Fondateurs="'.$val.'" WHERE IdE='.$ecole.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}

//modifie le nom de l'ecole
function modifNomEcole($ecole, $val)	{
	global $connexion;
	$requete = 'UPDATE Ecole_de_Danse SET Nom_ecole="'.$val.'" WHERE IdE='.$ecole.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}

//Retourne l'adresse et les paramètres GET
function getURI(){
    $adresse = $_SERVER['PHP_SELF'];
    $i = 0;
    foreach($_GET as $cle => $valeur){
        $adresse .= ($i == 0 ? '?' : '&').$cle.($valeur ? '='.$valeur : '');
        $i++;
    }
    return $adresse;
}

//modif le pays de l'ecole
function modifPays($ecole, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Nom_pays="'.$val.'" WHERE IdAd=( SELECT IdAd FROM  Ecole_de_Danse WHERE IdE = '.$ecole.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}

//modifie la ville de l'ecole
function modifVille($ecole, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Nom_ville="'.$val.'" WHERE IdAd=( SELECT IdAd FROM  Ecole_de_Danse WHERE IdE='.$ecole.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}

//modifie la rue de l'ecole
function modifRue($ecole, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Rue="'.$val.'" WHERE IdAd=( SELECT IdAd FROM  Ecole_de_Danse WHERE IdE='.$ecole.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}

//modifie le numero de voie de l'ecole
function modifNumVoie($ecole, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Num_voie="'.$val.'" WHERE IdAd=( SELECT IdAd FROM  Ecole_de_Danse WHERE IdE='.$ecole.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}

function modifComplement($ecole, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Complement="'.$val.'" WHERE IdAd=( SELECT IdAd FROM  Ecole_de_Danse WHERE IdE='.$ecole.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}

function modifNumCedex($ecole, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Num_cedex="'.$val.'" WHERE IdAd=( SELECT IdAd FROM  Ecole_de_Danse WHERE IdE='.$ecole.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}

function modifBoitePostale($ecole, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Boite_postale="'.$val.'" WHERE IdAd=( SELECT IdAd FROM  Ecole_de_Danse WHERE IdE='.$ecole.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}

function modifCodePostal($ecole, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Code_postal="'.$val.'" WHERE IdAd=( SELECT IdAd FROM  Ecole_de_Danse WHERE IdE='.$ecole.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}



////////////////modif cours/////////////////////
function modifCodeC($idcours, $val)	{
	global $connexion;
	echo $idcours;
	$requete = 'UPDATE Cours SET CodeC="'.$val.'" WHERE IdCours='.$idcours.';';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo ($requete);
		exit();
	}
	
}

function modifLibelle($idcours, $val)	{
	global $connexion;
	$requete = 'UPDATE Cours SET Libellé="'.$val.'" WHERE IdCours='.$idcours.';';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}

function modifCategorie($idcours, $val)	{
	global $connexion;
	$requete = 'UPDATE Cours SET Categorie_age="'.$val.'" WHERE IdCours='.$idcours.';';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}


function modifResponsableCours($idcours, $idecole, $val)	{
	global $connexion;
	$requete = 'UPDATE enseigne SET IdEmp="'.$val.'" WHERE IdCours='.$idcours.' AND IdE = '.$idecole.' ;';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo($requete);
		exit();
	}
}
function ajoutCours($codeC, $libelle, $categorie, $ecole, $employe)	{
	global $connexion;
	$requete1 = 'INSERT INTO Cours (CodeC, Libellé, Categorie_age) VALUES ("'.$codeC.'", "'.$libelle.'", "'.$categorie.'");'; 
	$requete2 = 'INSERT INTO enseigne (IdE, IdCours, IdEmp) VALUES 
	('.$ecole.', (SELECT IdCours FROM Cours WHERE CodeC="'.$codeC.'" AND Libellé="'.$libelle.'" AND Categorie_age="'.$categorie.'" LIMIT 1), '.$employe.');';
echo($requete1);
echo($requete2);
	$res1 = mysqli_query($connexion, $requete1);
	$res2 = mysqli_query($connexion, $requete2);
	if (!$res1) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
	if (!$res2) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}

//Renvoie 1 si le cours n'est donnée dans aucune école
function cours_pas_donnée($cours)
{
	global $connexion;
	$requete1 = 'SELECT IdCours FROM enseigne WHERE IdCours='.$cours.';';
	$res1 = mysqli_query($connexion, $requete1);
	$instances1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
	return ($instances1== null || count($instances1) == 0);
}

function suppressionCours($cours, $ecole)	{
	global $connexion;
	$requete1 = 'DELETE FROM enseigne WHERE IdCours="'.$cours.'" AND IdE="'.$ecole.'";';
	$res1 = mysqli_query($connexion, $requete1);
	if (cours_pas_donnée($cours))
	{
		$requete1 = 'DELETE FROM Cours WHERE IdCours="'.$cours.'";';
		$res1 = mysqli_query($connexion, $requete1);
	}
}

	
//////////////////////////////federation//////////////////////////

function get_federation($nomFon)	{
	global $connexion;
	//le nom, le sigle et l’adresse de la fédération
	$requete0 = 'SELECT F.idFed, F.NomF, F.Sigle, F.NomPresident,A.Num_voie, A.Rue, A.Complement_rue ,A.Numero_cedex, A.boite_postale, A.Code_postal ,A.Nom_ville, A.Nom_pays 
	FROM Fédération F JOIN Adresse A ON F.IdAd = A.IdAd JOIN Ecole_de_Danse E ON E.idFed = F.idFed
	WHERE E.Noms_Fondateurs LIKE "%'.$nomFon.'%";' ;
	$res0 = mysqli_query($connexion, $requete0);
	if (!$res0) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
	$instances0 = mysqli_fetch_all($res0, MYSQLI_ASSOC);
	return $instances0;
}


function get_info_fede($idfed)	{
	global $connexion;

	$requete1 = 'SELECT F.NomF, COUNT(DISTINCT C.IdCom) AS Nb_Comite, COUNT(DISTINCT P.Code) AS Nb_Compétitions, COUNT(DISTINCT I.Num_license) AS Nb_Adherents
FROM Fédération F JOIN Comité C ON F.idFed = C.idFed  
JOIN Ecole_de_Danse E ON E.idFed = F.idFed
JOIN est_inscrit_à I ON I.IdE = E.IdE
JOIN participe_à P ON P.Num_license_1 = I.Num_license OR P.Num_license_2 = I.Num_license 
WHERE F.idFed = '.$idfed.';';

//nombre d'adherent de la federation
	$requete2  = 'SELECT COUNT(DISTINCT I.Num_license) AS Nb_Adherents
FROM Fédération F JOIN Ecole_de_Danse E ON E.idFed = F.idFed
JOIN est_inscrit_à I ON I.IdE = E.IdE
WHERE F.idFed = '.$idfed.';';

$res1= mysqli_query($connexion, $requete1);
$instances1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
if (!$res1) {
	printf("Error: %s\n", mysqli_error($connexion));
	exit();
}

$res2 = mysqli_query($connexion, $requete2);
$instances2 = mysqli_fetch_all($res2, MYSQLI_ASSOC);
if (!$res2) {
	printf("Error: %s\n", mysqli_error($connexion));
	exit();
}
return array($instances1, $instances2);
}




///////////modif info federation/////////////////////

function modifFondFede($idfed, $val)	{
	global $connexion;
	$requete = 'UPDATE Fédération SET Noms_Fondateurs="'.$val.'" WHERE idFed='.$idfed.' ;';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}

function modifNomFede($idfed, $val)	{
	global $connexion;
	$requete = 'UPDATE Fédération SET NomF="'.$val.'" WHERE idFed='.$idfed.' ;';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}

function modifNumVoieFede($idfed, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Num_voie="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Fédération WHERE idFed='.$idfed.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}

function modifRueFede($idfed, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Rue="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Fédération WHERE idFed='.$idfed.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}

function modifComplementFede($idfed, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Complement_rue="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Fédération WHERE idFed='.$idfed.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}

function modifCodePostalFede($idfed, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Code_postal="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Fédération WHERE idFed='.$idfed.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}

function modifVilleFede($idfed, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Nom_ville="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Fédération WHERE idFed='.$idfed.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}

function modifPaysFede($idfed, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Nom_pays="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Fédération WHERE idFed='.$idfed.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}

function modifBoitePostaleFede($idfed, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET boite_postale="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Fédération WHERE idFed='.$idfed.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}

function modifCedexFede($idfed, $val)	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Numero_cedex="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Fédération WHERE idFed='.$idfed.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}

function modifSigleFedee($idfed, $val)	{
	global $connexion;
	$requete = 'UPDATE Fédération SET Sigle="'.$val.'" WHERE idFed='.$idfed.' ;';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}




///////////ajout federation/////////////////////
function ajout_federation($nom, $sigle, $noms_fondateurs, $num_voie, $rue, $code_postal, $nom_ville, $nom_pays)	{
	global $connexion;
	$requete = 'INSERT INTO Adresse (Num_voie, Rue,  Code_postal, Nom_ville, Nom_pays) VALUES ("'.$num_voie.'", "'.$rue.'", "'.$code_postal.'", "'.$nom_ville.'", "'.$nom_pays.'");';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
	$requete = 'INSERT INTO Fédération (NomF, Sigle, NomPresident, IdAd) VALUES ("'.$nom.'", "'.$sigle.'", "'.$noms_fondateurs.'", (SELECT IdAd FROM Adresse WHERE Num_voie="'.$num_voie.'" AND Rue="'.$rue.'"  AND Code_postal="'.$code_postal.'" AND Nom_ville="'.$nom_ville.'" AND Nom_pays="'.$nom_pays.'" LIMIT 1));';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		exit();
	}
}




//////////////////comite/////////////////////////

function get_comites($idfed)	{
	global $connexion;
	$requete = 'SELECT C.IdCom, C.Nom, C.Niveau
	FROM Comité C  JOIN Fédération F ON F.idFed = C.idFed
	WHERE F.idFed = '.$idfed.';';
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}

function get_comite($idcom)	{
	global $connexion;
	$requete = 'SELECT C.Code, C.Nom, A.Num_voie, A.Rue, A.Complement_rue, A.Code_postal ,A.Nom_ville, A.Nom_pays, A.boite_postale, A.Numero_cedex
	FROM Comité C JOIN Adresse A ON C.IdAd = A.IdAd
	WHERE C.IdCom = '.$idcom.';';
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}


//////////////////////modif comite/////////////////////////
function modif_nom_comite($val, $idcom)	{
	global $connexion;

	$requete = 'UPDATE Comité SET Nom="'.$val.'" WHERE IdCom='.$idcom.';';
	$res = mysqli_query($connexion, $requete);
	echo $requete;
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}

}

function modif_num_comite ($val, $idcom) 	{
	global $connexion;

	$requete = 'UPDATE Adresse SET Num_voie="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Comité WHERE IdCom='.$idcom.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}
}


function modif_rue_comite($val, $idcom) 	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Rue="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Comité WHERE IdCom='.$idcom.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}
}


function modif_ville_comite($val, $idcom) 	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Nom_ville="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Comité WHERE IdCom='.$idcom.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}
}

function modif_boitepostale_comite($val, $idcom) 	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Boite_postale="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Comité WHERE IdCom='.$idcom.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}
}

function modif_cedex_comite($val, $idcom) 	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Cedex="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Comité WHERE IdCom='.$idcom.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}
}

function modif_pays_comite($val, $idcom) 	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Nom_pays="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Comité WHERE IdCom='.$idcom.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}
}

function modif_cp_comite($val, $idcom) 	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Code_postal="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Comité WHERE IdCom='.$idcom.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}
}

function modif_complement_comite($val, $idcom) 	{
	global $connexion;
	$requete = 'UPDATE Adresse SET Complement_rue="'.$val.'" WHERE IdAd=(SELECT IdAd FROM Comité WHERE IdCom='.$idcom.');';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}
}







//////////////////////ajout comite/////////////////////////
function ajout_comite($nom, $code, $num, $rue, $ville, $cp, $pays,$niveau, $idfed, $complement, $boitepostale, $cedex, $depend)	{
	global $connexion;
	if ($complement != "" && $boitepostale != "" && $cedex != "") 
	{
		$requete = 'INSERT INTO Adresse (Num_voie, Rue, Nom_ville, Code_postal, Nom_pays, Complement_rue, Boite_postale, Numero_cedex) VALUES ("'.$num.'", "'.$rue.'", "'.$ville.'", "'.$cp.'", "'.$pays.'", "'.$complement.'", "'.$boitepostale.'", "'.$cedex.'");';
		$res = mysqli_query($connexion, $requete);
		if (!$res) {
			printf("Error: %s\n", mysqli_error($connexion));
			echo $requete;
			exit();
		}	
	}else {
		$var ="";
		$value = "";
		if ($complement != "") {
			$var = ", Complement_rue";
			$value = ', "'.$complement.'"';
		}
		if ($boitepostale != "") {
			$var = $var.", Boite_postale";
			$value = $value.', "'.$boitepostale.'"';
		}
		if ($cedex != "") {
			$var = $var.", Numero_cedex";
			$value = $value.', "'.$cedex.'"';
		}

		$requete = 'INSERT INTO Adresse (Num_voie, Rue, Nom_ville, Code_postal, Nom_pays '.$var.') VALUES ("'.$num.'", "'.$rue.'", "'.$ville.'", "'.$cp.'", "'.$pays.'"'.$value.');';
		$res = mysqli_query($connexion, $requete);
		if (!$res) {
			printf("Error: %s\n", mysqli_error($connexion));
			echo $requete;
			exit();
		}	
	}
	if($niveau =="reg")
	{
		$requete = 'INSERT INTO Comité (Nom, IdAd, IdFed, Code, Niveau) VALUES ("'.$nom.'", (SELECT IdAd FROM Adresse 
		WHERE Num_voie="'.$num.'" AND Rue="'.$rue.'" AND Nom_ville="'.$ville.'" AND Code_postal="'.$cp.'" AND Nom_pays="'.$pays.'" LIMIT 1
		), '.$idfed.', "'.$code.'", "'.$niveau.'");';
		$res = mysqli_query($connexion, $requete);
		if (!$res) {
			printf("Error: %s\n", mysqli_error($connexion));
			echo $requete;
			exit();
		}
	}else{ 
		if ($depend == "null") {
			echo("merci de choisir un comité de référence");
		}
		else{
			$requete = 'INSERT INTO Comité (Nom, IdAd, IdFed, Code, Niveau, IdCom_1) VALUES ("'.$nom.'", (SELECT IdAd FROM Adresse 
			WHERE Num_voie="'.$num.'" AND Rue="'.$rue.'" AND Nom_ville="'.$ville.'" AND Code_postal="'.$cp.'" AND Nom_pays="'.$pays.'" LIMIT 1
			), '.$idfed.', "'.$code.'", "'.$niveau.'", '.$depend.');';
			$res = mysqli_query($connexion, $requete);
			if (!$res) {
				printf("Error: %s\n", mysqli_error($connexion));
				echo $requete;
			}
			else{echo ("comite ajouté");}
		}
	}
}



//////////////////////Competition/////////////////////////

function get_competitions()	{ //retourne toutes les competitions
	global $connexion;
	$requete = 'SELECT Code, Libellé FROM Compétition;';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}else{
		return $res;
	}
}

function get_competition($codecomp)	{ //retourne les infos d'un cometition
	global $connexion;
	$requete1 = 'SELECT Code, Libellé, Niveau FROM Compétition WHERE Code="'.$codecomp.'";';
	$res1 = mysqli_query($connexion, $requete1);
	if (!$res1) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete1;
		exit();
	}
	$instances1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
	
	$requete2 = 'SELECT Année, ville_organisatrice, IdSP FROM Edition WHERE Code="'.$codecomp.'";';
	$res2 = mysqli_query($connexion, $requete2);
	if (!$res2) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete2;
		exit();
	}
	$instances2 = mysqli_fetch_all($res2, MYSQLI_ASSOC);

	return array($instances1, $instances2);
}


/////////////////modif competition et edition//////////////////////
function modif_libelle_competition($libelle, $codecomp)	{ //modifie le libelle d'une competition
	global $connexion;
	$requete = 'UPDATE Compétition SET Libellé="'.$libelle.'" WHERE Code="'.$codecomp.'";';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}else{
		return $res;
	}
}

function modif_niveau_competition($niveau, $codecomp)	{ //modifie le niveau d'une competition
	global $connexion;
	$requete = 'UPDATE Compétition SET Niveau="'.$niveau.'" WHERE Code="'.$codecomp.'";';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}else{
		return $res;
	}
}

function ajout_competition($code, $libelle, $niveau)	{
	global $connexion;
	$requete = 'INSERT INTO Compétition (Code, Libellé, Niveau) VALUES ("'.$code.'", "'.$libelle.'", "'.$niveau.'");';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}else{
		return $res;
	}
}

function suppr_competition($code)	{
	global $connexion;
	$requete = 'DELETE FROM Compétition WHERE Code="'.$code.'";';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}else{
		return $res;
	}
}


function modif_annee_edition($annee, $codecomp)	{ //modifie l'annee d'une edition
	global $connexion;
	$requete = 'UPDATE Edition SET Année="'.$annee.'" WHERE Code="'.$codecomp.'" ;';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}else{
		return $res;
	}
}

function modif_ville_edition($ville, $codecomp, $annee)	{ //modifie la ville d'une edition
	global $connexion;
	$requete = 'UPDATE Edition SET ville_organisatrice="'.$ville.'" WHERE Code="'.$codecomp.'" AND Année="'.$annee.'" ;';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}else{
		return $res;
	}
}

function modif_idsp_edition($idsp, $codecomp, $annee)	{ //modifie l'idsp d'une edition
	global $connexion;
	$requete = 'UPDATE Edition SET IdSP="'.$idsp.'" WHERE Code="'.$codecomp.'" AND Année="'.$annee.'" ;';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}else{
		return $res;
	}
}

function suppr_edition($code, $annee)	{
	global $connexion;
	$requete = 'DELETE FROM Edition WHERE Code="'.$code.'" AND Année="'.$annee.'";';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}else{
		return $res;
	}
}

function ajout_edition($code, $annee, $ville, $idsp)	{
	global $connexion;
	$requete = 'INSERT INTO Edition (Code, Année, ville_organisatrice, IdSP) VALUES ("'.$code.'", "'.$annee.'", "'.$ville.'", "'.$idsp.'");';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}else{
		return $res;
	}
}


///////////structure sportive/////////////////////

function get_structures()	{
	global $connexion;
	$requete = 'SELECT Nom, Type, Num_voie, Rue, Nom_ville, Code_postal, Nom_pays FROM Structure_sportive S JOIN Adresse A ON A.IdAd = S.IdAd;';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();
	}
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}

function ajout_structure_sportive( $nom, $type, $num,  $rue, $ville, $cp, $pays)	{
	global $connexion;
	$requete1 ='INSERT INTO Adresse ( Num_voie, Rue, Nom_ville, Code_postal , Nom_pays ) VALUES ("'.$num.'", "'.$rue.'", "'.$ville.'", "'.$cp.'", "'.$pays.'");';
	$res1 = mysqli_query($connexion, $requete1);
	if (!$res1) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete1;
		exit();
	}
	$requete2 = 'INSERT INTO Structure_sportive (Nom, Type, IdAd) VALUES ("'.$nom.'", "'.$type.'", (SELECT IdAd FROM Adresse WHERE Num_voie="'.$num.'" AND Rue="'.$rue.'" AND Nom_ville="'.$ville.'" AND Code_postal="'.$cp.'" AND Nom_pays="'.$pays.'" LIMIT 1));';
	$res2 = mysqli_query($connexion, $requete2);
	if (!$res2) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete2;
		exit();	
	}else{
		return $res2;
	}
}

function suppr_structure_sportive($idsp)	{
	global $connexion;
	$requete = 'DELETE FROM Structure_sportive WHERE IdSP="'.$idsp.'";';
	$res = mysqli_query($connexion, $requete);
	if (!$res) {
		printf("Error: %s\n", mysqli_error($connexion));
		echo $requete;
		exit();	
	}else{
		return $res;
	}
}





////////////////////////////////////////////////////////////////////////
///////    Informations (structure et contenu) d'une table    //////////
////////////////////////////////////////////////////////////////////////

/**
 *  Retourne le détail des infos sur une table
 * */
function get_infos( $typeVue, $nomTable ) {
	global $connexion;

	switch ( $typeVue) {
		case 'schema': return get_infos_schema( $nomTable ); break;
		case 'data': return get_infos_instances( $nomTable ); break;
		default: return null; 
	}
}

/**
 * Retourne le détail sur le schéma de la table
*/
function get_infos_schema( $nomTable ) {
	global $connexion;

	// récupération des informations sur la table (schema + instance)
	$requete = "SELECT * FROM $nomTable";
	$res = mysqli_query($connexion, $requete);

	// construction du schéma qui sera composé du nom de l'attribut et de son type	
	$schema = array( array( 'nom' => 'nom_attribut' ), array( 'nom' => 'type_attribut' ) , array('nom' => 'clé')) ;

	// récupération des valeurs associées au nom et au type des attributs
	$metadonnees = mysqli_fetch_fields($res);

	$infos_att = array();
	foreach( $metadonnees as $att ){
		//var_dump($att);

 		$is_in_pk = ($att->flags & MYSQLI_PRI_KEY_FLAG)?'PK':'';
 		$type = convertir_type($att->{'type'});

		array_push( $infos_att , array( 'nom' => $att->{'name'}, 'type' => $type , 'cle' => $is_in_pk) );	
	}

	return array('schema'=> $schema , 'instances'=> $infos_att);

}

/**
 * Retourne les instances de la table
*/
function get_infos_instances( $nomTable ) {
	global $connexion;

	// récupération des informations sur la table (schema + instance)
	$requete = "SELECT * FROM $nomTable";  
 	$res = mysqli_query($connexion, $requete);  

 	// extraction des informations sur le schéma à partir du résultat précédent
	$infos_atts = mysqli_fetch_fields($res); 

	// filtrage des information du schéma pour ne garder que le nom de l'attribut
	$schema = array();
	foreach( $infos_atts as $att ){
		array_push( $schema , array( 'nom' => $att->{'name'} ) ); // syntaxe objet permettant de récupérer la propriété 'name' du de l'objet descriptif de l'attribut courant
	}

	// récupération des données (instances) de la table
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	// renvoi d'un tableau contenant les informations sur le schéma (nom d'attribut) et les n-uplets
	return array('schema'=> $schema , 'instances'=> $instances);

}


function convertir_type( $code ){
	switch( $code ){
		case 1 : return 'BOOL/TINYINT';
		case 2 : return 'SMALLINT';
		case 3 : return 'INTEGER';
		case 4 : return 'FLOAT';
		case 5 : return 'DOUBLE';
		case 7 : return 'TIMESTAMP';
		case 8 : return 'BIGINT/SERIAL';
		case 9 : return 'MEDIUMINT';
		case 10 : return 'DATE';
		case 11 : return 'TIME';
		case 12 : return 'DATETIME';
		case 13 : return 'YEAR';
		case 16 : return 'BIT';
		case 246 : return 'DECIMAL/NUMERIC/FIXED';
		case 252 : return 'BLOB/TEXT';
		case 253 : return 'VARCHAR/VARBINARY';
		case 254 : return 'CHAR/SET/ENUM/BINARY';
		default : return '?';
	}

}


?>
