<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Plateforme de gestion des marchés publics - PNRLF</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <script type="text/javascript"  src="js/script.js"></script>
  <script type="text/javascript"  src="js/jquery-2.1.3.min.js"></script>
  <script type="text/javascript"  src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/jquery.ui.datepicker-fr.js"></script>
  <script type="text/javascript">
	var elementPattern = /^element(\d+)$/;
    var deletePattern = /^delete(\d+)$/;

	function ajouterElement()
    {
        var Conteneur = document.getElementById('conteneur');
        if(Conteneur)
        {
            Conteneur.appendChild(creerElement(dernierElement() + 1))
        }
		var nbfich = parseInt(document.getElementById('nbfichiers').getAttribute('value'));
		document.getElementById('nbfichiers').setAttribute('value',nbfich+1);
    }
	
	function dernierElement()
    {
      var Conteneur = document.getElementById('conteneur'), n = 0;
      if(Conteneur)
      {
        var elementID, elementNo;
        if(Conteneur.childNodes.length > 0)
        {
			for(var i = 0; i < Conteneur.childNodes.length; i++)
			{
				// Ici, on vérifie qu'on peut récupérer les attributs, si ce n'est pas possible, on renvoit false, sinon l'attribut
				elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
				if(elementID)
				{
					elementNo = parseInt(elementID.replace(elementPattern, '$1'));
					if(!isNaN(elementNo) && elementNo > n)
					{
						n = elementNo;
					}
				}
			}
			
			
        }
      }
      return n;
    }
	
    function creerElement(ID)
    {
		var Conteneur = document.createElement('div');
		Conteneur.setAttribute('id', 'element' + ID);
		Conteneur.setAttribute('class', 'piece');
		var Input = document.createElement('input');
		Input.setAttribute('type', 'file');
		Input.setAttribute('name', 'pieces[]');
		Input.setAttribute('id', 'pieces' + ID);
		var Delete = document.createElement('input');
		Delete.setAttribute('type', 'button');
		Delete.setAttribute('value', 'Supprimer n°' + ID + ' !');
		Delete.setAttribute('id', 'delete' + ID);
		Delete.onclick = supprimerElement;
		Conteneur.appendChild(Input);
		Conteneur.appendChild(Delete);
		return Conteneur;
    }
	function supprimerElement()
    {
		var Conteneur = document.getElementById('conteneur');
		var n = parseInt(this.id.replace(deletePattern, '$1'));
		if(Conteneur && !isNaN(n))
		{
			var elementID, elementNo;
			if(Conteneur.childNodes.length > 0)
			{
				for(var i = 0; i < Conteneur.childNodes.length; i++)
				{		
					elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
					if(elementID)
					{
						elementNo = parseInt(elementID.replace(elementPattern, '$1'));
						if(!isNaN(elementNo) && elementNo  == n)
						{
							Conteneur.removeChild(Conteneur.childNodes[i]);
							//updateElements(); // A supprimer si tu ne veux pas la màj
							
							//return;
						}
					}
				}
			}
			var nbfich = parseInt(document.getElementById('nbfichiers').getAttribute('value'));
			document.getElementById('nbfichiers').setAttribute('value',nbfich-1);
		}  
		
    }

	function updateElements()
    {
		var Conteneur = document.getElementById('conteneur'), n = 0;
		if(Conteneur)
		{
			var elementID, elementNo;
			if(Conteneur.childNodes.length > 0)
			{
				for(var i = 0; i < Conteneur.childNodes.length; i++)
				{
					elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
					if(elementID)
					{
						elementNo = parseInt(elementID.replace(elementPattern, '$1'));
						if(!isNaN(elementNo))
						{
							n++
							Conteneur.childNodes[i].setAttribute('id', 'element' + n);
							document.getElementById('pieces' + elementNo).setAttribute('id', 'pieces' + n);
							document.getElementById('delete' + elementNo).setAttribute('id', 'delete' + n);
						}
					}
				}
			}	
		}
    }

	function supprimerfichier(numfich)
	{
		document.getElementById('fic_'+numfich).remove();
	}
	function supprimerfichierp(numfich)
	{
		document.getElementById('ficp_'+numfich).remove();
	}
	function supprimerfichieroffres(numfich)
	{
		document.getElementById('fico_'+numfich).remove();
	}


	</script>
</head>
<body>
	<header>
		<div class="header">
			<h1><a href="index.php">Plateforme de gestion des marchés publics du Parc naturel régional Livradois-Forez</a></h1>
			<div id="monsvg"><img src="css/logo.svg" width="100%"/></div>
		</div>
	</header>
