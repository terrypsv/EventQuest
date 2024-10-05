<?php
require '../includes/db_connection.php';
include '../includes/session_start.php'; // Gestion des sessions

// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validation et nettoyage des données
    $evenement_id = filter_input(INPUT_POST, 'evenement_id', FILTER_VALIDATE_INT);
    $utilisateur_id = $_SESSION['utilisateur_id']; // L'utilisateur connecté
    $quantite = filter_input(INPUT_POST, 'quantite', FILTER_VALIDATE_INT);
    $code_promo_id = filter_input(INPUT_POST, 'code_promo_id', FILTER_VALIDATE_INT);
    $total_paye = filter_input(INPUT_POST, 'total_paye', FILTER_VALIDATE_FLOAT);

    // Vérification que tous les champs requis sont remplis
    if ($evenement_id && $utilisateur_id && $quantite && $total_paye) {
        // Insertion des données dans la table billets
        $sql = "INSERT INTO billets (evenement_id, utilisateur_id, quantite, code_promo_id, total_paye, date_achat) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$evenement_id, $utilisateur_id, $quantite, $code_promo_id, $total_paye])) {
            // Redirection en cas de succès
            header("Location: success.php?message=Billet créé avec succès");
            exit;
        } else {
            $error = "Erreur lors de la création du billet.";
        }
    } else {
        $error = "Tous les champs requis doivent être remplis correctement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer Billet</title>
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

    <h1>Créer un billet</h1>

    <!-- Affichage des messages d'erreur s'il y a un problème -->
    <?php if (isset($error)) : ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="billets.php">
        <label for="evenement_id">ID de l'événement :</label>
        <input type="number" id="evenement_id" name="evenement_id" required>

        <label for="quantite">Quantité :</label>
        <input type="number" id="quantite" name="quantite" required>

        <label for="code_promo_id">Code Promo (optionnel) :</label>
        <input type="number" id="code_promo_id" name="code_promo_id">

        <label for="total_paye">Total payé :</label>
        <input type="number" step="0.01" id="total_paye" name="total_paye" required>

        <button type="submit">Créer</button>
    </form>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>