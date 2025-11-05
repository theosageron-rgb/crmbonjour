<?php
$host = "localhost";
$user = "root";
$pass = ""; // mot de passe vide par défaut sous XAMPP
$db   = "bonjourcrm"; // ✅ ton vrai nom de base

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

define('APP_NAME', 'Ordex CRM');
?>

