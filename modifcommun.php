<?php 
	session_start();
	$current = 'modifcommun';
	include_once('classes/connect.php');
	include_once('classes/Montant.php');
	include_once('classes/Marche.php');
	
	$m = new Montant();
	$marche = new Marche();
	$identifiant = $_GET['m'];
	$listemontant = $m->getInfos('all');
	$infoM = $marche->getInfosMarche($identifiant);
	$id_formate=$infoM[0]['id_marche_formate'];
	$erreur=array();
	$erreurmsg='';
	$msgok='';
	$niveaupost=0;
	if(isset($_POST['partiecom']) && $_POST['partiecom']=='Modifier' )
	{
		$erreur=array();
		if($_POST['selectmontant']=='') 
		{
			$erreur['selectmontant']='erreur';
		}
		if($_POST['date_mel_com']=='')
		{
			$erreur['date_mel_com']='erreur';
		}
		if($_POST['redac']=='')
		{
			$erreur['redac']='erreur';
		}
		if($_POST['type']=='')
		{
			$erreur['type']='erreur';
		}
		if($_POST['titre']=='')
		{
			$erreur['titre']='erreur';
		}
		if(count($erreur)!=0)
		{
			$erreurmsg='Il y a '.count($erreur).' erreur(s). Merci de vérifier les données rentrées.';
		}
		else
		{	
			$dateavant=$_POST['date_mel_com'];
			$array_majdate = explode('/',$dateavant); 
			$datetranformee=$array_majdate[2].'-'.$array_majdate[1].'-'.$array_majdate[0]; 
			
			$niveaupost=$_POST['selectmontant'];
			$up = $marche->upPartieCom($identifiant,$_POST['selectmontant'],$datetranformee,$_POST['redac'],$_POST['type'],$_POST['titre'],$_POST['publicite']);
			
			if(file_exists("tmp/modele_de_lettre_de_consultation_".$id_formate.".doc"))
			{
				unlink("tmp/modele_de_lettre_de_consultation_".$id_formate.".doc");
			}
			if(file_exists("tmp/doc_descriptif_consultation_".$id_formate.".doc"))
			{
				unlink("tmp/doc_descriptif_consultation_".$id_formate.".doc");
			}
			if(file_exists("tmp/ccap_".$id_formate.".doc"))
			{
				unlink("tmp/ccap_".$id_formate.".doc");
			}
			if(file_exists("tmp/cctp_".$id_formate.".doc"))
			{
				unlink("tmp/cctp_".$id_formate.".doc");
			}
			if(file_exists("tmp/ae_".$id_formate.".doc"))
			{
				unlink("tmp/ae_".$id_formate.".doc");
			}
			
			if(file_exists("tmp/modele_lettre_candidat_retenu_dessous_25000_HT_".$id_formate.".doc"))
			{
				unlink("tmp/modele_lettre_candidat_retenu_dessous_25000_HT_".$id_formate.".doc");
			}
			if(file_exists("tmp/modele_lettre_candidat_retenu_dessus_25000_HT_".$id_formate.".doc"))
			{
				unlink("tmp/modele_lettre_candidat_retenu_dessus_25000_HT_".$id_formate.".doc");
			}
			if(file_exists("tmp/modele_lettre_mail_negociation_dessus_25000_".$id_formate.".doc"))
			{
				unlink("tmp/modele_lettre_mail_negociation_dessus_25000_".$id_formate.".doc");
			}
			if(file_exists("tmp/modele_lettre_mail_negociation_dessous_25000_".$id_formate.".doc"))
			{
				unlink("tmp/modele_lettre_mail_negociation_dessous_25000_".$id_formate.".doc");
			}
			if(file_exists("tmp/modele_rapport_analyse_consultation_dessus_25000_".$id_formate.".doc"))
			{
				unlink("tmp/modele_rapport_analyse_consultation_dessus_25000_".$id_formate.".doc");
			}
			if(file_exists("tmp/modele_rapport_analyse_consultation_dessous_25000_".$id_formate.".doc"))
			{
				unlink("tmp/modele_rapport_analyse_consultation_dessous_25000_".$id_formate.".doc");
			}
			if(file_exists("tmp/modele_lettre_candidat_non_retenu_dessous_25000_HT_".$id_formate.".doc"))
			{
				unlink("tmp/modele_lettre_candidat_non_retenu_dessous_25000_HT_".$id_formate.".doc");
			}
			if(file_exists("tmp/modele_lettre_candidat_non_retenu_dessus_25000_HT_".$id_formate.".doc"))
			{
				unlink("tmp/modele_lettre_candidat_non_retenu_dessus_25000_HT_".$id_formate.".doc");
			}
			if(file_exists("tmp/mdl_lettre_mail_suite_a_ddes_infos_complementaires_candidats_non_retenus_".$id_formate.".doc"))
			{
				unlink("tmp/mdl_lettre_mail_suite_a_ddes_infos_complementaires_candidats_non_retenus_".$id_formate.".doc");
			}
			switch($_POST['selectmontant'])
			{
				case 1:		
				case 2:	/*$doc_desc = file_get_contents("modeles/doc_consultation.xml");
						$doc_desc = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$doc_desc);
						$newFileHandler = fopen("tmp/doc_descriptif_consultation_".$id_formate.".doc","a");
						fwrite($newFileHandler,$doc_desc);
						fclose($newFileHandler);
						
						$lettrecandidatretenu = file_get_contents("modeles/modele_lettre_candidat_retenu_dessous_25000_HT.xml");
						$lettrecandidatretenu = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$lettrecandidatretenu);
						$newFileHandler = fopen("tmp/modele_lettre_candidat_retenu_dessous_25000_HT_".$id_formate.".doc","a");
						fwrite($newFileHandler,$lettrecandidatretenu);
						fclose($newFileHandler);
						$cctp = file_get_contents("modeles/cctp.xml");
						$cctp = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$cctp);
						$newFileHandler = fopen("tmp/cctp_".$id_formate.".doc","a");
						fwrite($newFileHandler,$cctp);
						fclose($newFileHandler);
						$lettrenego = file_get_contents("modeles/modele_lettre_mail_negociation_dessous_25000.xml");
						$newFileHandler = fopen("tmp/modele_lettre_mail_negociation_dessous_25000_".$id_formate.".doc","a");
						fwrite($newFileHandler,$lettrenego);
						fclose($newFileHandler);
						
						$analyse = file_get_contents("modeles/modele_rapport_analyse_consultation_dessous_25000.xml");
						$analyse = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$analyse);
						$analyse = str_replace("@PUB_MARCHE@",$_POST['publicite'],$analyse);
						$newFileHandler = fopen("tmp/modele_rapport_analyse_consultation_dessous_25000_".$id_formate.".doc","a");
						fwrite($newFileHandler,$analyse);
						fclose($newFileHandler);
						$lettrecandidatnonretenu = file_get_contents("modeles/modele_lettre_candidat_non_retenu_dessous_25000_HT.xml");
						$lettrecandidatnonretenu = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$lettrecandidatnonretenu);
						$newFileHandler = fopen("tmp/modele_lettre_candidat_non_retenu_dessous_25000_HT_".$id_formate.".doc","a");
						fwrite($newFileHandler,$lettrecandidatnonretenu);
						fclose($newFileHandler);
						
						break;*/
				case 3:
				case 4:	$ccap = file_get_contents("modeles/ccap.xml");
						$ccap = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$ccap);
						$ccap = str_replace("@DATE_MARCHE@",$dateavant,$ccap);
						$ccap = str_replace("@TYPE_MARCHE@",$_POST['type'],$ccap);
						$newFileHandler = fopen("tmp/ccap_".$id_formate.".doc","a");
						fwrite($newFileHandler,$ccap);
						fclose($newFileHandler);
						/*$cctp = file_get_contents("modeles/cctp.xml");
						$cctp = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$cctp);
						$cctp = str_replace("@DATE_MARCHE@",$dateavant,$cctp);;
						$newFileHandler = fopen("tmp/cctp_".$id_formate.".doc","a");
						fwrite($newFileHandler,$cctp);
						fclose($newFileHandler);
						$ae = file_get_contents("modeles/ae.xml");
						$ae = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$ae);
						$ae = str_replace("@REDACTEUR_MARCHE@",$_POST['redac'],$ae);
						$newFileHandler = fopen("tmp/ae_".$id_formate.".doc","a");
						fwrite($newFileHandler,$ae);
						fclose($newFileHandler);
						$lettrecandidatretenu = file_get_contents("modeles/modele_lettre_candidat_retenu_dessus_25000_HT.xml");
						$lettrecandidatretenu = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$lettrecandidatretenu);
						$newFileHandler = fopen("tmp/modele_lettre_candidat_retenu_dessus_25000_HT_".$id_formate.".doc","a");
						fwrite($newFileHandler,$lettrecandidatretenu);
						fclose($newFileHandler);
						$lettrenego = file_get_contents("modeles/modele_lettre_mail_negociation_dessus_25000.xml");
						$newFileHandler = fopen("tmp/modele_lettre_mail_negociation_dessus_25000_".$id_formate.".doc","a");
						fwrite($newFileHandler,$lettrenego);
						fclose($newFileHandler);
						$analyse = file_get_contents("modeles/modele_rapport_analyse_consultation_dessus_25000.xml");
						$analyse = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$analyse);
						$analyse = str_replace("@PUB_MARCHE@",$_POST['publicite'],$analyse);
						$newFileHandler = fopen("tmp/modele_rapport_analyse_consultation_dessus_25000_".$id_formate.".doc","a");
						fwrite($newFileHandler,$analyse);
						fclose($newFileHandler);
						$lettrecandidatnonretenu = file_get_contents("modeles/modele_lettre_candidat_non_retenu_dessus_25000_HT.xml");
						$lettrecandidatnonretenu = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$lettrecandidatnonretenu);
						$newFileHandler = fopen("tmp/modele_lettre_candidat_non_retenu_dessus_25000_HT_".$id_formate.".doc","a");
						fwrite($newFileHandler,$lettrecandidatnonretenu);
						fclose($newFileHandler);*/
						break;
				default:;
				
			}
			/*$infoscompl = file_get_contents("modeles/mdl_lettre_mail_suite_a_ddes_infos_complementaires_candidats_non_retenus.xml");
			$infoscompl = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$infoscompl);
			$newFileHandler = fopen("tmp/mdl_lettre_mail_suite_a_ddes_infos_complementaires_candidats_non_retenus_".$id_formate.".doc","a");
			fwrite($newFileHandler,$infoscompl);
			fclose($newFileHandler);*/
			
			
			$msgok='La mise à jour s\'est bien déroulée.';
		}
		
	}
	require_once('head.php');
	require_once('nav.php');
