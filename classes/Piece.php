<?php 

class Piece
{
	private $id_piece;
	private $id_marche;
	private $piece;
	
	public function __construct()
	{
		
	}
  
	public function addPiece($idmarche,$piece)
	{
		global $bdd;
		
		$q = $bdd->prepare("INSERT INTO piece SET id_marche = :idmarche, piece = :piece");
		$q->bindValue(":idmarche", $idmarche);
		$q->bindValue(":piece", $piece);
		$q->execute();
		$dernierid = $bdd->lastInsertId();
		return $dernierid;
	}
	
	public function getPiece($idmarche)
	{
		global $bdd;
		
		$q = $bdd->prepare("SELECT * FROM piece where id_marche = :idmarche");
		$q->bindValue(":idmarche", $idmarche);
		$q->execute();
		$data=$q->fetchAll();
		return $data;
	}
	
	public function delPiece($idpiece)
	{
		global $bdd;
		
		$q = $bdd->prepare("DELETE FROM piece WHERE id_piece = :piece");
		$q->bindValue(":piece", $idpiece);
		$q->execute();
	}
	
}


?>