<?php 
	session_start();
	$current = 'documents';
	include_once('classes/connect.php');
	include_once('classes/Marche.php');
	include_once('classes/Montant.php');
	include_once('classes/Document.php');
	
	$m = new Montant();
	$marche = new Marche();
	$documentm = new Document();
	$identifiant = $_GET['m'];	
	
	$infoM = $marche->getInfosMarche($identifiant);
	$tmpp=$tmpp2=$tmpo=$tmpo2=array();
	$listefichierspublies = $documentm->getDocByType($identifiant,'publies');
	$listefichiersoffres = $documentm->getDocByType($identifiant,'offres');

	foreach($listefichierspublies as $k => $v)
	{
		$idenD=$v['id_document'];
		$tmpp[]=$idenD;
		$tmpp2[$idenD]=$v;
	}
	foreach($listefichiersoffres as $k => $v)
	{
		$idenD=$v['id_document'];
		$tmpo[]=$idenD;
		$tmpo2[$idenD]=$v;
	}
	$id_formate=$infoM[0]['id_marche_formate'];
	$erreur=array();
	$erreurmsg='';
	$msgok='';
	$niveaupost=0;
	if(isset($_POST['partiecomptable']) && $_POST['partiecomptable']=='Enregistrer' )
	{
		$erreurmsg='';
		$msgok='';
		
		
		$tabhiddenfilesp=$tabhiddenfileso=array();
		if(isset($_POST['hiddenfilespublies']) && count($_POST['hiddenfilespublies'])!=0)
		{
			$tabhiddenfilesp=$_POST['hiddenfilespublies'];
		}
		$diff_tab=array_diff($tmpp,$tabhiddenfilesp);
		if(count($diff_tab)!=0)
		{
			foreach($diff_tab as $cle => $valeur)
			{
				$nomfichier = $tmpp2[$valeur]['document'];
				
				if(unlink('fichiers/'.$id_formate.'/'.$nomfichier))
					$del = $documentm->delDoc($valeur);
				else
					$erreur['erreurunlink'] = 'Erreur sur le unlink '.$nomfichier;
			}
		}
		if(isset($_POST['hiddenfilesoffres']) && count($_POST['hiddenfilesoffres'])!=0)
		{
			$tabhiddenfileso=$_POST['hiddenfilesoffres'];
		}
		$diff_tab=array_diff($tmpo,$tabhiddenfileso);
		if(count($diff_tab)!=0)
		{
			foreach($diff_tab as $cle => $valeur)
			{
				$nomfichier = $tmpo2[$valeur]['document'];
				
				if(unlink('fichiers/'.$id_formate.'/'.$nomfichier))
					$del = $documentm->delDoc($valeur);
				else
					$erreur['erreurunlink'] = 'Erreur sur le unlink '.$nomfichier;
			}
		}
	
		foreach ($_FILES["piecespublies"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				if(is_dir('fichiers/'.$id_formate) || mkdir('fichiers/'.$id_formate,0750,false))
				{
					$tmp_name = $_FILES["piecespublies"]["tmp_name"][$key];
					$nameext = $_FILES["piecespublies"]["name"][$key];
					$tempext1 = substr(strrchr($nameext,"."),1);
					$tempext = (strlen(substr(strrchr($nameext,"."),1))+1)*(-1);
					$name=substr($nameext,0,$tempext);
					$caracteres = array('À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a','È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e','Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i','Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o','Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u','Œ' => 'oe', 'œ' => 'oe','$' => 's');
 
					$name = strtr($name, $caracteres);
					$name = preg_replace('#[^A-Za-z0-9]+#', '-', $name);
					$name = trim($name, '-');
					$name= $name.'_'.$id_formate.'_'.rand().'.'.$tempext1;
					move_uploaded_file($tmp_name, 'fichiers/'.$id_formate.'/'.$name);
					$ins = $documentm->addDoc($identifiant,$name,'publies');
					
					$listefichiers[] = array('id_document'=>$ins,'id_marche'=>$identifiant,'document'=>$name);
					$tmpp[]=$ins;
					$tmpp2[$ins]=array('id_document'=>$ins,'id_marche'=>$identifiant,'document'=>$name);
					$_POST['hiddenfilespublies'][]=$ins;
				}
				else
				{
					$erreur['mkdir'] = 'Erreur création du dossier.';
				}
			}
			if($error == UPLOAD_ERR_INI_SIZE)
			{
				$erreur['upload'] = 'Erreur sur upload (taille du fichier ini). Fichier trop lourd.';
			}
			if($error == UPLOAD_ERR_FORM_SIZE)
			{
				$erreur['upload2'] = 'Erreur sur upload (taille du fichier champs max size form). Fichier trop lourd.';
				
			}
		}
		foreach ($_FILES["piecesoffres"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				if(is_dir('fichiers/'.$id_formate) || mkdir('fichiers/'.$id_formate,0750,false))
				{
					$tmp_name = $_FILES["piecesoffres"]["tmp_name"][$key];
					$nameext = $_FILES["piecesoffres"]["name"][$key];
					$tempext1 = substr(strrchr($nameext,"."),1);
					$tempext = (strlen(substr(strrchr($nameext,"."),1))+1)*(-1);
					$name=substr($nameext,0,$tempext);
					$caracteres = array('À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a','È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e','Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i','Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o','Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u','Œ' => 'oe', 'œ' => 'oe','$' => 's');
 
					$name = strtr($name, $caracteres);
					$name = preg_replace('#[^A-Za-z0-9]+#', '-', $name);
					$name = trim($name, '-');
					$name= $name.'_'.$id_formate.'_'.rand().'.'.$tempext1;
					move_uploaded_file($tmp_name, 'fichiers/'.$id_formate.'/'.$name);
					$ins = $documentm->addDoc($identifiant,$name,'offres');
					
					$listefichiers[] = array('id_document'=>$ins,'id_marche'=>$identifiant,'document'=>$name);
					$tmpo[]=$ins;
					$tmpo2[$ins]=array('id_document'=>$ins,'id_marche'=>$identifiant,'document'=>$name);
					$_POST['hiddenfilesoffres'][]=$ins;
				}
				else
				{
					$erreur['mkdir'] = 'Erreur création du dossier.';
				}
			}
			if($error == UPLOAD_ERR_INI_SIZE)
			{
				$erreur['upload'] = 'Erreur sur upload (taille du fichier ini). Fichier trop lourd.';
			}
			if($error == UPLOAD_ERR_FORM_SIZE)
			{
				$erreur['upload2'] = 'Erreur sur upload (taille du fichier champs max size form). Fichier trop lourd.';
			}
		}
		
		if(count($erreur)==0)
			$msgok='La mise à jour s\'est bien déroulée.';
		else
			$erreur['update']='Erreur sur l\'update';
	}

	require_once('head.php');
	require_once('nav.php');
