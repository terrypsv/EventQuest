<?php
// Inclut le fichier de connexion à la base de données et de gestion des sessions
require '../includes/db_connection.php';
include '../includes/session_start.php';

// Vérifie si l'utilisateur est connecté et a le bon rôle pour cette page (admin ou agence)
verifier_role('admin'); // Exemple : seuls les administrateurs peuvent ajouter des abonnements VIP

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $utilisateur_id = filter_input(INPUT_POST, 'utilisateur_id', FILTER_VALIDATE_INT);
    $date_debut = filter_input(INPUT_POST, 'date_debut', FILTER_SANITIZE_STRING);
    $date_fin = filter_input(INPUT_POST, 'date_fin', FILTER_SANITIZE_STRING);
    $niveau_vip = filter_input(INPUT_POST, 'niveau_vip', FILTER_SANITIZE_STRING);

    // Vérification des données
    if ($utilisateur_id && $date_debut && $date_fin && $niveau_vip) {
        // Prépare l'insertion dans la base de données
        $sql = "INSERT INTO abonnements_vip (utilisateur_id, date_debut, date_fin, niveau_vip) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Exécute l'insertion
        if ($stmt->execute([$utilisateur_id, $date_debut, $date_fin, $niveau_vip])) {
            // Redirige avec un message de succès
            header("Location: success.php?message=Abonnement VIP ajouté avec succès.");
            exit;
        } else {
            // Message d'erreur si l'insertion échoue
            $error = "Erreur lors de l'ajout de l'abonnement VIP.";
        }
    } else {
        // Message d'erreur si les champs sont invalides
        $error = "Tous les champs sont requis et doivent être valides.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Abonnement VIP</title>
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

    <h1>Ajouter un Abonnement VIP</h1>

    <!-- Affichage des erreurs s'il y en a -->
    <?php if (isset($error)) : ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="abonnements_vip.php">
        <label for="utilisateur_id">ID Utilisateur :</label>
        <input type="number" id="utilisateur_id" name="utilisateur_id" required>

        <label for="date_debut">Date de début :</label>
        <input type="datetime-local" id="date_debut" name="date_debut" required>

        <label for="date_fin">Date de fin :</label>
        <input type="datetime-local" id="date_fin" name="date_fin" required>

        <label for="niveau_vip">Niveau VIP :</label>
        <input type="text" id="niveau_vip" name="niveau_vip" required>

        <button type="submit">Ajouter</button>
    </form>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>