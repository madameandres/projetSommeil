<?
include "verification.php";

$activites = listeActivites($pdo);;
$nbJours = nbJours($pdo);
$jourDuJour = noJour($pdo);

if (isset($_POST["coucher"])) {
	$message = insertsommeil($pdo, $_POST);
	if ($message) {
		disconnect($pdo);
		Header("Location: stats.php");
	}
}
disconnect($pdo);

$message = "";
?>
<!DOCTYPE html>
<html>

<head>
	<title>Projet Sommeil - Saisie du sommeil</title>
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
		<p>Bonjour <?= $_SESSION["prenom"] ?>, vous pouvez enregistrer vos heures de sommeil</p>
		<p><?= $message ?></p>
		<form action="saisie.php" method="POST" name="formulaire">
			<label for="jour">Jour</label>
			<select name="jour" id="jour">
				<? for ($i = 1; $i < $nbJours + 1; $i++) { ?>
					<option value="Nuit <?= $i ?>" <?= ($i == $jourDuJour) ? "selected=selected" : "" ?>>Nuit <?= $i ?></option>
				<? } ?>
			</select><br /><br />

			<label for="coucher">Heure du coucher</label><br /><input type="datetime-local" name="coucher" id="coucher" value="<?= date_format(new DateTime('yesterday'), 'Y-m-d\TH:i');
																																?>" /><br /><br />
			<label for="endormi">Heure de l'endormissement </label><br /><input type="datetime-local" name="endormi" id="endormi" value="<?= date_format(new DateTime('yesterday'), 'Y-m-d\TH:i');
																																			?>" /><br /><br />
			<label for="lever">Heure du lever</label><br /><input type="datetime-local" name="lever" id="lever" value="<?= date_format(new DateTime('now'), 'Y-m-d\TH:i');
																														?>" /><br /><br />
			<label for="activite">Dernière activité avant le coucher</label><br /><select name="activite" id="activite" required>
				<option value="" disabled selected>Choisir</option>
				<? foreach ($activites as $activite) { ?>
					<option value="<?= $activite["id"] ?>"><?= $activite["libelle"] ?></option>
				<? } ?>
			</select><br /><br />
			<label for="fatigue">Fatigue au réveil</label><br /><input type="range" id="fatigue" name="fatigue" min="1" max="10" value="5" required><br><br /><br />
			<input type="hidden" name="id" id="id" value="<?= $_SESSION["id"] ?>" />
			<p class="center"><input type="reset" value="Annuler" /> <input type="submit" value='Créer' /></p>
			<p class="center"><a href="deconnexion.php">Se déconnecter</a></p>
	</div>
</body>

</html>