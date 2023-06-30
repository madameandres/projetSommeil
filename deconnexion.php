<?
session_start();
$_SESSION = [];
unset($_SESSION);
header("Location:connexion.php?".$_SERVER["QUERY_STRING"]);?>
