<!--Auriane GONINDARD p2101407 - Nicolas GALLET p2101620-->
<?php if (isset($_GET['p'])) { ?>   <!--on verifie que l'on a bien demandé la gestion des ecoles et cours-->


<?php if ($_GET['p'] == 'info') { //    <!--on verifie si l'on a demandé la gestion des federation -->
        if($federation == null || count($federation) == 0) {  //on verifie que l'on a bien des federation
            print("Aucune statistique n'est disponible!");
        }else{?>
        <!--si tout va bien on affiche les infos de la federation ... -->
        <div class ="panneau">
        <div>
            <table class="table_resultat">
                <tbody>
                    <tr><td>Nom</td><td><?php print($federation[0][0]['NomF'])?></td></tr>
                    <tr><td>Sigle</td><td><?php print($infoFed[0]['Sigle'])?></td></tr>
                    <tr><td>Dirigeant</td><td><?php print($infoFed[0]['NomPresident'])?></td></tr>
                    <tr><td>Adresse</td><td><?php print($infoFed[0]["Nom_pays"]." ".$infoFed[0]["Nom_ville"].
                    " ".$infoFed[0]["Num_voie"]." ".$infoFed[0]["Rue"])?></td></tr>
                    <?php if ($infoFed[0]['Numero_cedex'] != null) { ?>
                    <tr><td>Cedex</td><td><?php print($infoFed[0]['Numero_cedex'])?></td></tr>
                    <?php } ?>
                    <?php if ($infoFed[0]['boite_postale'] != null) { ?>
                        <tr><td>Boite postale</td><td><?php print($infoFed[0]['boite_postale'])?></td></tr>
                    <?php } ?>
                    <?php if ($infoFed[0]['Complement_rue'] != null) { ?>
                        <tr><td>Complement de rue</td><td><?php print($infoFed[0]['Complement_rue'])?></td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div>
            <p>La fédération <?php print($federation[0][0]['NomF'])?> est composée de  <?php print($federation[0][0]['Nb_Comite'])?> comité(s), 
            <?php print($federation[1][0]['Nb_Adherents'])?> adhérent(s).</p>
            <p>Elle a organisé <?php print($federation[0][0]['Nb_Compétitions'])?> compétition(s) et <?php print($federation[0][0]['Nb_Adherents'])?> 
            adhérent(s) ont participé à une de ces compétitions.</p>
        </div>
        <div>
            <p>Modifier le nom ou l'adresse de la fédération : </p> <!--on propose de modifier le nom ou l'adresse de la federation -->
            <form method="post" action="#" >
                <!--mettre un select pour choisir la federation-->
            <input type='hidden' name='idfederation' value="<?php print($federation[0][0]['IdFed'])?>">
            <input type='text' name='nom' placeholder="modifier le nom">
            <input type='text' name='fond' placeholder="modifier le president">
            <input type='text' name='sigle' placeholder="modifier le sigle">
            <input type='text' name='num' placeholder="modifier le numero de voie">
            <input type='text' name='rue' placeholder="modifier le nom de la rue">
            <input type='text' name='complement' placeholder="modifier le complement d'adresse"> 
            <input type='text' name='ville' placeholder="modifier le nom de la ville">
            <input type='text' name='boitepostale' placeholder="modifier la boite postale">
            <input type='text' name='cedex' placeholder="modifier le cedex">
            <input type='text' name='pays' placeholder="modifier le nom du pays">
            <input type='text' name='cp' placeholder="modifier le code postal">
            <input name ="modfed" type='submit' value='modifier'>
            </form>
        </div>
        <div>
            <p>Ajouter une federation : </p> <!--on propose d'ajouter une federation -->
            <form method="post" action="#" >
                <input type='text' name='nom' placeholder="nom">
                <input type='text' name='fond' placeholder="president">
                <input type='text' name='sigle' placeholder="sigle">
                <input type='text' name='num' placeholder="numero de voie">
                <input type='text' name='rue' placeholder="nom de la rue">
                <input type='text' name='complement' placeholder="complement d'adresse">
                <input type='text' name='ville' placeholder="nom de la ville">
                <input type='text' name='pays' placeholder="nom du pays">
                <input type='text' name='cp' placeholder="code postal">
                <input name ="ajoutfed" type='submit' value='ajouter'>
            </form>
            <p>Pour ajouter le numéro de cedex, la boite postale ou le complément d'adresse d'une nouvelle fédération, 
                merci de commencer par créer une nouvelle fédération puis la modifier avec le formulaire ci-contre. </p>
        </div>
    </div>


<?php }}

        if($_GET['p'] == 'comite') { ?>
    <div class="panneau">
            <div>
                <form method="post" action="#">
                    <select name="comite">
                        <?php foreach($comites as $key => $value){?>
                                <option value="<?php print($value['IdCom'])?>"><?php print($value['Nom'])?></option>
                        <?php }?>
                    </select>
                    <input name ="comité" type="submit" value="Afficher les informations du comite">
                </form>
            </div>
     
        
<?php
    if(isset($_POST['comité'])){ //si on a demandé les infos d'un comite on les affiche
        ?>
        <div>
            <table class="table_resultat">
                <tbody>
                    <tr><td>Code</td><td><?php print($comite[0]['Code'])?></td></tr>
                    <tr><td>Nom</td><td><?php print($comite[0]['Nom'])?></td></tr>
                    <tr><td>Adresse</td><td><?php print($comite[0]["Nom_pays"]." ".$comite[0]["Nom_ville"].
                    " ".$comite[0]["Num_voie"]." ".$comite[0]["Rue"])?></td></tr>
                    <tr><td>Code postal</td><td><?php print($comite[0]["Code_postal"])?></td></tr>
                    <?php if ($comite[0]['Numero_cedex'] != null) { ?>
                        <tr><td>Cedex</td><td><?php print($comite[0]['Numero_cedex'])?></td></tr>
                    <?php } ?>
                    <?php if ($comite[0]['boite_postale'] != null) { ?>
                        <tr><td>Boite postale</td><td><?php print($comite[0]['boite_postale'])?></td></tr>
                    <?php } ?>
                    <?php if ($comite[0]['Complement_rue'] != null) { ?>
                        <tr><td>Complement de rue</td><td><?php print($comite[0]['Complement_rue'])?></td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div>
            <p>Modifier le nom ou l'adresse du comité : </p> <!--on propose de modifier le nom ou l'adresse du comite -->
            <form method="post" action="#" >
            <input type='hidden' name='idcomite' value="<?php print($_POST['comite'])?>">
            <input type='text' name='nom' placeholder="modifier le nom">
            <input type='text' name='code' placeholder="modifier le code">
            <input type='text' name='num' placeholder="modifier le numero de voie">
            <input type='text' name='rue' placeholder="modifier le nom de la rue">
            <input type='text' name='complement' placeholder="modifier le complement d'adresse"> 
            <input type='text' name='ville' placeholder="modifier le nom de la ville">
            <input type='text' name='boitepostale' placeholder="modifier la boite postale">
            <input type='text' name='cedex' placeholder="modifier le cedex">
            <input type='text' name='pays' placeholder="modifier le nom du pays">
            <input type='text' name='cp' placeholder="modifier le code postal">
            <input name ="modcom" type='submit' value='modifier'>
            </form>
        </div>

        <div>
            <p>Ajouter un comité : </p> <!--on propose d'ajouter un comite -->
            <form method="post" action="#" > 
                <input type='text' name='nom' placeholder="nom">
                <input type='text' name='code' placeholder="code">
                <input type='text' name='num' placeholder="numero de voie">
                <input type='text' name='rue' placeholder="nom de la rue">
                <input type='text' name='complement' placeholder="complement d'adresse">
                <input type='text' name='ville' placeholder="nom de la ville">
                <input type='text' name='boitepostale' placeholder="modifier la boite postale">
                <input type='text' name='cedex' placeholder="modifier le cedex">
                <input type='text' name='cp' placeholder="code postal">
                <input type='text' name='pays' placeholder="nom du pays">
                <select name="niveau">
                    <option value="reg"> comité régional</option>
                    <option value="dept"> comité départemental</option>
                </select>
                <select name="dependance">
                    <option value="null">aucune dépendance</option>
                    <?php foreach($comites as $key => $value){
                    	if ($value['Niveau']=='reg') {?>
                        	<option value="<?php print($value['IdCom'])?>"><?php print($value['Nom']);?></option>
                    <?php }}?>
                </select>
                <input name ="addcom" type='submit' value='ajouter'>
            </form>

        <?php }?>
    </div>
<?php
    }//fin comite


    if ($_GET['p'] == "competition")    {?>
    <div class="panneau">
        <form method="post" action="#" >
            <select name="code_competition">
                <?php foreach($competitions as $key => $value){?>
                        <option value="<?php print($value['Code'])?>"><?php print($value['Libellé'])?></option>
                <?php }?>
            </select>
            <input name ="affcomp" type="submit" value="Afficher les informations de la competition">
        </form>

        </br>

        <div class ="separe">
            <div>
                <p>Ajouter une competition : </p> <!--on propose d'ajouter une competition -->
                <form method="post" action="#" > 
                    <input type='text' name='code' placeholder="code">
                    <input type='text' name='libelle' placeholder="libelle">
                    <input type='text' name='niveau' placeholder="niveau">
                    <input name ="addcomp" type='submit' value='ajouter'>
                </form>

            </div>

            </br>

            <div>
                <p>Supprimer une competition : </p> <!--on propose de supprimer une competition -->
                <form method="post" action="#" > 
                    <select name="code_competition">
                        <?php foreach($competitions as $key => $value){?>
                                <option value="<?php print($value['Code'])?>"><?php print($value['Libellé'])?></option>
                        <?php }?>
                    </select>
                    <input name ="delcomp" type='submit' value='supprimer'>
                </form>

            </div>
        </div>

        </br>

        <div class ="separe">
            <div> 
                <p> Ajouter une structure sportive : </p> <!--on propose d'ajouter une structure sportive -->
                <form method="post" action="#" > 
                    <input type='text' name='nom' placeholder="nom">
                    <input type='text' name='type' placeholder="type">
                    <input type='text' name='num' placeholder="numero de voie">
                    <input type='text' name='rue' placeholder="nom de la rue">
                    <input type='text' name='ville' placeholder="nom de la ville">
                    <input type='text' name='cp' placeholder="code postal">
                    <input type='text' name='pays' placeholder="nom du pays">
                    <input name ="addsp" type='submit' value='ajouter'>
                </form>
            </div>

            </br>
                                
            <div>
                <p>Supprimer ou modifier une structure sportive : </p> <!--on propose de supprimer ou de modifier une structure sportive -->
                <p> Il n'est pour le moment pas possible de modifier les informations d'une structure sportive. </p>
                <form method="post" action="#" > 
                    <select name="id">
                        <?php foreach($struct as $key => $value){?>
                                <option value="<?php print($value['IdSP'])?>"><?php print($value['Nom'])?></option>
                        <?php }?>
                    </select>
                    <input name ="delsp" type='submit' value='supprimer'>
                    
                    <input type='text' name='nom' placeholder="modifier le nom">
                    <input type='text' name='type' placeholder="modifier le type">
                    <input type='text' name='num' placeholder="modifier le numero de voie">
                    <input type='text' name='rue' placeholder="modifier le nom de la rue">
                    <input type='text' name='ville' placeholder="modifier le nom de la ville">
                    <input type='text' name='cp' placeholder="modifier le code postal">
                    <input type='text' name='pays' placeholder="modifier le nom du pays">
                    <input name ="modsp" type='submit' value='modifier'>
                </form>
            </div>
        </div>



    <?php if (isset($_POST['affcomp'])) {
        ?>
        <div class ="separe">
            <div>
                <p><?php print($competition[0][0]['Code'])?> : <?php print($competition[0][0]['Libellé'])?> niveau <?php print($competition[0][0]['Niveau'])?></p>
                <table class="table_resultat">
                    <thead>
                        <tr><th>Année</th><th>Ville organisatrice</th><th>IdSP</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($competition[1] as $key => $value){?>
                            <tr><td><?php print($value['Année'])?></td><td><?php print($value['ville_organisatrice'])?></td><td><?php print($value['IdSP'])?></td></tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>

            </br>
            
            <div>
            <form method="post" action="#"  name ="modifierCompetition"> <!--on propose de modifier le libelle ou le niveau de la competition -->
                <input type='hidden' name='code_competition' value="<?php print($_POST['code_competition'])?>">
                <input type='text' name='libelle' placeholder="modifier le libelle">
                <input type='text' name='niveau' placeholder="modifier le niveau">
                <input name ="modcomp" type='submit' value='modifier'>
            </form>
            </div>

        

            </br>

            <div>
                <p>Modifier une édition : </p> <!--on propose de modifier ou supprimer une edition -->
                <form methode ="post" action="#">
                    <select name="edition">
                        <?php  
                        foreach($competition[1] as $key => $value){?>
                                <option value="<?php print($value['Année'])?>"><?php print($value['Année']); print($value['ville_organisatrice'])?></option>
                        <?php }?>
                    </select>
                    <input type='text' name='annee' placeholder="annee">
                    <input type='text' name='ville' placeholder="ville">
                    <input type='text' name='idsp' placeholder="idsp">
                    <input name ="modedition" type='submit' value="modifier l'édition">
                    <input name ="deledition" type='submit' value="supprimer l'édition">
                </form>
            </div>

            </br>

            <div>
                <p>Ajouter une édition : </p> <!--on propose d'ajouter une edition -->
                <form methode ="post" action="#">
                    <input type='text' name='annee' placeholder="annee">
                    <input type='text' name='ville' placeholder="ville">
                    <input type='text' name='idsp' placeholder="idsp">
                    <input name ="addedition" type='submit' value="ajouter l'édition">

                </form>
                </div>
            </div>
        </div>




   <?php } //fin affcomp





    }//fin competition
    }?>
