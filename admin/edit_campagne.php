<?
include "verification.php"; 
$message = "";

//On modifie
if (isset($_POST["date_debut"])) {
    $message = updateCampagne($pdo, $_POST);
    if ($message) {
        disconnect($pdo);
        Header("Location:campagne.php");
        exit();
    }
}

if (isset($_GET["id"])) {
    $campagne = getCampagneById($pdo, $_GET["id"]);
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
        <form action="edit_campagne.php?id=<?= (isset($_GET["id"]))?$_GET["id"]:""?>" method="POST">
            <Label for="id">Identifiant</Label>
            <input type="text" id="id_campagne" name="id_campagne" readonly="readonly" value="<?= (isset($_GET["id"]))?$_GET["id"]:""?>">

            <label for="date_debut">Date début </label><input type="date" name="date_debut" id="date_debut" value="<?=$campagne["date_debut"]?>" /><br />
			<label for="date_fin">Date fin</label><input type="date" name="date_fin" id="date_fin" value="<?= $campagne["date_fin"]?>" />   <br/>   
            <div class="center"><input type="submit" value="Enregister" /><br /><a href="campagne.php">Retour</a></div>
        </form>
    </div>
    <footer><a href="index.php">Retour à l'accueil</a></footer>
</body>

</html>