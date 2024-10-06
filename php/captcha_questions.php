<?php
require '../includes/db_connection.php';
include '../includes/session_start.php'; // Démarrer la session si nécessaire pour gérer les utilisateurs

// Fonction pour vérifier le rôle d'administrateur
function verifier_role($role) {
    // On vérifie si l'utilisateur est connecté et a le bon rôle
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        die("Accès refusé. Vous n'avez pas les permissions nécessaires.");
    }
}

// Vérification que l'utilisateur est bien un administrateur
verifier_role('admin'); // Seuls les admins peuvent accéder à cette page

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validation et nettoyage des données
    $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_STRING);
    $reponse = filter_input(INPUT_POST, 'reponse', FILTER_SANITIZE_STRING);

    // Vérification des champs obligatoires
    if ($question && $reponse) {
        // Requête SQL pour insérer une nouvelle question/réponse de captcha
        $sql = "INSERT INTO captcha_questions (question, reponse, cree_le) VALUES (?, ?, NOW())";
        $stmt = $pdo->prepare($sql);

        // Exécution de la requête
        if ($stmt->execute([$question, $reponse])) {
            $message = "Captcha ajouté avec succès.";
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
    <!-- Menu de navigation -->
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

    <!-- Affichage des messages d'erreur ou de succès -->
    <?php if (isset($error)) : ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (isset($message)) : ?>
    <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter une question de CAPTCHA -->
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