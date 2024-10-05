<?php
require '../includes/db_connection.php';
include '../includes/session_start.php'; // Pour gérer les sessions si nécessaire

// Vérification du rôle d'administrateur
verifier_role('admin'); // Assurez-vous que seuls les administrateurs peuvent ajouter des captchas

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validation et nettoyage des données
    $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_STRING);
    $reponse = filter_input(INPUT_POST, 'reponse', FILTER_SANITIZE_STRING);

    if ($question && $reponse) {
        $sql = "INSERT INTO captcha_questions (question, reponse, cree_le) VALUES (?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$question, $reponse])) {
            echo "Captcha ajouté avec succès.";
        } else {
            $error = "Erreur lors de l'ajout du captcha.";
        }
    } else {
        $error = "Tous les champs doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Captcha</title>
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

    <h1>Ajouter une Question de Captcha</h1>

    <!-- Affichage des messages d'erreur s'il y a un problème -->
    <?php if (isset($error)) : ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="captcha_questions.php">
        <label for="question">Question :</label>
        <input type="text" id="question" name="question" required>

        <label for="reponse">Réponse :</label>
        <input type="text" id="reponse" name="reponse" required>

        <button type="submit">Ajouter</button>
    </form>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>