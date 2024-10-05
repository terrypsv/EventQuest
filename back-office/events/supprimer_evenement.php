<?php
include '../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php';

// Vérifie si l'utilisateur est admin
verifier_role('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur_id = $_POST['utilisateur_id'];

    // Supprimer l'utilisateur
    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
    $stmt->bindParam(':id', $utilisateur_id);
    $stmt->execute();

    echo "Utilisateur supprimé avec succès.";
} else {
    echo "Méthode non autorisée.";
}

// Récupérer l'ID de l'événement à supprimer
$event_id = $_GET['id'];

// Requête de suppression de l'événement
$sql = "DELETE FROM evenements WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id]);

// Redirection vers la liste des événements après suppression
header("Location: liste_evenements.php");
exit();