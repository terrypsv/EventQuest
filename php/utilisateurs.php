<?php
session_start();
require '../includes/db_connection.php'; // Connexion à la base de données

// Fonction pour générer un token CSRF
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Token CSRF invalide.');
    }

    // Récupération et nettoyage des données
    $nom_utilisateur = trim($_POST['nom_utilisateur']);
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $nom_complet = trim($_POST['nom_complet']);
    $role = $_POST['role'];

    // Validation de l'email et des champs requis
    if (empty($nom_utilisateur) || empty($email) || empty($mot_de_passe)) {
        $error = "Tous les champs obligatoires doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } elseif (!in_array($role, ['admin', 'agence', 'client'])) {
        $error = "Rôle non valide.";
    } else {
        // Hachage du mot de passe
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

        // Insertion dans la base de données
        $sql = "INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, nom_complet, role, cree_le) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nom_utilisateur, $email, $mot_de_passe_hash, $nom_complet, $role])) {
            $success = "Utilisateur créé avec succès.";
        } else {
            $error = "Erreur lors de la création de l'utilisateur.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer Utilisateur</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Créer un nouvel utilisateur</h1>

    <!-- Afficher les messages de succès ou d'erreur -->
    <?php if (isset($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php elseif (isset($success)): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter un utilisateur -->
    <form method="POST" action="">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>

        <label for="nom_complet">Nom complet :</label>
        <input type="text" id="nom_complet" name="nom_complet">

        <label for="role">Rôle :</label>
        <select id="role" name="role">
            <option value="admin">Admin</option>
            <option value="agence">Agence</option>
            <option value="client">Client</option>
        </select>

        <!-- Ajout du token CSRF -->
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">

        <button type="submit">Créer</button>
    </form>
</body>

</html>