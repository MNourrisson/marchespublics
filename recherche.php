<?php 
	session_start();
	$current = 'documents';
	include_once('classes/connect.php');
	include_once('classes/Marche.php');

	$marche = new Marche();
	
	$erreur=array();
	$erreurmsg='';
	if(isset($_POST['recherche']) && $_POST['recherche']=='Rechercher' && $_POST['recherche_redac']!='' && $_POST['recherche_annee']!='')
	{
		$redac = trim($_POST['recherche_redac']);
		$annee = trim($_POST['recherche_annee']);
		$listeRes = $marche->getRecherche($redac,$annee);
		if(count($listeRes)==0)
		{
			$erreurmsg='Aucun résultat trouvé pour '.$redac.' en '.$annee;	
		}
		else
		{	$liste='';
			foreach($listeRes as $cle => $valeur)
			{
				$liste .= '<li><a href="documents.php?m='.$valeur['id_marche'].'">'.$valeur['redacteur'].' ('.$valeur['titre'].')</a></li>';
			}
			
		}
	}
	if(isset($_POST['recherche_redac']) && $_POST['recherche_redac']=='')
	{
		$erreur['recherche_redac']='Erreur';
	}
	if(isset($_POST['recherche_annee']) && $_POST['recherche_annee']=='')
	{
		$erreur['recherche_annee']='Erreur';
	}
	if(count($erreur)!=0)
	{
		$erreurmsg='Il y a '.count($erreur).' erreur(s). Merci de vérifier les données rentrées.';
	}
	
	require_once('head.php');
	require_once('nav.php');
?>
<section id="content">
	<h2>Rechercher d'un marché</h2>

	<p class="indication">Les champs suivis de * sont obligatoires.</p>
	<form action="" method="post">
		<fieldset>
			<label for="recherche_redac">Rédacteur<span class="obligatoire">*</span></label><input type="text" value="<?php if(isset($_POST['recherche_redac']) && $_POST['recherche_redac']!='') {echo $_POST['recherche_redac'];} ?>" name="recherche_redac" id="recherche_redac" /><?php if(isset($erreur['recherche_redac'])) echo '<p class="erreur left">'.$erreur['recherche_redac'].'</p>';?><br/>
			<label for="recherche_annee">Année mise en ligne<span class="obligatoire">*</span></label><input type="text" value="<?php if(isset($_POST['recherche_annee']) && $_POST['recherche_annee']!='') {echo $_POST['recherche_annee'];} else echo date('Y'); ?>" name="recherche_annee" id="recherche_annee" maxlength="4" /><?php if(isset($erreur['recherche_annee'])) echo '<p class="erreur left">'.$erreur['recherche_annee'].'</p>';?><br/>
			<input type="submit" value="Rechercher" name="recherche"/>
		</fieldset>
	
	</form>
	<?php
		if(isset($listeRes))
		{
			if($erreurmsg!='')
			{
				echo '<p class="erreur">'.$erreurmsg.'</p>';
			}
			else
			{	
				echo '<p class="resultat">Il y a '.count($listeRes).' résultat(s) pour "'.$redac.'" en "'.$annee.'".</p><ul class="liste_res">'.$liste.'</ul>';
			}
		}
	?>
</section>
<?php

require_once('footer.php');

?>
