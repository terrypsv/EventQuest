<?php
include_once __DIR__ . '/../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $nom_utilisateur = trim($_POST['nom_utilisateur']);
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $nom_complet = trim($_POST['nom_complet']);
    $role = $_POST['role'];  // Récupérer le rôle choisi (utilisateur ou agence)

    // Validation des données côté serveur
    if (empty($nom_utilisateur) || empty($email) || empty($mot_de_passe)) {
        echo "Tous les champs sont requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse email invalide.";
    } else {
        // Hachage du mot de passe
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Requête SQL pour insérer l'utilisateur
        $query = "INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, nom_complet, role) VALUES (:nom_utilisateur, :email, :mot_de_passe, :nom_complet, :role)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nom_utilisateur', $nom_utilisateur);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe_hash);
        $stmt->bindParam(':nom_complet', $nom_complet);
        $stmt->bindParam(':role', $role);  // Le rôle sera utilisateur ou agence selon le choix

        if ($stmt->execute()) {
            echo "Inscription réussie. Vous pouvez maintenant vous connecter.";
            // Redirection vers la page de connexion après quelques secondes
            header("refresh:2;url=/login.php");
        } else {
            echo "Erreur lors de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <h1>Inscription</h1>
    <form method="POST" action="">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" required><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>

        <label for="nom_complet">Nom complet :</label>
        <input type="text" id="nom_complet" name="nom_complet"><br>

        <label for="role">Je m'inscris en tant que :</label>
        <select id="role" name="role" required>
            <option value="utilisateur">Utilisateur</option>
            <option value="agence">Agence</option>
        </select><br>

        <button type="submit">S'inscrire</button>
    </form>

    <a href="/login.php">Déjà inscrit ? Connectez-vous ici</a>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>