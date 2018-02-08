<?php 

class Montant
{
	private $_id_montant;
	private $libelle;
	private $actif;
	
	public function __construct()
	{
		
	}
  
	public function getInfos($statut='all')
	{
		global $bdd;
		if($statut=='all')
		{
			$req = $bdd->prepare('SELECT * FROM montant');
		}
		else
		{
			$req = $bdd->prepare('SELECT * FROM montant WHERE actif = :statut');
			$req->bindValue(":statut", $statut);
		}
		$req->execute();
		$data=$req->fetchAll();
		return $data;
	}

}


?>