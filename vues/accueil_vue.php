<!--Auriane GONINDARD p2101407 - Nicolas GALLET p2101620-->
<main>
<!-- si pas authentification alors on affiche les formulaires d'authentification -->
<?php if (!isset($_POST['authentification']) && !isset($_POST['authentifederation'])){?>
	<div class = "authentification">
		<div>
		<form class="bloc_authentification" method="post" action="#">
			<H2>Veuillez vous Authentifier en tant que gerant d'école</H2> 
			<select name="Fondateurs">
				<?php foreach ($stats as $key => $value) {?>
						<option value='<?php print($value["Noms_Fondateurs"])?>'>
						<?php print($value["Noms_Fondateurs"])?></option>
				<?php } ?>
			</select>
			<input type="submit" name="authentification" value="soumettre"/>
		</form>
	</div>
		

	<!-- pour le moment on identifie les gerants d'ecole, c'est juste un copier-coller 
	parce que je sais pas trop qui est considerer comme membre de la fede -->
		<div>
			<form class="bloc_authentification" method="post" action="#">
				<H2>Veuillez vous Authentifier en tant que membre de la federation</H2> 
				<select name="Federation">
					<?php foreach ($stats as $key => $value) {?>
						<option value='<?php print($value["Noms_Fondateurs"])?>'>
						<?php print($value["Noms_Fondateurs"])?></option>
					<?php } ?>
				</select>
				<input type="submit" name="authentifederation" value="soumettre"/>
			</form>
		</div>
	</div>	

	<div class ="presentation">
		<p class="accueil_description"> Bienvenue sur le gestionnaire de BD des fédérations et écoles de danse.</p>
		<p class="accueil_description accueil_auteurs">Vous êtes sur le site créé par Auriane GONINDARD et Nicolas GALLET. </p>
		<p id="contexte" >Ce site a été réalisé dans le cadre de l'UE LBDW.</p>
		<p class="accueil_description">Ce site permet de consulter une base de données pour modifier les informations d'une école,
			de ses cours, d'une fédération et de ses comités.
		</p>
		<p>Attention : après avoir modifié, ajouté ou supprimé une information, 
			il peut etre necessaire de recharger la page pour voir les modifications.</p>
	</div>
<?php }?>


<?php if (isset($_POST['authentification'])){ //si on a cliqué sur le bouton d'authentification(ecole) alors on affiche les infos de l'ecole
		/*if( $message != "" ) { ?>
			<p class="notification">
			<?= $message ?></p>  		 //pour une raison inconue, il passe dans le then alors que le message est vide
	<?php}else{;*/?>
			<div>
				<p>  <!--si tout va bien on affiche les infos de l'ecole ... -->
            L'école <?php print($ecole[0]['Nom_ecole'])?> a été créée par <?php print($ecole[0]['Noms_Fondateurs'])?>.
		</br>
			Adresse : <?php print($ecole[0]['Num_voie']." ".$ecole[0]['Rue']." ");
			if($ecole[0]['Complement_rue']!=null) 
				{print($ecole[0]['Complement_rue']);} 
			print(" ".$ecole[0]['Code_postal']." ".$ecole[0]['Nom_ville']." en ".$ecole[0]['Nom_pays']);?> 
       			</p>

			<?php if($ecole [0]['Numero_cedex'] != null){?>
				<p> Numéro de Cedex : <?php print($ecole[0]['Numero_cedex'])?></p>
			<?php } ?>
			<?php if($ecole [0]['Boite_postale'] != null){?>
				<p> Boite postale : <?php print($ecole[0]['Boite_postale'])?></p>
			<?php } ?>
			</div>
			
			<div>
			<p>Elle emploie : 
				<ul>
					<?php foreach ($employes as $employe) { ?>
						<li><?php print($employe['Nom']." ".$employe['Prenom'])?></li>
					<?php } ?>
				</ul>
			</p>
			</div>

			<div>
			<p>Nombre d'adhérents pour l'année 2022 : <?php print($adherent[0]['Nb_Adherents'])?></p>
			<p>Liste des cours :
			<?php if (count($cours) == 0) {
						print("Aucun cours");}
					else{?>
					<ul>
						<?php foreach ($cours as $cour) { ?>
							<li><?php print($cour['CodeC']); print(". "); print($cour['Libellé']); print (" : "); print($cour['Categorie_age']);?>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>

			<p><?php print($nbAdComp[0]['Nb_Adherents'])?> adhérents de cette école ont participé au moins à une compétition toutes années confondues.</p>
			</div>





	<p>Vous pouvez accéder à : </p>
	 <form class="bloc_gestion" method="get" action="#">
		<input type="hidden" name="page" value="tdb_ecole"/>
		<input type="hidden" name="p" value="info"/>
		<input type ="hidden" name="fondateur" value="<?php print($_POST['Fondateurs'])?>"/>
		<input type="submit" name="gestion" value="gestion des information de l'école"/>
	</form>

	<form class="bloc_gestion" method="get" action="#">
		<input type="hidden" name="page" value="tdb_ecole"/>
		<input type="hidden" name="p" value="cours"/>
		<input type ="hidden" name="fondateur" value="<?php print($_POST['Fondateurs'])?>"/>
		<input type="submit" name="gestion" value="gestion des cours"/>
	</form>
	<?php /*}*/?> <!--fin du else message-->
	<?php }?> <!--fin du if authentification-->


	
<?php if (isset($_POST['authentifederation'])){?>
	<form class="bloc_gestion" method="get" action="#">
		<input type="hidden" name="page" value="tdb_federation"/>
		<input type="hidden" name="p" value="info"/>
		<input type ="hidden" name="idFederation" value="<?php  print($idfed[0]['idFed']) ?>"/>
		<input type = "hidden" name="fonFederation" value="<?php print($_POST['Federation'])?>"/>
		<input type="submit" name="gestion" value="gestion des informations de la fédération"/>
	</form>

	<form class="bloc_gestion" method="get" action="#">
		<input type="hidden" name="page" value="tdb_federation"/>
		<input type="hidden" name="p" value="comite"/>
		<input type ="hidden" name="idFederation" value="<?php  print($idfed[0]['idFed'])?>"/>
		<input type = "hidden" name="fonFederation" value="<?php print($_POST['Federation'])?>"/>
		<input type="submit" name="gestion" value="gestion des comités"/>
	</form>

	<form class="bloc_gestion" method="get" action="#">
		<input type="hidden" name="page" value="tdb_federation"/>
		<input type="hidden" name="p" value="competition"/>
		<input type ="hidden" name="idFederation" value="<?php  print($idfed[0]['idFed'])?>"/>
		<input type="submit" name="gestion" value="gestion des compétitions"/>
	</form>
	  
<?php }?>	 

<div class ="image">
	<img src="img/logo-lyon1.webp" alt="UCBL"/>
</div>
	
</main>