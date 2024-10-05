<?php
require '../includes/db_connection.php';
include '../includes/session_start.php'; // Gestion des sessions

// Vérifie si l'utilisateur a le rôle approprié (par exemple, admin ou autre)
verifier_role('admin');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validation et nettoyage des données
    $type_element = filter_input(INPUT_POST, 'type_element', FILTER_SANITIZE_STRING);
    $contenu = filter_input(INPUT_POST, 'contenu', FILTER_SANITIZE_STRING);
    $date_suppression = filter_input(INPUT_POST, 'date_suppression', FILTER_SANITIZE_STRING);
    $utilisateur_id = filter_input(INPUT_POST, 'utilisateur_id', FILTER_VALIDATE_INT);

    // Vérification des champs obligatoires
    if ($type_element && $contenu && $date_suppression && $utilisateur_id) {
        // Insertion des données dans la table archives
        $sql = "INSERT INTO archives (type_element, contenu, date_suppression, utilisateur_id) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$type_element, $contenu, $date_suppression, $utilisateur_id])) {
            // Redirection en cas de succès
            header("Location: success.php?message=Archive ajoutée avec succès");
            exit;
        } else {
            $error = "Erreur lors de l'ajout de l'archive.";
        }
    } else {
        $error = "Tous les champs doivent être remplis correctement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Archive</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="container navbar">
            <div class="logo-title">
                <img class="logo" src="../assets/images/logo.png" href="../index.php" width="3%" height="3%" />
                <a class="navbar-brand" href="../index.php">EventQuest</a>
            </div>
            <ul class="navbar-nav">
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
            </ul>
        </div>
    </header>

    <h1>Ajouter une Archive</h1>

    <!-- Affichage d'un message d'erreur s'il y a un problème -->
    <?php if (isset($error)) : ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="archives.php">
        <label for="type_element">Type d'Élément :</label>
        <input type="text" id="type_element" name="type_element" required>

        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" required></textarea>

        <label for="date_suppression">Date de Suppression :</label>
        <input type="datetime-local" id="date_suppression" name="date_suppression" required>

        <label for="utilisateur_id">ID Utilisateur :</label>
        <input type="number" id="utilisateur_id" name="utilisateur_id" required>

        <button type="submit">Ajouter</button>
    </form>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>