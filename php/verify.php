<?php
session_start();
include __DIR__ . '/../includes/db_connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $pdo = getDatabaseConnection();
    
    // Rechercher un utilisateur avec ce token de vérification
    $query = "SELECT * FROM utilisateurs WHERE token_verification = :token";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Mettre à jour l'utilisateur pour valider l'e-mail
        $updateQuery = "UPDATE utilisateurs SET email_verifie = true, token_verification = NULL WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':id', $user['id']);
        if ($updateStmt->execute()) {
            echo "Votre adresse e-mail a été vérifiée avec succès.";
        } else {
            echo "Erreur lors de la vérification de l'e-mail.";
        }
    } else {
        echo "Token de vérification invalide.";
    }
} else {
    echo "Aucun token fourni.";
}