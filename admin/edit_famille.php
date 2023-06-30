<?
include "verification.php"; 
$message = "";

//On modifie
if (isset($_POST["id"])) {
    $message = updateFamille($pdo, $_POST);
    if ($message) {
        disconnect($pdo);
        Header("Location:famille.php");
        exit();
    }
}

if (isset($_GET["id"])) {
    $famille = getFamilleById($pdo, $_GET["id"]);
    $membres = getMembres($pdo, $_GET["id"]);
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
        <form action="edit_famille.php?id=<?= $_GET["id"] ?>" method="POST">
            <Label for="id">Identifiant</Label>
            <input type="text" id="id" name="id" readonly="readonly" value="<?= $_GET["id"] ?>">

            <Label for="famille">Nom de famille :</Label>
            <input type="text" id="nom" name="nom" placeholder="Entrer votre nom de famille" required value="<?= $famille["nom"] ?>">

            <table>
                <tr>
                    <th>Prénom</th>
                    <th>Genre</th>
                    <th>Statut</th>
                    <th>Age</th>
                </tr>
                <? foreach ($membres as $membre) {
                    echo "<tr><td>".$membre['prenom']."</td>
                    <td>".$membre['genrenom']."</td>
                    <td>".$membre['rolenom']."</td>
                    <td>".$membre['age']."</td>
                    <td><a href='edit_utilisateur.php?id=" . $membre['id'] . "'>Modifier</a></td>
                    </tr>";
                }
                ?>
            </table>
            <br/>   
            <div class="center"><input type="submit" value="Enregister" /><br /><a href="famille.php">Retour</a></div>
        </form>
    </div>
    <footer><a href="index.php">Retour à l'accueil</a></footer>
</body>

</html>