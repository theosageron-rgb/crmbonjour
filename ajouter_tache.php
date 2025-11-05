<?php
include __DIR__ . '/Config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fiche_id = intval($_POST['fiche_id']);
  $titre = trim($_POST['titre']);
  $description = trim($_POST['description']);
  $date_echeance = $_POST['date_echeance'] ?: null;

  if ($titre !== '') {
    $stmt = $conn->prepare("INSERT INTO taches (fiche_id, titre, description, date_echeance) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $fiche_id, $titre, $description, $date_echeance);
    $stmt->execute();
  }
  header("Location: fiche.php?id=$fiche_id");
  exit;
}
?>
