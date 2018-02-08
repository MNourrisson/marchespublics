<?php 
	session_start();
	$current = 'ajoutcommun';
	include_once('classes/connect.php');
	include_once('classes/Montant.php');
	include_once('classes/Marche.php');
	
	$m = new Montant();
	$marche = new Marche();
	
	$listemontant = $m->getInfos('all');
	$erreur=array();
	$erreurmsg='';
	if(isset($_POST['partiecom']) && $_POST['partiecom']=='Enregistrer' )
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
			
			$insert = $marche->addPartieCom($_POST['selectmontant'],$datetranformee,$_POST['redac'],$_POST['type'],$_POST['titre'],$_POST['publicite']);
			$id_formate = date('Y').'-'.str_pad($insert,4,"0",STR_PAD_LEFT);
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
			if(file_exists("tmp/modele_lettre_candidat_retenu_dessus_25000_HT_".$id_formate.".doc"))
			{
				unlink("tmp/modele_lettre_candidat_retenu_dessus_25000_HT_".$id_formate.".doc");
			}
			if(file_exists("tmp/modele_lettre_candidat_retenu_dessous_25000_HT".$id_formate.".doc"))
			{
				unlink("tmp/modele_lettre_candidat_retenu_dessous_25000_HT".$id_formate.".doc");
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
						
						$lettrenego = file_get_contents("modeles/modele_lettre_mail_negociation_dessous_25000.xml");
						$newFileHandler = fopen("tmp/modele_lettre_mail_negociation_dessous_25000_".$id_formate.".doc","a");
						fwrite($newFileHandler,$lettrenego);
						fclose($newFileHandler);
						$cctp = file_get_contents("modeles/cctp.xml");
						$cctp = str_replace("@TITRE_MARCHE@",htmlspecialchars($_POST['titre']),$cctp);
						$newFileHandler = fopen("tmp/cctp_".$id_formate.".doc","a");
						fwrite($newFileHandler,$cctp);
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
						$cctp = str_replace("@DATE_MARCHE@",$dateavant,$cctp);
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
			
			$to      = "emaildestinataire@votredomaine.fr";
			$subject = "Ajout d'un nouveau marché";
			$message = "<html><head><title>Nouveau marché</title></head><body><table><p>Bonjour, un nouveau marché vient d'être ajouté.</p> <table><tr><td>Rédacteur :</td><td> ".$_POST['redac']."<td></tr><tr><td>Titre du marché : </td><td>".$_POST['titre']."</td></tr></body></html>";
			$headers = "From: emailexpe@votredomaine.fr" . "\r\n" .
			"MIME-Version: 1.0" . "\r\n".
			"X-Priority: 1 (Highest)"."\r\n".
			"X-MSMail-Priority: High"."\r\n".
			"Importance: High"."\r\n".
			"Content-type: text/html; charset=utf-8" . "\r\n".
			"Subject: Nouveau marché" . "\r\n";
	
			if(mail($to,$subject,$message,$headers))
			{
				header('Location: modifcommun.php?m='.$insert);
			}
			else{
				echo 'Erreur envoie mail';
				
			}
			
			
		}
		
	}
	
	//print_r($listemontant);
	require_once('head.php');
	require_once('nav.php');
?>
<section id="content">
	<h2>Ajout d'un marché</h2>
	<p class="indication">Les champs suivis de * sont obligatoires.</p>
	<?php if(isset($erreurmsg) && $erreurmsg!='') echo '<p class="erreur left">'.$erreurmsg.'</p><br/>'; ?>
	<form action="" method="post">
		<fieldset>
			<label for="selectmontant">Montant du marché (HT)<span class="obligatoire">*</span></label>
			<select name="selectmontant" id="selectmontant">
				<option value="" <?php if(isset($_POST['selectmontant']) && $_POST['selectmontant']=='') {echo 'selected="selected"';} ?>>-- Choisir --</option>
				<?php
					foreach($listemontant as $clem => $valeurm)
					{
						$selected='';
						if(isset($_POST['selectmontant']) && $_POST['selectmontant']==$valeurm['id_montant']) {$selected='selected="selected"';}
						echo '<option value="'.$valeurm['id_montant'].'" '.$selected.'>'.$valeurm['libelle'].'</option>';
						
					}
				?>
			</select><?php if(isset($erreur['selectmontant'])) echo '<p class="erreur left">'.$erreur['selectmontant'].'</p>';?><br/>
			<label>Publicité</label>
			<?php
				$hidden="";
				foreach($listemontant as $clem => $valeurm)
				{
					
					if(isset($_POST['selectmontant']) && $_POST['selectmontant']==$valeurm['id_montant']) {$selected='class="select"'; $hidden=$valeurm['publi'];} else {$selected='class="none"'; $hidden="";}
					echo '<div '.$selected.' id="pub'.$valeurm['id_montant'].'">'.$valeurm['publi'].'</div>';
					
				}
				echo '<input type="hidden" value="'.$hidden.'" name="publicite" id="publicite"/>';
			?>
			<br/>
			<label for="date_mel_com">Date de création<span class="obligatoire">*</span></label><input id="date_mel_com" type="text" value="<?php if(isset($_POST['date_mel_com']) && $_POST['date_mel_com']!='') {echo $_POST['date_mel_com'];} else echo date('d/m/Y'); ?>" name="date_mel_com" placeholder="jj/mm/aaaa" /><?php if(isset($erreur['date_mel_com'])) echo '<p class="erreur left">'.$erreur['date_mel_com'].'</p>';?><br/>
			<label for="redac">Rédacteur<span class="obligatoire">*</span></label><input type="text" value="<?php if(isset($_POST['redac']) && $_POST['redac']!='') {echo $_POST['redac'];} ?>" name="redac" id="redac" placeholder="Nom Prénom"/><?php if(isset($erreur['redac'])) echo '<p class="erreur left">'.$erreur['redac'].'</p>';?><br/>
			<label for="type">Type<span class="obligatoire">*</span></label>
			<select name="type" id="type">
				<option value="" <?php if(isset($_POST['type']) && $_POST['type']=='') {echo 'selected="selected"';} ?> >-- Choisir --</option>
				<option value="fournitures" <?php if(isset($_POST['type']) && $_POST['type']=='fournitures') {echo 'selected="selected"';} ?> >Fournitures</option>
				<option value="travaux" <?php if(isset($_POST['type']) && $_POST['type']=='travaux') {echo 'selected="selected"';} ?>>Travaux</option>
				<option value="services" <?php if(isset($_POST['type']) && $_POST['type']=='services') {echo 'selected="selected"';} ?>>Services</option>
			</select><?php if(isset($erreur['type'])) echo '<p class="erreur left">'.$erreur['type'].'</p>';?><br/>
			<label for="titre">Titre<span class="obligatoire">*</span></label><input type="text" value="<?php if(isset($_POST['titre']) && $_POST['titre']!='') {echo $_POST['titre'];} ?>" name="titre" id="titre" /><?php if(isset($erreur['titre'])) echo '<p class="erreur left">'.$erreur['titre'].'</p>';?><br/>
			<input type="submit" value="Enregistrer" name="partiecom"/>
		</fieldset>
	
	</form>
</section>
<script type="text/javascript">

$(document).ready(function() {	
	$("#date_mel_com").datepicker({
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
