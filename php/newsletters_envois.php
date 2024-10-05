<?php
require '../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php'; // Session pour vérifier si l'utilisateur est connecté

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
    $newsletter_id = $_POST['newsletter_id'];

    // Validation des données
    if (!empty($utilisateur_id) && !empty($newsletter_id)) {
        $sql = "INSERT INTO newsletter_envois (utilisateur_id, newsletter_id, date_envoi, status) VALUES (?, ?, NOW(), 'envoyé')";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$utilisateur_id, $newsletter_id])) {
            echo "Envoi de la newsletter enregistré avec succès.";
        } else {
            echo "Erreur lors de l'enregistrement de l'envoi.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Envoi de Newsletter</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Enregistrer un Envoi de Newsletter</h1>
    <form method="POST" action="">
        <label for="utilisateur_id">ID Utilisateur :</label>
        <input type="number" id="utilisateur_id" name="utilisateur_id" required>

        <label for="newsletter_id">ID Newsletter :</label>
        <input type="number" id="newsletter_id" name="newsletter_id" required>

        <!-- Ajout d'un champ CSRF pour la protection -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <button type="submit">Ajouter</button>
    </form>

    <a href="/php/newsletters.php">Retour à la gestion des newsletters</a>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>