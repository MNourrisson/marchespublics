<?php 

class Marche
{
	private $_id_marche;
	private $_id_montant;
	private $date_mel_com;
	private $redacteur;
	private $type;
	private $titre;
	private $publicite;
	private $date_attribution;
	private $num_comptable;
	private $date_debut;
	private $date_fin;
	private $avenant1;
	private $avenant2;
	private $avenant3;
	private $montant_ht_total;
	private $montant_ht_non_soumis_total;
	private $taux_tva_total;
	private $montant_ttc_total;
	private $attributaire;
	private $code_postal;
	private $lieu;
	private $montant_ht_attributaire;
	private $montant_ht_non_soumis_attributaire;
	private $taux_tva_attributaire;
	private $montant_ttc_attributaire;
	private $cotraitant_type;
	private $cotraitant;
	private $montant_ht_cotraitant;
	private $montant_ht_non_soumis_cotraitant;
	private $taux_tva_cotraitant;
	private $montant_ttc_cotraitant;
	private $sstraitant;
	private $montant_ht_sstraitant;
	private $montant_ht_non_soumis_sstraitant;
	private $taux_tva_sstraitant;
	private $montant_ttc_sstraitant;
	private $infos;
	private $certif_adm;
	private $tranche_ferme;
	private $tranche_conditionnelle1;
	private $tranche_conditionnelle2;
	private $marche_reconductible;
	private $date_reconduction_ferme;
	private $date_engagement_tc1;
	private $date_engagement_tc2;
	
	public function __construct()
	{
		
	}
  
	public function addPartieCom($idmontant,$dateligne,$redac,$type,$titre,$publicite)
	{
		global $bdd;
		
		$q = $bdd->prepare("INSERT INTO marche SET id_montant = :idmontant, date_mel_com = :dateligne, redacteur = :redac, type = :type, titre= :titre, publicite= :publicite");
		$q->bindValue(":idmontant", $idmontant);
		$q->bindValue(":dateligne", $dateligne);
		$q->bindValue(":redac", $redac);
		$q->bindValue(":type", $type);
		$q->bindValue(":titre", $titre);
		$q->bindValue(":publicite", $publicite);
		$q->execute();
		
		$dernierid = $bdd->lastInsertId();
		$id_formate = date('Y').'-'.str_pad($dernierid,4,"0",STR_PAD_LEFT);
		$q = $bdd->prepare("UPDATE marche SET id_marche_formate = :id_formate WHERE id_marche= :dernierid");
		$q->bindValue(":id_formate", $id_formate);
		$q->bindValue(":dernierid", $dernierid);
		$q->execute();
		
		return $dernierid;

	}
	public function upPartieCom($id,$idmontant,$dateligne,$redac,$type,$titre,$publicite)
	{
		global $bdd;
		
		$q = $bdd->prepare("UPDATE marche SET id_montant = :idmontant, date_mel_com = :dateligne, redacteur = :redac, type = :type, titre = :titre, publicite = :publicite WHERE id_marche=:id");
		$q->bindValue(":idmontant", $idmontant);
		$q->bindValue(":dateligne", $dateligne);
		$q->bindValue(":redac", $redac);
		$q->bindValue(":type", $type);
		$q->bindValue(":titre", $titre);
		$q->bindValue(":publicite", $publicite);
		$q->bindValue(":id", $id);
		$q->execute();

	}

