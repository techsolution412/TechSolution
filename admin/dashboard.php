<?php
require_once '../config/DataBase.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: acces.php");
    exit;
}
// var_dump($_SESSION);
$stmt = $conn->query("SELECT * FROM rendezvous ORDER BY date DESC, heure DESC");
$stmt = $conn->query("SELECT nom, email, telephone FROM rendezvous");
$log = $conn ->query("SELECT * FROM connexions_admin ORDER BY date_connexion DESC");
$acces_log = $log ->fetchAll(PDO::FETCH_ASSOC);
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rendezvous = $stmt->fetchAll(PDO::FETCH_ASSOC);


// var_dump($acces_log);
// var_dump($clients);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin - Rendez-vous</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 0 10px #ccc;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #0a0a23;
      color: white;
    }
    h2 {
      text-align: center;
      color: #0a0a23;
    }
  </style>
</head>
<body>
<h4>
    <?php
    if (isset($_SESSION['admin'])) {
        echo "Vous etes connecte : " . htmlspecialchars($_SESSION['admin']);
    } else {
        echo "Aucun administrateur connecte.";
    }
    ?>
</h4>

<h2>Liste des rendez-vous - TechSolutions</h2>
<!-- gere la deconnection de l'admin -->

<form action="logout.php" method="post" style="display:inline;">
    <button type="submit" class="btn btn-danger">Deconnexion</button>
</form>

<table>
  <thead>
    <tr>
      <th>Nom</th>
      <th>Email</th>
      <th>Téléphone</th>
      <th>Date</th>
      <th>Heure</th>
      <th>Service</th>
      <th>Message</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rendezvous as $rdv): ?>
      <tr>
        <td><?= htmlspecialchars($rdv['nom']) ?></td>
        <td><?= htmlspecialchars($rdv['email']) ?></td>
        <td><?= htmlspecialchars($rdv['telephone']) ?></td>
        <td><?= $rdv['date'] ?></td>
        <td><?= $rdv['heure'] ?></td>
        <td><?= htmlspecialchars($rdv['service']) ?></td>
        <td><?= nl2br(htmlspecialchars($rdv['message'])) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<hr>
<hr>
<hr>
<h3> Liste des clients</h3>
<table>
  <thead>
    <tr>
      <th>Nom</th>
      <th>Email</th>
      <th>Téléphone</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($clients as $client): ?>
      <tr>
        <td><?= htmlspecialchars($client['nom']) ?></td>
        <td><?= htmlspecialchars($client['email']) ?></td>
        <td><?= htmlspecialchars($client['telephone']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>


</body>
</html>
