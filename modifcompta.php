<?php 
	session_start();
	$current = 'modifcompta';
	include_once('classes/connect.php');
	include_once('classes/Marche.php');
	include_once('classes/Montant.php');
	include_once('classes/Piece.php');
	include_once('classes/Document.php');
	$identifiant = $_GET['m'];	
	$_SESSION['page']='modifcompta.php?m='.$identifiant;
	if(isset($_COOKIE['login']) && $_COOKIE['login']!='')
	{
		$_SESSION['login'] = $_COOKIE['login'];
		$_SESSION['id'] =$_COOKIE['id'];
	}
	if(!isset($_SESSION['login']) || $_SESSION['login']=='')
	{
		header('Location: connexion.php');
	}
	
	$m = new Montant();
	$marche = new Marche();
	$piecem = new Piece();
	$docm = new Document();
	
	$zip=new ZipArchive();

	$infoM = $marche->getInfosMarche($identifiant);
	$tmp=array();
	$tmp2=array();
	$listefichiers = $piecem->getPiece($identifiant);
	$listedoc = $docm->getDoc($identifiant);

	foreach($listefichiers as $k => $v)
	{
		$idenP=$v['id_piece'];
		$tmp[]=$idenP;
		$tmp2[$idenP]=$v;
	}
	$id_formate=$infoM[0]['id_marche_formate'];
	$erreur=array();
	$erreurmsg='';
	$msgok='';
	$niveaupost=0;
	
	
	if($zip->open('fichiers/archives/documents_'.$id_formate.'.zip',ZipArchive::CREATE)==TRUE)
	{
		if(count($listedoc)!=0)
		{
			foreach($listedoc as $k=>$v)
			{
				$zip->addFile('fichiers/'.$id_formate.'/'.$v['document'],$v['document']);	
			}
		}
		if(count($listefichiers)!=0)
		{
			foreach($listefichiers as $k=>$v)
			{
				$zip->addFile('uploads/'.$id_formate.'/'.$v['piece'],$v['piece']);	
			}
		}
		
		$zip->close();
	}
	else
	{
		$ereurarchive ='Erreur ouverture archive';
	}
	
	
	
	if(isset($_POST['partiecomptable']) && $_POST['partiecomptable']=='Enregistrer' )
	{
		$erreurmsg='';
		$msgok='';
		if(isset($_POST['date_attribution']) && $_POST['date_attribution']!='')	
		{
			$date_attribution_avant=$_POST['date_attribution'];
			$array_majdate = explode('/',$date_attribution_avant); 
			$date_attribution_apres=$array_majdate[2].'-'.$array_majdate[1].'-'.$array_majdate[0]; 
		}
		else
		{
			$date_attribution_avant='';
			$date_attribution_apres='0000-00-00';
			// $date_attribution_apres=NULL;
		}
		if(isset($_POST['date_debut']) && $_POST['date_debut']!='')	
		{
			$date_debut_avant=$_POST['date_debut'];
			$array_majdate = explode('/',$date_debut_avant); 
			$date_debut_apres=$array_majdate[2].'-'.$array_majdate[1].'-'.$array_majdate[0]; 
		}
		else
		{
			$date_debut_apres='0000-00-00';
			// $date_debut_apres=NULL;
		}
		if(isset($_POST['date_fin']) && $_POST['date_fin']!='')	
		{
			$date_fin_avant=$_POST['date_fin'];
			$array_majdate = explode('/',$date_fin_avant); 
			$date_fin_apres=$array_majdate[2].'-'.$array_majdate[1].'-'.$array_majdate[0]; 
		}
		else
		{
			$date_fin_apres='0000-00-00';
			// $date_fin_apres=NULL;
		}
		if(isset($_POST['avenant1']) && $_POST['avenant1']!='')	
		{
			$date_av1=$_POST['avenant1'];
			$array_majdate = explode('/',$date_av1); 
			$date_av1_apres=$array_majdate[2].'-'.$array_majdate[1].'-'.$array_majdate[0]; 
		}
		else
		{
			$date_av1_apres='0000-00-00';
			// $date_av1_apres=NULL;
		}
		if(isset($_POST['avenant2']) && $_POST['avenant2']!='')	
		{
			$date_av2=$_POST['avenant2'];
			$array_majdate = explode('/',$date_av2); 
			$date_av2_apres=$array_majdate[2].'-'.$array_majdate[1].'-'.$array_majdate[0]; 
		}
		else
		{
			$date_av2_apres='0000-00-00';
			// $date_av2_apres=NULL;
		}
		if(isset($_POST['avenant3']) && $_POST['avenant3']!='')	
		{
			$date_av3=$_POST['avenant3'];
			$array_majdate = explode('/',$date_av3); 
			$date_av3_apres=$array_majdate[2].'-'.$array_majdate[1].'-'.$array_majdate[0]; 
		}
		else
		{
			$date_av3_apres='0000-00-00';
			// $date_av3_apres=NULL;
		}
		if(isset($_POST['date_reconduction_ferme']) && $_POST['date_reconduction_ferme']!='')	
		{
			$date_reconduction_ferme=$_POST['date_reconduction_ferme'];
			$array_majdate = explode('/',$date_reconduction_ferme); 
			$date_reconduction_ferme_apres=$array_majdate[2].'-'.$array_majdate[1].'-'.$array_majdate[0]; 
		}
		else
		{
			$date_reconduction_ferme_apres='0000-00-00';
			// $date_reconduction_ferme_apres=NULL;
		}
		if(isset($_POST['date_engagement_tc1']) && $_POST['date_engagement_tc1']!='')	
		{
			$date_engagement_tc1=$_POST['date_engagement_tc1'];
			$array_majdate = explode('/',$date_engagement_tc1); 
			$date_engagement_tc1_apres=$array_majdate[2].'-'.$array_majdate[1].'-'.$array_majdate[0]; 
		}
		else
		{
			$date_engagement_tc1_apres='0000-00-00';
			// $date_engagement_tc1_apres=NULL;
		}
		if(isset($_POST['date_engagement_tc2']) && $_POST['date_engagement_tc2']!='')	
		{
			$date_engagement_tc2=$_POST['date_engagement_tc2'];
			$array_majdate = explode('/',$date_engagement_tc2); 
			$date_engagement_tc2_apres=$array_majdate[2].'-'.$array_majdate[1].'-'.$array_majdate[0]; 
		}
		else
		{
			$date_engagement_tc2_apres='0000-00-00';
			// $date_engagement_tc2_apres=NULL;
		}
	
		(isset($_POST['cotraitant_type'])) ? $cotraitant=$_POST['cotraitant_type'] : $cotraitant='';
		
		$up = $marche->upPartieComptable($identifiant,$date_attribution_apres,$_POST['num_comptable'],$date_debut_apres,$date_fin_apres,$date_av1_apres, $date_av2_apres,$date_av3_apres,$_POST['montant_ht_total'],$_POST['montant_ht_non_soumis_total'],$_POST['taux_tva_total'],$_POST['montant_ttc_total'],$_POST['attributaire'],$_POST['code_postal'],$_POST['lieu'],$_POST['montant_ht_attributaire'],$_POST['montant_ht_non_soumis_attributaire'],$_POST['taux_tva_attributaire'],$_POST['montant_ttc_attributaire'],$_POST['sstraitant'],$_POST['montant_ht_sstraitant'],$_POST['montant_ht_non_soumis_sstraitant'],$_POST['taux_tva_sstraitant'],$_POST['montant_ttc_sstraitant'],$cotraitant,$_POST['cotraitant'],$_POST['montant_ht_cotraitant'],$_POST['montant_ht_non_soumis_cotraitant'],$_POST['taux_tva_cotraitant'],$_POST['montant_ttc_cotraitant'],$_POST['infos'],$_POST['certif_admin'],$_POST['tranche_ferme'],$_POST['tranche_conditionnelle1'],$_POST['tranche_conditionnelle2'],$_POST['marche_reconductible'],$date_reconduction_ferme_apres,$date_engagement_tc1_apres,$date_engagement_tc2_apres);
	
	
		if(file_exists("tmp/certif_admn_DV_solde_marche_".$id_formate.".doc"))
		{
			unlink("tmp/certif_admn_DV_solde_marche_".$id_formate.".doc");
		}
		$ddeprix = file_get_contents("modeles/certif_admn_DV_solde_marche.xml");
		$ddeprix = str_replace("@ATTRIBUTAIRE@",$_POST['attributaire'],$ddeprix);
		$ddeprix = str_replace("@TITRE_MARCHE@",$_POST['titre'],$ddeprix);
		$ddeprix = str_replace("@MONTANT_TTC@",$_POST['montant_ttc_total'],$ddeprix);
		$ddeprix = str_replace("@DATE_ATTRIBUTION@",$date_attribution_avant,$ddeprix);
		$ddeprix = str_replace("@DATE_JOUR@",date('d/m/Y'),$ddeprix);
		$newFileHandler = fopen("tmp/certif_admn_DV_solde_marche_".$id_formate.".doc","a");
		fwrite($newFileHandler,$ddeprix);
		fclose($newFileHandler);
		
		$tabhiddenfiles=array();
		if(isset($_POST['hiddenfiles']) && count($_POST['hiddenfiles'])!=0)
		{
			$tabhiddenfiles=$_POST['hiddenfiles'];
		}
		$diff_tab=array_diff($tmp,$tabhiddenfiles);
		if(count($diff_tab)!=0)
		{
			foreach($diff_tab as $cle => $valeur)
			{
				$nomfichier = $tmp2[$valeur]['piece'];
				
				if(unlink('uploads/'.$id_formate.'/'.$nomfichier))
				{
					if ($zip->open('fichiers/archives/documents_'.$id_formate.'.zip') === TRUE) {
						$zip->deleteName($nomfichier);
						$zip->close();
					}
					$del = $piecem->delPiece($valeur);
				}
				else
					$erreur['erreurunlink'] = 'Erreur sur le unlink '.$nomfichier;
			}
		}
		foreach ($_FILES["pieces"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				if(is_dir('uploads/'.$id_formate) || mkdir('uploads/'.$id_formate,0750,false))
				{
					$tmp_name = $_FILES["pieces"]["tmp_name"][$key];
					$nameext = $_FILES["pieces"]["name"][$key];
					$tempext1 = substr(strrchr($nameext,"."),1);
					$tempext = (strlen(substr(strrchr($nameext,"."),1))+1)*(-1);
					$name=substr($nameext,0,$tempext);
					$caracteres = array('À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a','È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e','Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i','Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o','Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u','Œ' => 'oe', 'œ' => 'oe','$' => 's');
 
					$name = strtr($name, $caracteres);
					$name = preg_replace('#[^A-Za-z0-9]+#', '-', $name);
					$name = trim($name, '-');
					$name= $name.'_'.$id_formate.'_'.rand().'.'.$tempext1;
					move_uploaded_file($tmp_name, 'uploads/'.$id_formate.'/'.$name);
					$ins = $piecem->addPiece($identifiant,$name);
					
					$listefichiers[] = array('id_piece'=>$ins,'id_marche'=>$identifiant,'piece'=>$name);
					$tmp[]=$ins;
					$tmp2[$ins]=array('id_piece'=>$ins,'id_marche'=>$identifiant,'piece'=>$name);
					$_POST['hiddenfiles'][]=$ins;
					if ($zip->open('fichiers/archives/documents_'.$id_formate.'.zip') === TRUE) {
						$zip->addFile('uploads/'.$id_formate.'/'.$name,$name);
						$zip->close();
					}
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
		
		if($up && count($erreur)==0)
			$msgok='La mise à jour s\'est bien déroulée.';
		else
			
			$erreur['update']='Erreur sur l\'update';
	}

	require_once('head.php');
	require_once('nav.php');
?>
<section id="content">
	<h2>Suivi comptable</h2>
	<?php if(isset($infoM[0]['titre']) && $infoM[0]['titre']!=''){echo '<h2>'.$infoM[0]['titre'].'</h2>';} ?>
	<p><a href="modeles/modele_tableau_suivi_comptable.xlsx">Télécharger le modèle de tableau pour le suivi comptable (XLS).</a></p>
	<p><a href="<?php echo 'fichiers/archives/documents_'.$id_formate.'.zip'; ?>">Télécharger tous les fichiers du marché.</a></p>
	<br/>

	<div id="tabs">
	  <ul>
		<li><a href="#tab1">Partie commune</a></li>
		<li><a href="#tab2">Partie comptable</a></li>
	  </ul>
	<form action="modifcompta.php?m=<?php echo$identifiant; ?>" method="post" enctype="multipart/form-data">
		
		<fieldset id="tab1">
			<!--legend>Partie commune</legend-->			
			<label for="selectmontant">Montant du marché (HT)</label><input type="text" readonly value="<?php echo $infoM[0]['libelle'] ?>" name="selectmontant"/><br/>
			<label for="date_mel_com">Date de création</label><input id="date_mel_com" type="text" value="<?php if(isset($infoM[0]['date_mel_com']) && $infoM[0]['date_mel_com']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['date_mel_com']); $date_c = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_c; } ?>" name="date_mel_com" readonly /><br/>
			<label for="date_fin_com">Date de fin du marché</label><input id="date_fin_com" type="text" value="<?php if(isset($infoM[0]['date_fin_marche_com']) && $infoM[0]['date_fin_marche_com']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['date_fin_marche_com']); $date_c = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_c; } ?>" name="date_fin_com" readonly /><br/>
			<label for="redac">Rédacteur</label><input type="text" value="<?php if(isset($infoM[0]['redacteur']) && $infoM[0]['redacteur']!=''){echo $infoM[0]['redacteur'];}?>" name="redac" readonly /><br/>
			<label for="type">Type</label><input type="text" readonly value="<?php echo $infoM[0]['type']; ?>" for="type"/><br/>
			<label for="titre">Titre</label><textarea name="titre" readonly><?php if(isset($infoM[0]['titre']) && $infoM[0]['titre']!=''){echo $infoM[0]['titre'];} ?></textarea><br/>
			<label for="pub">Publicité</label><div id="pub"><?php if(isset($infoM[0]['publi']) && $infoM[0]['publi']!=''){echo $infoM[0]['publi'];}?></div><br/>
			<label>Documents finaux</label><div>
			<?php 
				if(count($listedoc)!=0)
				{
					echo '<br/><ul>';
					foreach($listedoc as $k=>$v)
					{
						echo '<li class="'.$v['type'].'"><a href="fichiers/'.$id_formate.'/'.$v['document'].'" target="_blank">'.$v['document'].'</a></li>';
					}
					echo '</ul>';
				}
				else
					echo 'Aucun fichier';
			
			?></div></br>
		</fieldset>
		<fieldset id="tab2">
			<!--legend>Partie comptable</legend-->
			<?php if(isset($erreur) && count($erreur)!=0) { foreach($erreur as $keyerr => $valueerr) { echo '<p class="erreur left">'.$valueerr.'</p><br/>'; }}?>
			<?php if(isset($msgok) && $msgok!='') echo '<p class="msgok left">'.$msgok.'</p><br/>'; ?>
			<label for="date_attribution">Date attribution du marché</label><input type="text" value="<?php if(isset($_POST['date_attribution']) && $_POST['date_attribution']!='') {echo $_POST['date_attribution'];} elseif(isset($infoM[0]['date_attribution']) && $infoM[0]['date_attribution']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['date_attribution']); $date_c = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_c; } ?>" name="date_attribution" id="date_attribution" /><br/>
			<hr/>
			<label for="num_comptable">N° comptable</label><input type="text" value="<?php if(isset($_POST['num_comptable']) && $_POST['num_comptable']!='') {echo $_POST['num_comptable'];}  elseif(isset($infoM[0]['num_comptable'])) {echo $infoM[0]['num_comptable'];} ?>" name="num_comptable"  id="num_comptable" /><br/>
			<hr/>
			<label for="date_debut">Date de début</label><input type="text" value="<?php if(isset($_POST['date_debut']) && $_POST['date_debut']!='') {echo $_POST['date_debut'];} elseif(isset($infoM[0]['date_debut']) && $infoM[0]['date_debut']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['date_debut']); $date_c = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_c; } ?>" name="date_debut" id="date_debut" /><br/>
			<hr/>
			<label for="date_fin">Date de fin</label><input type="text" value="<?php if(isset($_POST['date_fin']) && $_POST['date_fin']!='') {echo $_POST['date_fin'];} elseif(isset($infoM[0]['date_fin']) && $infoM[0]['date_fin']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['date_fin']); $date_c = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_c; } ?>" name="date_fin" id="date_fin" /><br/>
			<hr/>
			<label for="avenant1">Avenant 1</label><input type="text" value="<?php if(isset($_POST['avenant1']) && $_POST['avenant1']!='') {echo $_POST['avenant1'];} elseif(isset($infoM[0]['avenant1']) && $infoM[0]['avenant1']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['avenant1']); $date_a1 = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_a1; } ?>" name="avenant1" id="avenant1" /><br/>
			<hr/>
			<label for="avenant2">Avenant 2</label><input type="text" value="<?php if(isset($_POST['avenant2']) && $_POST['avenant2']!='') {echo $_POST['avenant2'];} elseif(isset($infoM[0]['avenant2']) && $infoM[0]['avenant2']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['avenant2']); $date_a2 = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_a2; } ?>" name="avenant2" id="avenant2" /><br/>
			<hr/>
			<label for="avenant3">Avenant 3</label><input type="text" value="<?php if(isset($_POST['avenant3']) && $_POST['avenant3']!='') {echo $_POST['avenant3'];} elseif(isset($infoM[0]['avenant3']) && $infoM[0]['avenant3']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['avenant3']); $date_a3 = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_a3; } ?>" name="avenant3" id="avenant3" /><br/>
			<hr/>
			<label for="tranche_ferme">Tranche ferme HT</label><input type="text" value="<?php if(isset($_POST['tranche_ferme']) && $_POST['tranche_ferme']!='') {echo $_POST['tranche_ferme'];}  elseif(isset($infoM[0]['tranche_ferme'])) {echo $infoM[0]['tranche_ferme'];} ?>" name="tranche_ferme" id="tranche_ferme" /><span class="unite">€</span><br/>
			<br/>
			<label>Marché reconductible</label><input type="radio" value="O" name="marche_reconductible"  id="marche_reconductible_o"  <?php if(isset($_POST['marche_reconductible']) && $_POST['marche_reconductible']=='O') {echo 'checked="checked"';}  elseif(isset($infoM[0]['marche_reconductible']) && $infoM[0]['marche_reconductible']=='O') {echo 'checked="checked"';} ?>/><label for="marche_reconductible_o">Oui</label><input type="radio" value="N" name="marche_reconductible" id="marche_reconductible_n"  <?php if(isset($_POST['marche_reconductible']) && $_POST['marche_reconductible']=='N') {echo 'checked="checked"';}  elseif(isset($infoM[0]['marche_reconductible']) && $infoM[0]['marche_reconductible']=='N') {echo 'checked="checked"';} elseif(isset($infoM[0]['marche_reconductible']) && $infoM[0]['marche_reconductible']=='') {echo 'checked="checked"';}?>/><label for="marche_reconductible_n">Non</label>
			<br/>
			<label for="date_reconduction_ferme">Date reconduction</label><input type="text" value="<?php if(isset($_POST['date_reconduction_ferme']) && $_POST['date_reconduction_ferme']!='') {echo $_POST['date_reconduction_ferme'];} elseif(isset($infoM[0]['date_reconduction_ferme']) && $infoM[0]['date_reconduction_ferme']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['date_reconduction_ferme']); $date_c = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_c; } ?>" name="date_reconduction_ferme" id="date_reconduction_ferme" /><br/>
			<hr/>
			
			<label for="tranche_conditionnelle1">Tranche conditionnelle 1 HT</label><input type="text" value="<?php if(isset($_POST['tranche_conditionnelle1']) && $_POST['tranche_conditionnelle1']!='') {echo $_POST['tranche_conditionnelle1'];}  elseif(isset($infoM[0]['tranche_conditionnelle1'])) {echo $infoM[0]['tranche_conditionnelle1'];} ?>" name="tranche_conditionnelle1" id="tranche_conditionnelle1" /><span class="unite">€</span><br/>
			<label for="date_engagement_tc1">Date engagement avant le</label><input type="text" value="<?php if(isset($_POST['date_engagement_tc1']) && $_POST['date_engagement_tc1']!='') {echo $_POST['date_engagement_tc1'];} elseif(isset($infoM[0]['date_engagement_tc1']) && $infoM[0]['date_engagement_tc1']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['date_engagement_tc1']); $date_c = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_c; } ?>" name="date_engagement_tc1" id="date_engagement_tc1" /><br/>
			<hr/>
			<label for="tranche_conditionnelle2">Tranche conditionnelle 2 HT</label><input type="text" value="<?php if(isset($_POST['tranche_conditionnelle2']) && $_POST['tranche_conditionnelle2']!='') {echo $_POST['tranche_conditionnelle2'];}  elseif(isset($infoM[0]['tranche_conditionnelle2'])) {echo $infoM[0]['tranche_conditionnelle2'];} ?>" name="tranche_conditionnelle2" id="tranche_conditionnelle2" /><span class="unite">€</span><br/>
			<label for="date_engagement_tc2">Date engagement avant le</label><input type="text" value="<?php if(isset($_POST['date_engagement_tc2']) && $_POST['date_engagement_tc2']!='') {echo $_POST['date_engagement_tc2'];} elseif(isset($infoM[0]['date_engagement_tc2']) && $infoM[0]['date_engagement_tc2']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['date_engagement_tc2']); $date_c = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_c; } ?>" name="date_engagement_tc2" id="date_engagement_tc2" /><br/>
			<hr/>
			<label for="montant_ht">Montant HT total</label><input type="text" value="<?php if(isset($_POST['montant_ht_total']) && $_POST['montant_ht_total']!='') {echo $_POST['montant_ht_total'];}  elseif(isset($infoM[0]['montant_ht_total'])) {echo $infoM[0]['montant_ht_total'];} ?>" name="montant_ht_total" id="montant_ht_total" /><span class="unite">€</span><br/>
			<hr/>
			<label for="montant_ht_non_soumis_total">Montant HT total non soumis</label><input type="text" value="<?php if(isset($_POST['montant_ht_non_soumis_total']) && $_POST['montant_ht_non_soumis_total']!='') {echo $_POST['montant_ht_non_soumis_total'];}  elseif(isset($infoM[0]['montant_ht_non_soumis_total'])) {echo $infoM[0]['montant_ht_non_soumis_total'];} ?>" name="montant_ht_non_soumis_total" id="montant_ht_non_soumis_total" /><span class="unite">€</span><br/>
			<hr/>
			<label for="taux_tva_total">Taux TVA</label><input type="text" value="<?php if(isset($_POST['taux_tva_total']) && $_POST['taux_tva_total']!='') {echo $_POST['taux_tva_total'];}  elseif(isset($infoM[0]['taux_tva_total'])) {echo $infoM[0]['taux_tva_total'];} ?>" name="taux_tva_total" id="taux_tva_total" /><span class="unite">%</span><br/>
			<hr/>
			<label for="montant_ttc_total">Montant TTC total</label><input type="text" value="<?php if(isset($_POST['montant_ttc_total']) && $_POST['montant_ttc_total']!='') {echo $_POST['montant_ttc_total'];}  elseif(isset($infoM[0]['montant_ttc_total'])) {echo $infoM[0]['montant_ttc_total'];} ?>" name="montant_ttc_total" id="montant_ttc_total" /><span class="unite">€</span><br/>
			<hr/>
			<label for="attributaire">Attributaire</label><input type="text" value="<?php if(isset($_POST['attributaire']) && $_POST['attributaire']!='') {echo $_POST['attributaire'];}  elseif(isset($infoM[0]['attributaire'])) { echo $infoM[0]['attributaire']; } ?>" name="attributaire" id="attributaire" /><br/>
			<label for="code_postal">CP</label><input type="text" value="<?php if(isset($_POST['code_postal']) && $_POST['code_postal']!='') {echo $_POST['code_postal'];}  elseif(isset($infoM[0]['code_postal'])) { echo $infoM[0]['code_postal']; }?>" name="code_postal" id="code_postal" /><br/>
			<label for="lieu">Lieu</label><input type="text" value="<?php if(isset($_POST['lieu']) && $_POST['lieu']!='') {echo $_POST['lieu'];}  elseif(isset($infoM[0]['lieu'])) { echo $infoM[0]['lieu']; } ?>" name="lieu" id="lieu" /><br/>
			<label for="montant_ht_attributaire">Montant HT attributaire</label><input type="text" value="<?php if(isset($_POST['montant_ht_attributaire']) && $_POST['montant_ht_attributaire']!='') {echo $_POST['montant_ht_attributaire'];}  elseif(isset($infoM[0]['montant_ht_attributaire'])) {echo $infoM[0]['montant_ht_attributaire'];} ?>" name="montant_ht_attributaire" id="montant_ht_attributaire" /><span class="unite">€</span><br/>
			<label for="montant_ht_non_soumis_attributaire">Montant HT non soumis attributaire</label><input type="text" value="<?php if(isset($_POST['montant_ht_non_soumis_attributaire']) && $_POST['montant_ht_non_soumis_attributaire']!='') {echo $_POST['montant_ht_non_soumis_attributaire'];}  elseif(isset($infoM[0]['montant_ht_non_soumis_attributaire'])) {echo $infoM[0]['montant_ht_non_soumis_attributaire'];} ?>" name="montant_ht_non_soumis_attributaire" id="montant_ht_non_soumis_attributaire" /><span class="unite">€</span><br/>
			<label for="taux_tva_attributaire">Taux TVA attributaire</label><input type="text" value="<?php if(isset($_POST['taux_tva_attributaire']) && $_POST['taux_tva_attributaire']!='') {echo $_POST['taux_tva_attributaire'];}  elseif(isset($infoM[0]['taux_tva_attributaire'])) {echo $infoM[0]['taux_tva_attributaire'];} ?>" name="taux_tva_attributaire" id="taux_tva_attributaire" /><span class="unite">%</span><br/>
			<label for="montant_ttc_attributaire">Montant TTC attributaire</label><input type="text" value="<?php if(isset($_POST['montant_ttc_attributaire']) && $_POST['montant_ttc_attributaire']!='') {echo $_POST['montant_ttc_attributaire'];}  elseif(isset($infoM[0]['montant_ttc_attributaire'])) {echo $infoM[0]['montant_ttc_attributaire'];} ?>" name="montant_ttc_attributaire" id="montant_ttc_attributaire" /><span class="unite">€</span><br/>
			<hr/>
			<label>Type de cotraitant</label><input type="radio" value="solidaire" name="cotraitant_type" id="solidaire" <?php if(isset($_POST['cotraitant_type']) && $_POST['cotraitant_type']=='solidaire') {echo 'checked="checked"';}  elseif(isset($infoM[0]['cotraitant_type']) && $infoM[0]['cotraitant_type']=='solidaire') {echo 'checked="checked"';} ?>/><label for="solidaire">Solidaire</label><input type="radio" value="conjoint" name="cotraitant_type" id="conjoint" <?php if(isset($_POST['cotraitant_type']) && $_POST['cotraitant_type']=='conjoint') {echo 'checked="checked"';}  elseif(isset($infoM[0]['cotraitant_type']) && $infoM[0]['cotraitant_type']=='conjoint') {echo 'checked="checked"';} ?>/><label for="conjoint">Conjoint</label><input type="radio" value="solidaire_conjoint" name="cotraitant_type" id="deux" <?php if(isset($_POST['cotraitant_type']) && $_POST['cotraitant_type']=='solidaire_conjoint') {echo 'checked="checked"';}  elseif(isset($infoM[0]['cotraitant_type']) && $infoM[0]['cotraitant_type']=='solidaire_conjoint') {echo 'checked="checked"';} ?>/><label for="deux">Les deux</label><br/>
			<label for="cotraitant">Co-traitant</label><input type="text" value="<?php if(isset($_POST['cotraitant']) && $_POST['cotraitant']!='') {echo $_POST['cotraitant'];}  elseif(isset($infoM[0]['cotraitant'])) { echo $infoM[0]['cotraitant']; } ?>" name="cotraitant" id="cotraitant" /><br/>
			
			<div id="divcotraitant" <?php if(isset($_POST['cotraitant']) && $_POST['cotraitant']!='') {echo 'style="display:block;"';} elseif(isset($infoM[0]['cotraitant']) && $infoM[0]['cotraitant']!=''){echo 'style="display:block;"';}else{echo 'style="display:none;"';} ?> ><!-- cotraitant -->
				
				<label for="montant_ht_cotraitant">Montant HT co-traitant</label><input type="text" value="<?php if(isset($_POST['montant_ht_cotraitant']) && $_POST['montant_ht_cotraitant']!='') {echo $_POST['montant_ht_cotraitant'];}  elseif(isset($infoM[0]['montant_ht_cotraitant'])) {echo $infoM[0]['montant_ht_cotraitant'];} ?>" name="montant_ht_cotraitant" id="montant_ht_cotraitant" /><span class="unite">€</span><br/>
				<label for="montant_ht_non_soumis_cotraitant">Montant HT non soumis co-traitant</label><input type="text" value="<?php if(isset($_POST['montant_ht_non_soumis_cotraitant']) && $_POST['montant_ht_non_soumis_cotraitant']!='') {echo $_POST['montant_ht_non_soumis_cotraitant'];}  elseif(isset($infoM[0]['montant_ht_non_soumis_cotraitant'])) {echo $infoM[0]['montant_ht_non_soumis_cotraitant'];} ?>" name="montant_ht_non_soumis_cotraitant" id="montant_ht_non_soumis_cotraitant" /><span class="unite">€</span><br/>
				<label for="taux_tva_cotraitant">Taux TVA co-traitant</label><input type="text" value="<?php if(isset($_POST['taux_tva_cotraitant']) && $_POST['taux_tva_cotraitant']!='') {echo $_POST['taux_tva_cotraitant'];}  elseif(isset($infoM[0]['taux_tva_cotraitant'])) {echo $infoM[0]['taux_tva_cotraitant'];} ?>" name="taux_tva_cotraitant" id="taux_tva_cotraitant" /><span class="unite">%</span><br/>
				<label for="montant_ttc_cotraitant">Montant TTC co-traitant</label><input type="text" value="<?php if(isset($_POST['montant_ttc_cotraitant']) && $_POST['montant_ttc_cotraitant']!='') {echo $_POST['montant_ttc_cotraitant'];}  elseif(isset($infoM[0]['montant_ttc_cotraitant'])) {echo $infoM[0]['montant_ttc_cotraitant'];} ?>" name="montant_ttc_cotraitant" id="montant_ttc_cotraitant" /><span class="unite">€</span><br/>
			</div>
			<hr/>
			<label for="sstraitant">Sous-traitant</label><input type="text" value="<?php if(isset($_POST['sstraitant']) && $_POST['sstraitant']!='') {echo $_POST['sstraitant'];}  elseif(isset($infoM[0]['sstraitant'])) { echo $infoM[0]['sstraitant']; } ?>" name="sstraitant" id="sstraitant" /><br/>
			<div id="divsstraitant" <?php if(isset($_POST['sstraitant']) && $_POST['sstraitant']!='') {echo 'style="display:block;"';} elseif(isset($infoM[0]['sstraitant']) && $infoM[0]['sstraitant']!=''){echo 'style="display:block;"';}else{echo 'style="display:none;"';} ?> ><!-- soustraitant -->
				<label for="montant_ht_sstraitant">Montant HT sous-traitant</label><input type="text" value="<?php if(isset($_POST['montant_ht_sstraitant']) && $_POST['montant_ht_sstraitant']!='') {echo $_POST['montant_ht_sstraitant'];}  elseif(isset($infoM[0]['montant_ht_sstraitant'])) {echo $infoM[0]['montant_ht_sstraitant'];} ?>" name="montant_ht_sstraitant" id="montant_ht_sstraitant" /><span class="unite">€</span><br/><br/>
				<label for="montant_ht_non_soumis_sstraitant">Montant HT non soumis sous-traitant</label><input type="text" value="<?php if(isset($_POST['montant_ht_non_soumis_sstraitant']) && $_POST['montant_ht_non_soumis_sstraitant']!='') {echo $_POST['montant_ht_non_soumis_sstraitant'];}  elseif(isset($infoM[0]['montant_ht_non_soumis_sstraitant'])) {echo $infoM[0]['montant_ht_non_soumis_sstraitant'];} ?>" name="montant_ht_non_soumis_sstraitant" id="montant_ht_non_soumis_sstraitant" /><span class="unite">€</span><br/><br/>
				<label for="taux_tva_sstraitant">Taux TVA sous-traitant</label><input type="text" value="<?php if(isset($_POST['taux_tva_sstraitant']) && $_POST['taux_tva_sstraitant']!='') {echo $_POST['taux_tva_sstraitant'];}  elseif(isset($infoM[0]['taux_tva_sstraitant'])) {echo $infoM[0]['taux_tva_sstraitant'];} ?>" name="taux_tva_sstraitant" id="taux_tva_sstraitant" /><span class="unite">%</span><br/><br/>
				<label for="montant_ttc_sstraitant">Montant TTC sous-traitant</label><input type="text" value="<?php if(isset($_POST['montant_ttc_sstraitant']) && $_POST['montant_ttc_sstraitant']!='') {echo $_POST['montant_ttc_sstraitant'];}  elseif(isset($infoM[0]['montant_ttc_sstraitant'])) {echo $infoM[0]['montant_ttc_sstraitant'];} ?>" name="montant_ttc_sstraitant" id="montant_ttc_sstraitant" /><span class="unite">€</span><br/><br/>
			</div>
			<hr/>
			<div id="conteneur">
				<label>Pièces du marché</label>
				<?php 
					if(isset($_POST['hiddenfiles']) && count($_POST['hiddenfiles'])!=0)
					{
						echo '<ul class="liste_res clear">';
						foreach($_POST['hiddenfiles'] as $keyf => $valuef)
						{
							echo '<li id="fic_'.$keyf.'"><a href="uploads/'.$id_formate.'/'.$tmp2[$valuef]['piece'].'"  target="_blank">'.$tmp2[$valuef]['piece'].'</a><span onclick="supprimerfichier('.$keyf.');" ><img src="img/delete.png" alt="Supprimer" width="24px"/></span><input type="hidden" name="hiddenfiles[]" value="'.$valuef.'" /></li>';
							
						}
						echo '</ul>';
					}
					elseif(isset($listefichiers) && count($listefichiers)!=0)
					{	
						echo '<ul class="liste_res clear">';
						foreach($listefichiers as $keyf => $valuef)
						{
							echo '<li id="fic_'.$keyf.'"><a href="uploads/'.$id_formate.'/'.$valuef['piece'].'" target="_blank">'.$valuef['piece'].'</a><span onclick="supprimerfichier('.$keyf.');" ><img src="img/delete.png" alt="Supprimer" width="24px"/></span><input type="hidden" name="hiddenfiles[]" value="'.$valuef['id_piece'].'" /></li>';
							
						}
						echo '</ul>';
					}
						?>
				<div id="element1" class="piece"><input type="file" value="" name="pieces[]" id="pieces1" multiple /><br/></div>
			</div>
			<!--input type="hidden" id="nbfichiers" name="nbfichiers" value="1" />
			<input type="button" value="Ajouter un fichier" onclick="javascript:ajouterElement();" /--><br/>
			<hr/>
			<label for="infos">Informations complémentaires</label><textarea name="infos"><?php if(isset($_POST['infos']) && $_POST['infos']!='') {echo $_POST['infos'];}  elseif(isset($infoM[0]['infos'])) {echo $infoM[0]['infos'];}?></textarea><br/>
			<hr/>
			<label for="certif_admin">Certificat administratif</label><input type="radio" value="1" name="certif_admin" id="certif_admin_o" <?php if(isset($_POST['certif_admin']) && $_POST['certif_admin']==1) {echo 'checked="checked"';}  elseif($infoM[0]['certif_adm']==1 && !isset($_POST['certif_admin'])) {echo 'checked="checked"';} ?>  /><label for="certif_admin_o">Oui</label><input type="radio" value="0" name="certif_admin" id="certif_admin_n" <?php if(isset($_POST['certif_admin']) && $_POST['certif_admin']==0) {echo 'checked="checked"';}  elseif($infoM[0]['certif_adm']==0 && !isset($_POST['certif_admin'])){echo 'checked="checked"';} ?> /><label for="certif_admin_n">Non</label><br/>
			<input type="submit" value="Enregistrer" name="partiecomptable"/>
			<br/>
		</fieldset>
	</form>
	<?php
		if((isset($_POST['certif_admin']) && $_POST['certif_admin']==1)||$infoM[0]['certif_adm']==1)
		{
			echo '<p class="resultat"><a href="tmp/certif_admn_DV_solde_marche_'.$id_formate.'.doc">Certificat administratif</a></p>';
		}
	?>
	</div>
</section>
<script type="text/javascript">

$(document).ready(function() {	
	$("#date_attribution,#date_debut,#date_fin,#avenant1,#avenant2,#avenant3,#date_reconduction_ferme,#date_engagement_tc1,#date_engagement_tc2").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true
	});$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
	$("#date_attribution").bind('change',function(){
		$("#date_debut").attr('value',$("#date_attribution").val());
	});
	$( "#tabs" ).tabs({
		active:1
	});
	$("#cotraitant").bind('change',function(){
		if($("#cotraitant").val()!='')
		{
			$("#divcotraitant").css('display','block');
		}
		else{
			$("#divcotraitant").css('display','none');
		}
	});
	$("#sstraitant").bind('change',function(){
		if($("#sstraitant").val()!='')
		{
			$("#divsstraitant").css('display','block');
		}
		else{
			$("#divcsstraitant").css('display','none');
		}
	});
	$("#montant_ht_total,#montant_ht_non_soumis_total,#taux_tva_total").bind('change',function(){
		var mont_ht = $("#montant_ht_total").val();
		var mont_ht_non=0;
		if($("#montant_ht_non_soumis_total").val()!='')
		{
			mont_ht_non=$("#montant_ht_non_soumis_total").val();
		}
		var tva = ($("#taux_tva_total").val()/100)+1;
		var mont_ttc = mont_ht*tva + parseFloat(mont_ht_non);
		$("#montant_ttc_total").attr('value',mont_ttc.toFixed(2));
	});
	$("#montant_ht_attributaire,#montant_ht_non_soumis_attributaire,#taux_tva_attributaire").bind('change',function(){
		var mont_ht_attributaire = $("#montant_ht_attributaire").val();
		var mont_ht_non_attributaire=0;
		if($("#montant_ht_non_soumis_attributaire").val()!='')
		{
			mont_ht_non_attributaire=$("#montant_ht_non_soumis_attributaire").val();
		}
		var tva_attributaire = ($("#taux_tva_attributaire").val()/100)+1;
		var mont_ttc_attributaire = mont_ht_attributaire*tva_attributaire + parseFloat(mont_ht_non_attributaire);
		$("#montant_ttc_attributaire").attr('value',mont_ttc_attributaire.toFixed(2));
	});
	$("#montant_ht_cotraitant,#montant_ht_non_soumis_cotraitant,#taux_tva_cotraitant").bind('change',function(){
		var mont_ht_cotraitant = $("#montant_ht_cotraitant").val();
		var mont_ht_non_cotraitant=0;
		if($("#montant_ht_non_soumis_cotraitant").val()!='')
		{
			mont_ht_non_cotraitant=$("#montant_ht_non_soumis_cotraitant").val();
		}
		var tva_cotraitant = ($("#taux_tva_cotraitant").val()/100)+1;
		var mont_ttc_cotraitant = mont_ht_cotraitant*tva_cotraitant + parseFloat(mont_ht_non_cotraitant);
		$("#montant_ttc_cotraitant").attr('value',mont_ttc_cotraitant.toFixed(2));
	});
	$("#montant_ht_sstraitant,#montant_ht_non_soumis_sstraitant,#taux_tva_sstraitant").bind('change',function(){
		var mont_ht_sstraitant = $("#montant_ht_sstraitant").val();
		var mont_ht_non_sstraitant=0;
		if($("#montant_ht_non_soumis_sstraitant").val()!='')
		{
			mont_ht_non_sstraitant=$("#montant_ht_non_soumis_sstraitant").val();
		}
		var tva_sstraitant = ($("#taux_tva_sstraitant").val()/100)+1;
		var mont_ttc_sstraitant = mont_ht_sstraitant*tva_sstraitant + parseFloat(mont_ht_non_sstraitant);
		$("#montant_ttc_sstraitant").attr('value',mont_ttc_sstraitant.toFixed(2));
	});

});
</script>
<?php

require_once('footer.php');

?>
