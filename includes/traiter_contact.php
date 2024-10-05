<?php
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage des entrées utilisateur
    $nom = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $message = trim(htmlspecialchars($_POST['message']));

    // Validation côté serveur
    if (!empty($nom) && !empty($email) && !empty($message)) {
        // Vérification de la validité de l'email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                // Insertion des données dans la base
                $sql = "INSERT INTO messages_contact (nom, email, message) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nom, $email, $message]);

                // Redirection après succès
                header("Location: ../pages/contact.php?success=1");
                exit;
            } catch (PDOException $e) {
                // Journalisation de l'erreur dans un fichier de log
                error_log("Erreur d'insertion dans la base de données : " . $e->getMessage(), 3, "../logs/error.log");

                // Redirection avec message d'erreur
                header("Location: ../pages/contact.php?error=database");
                exit;
            }
        } else {
            // Redirection avec message d'erreur email
            header("Location: ../pages/contact.php?error=email");
            exit;
        }
    } else {
        // Redirection avec message d'erreur de champs vides
        header("Location: ../pages/contact.php?error=fields");
        exit;
    }
} else {
    // Redirection en cas de méthode non autorisée
    header("Location: ../pages/contact.php?error=method");
    exit;
}