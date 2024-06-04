<!--Auriane GONINDARD p2101407 - Nicolas GALLET p2101620-->
<?php if (isset($_GET['p'])) { 

//////////////////////////////////////gestion des federation/////////////////////////////////////
    if ($_GET['p'] == 'info') { //    <!--on verifie si l'on a demandé la gestion des federation -->
        $federation=get_info_fede($_GET['idFederation']);    
        $infoFed =get_federation($_GET['fonFederation']);

    
        if (isset($_POST['modfed']))   {
            if($_POST['fond'] != null){
                modifFondFede($infoFed[0]['idFed'],$_POST['fond']);
                echo('president modifié');
            }
            if($_POST['nom'] != null){
                modifNomFede($infoFed[0]['idFed'],$_POST['nom']);
                echo('nom federation modifié');
            }
            if (!is_numeric($_POST['num'])) {
                echo('Merci de mettre un nombre pour le numero de voie');
            }
            else{
                if($_POST['num'] != null){
                    modifNumVoieFede($infoFed[0]['idFed'],$_POST['num']);
                    echo('num voie modifié');
                }
            }
            if($_POST['rue'] != null){
                modifRueFede($infoFed[0]['idFed'],$_POST['rue']);
                echo('rue modifié');
            }
            if($_POST['complement'] != null){
                modifComplementFede($infoFed[0]['idFed'],$_POST['complement']);
                echo('complement modifié');
            }
            if($_POST['cp'] != null){
                modifCodePostalFede($infoFed[0]['idFed'],$_POST['cp']);
                echo('code postal modifié');
            }
            if($_POST['ville'] != null){
                modifVilleFede($infoFed[0]['idFed'],$_POST['ville']);
                echo('ville modifié');
            }
            if($_POST['pays'] != null){
                modifPaysFede($infoFed[0]['idFed'],$_POST['pays']);
                echo('pays modifié');
            }
            if($_POST['boitepostale'] != null){
                modifBoitePostaleFede($infoFed[0]['idFed'],$_POST['boitepostale']);
                echo('boite postale modifié');
            }
            if(!is_numeric($_POST['cedex']))    {
                echo('Merci de mettre un nombre pour le cedex');
            }
            else{
                if($_POST['cedex'] != null){
                modifCedexFede($infoFed[0]['idFed'],$_POST['cedex']);
                echo('cedex modifié');
                }
             }
            if($_POST['sigle'] != null){
                modifSigleFede($infoFed[0]['idFed'],$_POST['sigle']);
                echo('sigle modifié');
            }
        }
    
        if (isset($_POST['ajoutfed']))  {
            if (!is_numeric($_POST['num']) ){
                echo('Merci de mettre un nombre pour le numero de voie');
            }
            else{
                if($_POST['fond'] != null && $_POST['nom'] != null && $_POST['num'] != null && $_POST['rue'] != null && $_POST['ville'] != null && $_POST['cp'] != null && $_POST['pays'] != null ){
                    ajout_federation( $_POST['nom'], $_POST['sigle'], $_POST['fond'], $_POST['num'], $_POST['rue'],  $_POST['cp'], $_POST['ville'], $_POST['pays']);
                    echo('federation ajouté');
                }
                else{
                    echo('erreur lors de l\'ajout');
                }
        }

        }
    }
    ///////////////////////fin gestion des federation/////////////////////////////




    /////////////////////////////gestion des comites///////////////////////////////
    else {
    if($_GET['p'] == 'comite') { 
        $comites=get_comites($_GET['idFederation']); //    <!--on verifie si l'on a demandé la gestion des comites -->
        

        if(isset($_POST['comité'])){ //si on a demandé les infos d'un comite on les affiche
            $comite = get_comite($_POST['comite']);
            $federation = get_federation($_GET['fonFederation']);
        }
	

        if (isset($_POST['modcom'])) //si on a demandé de modifier un comite on le modifie
        {
            if( $_POST['nom'] != ""){
                modif_nom_comite($_POST['nom'], $_POST['idcomite']);
                echo ("nom modifié");
            }
            if( $_POST['num'] != ""){
                modif_num_comite($_POST['num'], $_POST['idcomite']);
                echo ("num modifié");
            }
            if( $_POST['rue'] != ""){
                modif_rue_comite($_POST['rue'], $_POST['idcomite']);
                echo ("rue modifié");
            }
            if( $_POST['complement'] != ""){
                modif_complement_comite($_POST['complement'], $_POST['idcomite']);
                echo ("complement modifié");
            }
            if( $_POST['ville'] != ""){
                modif_ville_comite($_POST['ville'], $_POST['idcomite']);
                echo ("ville modifié");
            }
            if( $_POST['boitepostale'] != ""){
                modif_boitepostale_comite($_POST['boitepostale'], $_POST['idcomite']);
                echo ("boitepostale modifié");
            }
            if( $_POST['cedex'] != ""){
                modif_cedex_comite($_POST['cedex'], $_POST['idcomite']);
                echo ("cedex modifié");
            }
            if( $_POST['pays'] != ""){
                modif_pays_comite($_POST['pays'], $_POST['idcomite']);
                echo ("pays modifié");
            }
            if( $_POST['cp'] != ""){
                modif_cp_comite($_POST['cp'], $_POST['idcomite']);
                echo ("code postal modifié");
            }
            if( $_POST['code'] != ""){
                modif_code_comite($_POST['code'], $_POST['idcomite']);
                echo ("code modifié");
            }
            $comites=get_comites($_GET['idFederation']);
        }//fin modif comite


        if (isset($_POST['addcom'])) // si on a demander d'ajouter un comite on l'ajoute
        {
            if ( $_POST['nom'] != "" && $_POST['code'] != "" && $_POST['num'] != "" && $_POST['rue'] != "" && $_POST['ville'] != "" && $_POST['cp'] != "" && $_POST['pays'] != "" && $_POST['niveau'] != "" )
            {$num = $_POST['num']; //conversion du numero de voie en int
            if (isset($_POST['cedex']) && is_numeric($_POST['cedex']))
            	$cedex= (int)$_POST['cedex'];
            else
            	$cedex=NULL;
            if (isset($_POST['complement']))
            	$comple= $_POST['complement'];
            else
            	$comple=NULL;
            if (isset($_POST['boitepostale']))
            	$boitepost= $_POST['boitepostale'];
            else
            	$boitepost=NULL;
                
                if(!is_numeric($num)){
                    echo ("le numero de voie doit etre un entier");
                }
                else{
                    (int)$num;
                    ajout_comite($_POST['nom'], $_POST['code'], $num, $_POST['rue'], $_POST['ville'], 
                    $_POST['cp'], $_POST['pays'], $_POST['niveau'], $_GET['idFederation'], $comple, $boitepost, $cedex, $_POST['dependance'] );
                    $comites=get_comites($_GET['idFederation']);
                }
            }
            else{
                echo ("merci de remplir tous les champs");
            }

        }//fin ajout comite    
}
/////////////////////////////fin gestion des comites/////////////////////////


/////////////////////////////gestion des competitions///////////////////////

else { if ($_GET['p'] == "competition")    {
    $competitions = get_competitions();
    $struct = get_structures();

    if (isset($_POST['affcomp'])) {
        $competition = get_competition($_POST['code_competition']);

    }

    if (isset($_POST['modcomp']))   {
        if ($_POST['libelle'] != "")    {
            $res =modif_libelle_competition($_POST['libelle'], $_POST['code_competition']);
            if ($res == 1)  {
                echo ("libelle modifié");
            }
            else    {
                echo ("libelle non modifié");
            }
            
        }
        if ($_POST['niveau'] != "")    {
            $res = modif_niveau_competition($_POST['niveau'], $_POST['code_competition']);
            if($res == 1)   {
                echo ("niveau modifié");
            }
            else    {
                echo ("niveau non modifié");
            }
        }
    }//fin modif competition

    if (isset($_POST['addcomp']))   {
        if ($_POST['libelle'] != "" && $_POST['niveau'] != "" && $_POST['code'] != "")    {
            $res = ajout_competition($_POST['code'], $_POST['libelle'], $_POST['niveau']);
            if ($res == 1)  {
                echo ("competition ajoutée");
            }
            else    {
                echo ("competition non ajoutée");
            }
        }
        else    {
            echo ("merci de remplir tous les champs");
        }
    }//fin ajout competition

    if (isset($_POST['delcomp']))   {
        $res = suppr_competition($_POST['code_competition']);
        if ($res == 1)  {
            echo ("competition supprimée");
        }
        else    {
            echo ("competition non supprimée");
        }
    }//fin suppr competition

    if (isset($_POST['modedition']))   {
        if ($_POST['annee'] != "")    {
            $res = modif_annee_edition($_POST['annee'], $_POST['code_competition']);
            if ($res == 1)  {
                echo ("annee modifiée");
            }
            else    {
                echo ("annee non modifiée");
            }
        }
        if ($_POST['ville'] != "")   {
            $res = modif_ville_edition($_POST['ville'], $_POST['code_competition'], $_POST['annee']);
            if ($res == 1)  {
                echo ("ville modifiée");
            }
            else    {
                echo ("ville non modifiée");
            }
        }
        if ($_POST['idsp'] != "")    {
            $res = modif_idsp_edition($_POST['idsp'], $_POST['code_competition']);
            if ($res == 1)  {
                echo ("idsp modifiée");
            }
            else    {
                echo ("idsp non modifiée");
            }
        }
    
    }//fin modif edition

    if (isset($_POST['addedition']))   {
        if ($_POST['annee'] != "" && $_POST['ville'] != "" && $_POST['idsp'] != "")    {
            $res = ajout_edition($_POST['annee'], $_POST['ville'], $_POST['idsp'], $_POST['code_competition']);
            if ($res == 1)  {
                echo ("edition ajoutée");
            }
            else    {
                echo ("edition non ajoutée");
            }
        }
        else    {
            echo ("merci de remplir tous les champs");
        }
    }//fin ajout edition

    if (isset($_POST['deledition']))   {
        $res = suppr_edition($_POST['code_competition'], $_POST['annee']);
        if ($res == 1)  {
            echo ("edition supprimée");
        }
        else    {
            echo ("edition non supprimée");
        }
    }//fin suppr edition

    if (isset($_POST['addsp']))   { //ajout d'une structure sportive
        if ($_POST['nom'] != "" && $_POST['type'] != "" && $_POST['num'] != "" && $_POST['rue'] != "" && $_POST['ville'] != "" && $_POST['cp'] != "" && $_POST['pays'] != "" )
            {$num = $_POST['num']; //conversion du numero de voie en int
            
                if(!is_numeric($num)){
                    echo ("le numero de voie doit etre un entier");
                }
                else{
                    (int)$num;
                    ajout_structure_sportive($_POST['nom'], $_POST['type'], $num, $_POST['rue'], $_POST['ville'], 
                    $_POST['cp'], $_POST['pays']);
                    echo ("structure sportive ajoutée");
                
                }
            }
            else{
                echo ("merci de remplir tous les champs");
            }
    }//fin ajout structure sportive

    if (isset($_POST['delsp']))   {
        $res = suppr_structure_sportive($_POST['idsp']);
        if ($res == 1)  {
            echo ("structure sportive supprimée");
        }
        else    {
            echo ("structure sportive non supprimée");
        }
    }//fin suppr structure sportive

  
    
    } //fin gestion des competitions


}}





}  ?>
