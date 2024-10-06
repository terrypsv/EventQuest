<?php
include_once __DIR__ . '/../includes/db_connection.php'; // Connexion à la base de données
require __DIR__ . '/../vendor/autoload.php'; // Inclure le fichier autoload de Composer

// Importer les classes PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Dotenv\Dotenv;

$pdo = getDatabaseConnection();  // Appelle la fonction pour récupérer la connexion PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $nom_utilisateur = trim($_POST['nom_utilisateur']);
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $nom_complet = trim($_POST['nom_complet']);
    $role = $_POST['role'];

    // Validation des données côté serveur
    if (empty($nom_utilisateur) || empty($email) || empty($mot_de_passe)) {
        echo "Tous les champs sont requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse email invalide.";
    } else {
        // Hachage du mot de passe
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Générer un token de vérification aléatoire
        $token = bin2hex(random_bytes(50));

        // Requête SQL pour insérer l'utilisateur
        $query = "INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, nom_complet, role, token_verification) VALUES (:nom_utilisateur, :email, :mot_de_passe, :nom_complet, :role, :token)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nom_utilisateur', $nom_utilisateur);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe_hash);
        $stmt->bindParam(':nom_complet', $nom_complet);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':token', $token);

        if ($stmt->execute()) {
            // Envoyer l'e-mail de vérification
            envoyerEmailVerification($email, $token);
            echo "Inscription réussie. Un e-mail de vérification vous a été envoyé.";
        } else {
            echo "Erreur lors de l'inscription.";
        }
    }
}

// Fonction pour envoyer l'e-mail de vérification
function envoyerEmailVerification($email, $token) {
    $mail = new PHPMailer(true);  // Créer une instance de PHPMailer

    try {
        // Configuration du SMTP
        $mail->isSMTP();
        $mail->Host = 'ssl0.ovh.net';  // Serveur SMTP OVH
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@eventquest.ovh';  // Adresse e-mail OVH
        $mail->Password = getenv('SMTP_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Utiliser SSL
        $mail->Port = 465;

        // Paramètres de l'e-mail
        $mail->setFrom('contact@eventquest.ovh', 'EventQuest');  // Adresse et nom d’expéditeur
        $mail->addAddress($email);  // Adresse e-mail du destinataire

        // Contenu de l'e-mail
        $mail->isHTML(true);  // Format HTML
        $mail->Subject = 'Vérification de votre adresse e-mail';
        $mail->Body    = "Cliquez sur ce lien pour vérifier votre e-mail : <a href='http://eventquest.ovh/verify.php?token=$token'>Vérifier l'e-mail</a>";

        // Envoyer l'e-mail
        $mail->send();
        echo 'E-mail de vérification envoyé.';
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
}