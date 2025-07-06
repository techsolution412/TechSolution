<?php
session_start();
require_once '../config/DataBase.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['pseudo'];
    $motDePasse = $_POST['mot_de_passe'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE pseudo = :pseudo");
    $stmt->execute([':pseudo' => $email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($motDePasse, $admin['mot_de_passe'])) {
        $_SESSION['admin'] = $admin['pseudo'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Identifiants invalides.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion Admin</title>
  <style>
    body {
      background-color: #f4f4f4;
      font-family: Arial, sans-serif;
      display: flex;
      height: 100vh;
      justify-content: center;
      align-items: center;
      margin: 0;
    }

    .login-container {
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    .login-container form {
      display: flex;
      flex-direction: column;
    }

    .login-container input {
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    .login-container button {
      padding: 12px;
      background-color: #3498db;
      color: white;
      border: none;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-container button:hover {
      background-color: #2980b9;
    }

    .error-message {
      color: red;
      text-align: center;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h2>Connexion Administrateur</h2>

    <?php if ($error): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <input type="text" name="pseudo" placeholder="Pseudo admin" required>
      <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
      <button type="submit">Connexion</button>
    </form>
  </div>

</body>
</html>
