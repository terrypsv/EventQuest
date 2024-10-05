<?php
require '../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php';

// Vérifie si l'utilisateur est un administrateur
verifier_role('admin');

// Message de retour pour l'utilisateur
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validation des données
    $utilisateur_id = filter_input(INPUT_POST, 'utilisateur_id', FILTER_VALIDATE_INT);
    $action = trim($_POST['action']);

    if ($utilisateur_id && !empty($action)) {
        // Insertion dans la base de données
        $sql = "INSERT INTO logs (utilisateur_id, action, date_log) VALUES (?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$utilisateur_id, $action])) {
            $message = "Log ajouté avec succès.";
        } else {
            $message = "Erreur lors de l'ajout du log.";
        }
    } else {
        $message = "Veuillez remplir tous les champs correctement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Log</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Ajouter un Log</h1>

    <?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="logs.php">
        <label for="utilisateur_id">ID Utilisateur :</label>
        <input type="number" id="utilisateur_id" name="utilisateur_id" required>

        <label for="action">Action :</label>
        <input type="text" id="action" name="action" required>

        <button type="submit">Ajouter</button>
    </form>
</body>

</html>