?>
<section id="content" class="document">
	<h2>Documents finaux</h2>
	<?php if(isset($infoM[0]['titre']) && $infoM[0]['titre']!=''){echo '<h2>'.$infoM[0]['titre'].'</h2>';} ?>

	<div id="tabs">
	  <ul>
		<li><a href="#tab1">Partie commune</a></li>
		<li><a href="#tab2">Pièces finales du marché</a></li>
	  </ul>
	<form action="documents.php?m=<?php echo$identifiant; ?>" method="post" enctype="multipart/form-data">
		
		<fieldset id="tab1">
			<!--legend>Partie commune</legend-->			
			<label for="selectmontant">Montant du marché (HT)</label><input type="text" readonly value="<?php echo $infoM[0]['libelle'] ?>" name="selectmontant"/><br/>
			<label for="date_mel_com">Date de création</label><input id="date_mel_com" type="text" value="<?php if(isset($infoM[0]['date_mel_com']) && $infoM[0]['date_mel_com']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['date_mel_com']); $date_c = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_c; } ?>" name="date_mel_com" readonly /><br/>
			<label for="date_fin_com">Date de fin du marché</label><input id="date_fin_com" type="text" value="<?php if(isset($infoM[0]['date_fin_marche_com']) && $infoM[0]['date_fin_marche_com']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['date_fin_marche_com']); $date_c = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_c; } ?>" name="date_fin_com" readonly /><br/>
			<label for="redac">Rédacteur</label><input type="text" value="<?php if(isset($infoM[0]['redacteur']) && $infoM[0]['redacteur']!=''){echo $infoM[0]['redacteur'];}?>" name="redac" readonly /><br/>
			<label for="type">Type</label><input type="text" readonly value="<?php echo $infoM[0]['type']; ?>" for="type"/><br/>
			<label for="titre">Titre</label><input type="text" value="<?php if(isset($infoM[0]['titre']) && $infoM[0]['titre']!=''){echo $infoM[0]['titre'];} ?>" name="titre" readonly /><br/>
			<label for="pub">Publicité</label><div id="pub"><?php if(isset($infoM[0]['publi']) && $infoM[0]['publi']!=''){echo $infoM[0]['publi'];}?></div><br/>
		</fieldset>
		<fieldset id="tab2">
			<!--legend>Partie comptable</legend-->
			<?php if(isset($erreur) && count($erreur)!=0) { foreach($erreur as $keyerr => $valueerr) { echo '<p class="erreur left">'.$valueerr.'</p><br/>'; }}?>
			<?php if(isset($msgok) && $msgok!='') echo '<p class="msgok left">'.$msgok.'</p><br/>'; ?>			
			<div id="conteneur">
				
				<?php 
					echo '<h3>Docs publies / docs du marché</h3>';
					if(isset($_POST['hiddenfilespublies']) && count($_POST['hiddenfilespublies'])!=0)
					{
						echo '<ul class="liste_res publies clear">';
						foreach($_POST['hiddenfilespublies'] as $keyf => $valuef)
						{
							echo '<li id="ficp_'.$keyf.'"><a href="fichiers/'.$id_formate.'/'.$tmpp2[$valuef]['document'].'"  target="_blank">'.$tmpp2[$valuef]['document'].'</a><span onclick="supprimerfichierp('.$keyf.');" ><img src="img/delete.png" alt="Supprimer" width="24px"/></span><input type="hidden" name="hiddenfilespublies[]" value="'.$valuef.'" /></li>';
							
						}
						echo '</ul>';
					}
					elseif(isset($listefichierspublies) && count($listefichierspublies)!=0)
					{	
						echo '<ul class="liste_res publies clear">';
						foreach($listefichierspublies as $keyf => $valuef)
						{
							echo '<li id="ficp_'.$keyf.'"><a href="fichiers/'.$id_formate.'/'.$valuef['document'].'" target="_blank">'.$valuef['document'].'</a><span onclick="supprimerfichierp('.$keyf.');" ><img src="img/delete.png" alt="Supprimer" width="24px"/></span><input type="hidden" name="hiddenfilespublies[]" value="'.$valuef['id_document'].'" /></li>';
							
						}
						echo '</ul>';
					}
					echo '<h3>Offre</h3>';
					if(isset($_POST['hiddenfilesoffres']) && count($_POST['hiddenfilesoffres'])!=0)
					{
						echo '<ul class="liste_res offres clear">';
						foreach($_POST['hiddenfilesoffres'] as $keyf => $valuef)
						{
							echo '<li id="fico_'.$keyf.'"><a href="fichiers/'.$id_formate.'/'.$tmpo2[$valuef]['document'].'"  target="_blank">'.$tmpo2[$valuef]['document'].'</a><span onclick="supprimerfichieroffres('.$keyf.');" ><img src="img/delete.png" alt="Supprimer" width="24px"/></span><input type="hidden" name="hiddenfilesoffres[]" value="'.$valuef.'" /></li>';
							
						}
						echo '</ul>';
					}
					elseif(isset($listefichiersoffres) && count($listefichiersoffres)!=0)
					{	
						echo '<ul class="liste_res offres clear">';
						foreach($listefichiersoffres as $keyf => $valuef)
						{
							echo '<li id="fico_'.$keyf.'"><a href="fichiers/'.$id_formate.'/'.$valuef['document'].'" target="_blank">'.$valuef['document'].'</a><span onclick="supprimerfichieroffres('.$keyf.');" ><img src="img/delete.png" alt="Supprimer" width="24px"/></span><input type="hidden" name="hiddenfilesoffres[]" value="'.$valuef['id_document'].'" /></li>';
							
						}
						echo '</ul>';
					}
					
						?>
				<label>Documents publiés / documents du marché</label>
				<div id="element1" class="piece"><input type="file" value="" name="piecespublies[]" id="pieces1"  multiple /><br/></div>
				<hr/>
				<label>Offre définitive</label>
				<div id="element2" class="piece"><input type="file" value="" name="piecesoffres[]" id="pieces2"  multiple /><br/></div>
			</div>
			
			<input type="submit" value="Enregistrer" name="partiecomptable"/>
			<br/>
		</fieldset>
	</form>

	</div>
</section>
<script type="text/javascript">

$(document).ready(function() {	
	$( "#tabs" ).tabs({
		active:1
	});
});
</script>
<?php

require_once('footer.php');

?>
