<?php
header('Content-Type: application/json');
include_once "DataBase.php";
$messageConfirm = "";


try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        //recuperation des champs de saisis
        $nom = trim(htmlspecialchars($_POST["nom"]));
        $email = trim(htmlspecialchars($_POST["email"]));
        $telephone = trim(htmlspecialchars($_POST["telephone"]));
        $date = $_POST["date"];
        $heure = $_POST["heure"];
        $service = trim(htmlspecialchars($_POST["service"]));
        $messageClient = trim(htmlspecialchars($_POST["message"]));

        // Verification des champs de saisi 
        if (empty($nom) || empty($email) || empty($telephone) || empty($date) || empty($heure) || empty($service)) {
            echo json_encode(["succes" => false, "message" => " Tous les champs sont obligatoires."]);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["succes" => false, "message" => " Adresse email invalide."]);
            exit;
        }
        // validiter du numero du telephone aevec une expression regulier
       if (!preg_match('/^(?:(?:\+221|00221)?)(7[05678][0-9]{7})$/', $telephone)) {
            echo json_encode(["succes" => false, "message" => "Numero de telephone invalide."]);
            exit;
        }
        
        // Combinaison des deux en objet DateTime
        $rendezVous = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $heure);
        $now = new DateTime();

        // Verifie si la date/heure est valide
        if (!$rendezVous) {
            echo json_encode(["succes" => false, "message" => " Format de date ou heure invalide."]);
            exit;
        }

        // Verifie si la date/heure est dans le passe
        if ($rendezVous < $now) {
            echo json_encode(["succes" => false, "message" => " La date ou l'heure du rendez-vous est deja passee."]);
            exit;
        }

        // Insertion
        $sql = "INSERT INTO rendezvous (nom, email, telephone, date, heure, service_id, message) 
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

        echo json_encode(["succes" => true, "message" => " Rendez-vous enregistre avec succes."]);
    }
} catch (Exception $e) {
    echo json_encode(["succes" => false, "message" => " Erreur : " . $e->getMessage()]);
}

    // validation de l'heure







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
