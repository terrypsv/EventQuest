<?php
require '../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php'; // Démarrer la session si nécessaire

// Vérifiez que l'utilisateur a le bon rôle pour ajouter des membres (peut être "admin" ou "proprietaire")
verifier_role('admin'); // Ajuster en fonction des droits nécessaires

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validation des données
    $groupe_id = filter_input(INPUT_POST, 'groupe_id', FILTER_VALIDATE_INT);
    $utilisateur_id = filter_input(INPUT_POST, 'utilisateur_id', FILTER_VALIDATE_INT);
    $role = trim($_POST['role']);

    if ($groupe_id && $utilisateur_id && !empty($role)) {
        // Insertion dans la base de données
        $sql = "INSERT INTO membres_groupe (groupe_id, utilisateur_id, role) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$groupe_id, $utilisateur_id, $role])) {
            $message = "Membre ajouté au groupe avec succès.";
        } else {
            $message = "Erreur lors de l'ajout du membre au groupe.";
        }
    } else {
        $message = "Tous les champs sont requis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Membre au Groupe</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Pour garder la cohérence avec le site -->
</head>

<body>
    <h1>Ajouter un Membre au Groupe</h1>

    <?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="membres_groupe.php">
        <label for="groupe_id">ID Groupe :</label>
        <input type="number" id="groupe_id" name="groupe_id" required>

        <label for="utilisateur_id">ID Utilisateur :</label>
        <input type="number" id="utilisateur_id" name="utilisateur_id" required>

        <label for="role">Rôle :</label>
        <input type="text" id="role" name="role" required>

        <button type="submit">Ajouter</button>
    </form>
</body>

</html>