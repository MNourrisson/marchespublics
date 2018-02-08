<?php 

class Personne
{
	private $id_personne;
	private $login;
	private $mdp;
	
	public function __construct()
	{
		
	}
	public function identification($mail)
	{
		global $bdd;
		$query=$bdd->prepare('SELECT id_personne, mdp, login FROM personne WHERE login = :mail');
		$query->bindValue(':mail',$mail, PDO::PARAM_STR);
		$query->execute();
		$data=$query->fetchAll();
		return $data;
	}
	
	
}		
?>