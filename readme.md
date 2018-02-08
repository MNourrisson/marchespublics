Nom du projet : Marchés publics

Auteur : Mélanie Nourrisson - Parc naturel régional Livradois-Forez

Description du projet :
Gestion interne des marchés publics. A partir des informations fournies par l'initiateur du marché, les pièces du marchés sont générées automatiquement en fonction du montant du marché. Cela permet ainsi d'avoir les fichiers réglementaires à jour plus facilement et au même endroit pour tout le monde.
Un suivi comptable est aussi réalisé avec un envoi d'email pour les rappels. L'accès à la partie comptable nécessite un mot de passe.

Installation :
Utiliser le script fourni pour créer la base de données (sql/structure_marchespublics.sql)
Ajouter les emails dans ajoutcommun.php, cron.php
Modifier les liens dans cron.php, recap.php
Programmer la tache cron qui vérifie les marchés et envoi un email de rappel
Compléter le fichier de connexion avec vos identifiants (classes/connect.php)
Créer directement en base un utilisateur, utilisé sha1 pour crypter le mot de passe. Attention, en cas d'utilisation sur un réseau non interne, prévoir une modification pour la sécurité du mot de passe.

Créer les fichiers modèles :
Les fichiers modèles doivent être des fichiers XML. Pour les construire, vous pouvez partir de vos fichiers Word ou Open Office et d'insérer aux endroits souhaités les codes ci-dessous. Une fois, les modifications apportées, il faut enregistrer le document en format Microsoft Word 2003 XML, dans le dossier modeles. Vous y trouverez le fichier ccap.xml qui est un exemple. 
Pour vérifier si le fichier xml est bien construit, vous pouvez visualiser le "code xml" de votre fichier en l'ouvrant avec le bloc-note ou un navigateur et faites une recherche sur les codes qui vous avez intégrés. Si vous ne les trouvez pas, c'est qu'il y eu un soucis. 
Par exemple si vous trouvez quelque chose comme <w:t>@TITRE</w:t><w:t>_MARCHE@</w:t>, il faut le remplacer par <w:t>@TITRE_MARCHE@</w:t>. Il faut que le code soit en un seul bloc.

Liste des codes :
@TITRE_MARCHE@ : titre du marché
@DATE_MARCHE@ : la date du marché au format française dd/mm/aaaa
@REDACTEUR_MARCHE@ : rédacteur du marché
@PUB_MARCHE@ : la pub du marché en fonction du montant
@TYPE_MARCHE@ : type de marché

Utilisation :
Au moment de la rédaction, on inscrit le marché via le formulaire "Ajouter un marché". Une fois enregistrer, les documents du marché vont être générés en fonction du montant choisi. Ces documents sont servir à la rédaction du marché. 

Licence : GNU General Public License v3.0

Liste des dépendances : PHPExcel, google font Abeezee

Langages : HTML, CSS, PHP, jQuery
