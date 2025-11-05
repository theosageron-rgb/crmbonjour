<?php
include __DIR__ . '/Config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $id = intval($_POST['id']);
  
  $stmt = $conn->prepare("UPDATE taches SET statut = 'Terminée' WHERE id = ?");
  $stmt->bind_param("i", $id);
  
  if ($stmt->execute()) {
    echo "success";
  } else {
    echo "error";
  }
  
  $stmt->close();
  $conn->close();
} else {
  echo "invalid";
}
?>
