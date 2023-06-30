<?
include "verification.php";
$dureeSommeil = calculSommeil($pdo, $_SESSION["id"], "Jour ".noJour($pdo));
disconnect($pdo);

?>
<!DOCTYPE html>
<html>

<head>
	<title>Projet Sommeil - Statistiques</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css?v=<?=rand()?>" media="screen" type="text/css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Pacifico&display=swap" rel="stylesheet">

</head>

<body>
	<header>Projet Sommeil</header>
	<div id="container">
		<p>Votre sommeil a été enregistré</p>
		<p>
			<? foreach ($dureeSommeil as $jour){?>
		<?=$jour["jour"]?> : Vous avez dormi <?= $jour["duree"] ?><br/>
		<?}?>
		</p>
		<p><a href="deconnexion.php">Se déconnecter</a></p>
	</div>
	<footer>
		<p>Copyright 2023 - Tous droits réservés <br><a href="cgu.html">Mentions légales - CGU - Nous contacter</a></p>
	</footer>
</body>

</html>