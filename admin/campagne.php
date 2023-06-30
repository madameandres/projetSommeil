<?
include "verification.php"; 
$message="";
$rows = listeCampagnes($pdo);

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
                    <th>ID campagne</th>
                    <th>Date début</th>
                    <th>Date Fin</th>
                    <th>Active ?</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['id_campagne'] . "</td>";
                    echo "<td>" . $row['date_debut'] . "</td>";
                    
                    echo "<td>" . $row['date_fin'] . "</td>";
                    echo "<td>" . $row['is_active'] . "</td>";
                    echo "<td><a href='edit_campagne.php?id=" . $row['id_campagne'] .
                     "'>Modifier</a> | <a onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ? Cela va supprimer toutes heures de sommeil de cette campagne.')\" href='delete_campagne.php?id=" . $row['id_campagne'] . "'>Supprimer</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <footer><a href="index.php">Retour</a> - <a href="edit_campagne.php">Nouvelle campagne</a></footer>
</body>

</html>