<?php
require_once '../config/DataBase.php';
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['admin'])) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['success' => false, 'message' => 'Accès refusé']);
    exit;
}

// Vérifier l'ID reçu
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'message' => 'ID invalide']);
    exit;
}

$id = (int)$_POST['id'];

try {
    $stmt = $conn->prepare("UPDATE rendezvous SET statut = 'archive' WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    echo json_encode(['success' => true, 'message' => 'Rendez-vous archivé']);
} catch (PDOException $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['success' => false, 'message' => 'Erreur de base de données']);
}
?>