<?php
require '../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php';

// Protection CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Erreur de vérification CSRF. Veuillez réessayer.";
        exit;
    }

    $role = $_POST['role'];
    $action = $_POST['action'];
    $autorise = isset($_POST['autorise']) ? 1 : 0;

    // Validation des champs
    if (!empty($role) && !empty($action)) {
        $sql = "INSERT INTO permissions (role, action, autorise) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$role, $action, $autorise])) {
            echo "Permission ajoutée avec succès.";
        } else {
            echo "Erreur lors de l'ajout de la permission.";
        }
    } else {
        echo "Tous les champs doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Permission</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Ajouter une permission</h1>
    <form method="POST" action="creer_permission.php">
        <label for="role">Rôle :</label>
        <input type="text" id="role" name="role" required>

        <label for="action">Action :</label>
        <input type="text" id="action" name="action" required>

        <label for="autorise">Autorisé :</label>
        <input type="checkbox" id="autorise" name="autorise" checked>

        <!-- Ajout du token CSRF -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <button type="submit">Ajouter</button>
    </form>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>