<?php
session_start();
require __DIR__ . '/../includes/db_connection.php'; // Connexion à la base de données
require __DIR__ . '/../email_functions.php'; // Inclure les fonctions d'envoi d'e-mail

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_utilisateur = trim($_POST['nom_utilisateur']);
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $nom_complet = trim($_POST['nom_complet']);
    $role = $_POST['role'];
    $captcha_reponse = trim($_POST['captcha_reponse']);

    // Vérification du CAPTCHA
    if ($captcha_reponse !== $_SESSION['captcha_reponse']) {
        die("CAPTCHA incorrect. Veuillez réessayer.");
    }

    // Validation des champs
    if (empty($nom_utilisateur) || empty($email) || empty($mot_de_passe)) {
        die("Tous les champs sont requis.");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Adresse e-mail invalide.");
    }

    // Hachage du mot de passe
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Générer un token de vérification
    $token = bin2hex(random_bytes(50));

    // Insertion des données dans la base de données
    $pdo = getDatabaseConnection();
    $query = "INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, nom_complet, role, token_verification) 
              VALUES (:nom_utilisateur, :email, :mot_de_passe, :nom_complet, :role, :token_verification)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nom_utilisateur', $nom_utilisateur);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mot_de_passe', $mot_de_passe_hash);
    $stmt->bindParam(':nom_complet', $nom_complet);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':token_verification', $token);

    if ($stmt->execute()) {
        envoyerEmailVerification($email, $token); // Envoi de l'e-mail de vérification
        echo "Inscription réussie. Un e-mail de vérification vous a été envoyé.";
    } else {
        die("Erreur lors de l'inscription.");
    }
}