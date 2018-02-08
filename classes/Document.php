<?php 

class Document
{
	private $id_document;
	private $id_marche;
	private $document;
	private $date_mel;
	private $type;
	
	public function __construct()
	{
		
	}
  
	public function addDoc($idmarche,$document,$type)
	{
		global $bdd;
		
		$q = $bdd->prepare("INSERT INTO document SET id_marche = :idmarche, document = :document, date_mel =:date_mel, type=:type");
		$q->bindValue(":idmarche", $idmarche);
		$q->bindValue(":document", $document);
		$q->bindValue(":date_mel", date('Y-m-d'));
		$q->bindValue(":type", $type);
		$q->execute();
		$dernierid = $bdd->lastInsertId();
		return $dernierid;
	}
	
	public function getDoc($idmarche)
	{
		global $bdd;
		
		$q = $bdd->prepare("SELECT * FROM document where id_marche = :idmarche");
		$q->bindValue(":idmarche", $idmarche);
		$q->execute();
		$data=$q->fetchAll();
		return $data;
	}	
	public function getDocByType($idmarche,$type)
	{
		global $bdd;
		
		$q = $bdd->prepare("SELECT * FROM document where id_marche = :idmarche AND type=:type");
		$q->bindValue(":idmarche", $idmarche);
		$q->bindValue(":type", $type);
		$q->execute();
		$data=$q->fetchAll();
		return $data;
	}
	
	public function delDoc($iddoc)
	{
		global $bdd;
		
		$q = $bdd->prepare("DELETE FROM document WHERE id_document = :iddoc");
		$q->bindValue(":iddoc", $iddoc);
		$q->execute();
	}
	
}


?>