	public function upPartieComptable($id,$date_attribution,$numcomptable,$datedeb,$datefin,$avenant1,$avenant2,$avenant3,$montant_ht_total,$montant_ht_non_soumis_total,$taux_tva_total,$montant_ttc_total,$attributaire,$cp,$lieu,$montant_ht_attributaire,$montant_ht_non_soumis_attributaire,$taux_tva_attributaire,$montant_ttc_attributaire,$sstraitant,$montant_ht_sstraitant,$montant_ht_non_soumis_sstraitant,$taux_tva_sstraitant,$montant_ttc_sstraitant,$cotraitant_type,$cotraitant,$montant_ht_cotraitant,$montant_ht_non_soumis_cotraitant,$taux_tva_cotraitant,$montant_ttc_cotraitant,$infos,$certif,$tranche_ferme,$tranche_conditionnelle1,$tranche_conditionnelle2,$marche_reconductible,$date_reconduction_ferme,$date_engagement_tc1,$date_engagement_tc2)
	{
		global $bdd;
		
		$q = $bdd->prepare("UPDATE marche SET date_attribution = :date_attribution, num_comptable = :numcomptable, date_debut = :datedeb, date_fin = :datefin, avenant1 = :avenant1, avenant2 = :avenant2, avenant3 = :avenant3, montant_ht_total = :montant_ht_total,montant_ht_non_soumis_total = :montant_ht_non_soumis_total,taux_tva_total= :taux_tva_total, montant_ttc_total = :montant_ttc_total,attributaire = :attributaire, code_postal = :cp, lieu = :lieu, montant_ht_attributaire = :montant_ht_attributaire,montant_ht_non_soumis_attributaire = :montant_ht_non_soumis_attributaire,taux_tva_attributaire= :taux_tva_attributaire, montant_ttc_attributaire = :montant_ttc_attributaire,sstraitant = :sstraitant, montant_ht_sstraitant = :montant_ht_sstraitant,montant_ht_non_soumis_sstraitant = :montant_ht_non_soumis_sstraitant,taux_tva_sstraitant= :taux_tva_sstraitant, montant_ttc_sstraitant = :montant_ttc_sstraitant,cotraitant_type = :cotraitant_type, cotraitant = :cotraitant,montant_ht_cotraitant = :montant_ht_cotraitant,montant_ht_non_soumis_cotraitant = :montant_ht_non_soumis_cotraitant,taux_tva_cotraitant= :taux_tva_cotraitant, montant_ttc_cotraitant = :montant_ttc_cotraitant, infos = :infos, certif_adm = :certif, tranche_ferme=:tranche_ferme, tranche_conditionnelle1=:tranche_conditionnelle1, tranche_conditionnelle2=:tranche_conditionnelle2, marche_reconductible=:marche_reconductible, date_reconduction_ferme=:date_reconduction_ferme, date_engagement_tc1=:date_engagement_tc1, date_engagement_tc2=:date_engagement_tc2 WHERE id_marche=:id");

		$q->bindValue(":date_attribution", $date_attribution);
		$q->bindValue(":numcomptable", $numcomptable);
		$q->bindValue(":datedeb", $datedeb);
		$q->bindValue(":datefin", $datefin);
		$q->bindValue(":avenant1", $avenant1);
		$q->bindValue(":avenant2", $avenant2);
		$q->bindValue(":avenant3", $avenant3);
		$q->bindValue(":montant_ht_total", $montant_ht_total);
		$q->bindValue(":montant_ht_non_soumis_total", $montant_ht_non_soumis_total);
		$q->bindValue(":taux_tva_total", $taux_tva_total);
		$q->bindValue(":montant_ttc_total", $montant_ttc_total);
		$q->bindValue(":attributaire", $attributaire);
		$q->bindValue(":cp", $cp);
		$q->bindValue(":lieu", $lieu);
		$q->bindValue(":montant_ht_attributaire", $montant_ht_attributaire);
		$q->bindValue(":montant_ht_non_soumis_attributaire", $montant_ht_non_soumis_attributaire);
		$q->bindValue(":taux_tva_attributaire", $taux_tva_attributaire);
		$q->bindValue(":montant_ttc_attributaire", $montant_ttc_attributaire);
		$q->bindValue(":sstraitant", $sstraitant);
		$q->bindValue(":montant_ht_sstraitant", $montant_ht_sstraitant);
		$q->bindValue(":montant_ht_non_soumis_sstraitant", $montant_ht_non_soumis_sstraitant);
		$q->bindValue(":taux_tva_sstraitant", $taux_tva_sstraitant);
		$q->bindValue(":montant_ttc_sstraitant", $montant_ttc_sstraitant);
		$q->bindValue(":cotraitant_type", $cotraitant_type);
		$q->bindValue(":cotraitant", $cotraitant);
		$q->bindValue(":montant_ht_cotraitant", $montant_ht_cotraitant);
		$q->bindValue(":montant_ht_non_soumis_cotraitant", $montant_ht_non_soumis_cotraitant);
		$q->bindValue(":taux_tva_cotraitant", $taux_tva_cotraitant);
		$q->bindValue(":montant_ttc_cotraitant", $montant_ttc_cotraitant);
		$q->bindValue(":infos", $infos);
		$q->bindValue(":certif", $certif);
		$q->bindValue(":tranche_ferme", $tranche_ferme);
		$q->bindValue(":tranche_conditionnelle1", $tranche_conditionnelle1);
		$q->bindValue(":tranche_conditionnelle2", $tranche_conditionnelle2);
		$q->bindValue(":marche_reconductible", $marche_reconductible);
		$q->bindValue(":date_reconduction_ferme", $date_reconduction_ferme);
		$q->bindValue(":date_engagement_tc1", $date_engagement_tc1);
		$q->bindValue(":date_engagement_tc2", $date_engagement_tc2);
		$q->bindValue(":id", $id);
		return $q->execute();
		//print_r($q->errorInfo()); die();

	}
	public function getInfosMarche($idmarche)
	{
		global $bdd;
		
		$req = $bdd->prepare('SELECT * FROM marche, montant WHERE id_marche = :idmarche AND marche.id_montant=montant.id_montant');
		$req->bindValue(":idmarche", $idmarche);
		$req->execute();
		$data=$req->fetchAll();
		return $data;
	}
	
	public function getRecherche($redac,$annee)
	{
		global $bdd;
		
		$req = $bdd->prepare("SELECT * FROM marche WHERE UPPER(redacteur) LIKE UPPER ('%$redac%') AND YEAR(date_mel_com) = :annee");
		$req->bindValue(":annee", $annee,PDO::PARAM_INT);
		$req->execute();
		$data=$req->fetchAll();
		return $data;
	}
	public function getRecap($annee)
	{
		global $bdd;
		
		$req = $bdd->prepare("SELECT * FROM marche, montant WHERE YEAR(date_debut) = :annee AND marche.id_montant = montant.id_montant ORDER BY marche.id_montant ASC, type ASC ");
		$req->bindValue(":annee", $annee);
		$req->execute();
		$data=$req->fetchAll();
		return $data;
	}
	public function getCertif($certif)
	{
		global $bdd;
		
		$req = $bdd->prepare("SELECT * FROM marche, montant WHERE certif_adm= :certif AND marche.id_montant = montant.id_montant ORDER BY  marche.id_montant ASC, type ASC,date_debut ASC ");
		$req->bindValue(":certif", $certif);
		$req->execute();
		$data=$req->fetchAll();
		return $data;
	}
	public function get2Weeks()
	{
		global $bdd;
		
		//$req = $bdd->prepare("SELECT * FROM marche WHERE (date_fin BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)) AND certif_adm='0'");
		// marches sans certif adm et dont la date de fin est sous un mois ou quand la date de fin est passée.
		$req = $bdd->prepare("SELECT * FROM marche WHERE certif_adm='0' and ((date_fin< CURDATE() and date_fin!='0000-00-00') or (date_fin BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)))");
		$req->execute();
		$data=$req->fetchAll();
		return $data;
	}

}


?>