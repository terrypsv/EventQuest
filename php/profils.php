<?php
include_once __DIR__ . '/../sessions/session_start.php';
include_once __DIR__ . '/../includes/db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: /login.php');
    exit;
}

// Récupérer les informations de l'utilisateur connecté
$utilisateur_id = $_SESSION['utilisateur_id'];

// Requête SQL pour récupérer les informations de l'utilisateur
$query = "SELECT nom_utilisateur, email, nom_complet, role, derniere_connexion FROM utilisateurs WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $utilisateur_id);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$utilisateur) {
    echo "Utilisateur introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <h1>Mon Profil</h1>

    <div class="profile-container">
        <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($utilisateur['nom_utilisateur']); ?></p>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($utilisateur['email']); ?></p>
        <p><strong>Nom complet :</strong> <?php echo htmlspecialchars($utilisateur['nom_complet']); ?></p>
        <p><strong>Rôle :</strong> <?php echo htmlspecialchars($utilisateur['role']); ?></p>
        <p><strong>Dernière connexion :</strong> <?php echo htmlspecialchars($utilisateur['derniere_connexion']); ?></p>
    </div>

    <a href="/php/modifier_profil.php">Modifier le profil</a> |
    <a href="/php/logout.php">Déconnexion</a>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>