<?php
require '../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php'; // Gestion de la session

// Protection CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Erreur de vérification. Veuillez réessayer.";
        exit;
    }

    $utilisateur_id = $_POST['utilisateur_id'];
    $evenement_id = !empty($_POST['evenement_id']) ? $_POST['evenement_id'] : null;  // Champ optionnel
    $message = $_POST['message'];

    // Validation des données
    if (!empty($utilisateur_id) && !empty($message)) {
        $sql = "INSERT INTO notifications (utilisateur_id, evenement_id, message, statut_lu, cree_le) 
                VALUES (?, ?, ?, 0, NOW())";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$utilisateur_id, $evenement_id, $message])) {
            echo "Notification ajoutée avec succès.";
        } else {
            echo "Erreur lors de l'ajout de la notification.";
        }
    } else {
        echo "Tous les champs obligatoires doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Notification</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Ajouter une Notification</h1>
    <form method="POST" action="creer_notification.php">
        <label for="utilisateur_id">ID Utilisateur :</label>
        <input type="number" id="utilisateur_id" name="utilisateur_id" required>

        <label for="evenement_id">ID Événement (optionnel) :</label>
        <input type="number" id="evenement_id" name="evenement_id">

        <label for="message">Message :</label>
        <textarea id="message" name="message" required></textarea>

        <!-- Protection CSRF -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <button type="submit">Ajouter</button>
    </form>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>