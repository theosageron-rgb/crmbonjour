<?php
include __DIR__ . '/Config/config.php';

$fiche_id = intval($_POST['fiche_id']);
$contenu = trim($_POST['contenu']);

if (!empty($contenu)) {
  $stmt = $conn->prepare("INSERT INTO notes (fiche_id, contenu, date_creation) VALUES (?, ?, NOW())");
  $stmt->bind_param("is", $fiche_id, $contenu);
  $stmt->execute();
}

header("Location: fiche.php?id=$fiche_id");
exit;
?>

