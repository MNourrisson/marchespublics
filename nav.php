<nav id="nav" class="clear">
	<ul>
		<li <?php if($current=='ajoutcommun') echo 'class="current"';?>><a href="ajoutcommun.php">Ajouter un marché</a></li>
		<li <?php if($current=='modifcommun') echo 'class="current"';?>><a href="recherchecommun.php">Formulaires à compléter</a></li>
		<li <?php if($current=='documents') echo 'class="current"';?>><a href="recherche.php">Documents finaux</a></li>
		<li <?php if($current=='modifcompta') echo 'class="current"';?>><a href="recherchecompta.php">Suivi Compta</a></li>
		<li <?php if($current=='recap') echo 'class="current"';?>><a href="recap.php">Récapitulatif</a></li>
	</ul>
</nav>
