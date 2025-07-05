<?php
require_once '../config/DataBase.php';

//  les admins je mets ca en constante directe
// $pseudo = "Polo412";
// $motDePasse = "Hunter412";

$pseudo = "Hitler";
$motDePasse = "MeinKampf";
// Hachage du mot de passe
$hash = password_hash($motDePasse, PASSWORD_DEFAULT);
// $hash1 = password_hash($motDePasse1, PASSWORD_DEFAULT);

// Insertion dans la table `admins`
$sql = "INSERT INTO admins (pseudo, mot_de_passe) VALUES (:pseudo, :mot_de_passe)";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':pseudo' => $pseudo,
    ':mot_de_passe' => $hash
]);

echo "✅ Admin succes!";
