<?php

include_once('classes/connect.php');

$madateJ =date('d');
$madateM =date('m');
if($madateM=='12')
{
	$madateM='01';
}
else
{
	$madateM=$madateM+1;
}
//jour et mois+1 de reconduction qui correspondent et pas de certif adm
$req1 = $bdd->prepare('SELECT * FROM marche WHERE DAY(date_reconduction_ferme)=:day AND MONTH(date_reconduction_ferme)=:month AND certif_adm=1');
$req1->bindValue(":day", $madateJ);
$req1->bindValue(":month", $madateM);
$req1->execute();
$data=$req1->fetchAll();
if(count($data)==0)
{
	$message1='';
}
else{
	$message1='<p>Liste des marchés reconductibles dans un mois<p><ul>';
	foreach($data as $key => $value)
	{
		$d = $value['date_reconduction_ferme'];
		$tab = explode('-',$d);
		$d = $tab[2].'/'.$tab[1].'/'.$tab[0];
		$message1.='<li>'.$value['redacteur'].' : '.$value['titre'].'. Date de reconduction ferme : '.$d.'. <a href="http://monlien/modifcompta.php?m='.$value['id_marche'].'">Accéder au marché</a></li>';
	}
	$message1.='</ul>';
}

//jour et mois+1 date engagement 1 qui correspondent et pas de certif adm
$req1 = $bdd->prepare('SELECT * FROM marche WHERE DAY(date_engagement_tc1)=:day AND MONTH(date_engagement_tc1)=:month AND certif_adm=1');
$req1->bindValue(":day", $madateJ);
$req1->bindValue(":month", $madateM);
$req1->execute();
$data=$req1->fetchAll();
if(count($data)==0)
{
	$message1.='';
}
else{
	$message1.='<p>Liste des marchés avec date d\'engagement tranche conditionnelle 1<p><ul>';
	foreach($data as $key => $value)
	{
		$d = $value['date_engagement_tc1'];
		$tab = explode('-',$d);
		$d = $tab[2].'/'.$tab[1].'/'.$tab[0];
		$message1.='<li>'.$value['redacteur'].' : '.$value['titre'].'. Date d\'engagement tranche conditionnelle 1 : '.$d.'. <a href="http://monlien/modifcompta.php?m='.$value['id_marche'].'">Accéder au marché</a></li>';
	}
	$message1.='</ul>';
}

//jour et mois+1 date engagement 2 qui correspondent et pas de certif adm
$req1 = $bdd->prepare('SELECT * FROM marche WHERE DAY(date_engagement_tc2)=:day AND MONTH(date_engagement_tc2)=:month AND certif_adm=1');
$req1->bindValue(":day", $madateJ);
$req1->bindValue(":month", $madateM);
$req1->execute();
$data=$req1->fetchAll();
if(count($data)==0)
{
	$message1.='';
}
else{
	$message1.='<p>Liste des marchés avec date d\'engagement tranche conditionnelle 2<p><ul>';
	foreach($data as $key => $value)
	{
		$d = $value['date_engagement_tc2'];
		$tab = explode('-',$d);
		$d = $tab[2].'/'.$tab[1].'/'.$tab[0];
		$message1.='<li>'.$value['redacteur'].' : '.$value['titre'].'. Date d\'engagement tranche conditionnelle 2 : '.$d.'. <a href="http://monlien/modifcompta.php?m='.$value['id_marche'].'">Accéder au marché</a></li>';
	}
	$message1.='</ul>';
}
//echo $message1;

$to      = "emaildestinataire@mondomaine.fr";
$subject = "Alerte marchés reconductibles et dates d'engagement";
$message = "<html><body>".$message1."</body></html>";
$headers = "From: emailexpediteur@mondomaine.fr" . "\r\n" .
		"MIME-Version: 1.0" . "\r\n".
		"X-Priority: 1 (Highest)"."\r\n".
		"X-MSMail-Priority: High"."\r\n".
		"Importance: High"."\r\n".
		"Content-type: text/html; charset=utf-8" . "\r\n".
		"Subject: Alerte marchés reconductibles et dates d'engagement" . "\r\n";
	
if($message1!='')
{
	mail($to,$subject,$message,$headers);
}

?>