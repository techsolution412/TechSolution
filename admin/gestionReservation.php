<?php 
require_once '../config/DataBase.php';
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if (!isset($_SESSION['admin'])) {
    header("Location: acces.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM rendezvous  WHERE date = CURDATE() AND statut != 'archive' ");
$rendezvousEnCours = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT * FROM rendezvous  WHERE date >= CURDATE() AND statut != 'archive'");
$rendezvousAvenir = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT * FROM rendezvous WHERE date < CURDATE() AND statut = 'en attente' ");
$rendezvousEnRetard = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Définition du statut comme constante
// define('STATUT_EN_RETARD', 'en retard');
    
// Récupération des IDs des rendez-vous en retard
// $tableauId = array_column($rendezvousEnRetard, 'id');

// if (!empty($tableauId)) {
//     try {
//         // Début de la transaction
//         $conn->beginTransaction();
        
//         // Création des placeholders (?,?,...)
//         $placeholders = implode(',', array_fill(0, count($tableauId), '?'));
        
//         // Préparation de la requête
//         $stmt = $conn->prepare("UPDATE rendezvous SET statut = :statut WHERE id IN ($placeholders)");
        
//         // Ajout du statut comme premier paramètre puis les IDs
//         $params = array_merge([STATUT_EN_RETARD], $tableauId);
        
//         // Exécution avec les paramètres
//         $stmt->execute($params);
        
//         // Validation de la transaction
//         $conn->commit();
        
//         // echo count($tableauId) . " rendez-vous marqués comme en retard avec succès.";
        
//     } catch (PDOException $e) {
//         // Annulation en cas d'erreur
//         $conn->rollBack();
//         error_log("Erreur lors de la mise à jour des rendez-vous: " . $e->getMessage());
//         throw $e; // Ou gestion d'erreur alternative
//     }
// }


function mettreAJourStatut($tableau, $nomConstante, $statut, $conn) {
    // Récupération des IDs des rendez-vous
    $tableauId = array_column($tableau, 'id');

    if (!empty($tableauId)) {
        try {
            // Début de la transaction
            $conn->beginTransaction();
            
            // Création des placeholders (?,?,...)
            $placeholders = implode(',', array_fill(0, count($tableauId), '?'));
            
            // Préparation de la requête (version avec paramètres positionnels uniquement)
            $stmt = $conn->prepare("UPDATE rendezvous SET statut = ? WHERE id IN ($placeholders)");
            
            // Construction du tableau de paramètres: statut d'abord, puis les IDs
            $params = array_merge([$statut], $tableauId);
            
            // Exécution avec les paramètres
            $stmt->execute($params);
            
            // Validation de la transaction
            $conn->commit();
            
        } catch (PDOException $e) {
            // Annulation en cas d'erreur
            $conn->rollBack();
            error_log("Erreur lors de la mise à jour des rendez-vous: " . $e->getMessage());
            throw $e;
        }
    }
}

mettreAJourStatut($rendezvousEnRetard, 'STATUT_EN_RETARD', 'en retard', $conn);
mettreAJourStatut($rendezvousEnCours, 'STATUT_EN_COURS', 'en cours', $conn);



