<!--Auriane GONINDARD p2101407 - Nicolas GALLET p2101620-->
<?php if (isset($_GET['p'])) { //on verifie que l'on a bien demandé la gestion des ecoles et cours


    
 if ($_GET['p'] == 'info') {    //on verifie si l'on a demandé la gestion des ecoles -->
    $ecole=get_info_ecole($_GET['fondateur']);  

        if (isset($_POST['modif'])) { //on verifie si l'on a cliqué sur le bouton modifier puis on modifie les infos de l'ecole
            if($_POST['modfondateur'] != null){
            modifFond($ecole[0]['IdE'],$_POST['modfondateur']);
            echo('fondateur modifié');
            }
            if($_POST['modnomEcole'] != null){
            modifNomEcole($ecole[0]['IdE'],$_POST['modnomEcole']);
            echo('nom ecole modifié');
            }
            if($_POST['modnumvoie'] != null){
            modifNumVoie($ecole[0]['IdE'],$_POST['modnumvoie']);
            echo('num voie modifié');
            }
            if($_POST['modrue'] != null){
            modifRue($ecole[0]['IdE'],$_POST['modrue']);
            echo('rue modifié');
            }
            if($_POST['modcomplement'] != null){
            modifComplement($ecole[0]['IdE'],$_POST['modcomplement']);
            echo("complement de rue modifié");
            }
            if($_POST['modnumcedex'] != null){
            modifNumCedex($ecole[0]['IdE'],$_POST['modnumcedex']);
            echo('num cedex modifié');
            }
            if($_POST['boitepostale'] != null){
            modifBoitePostale($ecole[0]['IdE'],$_POST['boitepostale']);
            echo('boite postale modifié');
            }
            if($_POST['modcodepostal'] != null){
            modifCodePostal($ecole[0]['IdE'],$_POST['modcodepostal']);
            echo('code postal modifié');
            }
            if($_POST['modville'] != null){
            modifVille($ecole[0]['IdE'],$_POST['modville']);
            echo('ville modifié');
            }
            if($_POST['modpays'] != null){
            modifPays($ecole[0]['IdE'],$_POST['modpays']);
            echo('pays modifié');
            }
            if($_POST['modfondateur'] != null){
                echo('<meta http-equiv="refresh" content="0; URL='.str_replace('tdb_ecole','index.php',$nomPage) .'?f=tdb_ecole&p=info&fondateur='.str_replace(' ','+',$_POST['modfondateur']).'&gestion=gestion+des+information+de+l\'école#">');
            }else{
                echo('<meta http-equiv="refresh" content="0; URL='.str_replace('tdb_ecole','index.php',$nomPage) .'?f=tdb_ecole&p=info&fondateur='.str_replace(' ','+',$_GET['fondateur']).'&gestion=gestion+des+information+de+l\'école#">');
            }
     } // fin du if de la verification de l'existence de l'ecole -->
    } // fin du if de la verification de la demande de gestion des ecoles -->


    else {if ($_GET['p'] == 'cours')  // si on est sur la page cours -->
        {
            $ecole=get_info_ecole($_GET['fondateur']);  //on recupere les infos de l'ecole
            $cours=get_cours($ecole[0]['IdE']); //on recupere les cours de l'ecole -->
            $responsables=get_employes($ecole[0]['IdE']);
            

            if (isset($_POST['modCours'])) { //on verifie si l'on a cliqué sur le bouton modifier puis on modifie les infos du cours
                if($_POST['modCodeC'] != null){
                    if(is_numeric($_POST['modCodeC'] ) == false){
                        echo('le code cours doit être un nombre');
                    }else{
                    modifCodeC($_POST['modCoursSEL'],$_POST['modCodeC']);
                    echo('code cours modifié');
                    }
                }
                if($_POST['modLibellé'] != null){
                modifLibelle($_POST['modCoursSEL'],$_POST['modLibellé']);
                echo('libellé cours modifié');
                }
                if($_POST['modCategorie_age'] != null){
                modifCategorie($_POST['modCoursSEL'],$_POST['modCategorie_age']);
                echo('categorie age modifié');
                }
                if($_POST['responsable'] != null)   {
                modifResponsableCours($_POST['modCoursSEL'],$ecole[0]['IdE'],$_POST['responsable']);
                echo('Responsable modifié');
                echo('<meta http-equiv="refresh" content="0; URL='.str_replace('tdb_ecole','index.php',$nomPage) .'?page=tdb_ecole&p=cours&fondateur='.str_replace(' ','+',$_GET['fondateur']).'&gestion=gestion+des+cours#">');
                }
            
            
            } //  <!-- fin du if de la verification de modification du cours -->

            if (isset($_POST['supCours'])) { 
                suppressionCours($_POST['modCoursSEL'], $ecole[0]['IdE']);
                echo('cours supprimé');
                echo('<meta http-equiv="refresh" content="0; URL='.str_replace('tdb_ecole','index.php',$nomPage) .'?page=tdb_ecole&p=cours&fondateur='.str_replace(' ','+',$_GET['fondateur']).'&gestion=gestion+des+cours#">');
            } 

            if (isset($_POST['ajoutCours'])) { //on verifie si l'on a cliqué sur le bouton ajouter puis on ajouter les infos du cours
                if (is_numeric($_POST['ajoutCodeC'] ) == false){
                    echo('le code cours doit être un nombre');
                }else{
                if ($_POST['ajoutCodeC'] != null && $_POST['ajoutLibellé'] != null && $_POST['ajoutCategorie_age'] != null){
                    ajoutCours($_POST['ajoutCodeC'],$_POST['ajoutLibellé'],$_POST['ajoutCategorie_age'], $ecole[0]['IdE'], $_POST['responsable']);
                    echo('cours ajouté');
                    echo('<meta http-equiv="refresh" content="0; URL='.str_replace('tdb_ecole','index.php',$nomPage) .'?page=tdb_ecole&p=cours&fondateur='.str_replace(' ','+',$_GET['fondateur']).'&gestion=gestion+des+cours#">');
                }
                else {
                    echo('veuillez remplir tous les champs');
                }
            }
            
                } //   <!-- fin du if de la verification de l'existence du cours -->

    } // fin du else de la verification de la demande de gestion des cours -->
} // fin du if de la verification de la demande de gestion des ecoles et cours -->
}?>

