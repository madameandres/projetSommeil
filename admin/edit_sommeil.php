<?
include "verification.php"; 
$message = "";
$nbJours=0;

//On modifie
if (isset($_POST["coucher"])) {
    $message = updateSommeil($pdo,$_POST);
    if ($message){
        disconnect($pdo);
        Header("Location:sommeil.php");
        exit();
    }
}
//On charge les données de l'utilisateur
if (isset($_GET["id"])) {
    $row = getSommeil($pdo, $_GET["id"]);
    $membres = listeUtilisateurs($pdo);
    $activites = listeActivites($pdo);
    $campagnes = listeCampagnes($pdo);
    $nbJours = nbJours($pdo, $row["id_campagne"]);
}

disconnect($pdo);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Projet Sommeil - Administration</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css" media="screen" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Pacifico&display=swap" rel="stylesheet">
</head>

<body>
    <header>Projet Sommeil</header>
    <div id="container">
        <p><?= $message ?></p>
        <form action="edit_sommeil.php?id=<?= $_GET["id"] ?>" method="POST">
        <label for="id_sommeil">ID Sommeil</label><input readonly="readonly" type="text" name="id_sommeil" id="id_sommeil" value="<?= $row["id_sommeil"];?>" /><br /><br />
        <label for="campagne">Campagne</label>
            <select  name="campagne" id="campagne" required>
                <? foreach($campagnes as $campagne){ ?>
                <option value="<?=$campagne["id_campagne"]?>" <?=($campagne["id_campagne"]==$row["id_campagne"])?"selected=selected":""?>><?="du ".$campagne["date_debut"]." au ".$campagne["date_fin"]?></option>
                <?}?>
            </select><br /><br />
            
            <label for="nom">Nom prénom</label><select name="id_utilisateur" id="id_utilisateur" required>
				<? foreach ($membres as $membre) { ?>
					<option value="<?= $membre["id"] ?>" <?=($membre["id"]==$row["id_utilisateur"]?"selected":"")?>><?= $membre["nom"]." ".$membre["prenom"] ?></option>
				<? } ?>
			</select><br /><br />
            
            <label for="jour">Nuit</label>
            <select  name="jour" id="jour" required>
                <? for($i=1; $i<$nbJours+1; $i++){ ?>
                <option value="Nuit <?=$i?>" <?=("Nuit ".$i==$row["jour"])?"selected=selected":""?>>Nuit <?=$i?></option>
                <?}?>
            </select><br /><br />
			
            <label for="coucher">Heure du coucher</label><input type="datetime-local" name="coucher" id="coucher" value="<?= $row["coucher"]?>" /><br /><br />
			<label for="endormi">Heure de l'endormissement </label><input type="datetime-local" name="endormi" id="endormi" value="<?= $row["endormissement"];?>" /><br /><br />
			<label for="lever">Heure du lever</label><input type="datetime-local" name="lever" id="lever" value="<?= $row["lever"];
																														?>" /><br /><br />
			<label for="activite">Dernière activité avant le coucher</label><select name="activite" id="activite" required>
				<? foreach ($activites as $activite) { ?>
					<option value="<?= $activite["id"] ?>" <?=($activite["id"]==$row["activite"]?"selected=selected":"")?>><?= $activite["libelle"]?></option>
				<? } ?>
			</select><br /><br />
			<label for="fatigue">Fatigue au réveil</label><input type="range" id="fatigue" name="fatigue" min="1" max="10" value="<?=$row["fatigue"]?>" required><br><br /><br />
			
            <div class="center"><input type="submit" value="Enregister"/><br/><a href="sommeil.php">Retour</a></div>
        </form>
    </div>
    <footer><a href="index.php">Retour à l'accueil</a></footer>
</body>

</html>