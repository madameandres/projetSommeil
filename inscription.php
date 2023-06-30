<?
session_start();
if (isset($_SESSION["id"])) {
	header("Location:deconnexion.php");
}
include "bdd.php";

$message = "";
$pdo = connect();
$familles = listeFamilles($pdo);
$genres = listeGenres($pdo);
$roles = listeRoles($pdo);

if (isset($_POST["famille"])) {
	$message = insertMembre($pdo, $_POST);
	$_SESSION["id"] = $pdo->lastInsertId();
	$_SESSION["prenom"] = $_POST["username"];
	disconnect($pdo);
	header("Location:saisie.php");
}

disconnect($pdo);
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

	<script>
		function openPopup() {
			// Définition des options de la fenêtre pop-up
			var popupOptions = "width=800,height=600,scrollbars=yes,resizable=yes";

			// Ouvrir la fenêtre pop-up avec le contenu des CGU
			window.open("cgu.html", "popupCGU", popupOptions);
		}
	</script>
</head>

<body>
	<header>Projet Sommeil</header>
	<div id="container">
		<p><?= $message ?></p>
		<form action="inscription.php" method="POST" name="formulaire">
			<Label for="famille">Votre nom :</Label>
			<input list="autocompletion_famille" id="famille" name="famille" placeholder="Entrer votre nom de famille" required>
			<datalist id="autocompletion_famille">
				<? foreach ($familles as $famille) { ?>
					<option name="<?= $famille["id"] ?>"><?= $famille["nom"] ?></option>
				<? } ?>
			</datalist><br>
			<Label for="username">Votre prénom :</Label>
			<input type="text" placeholder="Entrer votre prénom" name="username" id="username" required><br>
			<Label for="email">Email : </Label><input type="email" placeholder="Entrer votre email" name="email" id="email" required /><br /><br />
			<Label for="password">Mot de passe : </Label><input type="password"  placeholder="Entrer le mot de passe" name="password" id="password" required /><br/><span class="surligne">Le mot de passe doit contenir au moins 8 caractères, dont une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.</span><br /><br />
			<Label for="datenaissance">Date de naissance: </Label><input type="date" name="datenaissance" id="datenaissance" required /><br /><br />
			<Label for="genre">Votre Genre :</Label>
			<select id="genre" name="genre" placeholder="Entrer votre genre" required>
				<option value="" ?>Choisir</option>
				<? foreach ($genres as $genre) { ?>
					<option value="<?= $genre["id"] ?>"><?= $genre["libelle"] ?></option>
				<? } ?>
			</select><br>
			<Label for="role">Votre Rôle :</Label><select required id="role" name="role" placeholder="Entrer votre rôle">
				<option value="" ?>Choisir</option>
				<? foreach ($roles as $role) { ?>
					<option value="<?= $role["id"] ?>"><?= $role["libelle"] ?></option>
				<? } ?>
			</select>
			<br><br>
			<fieldset>
				<legend>Dormez-vous à l'internat ?</legend>
				<div><input id="non" type="radio" name="internat" value="0" checked /><label for="non">Non</label></div>
				<div><input id="oui" type="radio" name="internat" value="1" /><label for="oui">Oui</label></div>
			</fieldset>
			<input required type="checkbox" value="cgu" value="0" id="cgu" /> En validant mon inscription, j'accepte les <a href="javascript:void(0);" onclick="openPopup();">conditions générales d'utilisation du site</a> <br /><br />
			<div class="center"><input type="reset" value="Effacer" /> <input type="submit" value="S'inscrire" /></div>
		</form>
	</div>
	<footer>
		<p>Copyright 2023 - Tous droits réservés <br><a href="connexion.php">Se connecter</a> <a href="cgu.html">Mentions légales - CGU - Nous contacter</a></p>
	</footer>
</body>

</html>