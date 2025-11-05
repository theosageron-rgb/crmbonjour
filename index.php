<?php
ob_start(); // évite les erreurs d'en-têtes
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();

// ---------------------------------------------------------
// 1️⃣ Chargement de la configuration globale
// ---------------------------------------------------------
require_once __DIR__ . '/Config/config.php';

// ---------------------------------------------------------
// 2️⃣ Détermination de la page demandée
// ---------------------------------------------------------
$page = $_GET['page'] ?? 'dashboard'; // page par défaut

// ---------------------------------------------------------
// 3️⃣ Gestion des pages publiques / protégées
// ---------------------------------------------------------
$public_pages = ['login', 'register']; // accessibles sans être connecté

// Si l'utilisateur n'est pas connecté et que la page n'est pas publique :
if (!isset($_SESSION['user_id']) && !in_array($page, $public_pages)) {
    header("Location: index.php?page=login");
    exit();
}

// ---------------------------------------------------------
// 4️⃣ Détermination du contrôleur à charger
// ---------------------------------------------------------
$controllerName = ucfirst($page) . 'Controller';
$controllerPath = __DIR__ . "/Controllers/{$controllerName}.php";

// ---------------------------------------------------------
// 5️⃣ Vérification et exécution du contrôleur
// ---------------------------------------------------------
if (file_exists($controllerPath)) {
    require_once $controllerPath;

    if (class_exists($controllerName)) {
        $controller = new $controllerName();

        // Vérifie que la méthode "index" existe
        if (method_exists($controller, 'index')) {
            $controller->index();
        } else {
            echo "Erreur : la méthode 'index()' est manquante dans $controllerName.";
        }

    } else {
        echo "Erreur : la classe $controllerName n'existe pas dans le fichier.";
    }

} else {
    // Page introuvable : message clair + lien retour
    http_response_code(404);
    echo "<h1>Erreur 404</h1>";
    echo "<p>Le contrôleur <strong>$controllerName</strong> est introuvable.</p>";
    echo "<p><a href='index.php?page=dashboard'>Retour au tableau de bord</a></p>";
}


