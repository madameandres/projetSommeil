<?
include "verification.php"; 
$rows = quiquimanque($pdo);
$message="";

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
                    <th>Jour</th>
                    <th>ID sommeil</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Sommeil</a></th>
                    <th>Fatigue</th>
                    <th>Activite</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['jour'] . "</td>";
                    echo "<td>" . $row['id_sommeil'] . "</td>";
                    
                    echo "<td>" . $row['nom'] . "</td>";
                    echo "<td>" . $row['prenom'] . "</td>";
                    echo "<td>" . $row['temps_sommeil'] . "</td>";
                    echo "<td>" . $row['fatigue'] . "</td>";
                    echo "<td>" . $row['activite'] . "</td>";
                    echo "<td><a onclick=\"return confirm('Êtes-vous sûr de vouloir relancer cet utilisateur ?')\" href='relance_sommeil.php?id=" . $row['id'] . "'>Relancer</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <footer><a href="index.php">Retour</a></footer>
</body>

</html>