?>
<section id="content">
	<h2>Formulaires à compléter</h2>
	
	<form action="" method="post">
		<fieldset>
			
			<p class="indication">Les champs suivis de * sont obligatoires.</p>
			<?php if(isset($erreurmsg) && $erreurmsg!='') echo '<p class="erreur">'.$erreurmsg.'</p>'; ?>
			<?php if(isset($msgok) && $msgok!='') echo '<p class="msgok left">'.$msgok.'</p><br/>'; ?>
			<label for="selectmontant">Montant du marché (HT)<span class="obligatoire">*</span></label>
			<select name="selectmontant" id="selectmontant">
				<option value="" <?php if(isset($_POST['selectmontant']) && $_POST['selectmontant']=='') {echo 'selected="selected"';} ?>>-- Choisir --</option>
				<?php
					foreach($listemontant as $clem => $valeurm)
					{
						$selected='';
						if(isset($_POST['selectmontant']) && $_POST['selectmontant']==$valeurm['id_montant']) {$selected='selected="selected"';} elseif(!isset($_POST['selectmontant']) && isset($infoM[0]['id_montant']) && $infoM[0]['id_montant']==$valeurm['id_montant']) {$selected='selected="selected"';}
						echo '<option value="'.$valeurm['id_montant'].'" '.$selected.'>'.$valeurm['libelle'].'</option>';
						
					}
				?>
			</select><?php if(isset($erreur['selectmontant'])) echo '<p class="erreur">'.$erreur['selectmontant'].'</p>';?><br/>
			<label>Publicité</label>
			<?php
				$hidden=strip_tags($infoM[0]['publicite']);
				foreach($listemontant as $clem => $valeurm)
				{
					
					if(isset($_POST['selectmontant']) && $_POST['selectmontant']==$valeurm['id_montant']) {$selected='class="select"'; $hidden=$valeurm['publi'];} elseif(!isset($_POST['selectmontant']) && isset($infoM[0]['id_montant']) && $infoM[0]['id_montant']==$valeurm['id_montant']) {$selected='class="select"'; $hidden=$valeurm['publi'];} else {$selected='class="none"'; }
					echo '<div '.$selected.' id="pub'.$valeurm['id_montant'].'">'.$valeurm['publi'].'</div>';
					
				}
				echo'<input type="hidden" value="'.strip_tags($hidden).'" name="publicite" id="publicite" />';
			?><br/>
			<label for="date_mel_com">Date de création<span class="obligatoire">*</span></label><input id="date_mel_com" type="text" value="<?php if(isset($_POST['date_mel_com']) && $_POST['date_mel_com']!='') {echo $_POST['date_mel_com'];} elseif(isset($infoM[0]['date_mel_com']) && $infoM[0]['date_mel_com']!='0000-00-00'){$tab_majdate = explode('-',$infoM[0]['date_mel_com']); $date_c = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0]; echo $date_c; } ?>" name="date_mel_com" /><?php if(isset($erreur['date_mel_com'])) echo '<p class="erreur">'.$erreur['date_mel_com'].'</p>';?><br/>
			<label for="redac">Rédacteur<span class="obligatoire">*</span></label><input type="text" value="<?php if(isset($_POST['redac']) && $_POST['redac']!='') {echo $_POST['redac'];}  elseif(isset($infoM[0]['redacteur']) && $infoM[0]['redacteur']!=''){echo $infoM[0]['redacteur'];}?>" name="redac" id="redac" /><?php if(isset($erreur['redac'])) echo '<p class="erreur">'.$erreur['redac'].'</p>';?><br/>
			<label for="type">Type<span class="obligatoire">*</span></label>
			<select name="type" id="type">
				<option value="" <?php if(isset($_POST['type']) && $_POST['type']=='') {echo 'selected="selected"';} ?> >-- Choisir --</option>
				<option value="fournitures" <?php if(isset($_POST['type']) && $_POST['type']=='fournitures') {echo 'selected="selected"';} elseif(isset($infoM[0]['type']) && $infoM[0]['type']=='fournitures'){echo 'selected="selected"';} ?> >Fournitures</option>
				<option value="travaux" <?php if(isset($_POST['type']) && $_POST['type']=='travaux') {echo 'selected="selected"';} elseif(isset($infoM[0]['type']) && $infoM[0]['type']=='travaux'){echo 'selected="selected"';} ?>>Travaux</option>
				<option value="services" <?php if(isset($_POST['type']) && $_POST['type']=='services') {echo 'selected="selected"';} elseif(isset($infoM[0]['type']) && $infoM[0]['type']=='services'){echo 'selected="selected"';} ?>>Services</option>
			</select><?php if(isset($erreur['type'])) echo '<p class="erreur">'.$erreur['type'].'</p>';?><br/>
			<label for="titre">Titre<span class="obligatoire">*</span></label><input type="text" value="<?php if(isset($_POST['titre']) && $_POST['titre']!='') {echo $_POST['titre'];}  elseif(isset($infoM[0]['titre']) && $infoM[0]['titre']!=''){echo $infoM[0]['titre'];} ?>" name="titre" id="titre" /><?php if(isset($erreur['titre'])) echo '<p class="erreur">'.$erreur['titre'].'</p>';?><br/>
			<input type="submit" value="Modifier" name="partiecom"/>
		</fieldset>
	
	</form>
	
	<?php
		echo '<p>Modèles de fichiers à télécharger : </p>';
		if(isset($niveaupost) && $niveaupost!=0) { $niveau = $niveaupost;} elseif(isset($infoM[0]['id_montant']) && $infoM[0]['id_montant']!=''){$niveau = $infoM[0]['id_montant'];}
		switch($niveau)
		{
			case 1:		
			case 2: /*echo '<ul class="liste_res"><li><a href="tmp/doc_descriptif_consultation_'.$id_formate.'.doc">Document descriptif de la consultation</a></li><li><a href="tmp/modele_lettre_candidat_retenu_dessous_25000_HT_'.$id_formate.'.doc">Modèle de lettre candidat retenu en dessous de 25000€HT</a></li><li><a href="tmp/cctp_'.$id_formate.'.doc">Annexe au document descriptif Cahier des clauses techniques particulières</a></li><li><a href="tmp/modele_lettre_candidat_non_retenu_dessous_25000_HT_'.$id_formate.'.doc">Modèle lettre candidat non retenu</a></li><li><a href="tmp/modele_lettre_mail_negociation_dessous_25000_'.$id_formate.'.doc">Modèle de lettre/mail négociation en dessous de 25000€HT</a></li><li><a href="tmp/modele_rapport_analyse_consultation_dessous_25000_'.$id_formate.'.doc">Modèle de rapport d\'analyse consultation en dessous 25000€HT</a></li><li><a href="tmp/mdl_lettre_mail_suite_a_ddes_infos_complementaires_candidats_non_retenus_'.$id_formate.'.doc">Modèle de lettre/mail suite à informations complémentaires pour candidats non retenus</a></li></ul>';
					break;*/
			case 3: 
			case 4: echo '<ul class="liste_res"><li><a href="tmp/ccap_'.$id_formate.'.doc">Cahier des clauses administratives particulières</a></li>';
			/*echo '<li><a href="tmp/cctp_'.$id_formate.'.doc">Cahier des clauses techniques particulières</a></li><li><a href="tmp/ae_'.$id_formate.'.doc">Acte d\'engagement</a></li><li><a href="tmp/modele_lettre_candidat_retenu_dessus_25000_HT_'.$id_formate.'.doc">Modèle de lettre candidat retenu au dessus de 25000€HT</a></li><li><a href="tmp/modele_lettre_candidat_non_retenu_dessus_25000_HT_'.$id_formate.'.doc">Modèle lettre candidat non retenu</a></li><li><a href="tmp/modele_lettre_mail_negociation_dessus_25000_'.$id_formate.'.doc">Modèle de lettre/mail négociation au dessus de 25000€HT</a></li><li><a href="tmp/modele_rapport_analyse_consultation_dessus_25000_'.$id_formate.'.doc">Modèle de rapport d\'analyse consultation au dessus 25000€HT</a></li><li><a href="tmp/mdl_lettre_mail_suite_a_ddes_infos_complementaires_candidats_non_retenus_'.$id_formate.'.doc">Modèle de lettre/mail suite à informations complémentaires pour candidats non retenus</a></li>';*/
			echo '</ul>';
					break;
			default: break;
			
		}
	?>
	
</section>
<script type="text/javascript">

$(document).ready(function() {	
	$("#date_mel_com,#date_fin_com").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true
	});$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );

	$("#selectmontant").change(function(){
		$("div[id^='pub']").addClass("none");
		var num=0;
		$( "#selectmontant option:selected" ).each(function() {
			num = $( this ).val();
			$("#pub"+num).removeClass("none");
			$("#publicite").attr('value',$("#pub"+num).text());
		});
	})
});
</script>
<?php

require_once('footer.php');

?>
