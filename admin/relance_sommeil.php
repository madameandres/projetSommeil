<?
include "verification.php";
$message = "";

//On modifie
if (isset($_GET["id"])) {

    $utilisateur = getUtilisateur($pdo, $_GET["id"]);

    $to = $utilisateur["email"];

        if($utilisateur["role"]==3){
            $subject = $utilisateur["prenom"].', ne zappe pas ton temps de sommeil !';
            $message = 'Hey '.$utilisateur["prenom"].' !<br>';
            $message .= '<br/>Oups, on dirait que t\'as zappé de saisir ton temps de sommeil aujourd\'hui. <br/>Mais no stress, on est pas là pour te sortir un "game over" ou te mettre une alerte "busted" dans la face. <br/>Par contre, on compte sur toi pour saisir ton temps de sommeil ASAP, genre dès que t\'as posé tes pieds par terre le matin.<br>';
            $message .= '<br/>Pour mettre à jour tes heures de coucher et de lever, et nous dire quelle activité t\'as mis en mode "sleepy", clique sur le lien ci-dessous :<br>';
            $message .= '<a href="https://andresjdr.000webhostapp.com/sante">https://andresjdr.000webhostapp.com/sante</a><br>';
            $message .= '<br/>Franchement, ça serait cool de ta part de jouer le jeu ! <br/>Ta contribution va nous aider à mieux piger l\'importance du sommeil et à rendre cette expérience encore plus "swag".<br>';
            $message .= '<br/>On compte sur toi, mec/miss !<br/><br/> Merci et passe une journée de ouf, plein d\'énergie et de vibes positives ! Peace !';
        }else{
            $subject = $utilisateur["prenom"].', rappel : saisissez votre temps de sommeil !';
            $message = 'Cher(e) '.$utilisateur["prenom"].',<br>';
            $message .= '<br>Nous vous rappelons l\'importance de saisir votre temps de sommeil quotidiennement.<br>';
            $message .= '<br>La collecte de ces informations nous permet de mieux comprendre vos habitudes de sommeil et d\'analyser leur impact sur votre bien-être.<br>';
            $message .= '<br>Nous vous invitons à accéder à l\'interface de saisie en cliquant sur le lien ci-dessous :<br>';
            $message .= '<a href="https://andresjdr.000webhostapp.com/sante">https://andresjdr.000webhostapp.com/sante</a><br>';
            $message .= '<br>Votre participation est essentielle pour l\'avancement de notre projet de recherche sur le sommeil.<br>';
            $message .= '<br>Nous vous remercions pour votre collaboration et restons à votre disposition pour toute question éventuelle.<br>';
            $message .= '<br>Cordialement,';
            $message .= '<br>L\'équipe du Projet Sommeil';      
        }
    

    $headers = 'From: ProjetSommeil@monlycee.edu' . "\r\n" .
        'Reply-To: noreply@monlycee.edu' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    // Envoi de l'e-mail
    $mailSent = mail($to, $subject, $message, $headers);

    // Vérification du succès de l'envoi
    if ($mailSent) {
        $message= 'E-mail envoyé avec succès.';
    } else {
        $message= 'Échec de l\'envoi de l\'e-mail.';
    }
}
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
        <?=$message?>
            <p><a href="relance.php">Retour</a></p>
        
    </div>
</body>

</html>