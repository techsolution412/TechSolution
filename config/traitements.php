<?php
header('Content-Type: application/json');
include_once "DataBase.php";
$messageConfirm = "";

// la fonction pour les notifications telegram
function NotifTelegram($message){
    // mettre les token et le chat bot du telegram
    $token = "8168815760:AAHzrHyNTxVN366g0oVGCsV0oUf35tttWNU"; //token 8168815760:AAHzrHyNTxVN366g0oVGCsV0oUf35tttWNU
    $chat_id = "8029642357"; //id de notre chat telegram
    
    $url = "https://api.telegram.org/bot$token/sendMessage";

    $data = [
        'chat_id' => $chat_id,
        'text' => $message
    ];

    file_get_contents($url . '?' . http_build_query($data));
}

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
        $ip = $_SERVER['REMOTE_ADDR'];

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
        
       
      // Combinaison date + heure
        $rendezVous = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $heure);
        $now = new DateTime();

        if (!$rendezVous) {
            echo json_encode(["succes" => false, "message" => " Format de date ou d'heure invalide."]);
            exit;
        }

        // Verifie 
        if ($rendezVous < $now) {
            echo json_encode(["succes" => false, "message" => "La date ou l'heure est invalide."]);
            exit;
        }

        // Limite les heures autorise entre 09:00 et 20:30
        $heureRV = (int) $rendezVous->format('H');    // Heure seule
        $minuteRV = (int) $rendezVous->format('i');   // Minute seule

        if (
            $heureRV < 9 || 
            ($heureRV === 20 && $minuteRV > 30) || 
            $heureRV > 20
        ) {
            echo json_encode(["succes" => false, "message" => " Les rendez-vous sont autorises uniquement entre 09h00 et 20h30."]);
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
         
        // Notification Telegram 
        $sms = " *Nouveau rendez-vous reçu !*\n"
             . " *Nom* : $nom\n"
             . " *Email* : $email\n"
             . " *Telephone* : $telephone\n"
             . " *Date* : $date à $heure\n"
             . " *Service* : $service\n"
             . " *Message* : $messageClient\n"
             . " *Adresse Ip Client* : $ip";

             //appel de la fonction NotifTelegram($sms)
        NotifTelegram($sms);
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
