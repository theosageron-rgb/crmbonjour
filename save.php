<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/Config/config.php'; // Connexion à la base

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 🔹 Récupération et nettoyage des champs
    $nom        = trim($_POST['nom'] ?? '');
    $prenom     = trim($_POST['prenom'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $telephone  = trim($_POST['telephone'] ?? '');
    $profession = trim($_POST['profession'] ?? '');
    $societe    = trim($_POST['societe'] ?? '');
    $statut     = trim($_POST['statut'] ?? 'Prospect');
    $origine    = trim($_POST['origine'] ?? '');
    $notes      = trim($_POST['notes'] ?? '');

    // 🔹 Vérifie que les champs obligatoires sont remplis
    if (empty($nom) || empty($prenom) || empty($email)) {
        die("⚠️ Erreur : les champs nom, prénom et email sont obligatoires.");
    }

    // 🔹 Normalise le statut pour correspondre à ton ENUM SQL
    // (évite l'erreur "Data truncated for column 'statut'")
    $statut = ucfirst(strtolower($statut)); // ex: "prospect" → "Prospect"
    $valeurs_valides = ['Prospect', 'En cours', 'Gagné', 'Perdu'];
    if (!in_array($statut, $valeurs_valides)) {
        $statut = 'Prospect';
    }

    // 🔹 Vérifie les colonnes présentes dans la table "fiches"
    $columns_result = $conn->query("SHOW COLUMNS FROM fiches");
    $columns = [];
    while ($col = $columns_result->fetch_assoc()) {
        $columns[] = $col['Field'];
    }

    // 🔹 Colonnes et valeurs à insérer
    $fields = ['prenom', 'nom', 'email', 'profession', 'statut'];
    $placeholders = ['?', '?', '?', '?', '?'];
    $types = 'sssss';
    $values = [$prenom, $nom, $email, $profession, $statut];

    // Champs optionnels selon la table
    if (in_array('telephone', $columns)) {
        $fields[] = 'telephone';
        $placeholders[] = '?';
        $types .= 's';
        $values[] = $telephone;
    }

    if (in_array('societe', $columns)) {
        $fields[] = 'societe';
        $placeholders[] = '?';
        $types .= 's';
        $values[] = $societe;
    }

    if (in_array('origine', $columns)) {
        $fields[] = 'origine';
        $placeholders[] = '?';
        $types .= 's';
        $values[] = $origine;
    }

    if (in_array('notes', $columns)) {
        $fields[] = 'notes';
        $placeholders[] = '?';
        $types .= 's';
        $values[] = $notes;
    }

    // 🔹 Requête SQL d'insertion
    $sql = "INSERT INTO fiches (" . implode(', ', $fields) . ", date_creation)
            VALUES (" . implode(', ', $placeholders) . ", NOW())";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("❌ Erreur SQL : " . $conn->error);
    }

    // Liaison des paramètres
    $stmt->bind_param($types, ...$values);

    // 🔹 Exécution et redirection
    if ($stmt->execute()) {
        header("Location: list.php?success=1");
        exit;
    } else {
        echo "❌ Erreur lors de l'enregistrement : " . htmlspecialchars($stmt->error);
    }

    $stmt->close();

} else {
    echo "⚠️ Aucun formulaire soumis.";
}
?>

