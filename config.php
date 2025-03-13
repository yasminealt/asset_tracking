<?php
$host = "localhost";
$db = "asset_tracking";
$user = "root";
$password = ""; // Par défaut, MySQL n'a pas de mot de passe

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>

