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

    $utilisateur_id = $_POST['utilisateur_id'];
    $categorie_preferee = $_POST['categorie_preferee'];

    // Validation des champs
    if (!empty($utilisateur_id) && !empty($categorie_preferee)) {
        $sql = "INSERT INTO preferences_utilisateurs (utilisateur_id, categorie_preferee) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$utilisateur_id, $categorie_preferee])) {
            echo "Préférence utilisateur ajoutée avec succès.";
        } else {
            echo "Erreur lors de l'ajout de la préférence utilisateur.";
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
    <title>Ajouter Préférence Utilisateur</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Ajouter une Préférence Utilisateur</h1>
    <form method="POST" action="creer_preference_utilisateur.php">
        <label for="utilisateur_id">ID Utilisateur :</label>
        <input type="number" id="utilisateur_id" name="utilisateur_id" required>

        <label for="categorie_preferee">Catégorie Préférée :</label>
        <input type="text" id="categorie_preferee" name="categorie_preferee" required>

        <!-- Ajout du token CSRF -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <button type="submit">Ajouter</button>
    </form>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>