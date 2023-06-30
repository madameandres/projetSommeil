<?
include "verification.php"; 
$message = "";

//On modifie
if (isset($_GET["id"])) {
    $message = deleteSommeil($pdo,$_GET["id"]);
        disconnect($pdo);
        Header("Location:sommeil.php");
        exit();
    }
?>