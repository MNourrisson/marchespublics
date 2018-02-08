<?php 
	session_start();
	$current='';
	include_once('classes/connect.php');
	include_once('classes/Marche.php');
	
	$marche = new Marche();
	$marchesAlerte = $marche->get2Weeks();
	
	$liste='';
	if(count($marchesAlerte)!=0)
	{
		foreach($marchesAlerte as $k => $v)
		{
			$tab_majdate = explode('-',$v['date_fin']); $date_fin = $tab_majdate[2].'/'.$tab_majdate[1].'/'.$tab_majdate[0];
			$liste.= '<li>'.$v['titre'].' ('.$v['redacteur'].') - Date de fin : '.$date_fin.' - <a href="modifcompta.php?m='.$v['id_marche'].'">Accèder à la fiche</a></li>';
			
		}
		
	}
	
	
	require_once('head.php');
	require_once('nav.php');
?>
<section id="content">
	<h2>Bienvenue sur la plateforme de gestion des marchés publics du Parc naturel régional Livradois-Forez.</h2>
	
	<?php 		
			if($liste!='')
			{
				echo '<h3>Liste des marchés à surveiller</h3><ul class="alerte">'.$liste.'</ul>';
				
			}
	?>
	
</section>
<?php

require_once('footer.php');

?>
