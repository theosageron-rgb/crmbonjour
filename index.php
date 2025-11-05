<?php
session_start();

// Si l'utilisateur est déjà connecté, redirection vers le tableau de bord
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Sinon, redirection vers la page de connexion
header("Location: login.php");
exit();
