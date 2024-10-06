<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // Inclure Composer pour charger PHPMailer

// Fonction pour envoyer l'e-mail de vérification
function envoyerEmailVerification($email, $token) {
    $mail = new PHPMailer(true);

    try {
        // Utilisation des variables d'environnement pour la configuration SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];  // Adresse e-mail depuis .env
        $mail->Password = $_ENV['SMTP_PASSWORD'];  // Mot de passe depuis .env
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $_ENV['SMTP_PORT'];

        // Configuration de l'e-mail
        $mail->setFrom($_ENV['SMTP_USERNAME'], 'EventQuest');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Vérification de votre adresse e-mail';
        $mail->Body    = "Cliquez sur ce lien pour vérifier votre e-mail : <a href='http://eventquest.ovh/verify.php?token=$token'>Vérifier mon e-mail</a>";

        // Envoyer l'e-mail
        $mail->send();
        echo 'E-mail de vérification envoyé.';
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
}