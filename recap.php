<?php 
	ob_start();
	session_start();
	$current = 'recap';
	include_once('classes/connect.php');
	include_once('classes/Marche.php');
	include_once('classes/PHPExcel.php');
	$marche = new Marche();
	
	$erreur=array();
	$erreurmsg='';
	
	if(isset($_POST['recherche']) && $_POST['recherche']=='Rechercher' && $_POST['recherche_annee']!='')
	{
		$annee = trim($_POST['recherche_annee']);
		$listeRes = $marche->getRecap($annee);
		$listeCertif = $marche->getCertif('0');
		if(count($listeRes)==0 && count($listeCertif)==0)
		{
			$erreurmsg='Aucun résultat trouvé pour l\'année '.$annee;	
		}
		else
		{	
			$curseur=1;
			$prix=0;
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("Mélanie Nourrisson")
					->setLastModifiedBy("Mélanie Nourrisson")
					->setTitle("Récapitulatif ".$annee)
					->setSubject("Récapitulatif ".$annee);
			$myCertifSheet0 = new PHPExcel_Worksheet($objPHPExcel,'Marchés passées en '.$annee);
			$objPHPExcel->addSheet($myCertifSheet0,0);		
					
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$curseur, 'Récapitulatif des marchés passées en '.$annee);
			$curseur++;
			$styleTitre = new PHPExcel_Style();
			$styleTitre->applyFromArray(
			array(	'font'=>array('bold'=>true),
					'fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('argb' => 'FF00CCFF')
									)
				 ));
			$styleColonne = new PHPExcel_Style();
			$styleColonne->applyFromArray(
			array(	'fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('argb' => 'FFC2DAD2')
									)
				 ));
				 
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(9);//charte
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(11);//numéro
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(11);//date
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(21);//redacteur
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(10);//type
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(35);//titre
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(10);//pub
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(11);//date attribution
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(11);//num comptable
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(11);//date debut
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(11);//date fin
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(11);//avenant1
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(11);//avenant2
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth(11);//avenant3
 
				 
			foreach($listeRes as $cle => $valeur)
			{
			//	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '')
				if($prix!=$valeur['id_montant'])
				{
					$prix=$valeur['id_montant'];
					$curseur++;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$curseur, 'Marchés '.$valeur['libelle']);
					$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleTitre, "A".$curseur.":X".$curseur);
					$curseur++;
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$curseur.':G'.$curseur);
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$curseur.':X'.$curseur);
					$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$curseur)->applyFromArray(array('alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					$objPHPExcel->setActiveSheetIndex(0)->getStyle('G'.$curseur)->applyFromArray(array('alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$curseur, 'Partie commune');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$curseur, 'Partie comptable');
					$curseur++;
					$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleColonne, "A".$curseur);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$curseur, 'Charte');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$curseur, 'Numéro');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$curseur, 'Date mise en ligne');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$curseur, 'Rédacteur');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$curseur, 'Type');
					$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleColonne, "F".$curseur);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$curseur, 'Titre');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$curseur, 'Publicité');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$curseur, 'Date attribution');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$curseur, 'N° comptable');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$curseur, 'Date début');
					$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleColonne, "K".$curseur);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$curseur, 'Date fin');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$curseur, 'Avenant 1');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$curseur, 'Avenant 2');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$curseur, 'Avenant 3');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$curseur, 'Attributaire');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$curseur, 'CP');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$curseur, 'Lieu');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$curseur, 'Montant HT total');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$curseur, 'Montant HT non soumis total');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$curseur, 'TVA');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$curseur, 'Montant TTC total');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$curseur, 'Infos');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$curseur, 'Certif Adm');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$curseur, 'Documents');
					$curseur++;
				}
				
				$numC=$valeur['num_comptable']; // ex 2015/11211-140020
				if($numC!=='')
				{
				$tabnumC = explode('-',$numC); // tabnumC[0]=2015/11211 et tabnumC[1]=140020
				$tabnumC1 = explode('/',$tabnumC[0]); //tabnumC1[0]=2015 et tabnumC1[1]=11211
				$tabnumC2 = substr($tabnumC[1],0,2); // tabnumC2=14
				$numcharte = $tabnumC1[1].'-'.$tabnumC2;
				}
				else{
					$numcharte='';
				}
				$date_ligne=$valeur['date_mel_com']; $arr1 = explode('-',$date_ligne); $date_ligne=$arr1[2].'/'.$arr1[1].'/'.$arr1[0];
				$date_attribution=$valeur['date_attribution'];$arr3=explode('-',$date_attribution); $date_attribution=$arr3[2].'/'.$arr3[1].'/'.$arr3[0];
				$date_deb_compta=$valeur['date_debut'];$arr4=explode('-',$date_deb_compta); $date_deb_compta=$arr4[2].'/'.$arr4[1].'/'.$arr4[0];
				$date_fin_compta=$valeur['date_fin']; $arr5=explode('-',$date_fin_compta); $date_fin_compta=$arr5[2].'/'.$arr5[1].'/'.$arr5[0];	
				
				$avenant1 = $valeur['avenant1']; $arr2= explode('-',$avenant1); $avenant1=$arr2[2].'/'.$arr2[1].'/'.$arr2[0];				
				$avenant2 = $valeur['avenant2']; $arr2= explode('-',$avenant2); $avenant2=$arr2[2].'/'.$arr2[1].'/'.$arr2[0];				
				$avenant3 = $valeur['avenant3']; $arr2= explode('-',$avenant3); $avenant3=$arr2[2].'/'.$arr2[1].'/'.$arr2[0];	

				$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleColonne, "A".$curseur);				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$curseur, $numcharte);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$curseur, $valeur['id_marche_formate']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$curseur, $date_ligne);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$curseur, $valeur['redacteur']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$curseur, $valeur['type']);
				$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleColonne, "F".$curseur);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$curseur, $valeur['titre']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$curseur, strip_tags($valeur['publi']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$curseur, $date_attribution);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$curseur, $numC);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$curseur, $date_deb_compta);
				$objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleColonne, "K".$curseur);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$curseur, $date_fin_compta);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$curseur, $avenant1);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$curseur, $avenant2);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$curseur, $avenant3);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$curseur, $valeur['attributaire']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$curseur, $valeur['code_postal']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$curseur, $valeur['lieu']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$curseur, $valeur['montant_ht_total'].' €');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$curseur, $valeur['montant_ht_non_soumis_total'].' €');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$curseur, $valeur['taux_tva_total'].' %');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$curseur, $valeur['montant_ttc_total'].' €');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$curseur, $valeur['infos']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$curseur, ($valeur['certif_adm']==='0')?'N':'O');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$curseur, 'http://monlien/modifcompta.php?m='.$valeur['id_marche']);
				$objPHPExcel->setActiveSheetIndex(0)->getCell('X'.$curseur)->getHyperlink()->setUrl('http://monlien/modifcompta.php?m='.$valeur['id_marche']);
					
				
				$curseur++;
			}

			//deuxieme onglet	
			$myCertifSheet = new PHPExcel_Worksheet($objPHPExcel,'Pas de Certificat Administratif');
			$objPHPExcel->addSheet($myCertifSheet,1);
			$curseur=1;
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$curseur, 'Récapitulatif des marchés sans certificat administratif');
			$curseur++;
			$prix=0;	
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('A')->setWidth(9);//charte
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('B')->setWidth(11);//numéro
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('C')->setWidth(11);//date
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('D')->setWidth(21);//redacteur
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('E')->setWidth(10);//type
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('F')->setWidth(35);//titre
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('G')->setWidth(10);//pub
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('H')->setWidth(11);//date attribution
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('I')->setWidth(11);//num comptable
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('J')->setWidth(11);//date debut
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('K')->setWidth(11);//date fin
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('L')->setWidth(11);//avenant1
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('M')->setWidth(11);//avenant2
			$objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('N')->setWidth(11);//avenant3
			foreach($listeCertif as $cle => $valeur)
			{

				if($prix!=$valeur['id_montant'])
				{
					$prix=$valeur['id_montant'];
					$curseur++;
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$curseur, 'Marchés '.$valeur['libelle']);
					$objPHPExcel->setActiveSheetIndex(1)->setSharedStyle($styleTitre, "A".$curseur.":X".$curseur);
					$curseur++;
					$objPHPExcel->setActiveSheetIndex(1)->mergeCells('A'.$curseur.':G'.$curseur);
					$objPHPExcel->setActiveSheetIndex(1)->mergeCells('H'.$curseur.':X'.$curseur);
					$objPHPExcel->setActiveSheetIndex(1)->getStyle('A'.$curseur)->applyFromArray(array('alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					$objPHPExcel->setActiveSheetIndex(1)->getStyle('H'.$curseur)->applyFromArray(array('alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$curseur, 'Partie commune');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.$curseur, 'Partie comptable');
					$curseur++;
					$objPHPExcel->setActiveSheetIndex(1)->setSharedStyle($styleColonne, "A".$curseur);
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$curseur, 'Charte');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$curseur, 'Numéro');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$curseur, 'Date mise en ligne');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$curseur, 'Rédacteur');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$curseur, 'Type');
					$objPHPExcel->setActiveSheetIndex(1)->setSharedStyle($styleColonne, "F".$curseur);
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$curseur, 'Titre');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.$curseur, 'Publicité');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.$curseur, 'Date attribution');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'.$curseur, 'N° comptable');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('J'.$curseur, 'Date début');
					$objPHPExcel->setActiveSheetIndex(1)->setSharedStyle($styleColonne, "K".$curseur);
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('K'.$curseur, 'Date fin');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('L'.$curseur, 'Avenant 1');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('M'.$curseur, 'Avenant 2');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('N'.$curseur, 'Avenant 3');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('O'.$curseur, 'Attributaire');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('P'.$curseur, 'CP');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('Q'.$curseur, 'Lieu');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('R'.$curseur, 'Montant HT total');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('S'.$curseur, 'Montant HT non soumis total');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('T'.$curseur, 'TVA');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('U'.$curseur, 'Montant TTC total');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('V'.$curseur, 'Infos');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('W'.$curseur, 'Certif Adm');
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('X'.$curseur, 'Documents');
					$curseur++;
				}
				
				$numC=$valeur['num_comptable']; // ex 2015/11211-140020
				if($numC!=='')
				{
					$tabnumC = explode('-',$numC); // tabnumC[0]=2015/11211 et tabnumC[1]=140020
					$tabnumC1 = explode('/',$tabnumC[0]); //tabnumC1[0]=2015 et tabnumC1[1]=11211
					$tabnumC2 = substr($tabnumC[1],0,2); // tabnumC2=14
					$numcharte = $tabnumC1[1].'-'.$tabnumC2;
				}
				else
				{$numcharte='';}
				$date_ligne=$valeur['date_mel_com']; $arr1 = explode('-',$date_ligne); $date_ligne=$arr1[2].'/'.$arr1[1].'/'.$arr1[0];
				$date_attribution=$valeur['date_attribution'];$arr3=explode('-',$date_attribution); $date_attribution=$arr3[2].'/'.$arr3[1].'/'.$arr3[0];
				$date_deb_compta=$valeur['date_debut'];$arr4=explode('-',$date_deb_compta); $date_deb_compta=$arr4[2].'/'.$arr4[1].'/'.$arr4[0];
				$date_fin_compta=$valeur['date_fin']; $arr5=explode('-',$date_fin_compta); $date_fin_compta=$arr5[2].'/'.$arr5[1].'/'.$arr5[0];	
				
				$avenant1 = $valeur['avenant1']; $arr2= explode('-',$avenant1); $avenant1=$arr2[2].'/'.$arr2[1].'/'.$arr2[0];				
				$avenant2 = $valeur['avenant2']; $arr2= explode('-',$avenant2); $avenant2=$arr2[2].'/'.$arr2[1].'/'.$arr2[0];				
				$avenant3 = $valeur['avenant3']; $arr2= explode('-',$avenant3); $avenant3=$arr2[2].'/'.$arr2[1].'/'.$arr2[0];	

				$objPHPExcel->setActiveSheetIndex(1)->setSharedStyle($styleColonne, "A".$curseur);				
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$curseur, $numcharte);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$curseur, $valeur['id_marche_formate']);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$curseur, $date_ligne);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$curseur, $valeur['redacteur']);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$curseur, $valeur['type']);
				$objPHPExcel->setActiveSheetIndex(1)->setSharedStyle($styleColonne, "F".$curseur);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$curseur, $valeur['titre']);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.$curseur, strip_tags($valeur['publi']));
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.$curseur, $date_attribution);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'.$curseur, $numC);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('J'.$curseur, $date_deb_compta);
				$objPHPExcel->setActiveSheetIndex(1)->setSharedStyle($styleColonne, "K".$curseur);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('K'.$curseur, $date_fin_compta);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('L'.$curseur, $avenant1);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('M'.$curseur, $avenant2);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('N'.$curseur, $avenant3);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('O'.$curseur, $valeur['attributaire']);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('P'.$curseur, $valeur['code_postal']);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('Q'.$curseur, $valeur['lieu']);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('R'.$curseur, $valeur['montant_ht_total'].' €');
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('S'.$curseur, $valeur['montant_ht_non_soumis_total'].' €');
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('T'.$curseur, $valeur['taux_tva_total'].' %');
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('U'.$curseur, $valeur['montant_ttc_total'].' €');
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('V'.$curseur, $valeur['infos']);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('W'.$curseur, ($valeur['certif_adm']==='0')?'N':'O');
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('X'.$curseur, 'http://monlien/modifcompta.php?m='.$valeur['id_marche']);
				$objPHPExcel->setActiveSheetIndex(0)->getCell('X'.$curseur)->getHyperlink()->setUrl('http://monlien/modifcompta.php?m='.$valeur['id_marche']);
								
				$curseur++;
			}		
			
		
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('recap/recapitulatif_'.$annee.'.xlsx');
			unset($objPHPExcel);
			
		}
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
	<h2>Récapitulatif</h2>
	<?php 
	//	echo '<pre>'; print_r($listeRes); echo '</pre>';
		
		
	?>
	<p class="indication">Le champ est obligatoire.</p>
	<form action="" method="post">
		<fieldset>
			<label for="recherche_annee">Année<span class="obligatoire">*</span></label><input type="text" value="<?php if(isset($_POST['recherche_annee']) && $_POST['recherche_annee']!='') {echo $_POST['recherche_annee'];} else echo date('Y'); ?>" name="recherche_annee" id="recherche_annee" maxlength="4" /><?php if(isset($erreur['recherche_annee'])) echo '<p class="erreur left">'.$erreur['recherche_annee'].'</p>';?><br/>
			<input type="submit" value="Rechercher" name="recherche"/>
		</fieldset>
	
	</form>
	<?php
		if(isset($_POST['recherche']) && file_exists('recap/recapitulatif_'.$annee.'.xlsx'))
		{
			echo '<p>Télécharger le fichier (xlsx) : <a href="recap/recapitulatif_'.$annee.'.xlsx">Récapitulatif '.$annee.'</a></p>';
			
		}
	?>
</section>
<?php

require_once('footer.php');

?>
