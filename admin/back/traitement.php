<?php
header('Content-Type: application/json');
require_once '../../config/DataBase.php';
$messageConfirm = "";

try{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nom = htmlspecialchars($_POST["nom"]);
        $email = htmlspecialchars($_POST["email"]);
        $telephone = htmlspecialchars($_POST["telephone"]);
        $date = $_POST["date"];
        $heure = $_POST["heure"];
        $service = htmlspecialchars($_POST["service"]);
        $statut = htmlspecialchars($_POST["statut"]); 
        $messageClient = htmlspecialchars($_POST["message"]);

        $sql = "UPDATE rendezvous SET nom =:nom , email=:email, telephone = :telephone, date = :date, heure = :heure, service_id = :service_id, statut = :statut, message = :message WHERE id = :id"; 
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':email' => $email,
            ':telephone' => $telephone,
            ':date' => $date,
            ':heure' => $heure,
            ':service_id' => $service,
            ':statut' => $statut, // Statut par défaut
            ':message' => $messageClient,
            ':id' => $_POST['id'] 
        ]);

        // $messageConfirm = ;
        echo json_encode(["succes" => true, "message" => "✅ Rendez-vous enregistré avec succès."]);
    }
}catch(Exception $e){
    echo json_encode(["succes" => false, "message" => "Erreur : ". $e->getMessage()]);
}
