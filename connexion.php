<?
session_start();

include "bdd.php";

if (isset($_GET["erreur"])) {
	switch ($_GET["erreur"]) {
		case "1":
			$message = "Votre session a expiré. Veuillez vous reconnecter";
			break;
		case "2":
			$message = "Aucune campagne en cours. Veuillez réessayer plus tard";
			break;
		case "3":
			$message = "Vous n'avez pas les autorisations nécessaires";
			break;
		default:
			$message = "Une erreur est survenue";
			break;
	}
} else {
	$message = "";
}
if (isset($_SESSION["id"])) {
	header("Location:saisie.php");
}

if (isset($_POST["email"])) {
	$pdo = connect();
	if (seConnecter($pdo, $_POST)) {
		if(accesAdmin($pdo, $_SESSION["id"])==1){
			disconnect($pdo);
			Header("Location: ./admin/index.php");
		}else{
			disconnect($pdo);
			Header("Location: saisie.php");
		}
	} else {
		$message = "Erreur dans l'email ou le mot de passe";
	}
	disconnect($pdo);
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Projet Sommeil - Identification requise</title>
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
		<p><?= $message ?></p>
		<form action="connexion.php" method="POST">
			<Label for="email">Votre email :</Label> <input type="email" placeholder="Entrer votre email" name="email" id="email" required><br> <Label for="password">Mot de passe : </Label><input type="password" placeholder="Entrer le mot de passe" name="password" id="password" required /><br /><br />
			<div class="center"><input type="reset" value="Effacer" /> <input type="submit" value="Se connecter" /></div>

			<p class="center"><a href="inscription.php">S'inscrire</a></p>
	</div>
	<footer>
		<p>Copyright 2023 - Tous droits réservés <br><a href="cgu.html">Mentions légales - CGU - Nous contacter</a></p>
	</footer>
</body>

</html>