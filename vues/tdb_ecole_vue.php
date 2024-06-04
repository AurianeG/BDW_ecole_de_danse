<!--Auriane GONINDARD p2101407 - Nicolas GALLET p2101620-->
<?php if ($_GET['p'] == 'info') { //-on verifie si l'on a demandé la gestion des ecoles -->
        if($ecole == null || count($ecole) == 0) {  //on verifie que l'on a bien des ecoles
            print("<p>Aucune statistique n'est disponible!</p>");
        }else{?>
    <div class="panneau"> <!-- on affiche les infos de l'ecole -->
        <div>
        <p>  <!--si tout va bien on affiche les infos de l'ecole ... -->
            L'école <?php print($ecole[0]['Nom_ecole'])?> à été créée par <?php print($ecole[0]['Noms_Fondateurs'])?>.
        </br>
            Adresse : <?php print($ecole[0]['Num_voie']." ".$ecole[0]['Rue']." ");
			if($ecole[0]['Complement_rue']!=null) 
			{print($ecole[0]['Complement_rue']);} 
			print(" ".$ecole[0]['Code_postal']." ".$ecole[0]['Nom_ville']." en ".$ecole[0]['Nom_pays']);?> 
       </p>
       <?php if($ecole [0]['Numero_cedex'] != null){?>
        <p> Cedex : <?php print($ecole[0]['Numero_cedex'])?></p>
        <?php } ?>
        <?php if($ecole [0]['Boite_postale'] != null){?>
        <p> Boite postale : <?php print($ecole[0]['Boite_postale'])?></p>
        <?php } ?>
        </div>

        <div>
            <p>Remplissez un des champs ci-dessous pour modifier les informations de l'école : </p> <!-- ... et on propose de modifier les infos de l'ecole-->

            <form  name = "modif" action=# method="post">
                <input type="texte" name="modfondateur" placeholder="Entrez les noms des fondateurs"    >
                <input type="texte" name="modnomEcole" placeholder="Entrez le nom de l'école">
                <input type="texte" name="modnumvoie" placeholder="Entrez le numéro de la voie">
                <input type="texte" name="modrue" placeholder="Entrez le nom de la rue">
                <input type="texte" name="modcomplement" placeholder="Entrez le complément d'adresse">
                <input type="texte" name="modnumcedex" placeholder="Entrez le numero de cedex">
                <input type="texte" name="boitepostale" placeholder="Entrez la boite postale">
                <input type="texte" name="modcodepostal" placeholder="Entrez le code postal">
                <input type="texte" name="modville" placeholder="Entrez la ville de l'école">
                <input type="texte" name="modpays" placeholder="Entrez le pays de l'école">
                <input type="submit" name="modif" value="Modifier">
            </form>
        </div>

    </div>
 <?php } ?> <!-- fin du else de la verification de l'existence de l'ecole -->





<?php } else {
    if ($_GET['p'] == 'cours'){  //<!-- si on est sur la page cours -->
            if (count($cours) == 0) {
                print("Aucun cours");}
            else{?> <!-- si il y a des cours on les affiche -->
        <div class = "panneau">
            <div>
                <table class="table_resultat">
                <tbody>
                <tr><td>Code</td><td>Libellé</td><td>Catégorie d'age</td><td>Responsable</td></tr>
                    <?php foreach ($cours as $cour) { ?>
                        <tr><td><?php print($cour['CodeC'])?></td><td><?php print($cour['Libellé'])?></td><td><?php print($cour['Categorie_age'])?></td><td><?php print($cour['Nom']." ".$cour['Prenom'])?></td></tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>

            <div>
            <form name="modCoursForm" method="post" action="#">    <!-- formulaire pour choisir un cours aet le  modifier -->
                <H2>Veuillez choisir un cours et remplir les valeurs à modifier </H2> 
                <select name="modCoursSEL">
                    <?php foreach ($cours as $key => $value) {?>
                            <option value='<?php print($value["IdCours"])?>'>
                            <?php print($value["CodeC"].' : '.$value["Libellé"])?></option>
                        <?php } ?>
                </select>
                <input type="texte" name="modCodeC" placeholder="Entrez le code du cours">
                <input type="texte" name="modLibellé" placeholder="Entrez le libellé du cours">
                <input type="texte" name="modCategorie_age" placeholder="Entrez la catégorie d'age">
            	 <select name="responsable">
                    <?php $responsables=get_employes($ecole[0]['IdE']);
                    foreach ($responsables as $key => $value) {?>
                            <option value='<?php print($value["IdEmp"])?>'>
                            <?php print($value["Nom"].' '.$value["Prenom"])?></option>
                        <?php } ?>
                </select>
            <input type="submit" name="modCours" value="modifier"/>
            <input type="submit" name="supCours" value="supprimer"/>
            </form>
            </div>
        <?php   } ?>   


        <div>  
        <H2>Ajouter un cours</H2>
        <form  method="post" action="#">    <!-- formulaire pour ajouter un cours -->
            <input type="texte" name="ajoutCodeC" placeholder="Entrez le code du cours">
            <input type="texte" name="ajoutLibellé" placeholder="Entrez le libellé du cours">
            <input type="texte" name="ajoutCategorie_age" placeholder="Entrez la catégorie d'age">
            <select name="responsable">
                <option value='null'>Choisissez un responsable</option>
                    <?php  foreach ($responsables as $key => $value) {?>
                            <option value='<?php print($value["IdEmp"])?>'>
                            <?php print($value["Nom"].' '.$value["Prenom"])?></option>
                    <?php } ?>
            </select>
            <input type="submit" name="ajoutCours" value="ajouter"/>
        </form>
        <p>Pour ajouter un nouvel employé, veuillez vous rendre sur la page de gestion des employés (faite par un collègue)</p>
        </div>
    </div>


     <?php } 

 } ?> 
