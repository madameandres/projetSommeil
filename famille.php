<?
include "verification.php";

$message = "";
if (isset($_POST["famille"])) {

	$pdo = connect();
	if (insertFamille($pdo, $_POST["famille"])) {
		$message = "Famille " . $pdo->lastInsertId() . " créée";
	} else {
		$message = "Erreur lors de la création de la famille";
	}
	disconnect($pdo);
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Projet Sommeil - Création d'une famille</title>
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
		<h1>Création d'une famille</h1>
		<p><?= $message ?></p>
		<form action="famille.php" method="POST" name="formulaire">
			<input type="text" placeholder="Entrer le nom de la Famille" name="famille" id="famille" required /><br /><br />
			<input type="reset" value="Effacer" /> <input type="submit" value='Créer' />
	</div>
	<footer>
		<p>Copyright 2023 - Tous droits réservés <br><a href="cgu.html">Mentions légales - CGU - Nous contacter</a></p>
	</footer>
</body>

</html>