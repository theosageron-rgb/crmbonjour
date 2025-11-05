<?php
session_start();
include __DIR__ . '/Config/config.php'; // Connexion à la base

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            // Vérifie le mot de passe haché
            if (password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['user_email'] = $user['email'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Utilisateur non trouvé.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion — Ordex CRM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(180deg,#0b1020 0%,#0f172a 70%,#0b1020 100%);
      color: #e5e7eb;
      font-family: 'Inter', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .login-box {
      background: rgba(255,255,255,.05);
      border: 1px solid rgba(255,255,255,.08);
      box-shadow: 0 10px 30px rgba(0,0,0,.3);
      border-radius: 16px;
      padding: 2.5rem;
      width: 100%;
      max-width: 400px;
    }
    .login-box h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      font-weight: 700;
      color: #fff;
    }
    .form-control {
      background: rgba(255,255,255,.08);
      border: none;
      color: #fff;
    }
    .form-control:focus {
      background: rgba(255,255,255,.1);
      color: #fff;
      box-shadow: 0 0 0 0.25rem rgba(59,130,246,.25);
    }
    .btn-primary {
      background: linear-gradient(135deg,#1d4ed8,#0ea5e9);
      border: none;
      font-weight: 600;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg,#2563eb,#0284c7);
    }
    .error {
      background: rgba(239,68,68,.15);
      border: 1px solid rgba(239,68,68,.35);
      color: #fecaca;
      border-radius: 10px;
      padding: 10px;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h2>Connexion à <span style="color:#60a5fa;">Ordex CRM</span></h2>
    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Adresse email</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100 mt-3">Se connecter</button>
    </form>
  </div>

</body>
</html>

