<?php
require 'includes/db_connection.php'; // Connexion à la base de données
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);

    // Validation des champs
    if (!empty($email) && !empty($mot_de_passe)) {
        // Préparer la requête SQL pour récupérer l'utilisateur
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Connexion réussie, démarrer la session
            session_regenerate_id(true);  // Renouvelle l'ID de session pour éviter la fixation de session
            $_SESSION['utilisateur_id'] = $user['id'];  // Stocker l'ID utilisateur dans la session
            $_SESSION['role'] = $user['role'];  // Stocker le rôle utilisateur dans la session
            $_SESSION['nom_utilisateur'] = $user['nom_utilisateur'];  // Stocker le nom d'utilisateur
            header("Location: /profil.php");  // Rediriger vers la page de profil ou d'accueil après connexion
            exit;
        } else {
            $message = "Email ou mot de passe incorrect.";
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
    <title>Connexion</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <h1>Connexion</h1>
    <?php if (isset($message)) : ?>
    <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>

        <button type="submit">Se connecter</button>
    </form>
</body>

</html>