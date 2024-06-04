<!--Auriane GONINDARD p2101407 - Nicolas GALLET p2101620-->
<div class="panneau">

  <div>  <!-- Bloc permettant d'afficher les statistiques -->

	<h2>Statistiques de la base</h2>
<?php
		if( $message != "" ) { ?>
			<p class="notification"><?= $message ?></p>
<?php }else{?>
			<div>
				<p>Cette base de donnée contient <?php print($stats[0][0]["nbFed"])?> fédération(s), <?php print($stats[0][0]["nbCR"])?> 
				comités régionaux et <?php print($stats[0][0]["nbCD"])?> comités départementaux.</p>
			</div>

</br>
			
			<div>	
				<p>Voici le nombre d'écoles dans chaque département :</p>
				<table class="table_stats">
					<thead>
						<tr><th>departement</th><th>nb ecole</th></tr>
					</thead>
					<tbody>
						<?php foreach ($stats[1] as $key => $value) {?>
							<tr><td><?php print($value["Code_dept"])?></td><td><?php print($value["nbEcoles"])?></td></tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			<div>
				<p>Voici la liste des comités : </p>
				<table class="table_stats">
					<tbody>
						<?php foreach ($stats[2] as $key => $value) {?>
								<tr><td><?php print($value["Nom"])?></td></tr>
						<?php }?>
					</tbody>
				</table>
			</div>	
		
		
	 
	<div>
		<p>Voici les 5 écoles ayant le plus grand nombre d'adhérents :</p>
		<table class="table_stats">
			<thead>
				<tr><th>Nom de l'école</th><th>Ville</th><th>Nombre d'adhérents</th></tr>
			</thead>
			<tbody>
		<?php foreach ($stats[3] as $key => $value) {?>
				<tr><td><?php print($value["Nom_ecole"])?></td><td><?php print($value["Nom_ville"])?></td><td><?php print($value["Nb_Adherents"])?></td></tr>
		<?php }?>
			</tbody>
		</table>
	</div>
	<?php }?>

  </div>

</div>	