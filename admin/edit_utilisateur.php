<?
include "verification.php"; 
$message = "";

//On modifie
if (isset($_POST["id"])) {
    $message = updateMembre($pdo,$_POST);
    if ($message){
        disconnect($pdo);
        Header("Location:utilisateur.php");
        exit();
    }
}
//On charge les données de l'utilisateur
if (isset($_GET["id"])) {
    $row = getUtilisateur($pdo, $_GET["id"]);
    $familles = listeFamilles($pdo);
    $genres = listeGenres($pdo);
    $roles = listeRoles($pdo);
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
        <form action="edit_utilisateur.php?id=<?=$_GET["id"]?>" method="POST">
            <Label for="id">Identifiant</Label>
            <input type="text" id="id" name="id" readonly="readonly" value="<?= $row["id"] ?>">

            <Label for="famille">Nom de famille :</Label>
            <select id="famille" name="famille" placeholder="Entrer votre nom de famille" required>
                <? foreach ($familles as $famille) { ?>
                    <option value="<?= $famille["id"] ?>" <?= ($row["id_famille"] == $famille["id"] ? "selected" : "") ?>><?= $famille["nom"] ?></option>
                <? } ?>
            </select><br>
            <Label for="username">Prénom :</Label>
            <input type="text" placeholder="Entrer votre nom d'utilisateur" name="username" id="username" value="<?= $row["prenom"] ?>" required><br>
            <Label for="email">Email : </Label><input value="<?= $row["email"] ?>" type="email" placeholder="Entrer votre email" name="email" id="email" required /><br />
            <Label for="password">Mot de passe : </Label><input value="<?= $row["password"] ?>" type="password"  placeholder="Entrer le mot de passe" name="password" id="password" required /><br />
            <Label for="datenaissance">Date de naissance: </Label><input value="<?= $row["date_naissance"] ?>" type="date" name="datenaissance" id="datenaissance" required /><br /><br />
            <Label for="genre">Genre :</Label>
            <select id="genre" name="genre" placeholder="Entrer votre genre" required>
                <option value="" ?>Choisir</option>
                <? foreach ($genres as $genre) { ?>
                    <option value="<?= $genre["id"] ?>" <?= ($row["genre"] == $genre["id"] ? "selected" : "") ?>><?= $genre["libelle"] ?></option>
                <? } ?>
            </select><br>
            <Label for="role">Rôle :</Label><select required id="role" name="role" placeholder="Entrer votre rôle">
                <option value="" ?>Choisir</option>
                <? foreach ($roles as $role) { ?>
                    <option value="<?= $role["id"] ?>" <?= ($row["role"] == $role["id"] ? "selected" : "") ?>><?= $role["libelle"] ?></option>
                <? } ?>
            </select>
            <br><br>
            <fieldset>
                <legend>Dort-il à l'internat ?</legend>
                <div><input id="non" type="radio" name="internat" value="0" <?= ($row["internat"] == 0 ? "checked" : "") ?> /><label for="non">Non</label></div>
                <div><input id="oui" type="radio" name="internat" value="1" <?= ($row["internat"] == 1 ? "checked" : "") ?> /><label for="oui">Oui</label></div>
            </fieldset>
            <fieldset>
                <legend>Profil admin ?</legend>
                <div><input id="adminKO" type="radio" name="admin" value="0" <?= ($row["internat"] == 0 ? "checked" : "") ?> /><label for="adminKO">Non</label></div>
                <div><input id="adminOK" type="radio" name="admin" value="1" <?= ($row["internat"] == 1 ? "checked" : "") ?> /><label for="adminOK">Oui</label></div>
            </fieldset>
            <div class="center"><input type="submit" value="Enregister"/><br/><a href="utilisateur.php">Retour</a></div>
        </form>
    </div>
    <footer><a href="index.php">Retour à l'accueil</a></footer>
</body>

</html>