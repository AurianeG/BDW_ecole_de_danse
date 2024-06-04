<!--Auriane GONINDARD p2101407 - Nicolas GALLET p2101620-->
<?php	
if (isset($_POST['authentification'])){
	$message = "";

	// recupération de la liste des tables
		$ecole=get_info_ecole($_POST['Fondateurs']);
		$employes=get_employes($ecole[0]['IdE']);
		$adherent=get_nb_adherent($ecole[0]['IdE']);
		$cours=get_cours($ecole[0]['IdE']);
		$nbAdComp=get_adh_comp($ecole[0]['IdE']);


	if($ecole == null || count($ecole) == 0) {
		$message .= "Aucune statistique n'est disponible!";
	}
		

}
if (!isset($_POST['authentification']) && !isset($_POST['authentifederation'])){
	$stats = get_fondateurs();
	//recuperer les membres de la federation

 }

if (isset($_POST['authentifederation'])){
	$idfed = get_federation($_POST['Federation']);
 }

?>