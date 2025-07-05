<?php
include_once "DataBase.php";
$messageConfirm = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $email = htmlspecialchars($_POST["email"]);
    $telephone = htmlspecialchars($_POST["telephone"]);
    $date = $_POST["date"];
    $heure = $_POST["heure"];
    $service = htmlspecialchars($_POST["service"]);
    $messageClient = htmlspecialchars($_POST["message"]);

    $sql = "INSERT INTO rendezvous (nom, email, telephone, date, heure, service, message) 
            VALUES (:nom, :email, :telephone, :date, :heure, :service, :message)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':email' => $email,
        ':telephone' => $telephone,
        ':date' => $date,
        ':heure' => $heure,
        ':service' => $service,
        ':message' => $messageClient
    ]);

    $messageConfirm = "✅ Rendez-vous enregistré avec succès.";
    
//     // Préparation de l’e-mail
// $to = $email;
// $sujet = "Confirmation de rendez-vous - TechSolutions";
// $contenu = "Bonjour $nom,

// Votre rendez-vous a bien été enregistré.

// 📅 Date : $date
// ⏰ Heure : $heure
// 🛠️ Service : $service

// Message :
// $messageClient

// Merci de votre confiance.

// Cordialement,
// L’équipe TechSolutions";

// $headers = "From: contact@techsolutions.com\r\n" .
//            "Reply-To: contact@techsolutions.com\r\n" .
//            "Content-Type: text/plain; charset=UTF-8";

// // Envoi de l’e-mail
// mail($to, $sujet, $contenu, $headers);
// }
// // Notification à l’admin
// $adminEmail = "admin@techsolutions.com";
// $adminSujet = "📩 Nouveau rendez-vous - TechSolutions";
// $adminMessage = "Un nouveau rendez-vous a été demandé :

// Nom : $nom
// Email : $email
// Téléphone : $telephone
// Date : $date
// Heure : $heure
// Service : $service
// Message :
// $messageClient

// Connectez-vous à l’espace admin pour plus de détails.";

// $adminHeaders = "From: noreply@techsolutions.com\r\n" .
//                 "Content-Type: text/plain; charset=UTF-8";

// mail($adminEmail, $adminSujet, $adminMessage, $adminHeaders);
}