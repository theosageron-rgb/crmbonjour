<?php
include __DIR__ . '/Config/config.php';

$id = intval($_POST['id']);
$statut = $conn->real_escape_string($_POST['statut']);

if ($id > 0 && !empty($statut)) {
  $conn->query("UPDATE fiches SET statut='$statut' WHERE id=$id");
  echo "success";
} else {
  echo "error";
}
?>
