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

$id = $_GET['id']; // Récupérer l'ID de l'utilisateur

// Suppression de l'utilisateur
$sql = "DELETE FROM utilisateurs WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header("Location: liste_utilisateurs.php");
exit();