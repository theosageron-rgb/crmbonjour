<?php
$password = 'admin1234';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h2 style='font-family:monospace;'>Hash généré pour le mot de passe <strong>$password</strong> :</h2>";
echo "<pre style='font-size:16px; color:#2563eb;'>$hash</pre>";
