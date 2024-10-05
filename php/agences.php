<?php
// Inclusion de la connexion à la base de données et de la session
require '../includes/db_connection.php';
include '../includes/session_start.php';

// Vérifie si l'utilisateur est connecté et a le bon rôle pour créer une agence
verifier_role('admin'); // Par exemple, seuls les administrateurs peuvent créer des agences

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validation des données utilisateur
    $nom_agence = filter_input(INPUT_POST, 'nom_agence', FILTER_SANITIZE_STRING);
    $utilisateur_id = filter_input(INPUT_POST, 'utilisateur_id', FILTER_VALIDATE_INT);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

    // Vérification des champs obligatoires
    if ($nom_agence && $utilisateur_id) {
        // Insertion dans la base de données
        $sql = "INSERT INTO agences (nom_agence, utilisateur_id, description, cree_le) VALUES (?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);

        // Exécution de la requête
        if ($stmt->execute([$nom_agence, $utilisateur_id, $description])) {
            // Redirection après succès
            header("Location: success.php?message=Agence créée avec succès.");
            exit;
        } else {
            $error = "Erreur lors de la création de l'agence.";
        }
    } else {
        $error = "Tous les champs requis doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer Agence</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
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

    <h1>Créer une nouvelle agence</h1>

    <!-- Affichage d'un message d'erreur s'il y a un problème -->
    <?php if (isset($error)) : ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="agences.php">
        <label for="nom_agence">Nom de l'agence :</label>
        <input type="text" id="nom_agence" name="nom_agence" required>

        <label for="utilisateur_id">ID utilisateur (propriétaire de l'agence) :</label>
        <input type="number" id="utilisateur_id" name="utilisateur_id" required>

        <label for="description">Description de l'agence :</label>
        <textarea id="description" name="description"></textarea>

        <button type="submit">Créer</button>
    </form>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>