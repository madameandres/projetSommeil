<?
$message="";
include "verification.php"; 
$rows = listeUtilisateurs($pdo);

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
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Age</th>
                    <th>Genre</th>
                    <th>Internat</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nom'] . "</td>";
                    echo "<td>" . $row['prenom'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['role'] . "</td>";
                    echo "<td>" . round($row['age'],0) . " ans </td>";
                    echo "<td>" . $row['genre'] . "</td>";
                    echo "<td>" . ($row['internat']==1?"Oui":"Non"). "</td>";
                    echo "<td>" . ($row['admin']==1?"Oui":"-" ). "</td>";
                    echo "<td><a href='edit_utilisateur.php?id=" . $row['id'] . "'>Modifier</a> | <a onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')\" href='delete_utilisateur.php?id=" . $row['id'] . "'>Supprimer</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <footer><a href="index.php">Retour</a></footer>
</body>

</html>