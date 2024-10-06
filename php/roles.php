<?php
session_start();
require '../includes/db_connection.php';

// Vérification que l'utilisateur est admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès non autorisé.");
}

// Ajouter un nouveau rôle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nouveau_role'])) {
    $nouveau_role = trim($_POST['nouveau_role']);
    
    if (!empty($nouveau_role)) {
        $sql = "INSERT INTO roles (role_name) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$nouveau_role])) {
            $message = "Rôle ajouté avec succès.";
        } else {
            $message = "Erreur lors de l'ajout du rôle.";
        }
    } else {
        $message = "Le nom du rôle ne peut pas être vide.";
    }
}

// Supprimer un rôle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supprimer_role'])) {
    $role_id = $_POST['role_id'];
    
    $sql = "DELETE FROM roles WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$role_id])) {
        $message = "Rôle supprimé avec succès.";
    } else {
        $message = "Erreur lors de la suppression du rôle.";
    }
}

// Récupérer tous les rôles
$sql = "SELECT * FROM roles";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des rôles</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Gestion des rôles</h1>

    <!-- Afficher les messages de succès ou d'erreur -->
    <?php if (isset($message)): ?>
    <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter un nouveau rôle -->
    <h2>Ajouter un nouveau rôle</h2>
    <form method="POST" action="">
        <label for="nouveau_role">Nom du nouveau rôle :</label>
        <input type="text" id="nouveau_role" name="nouveau_role" required>
        <button type="submit">Ajouter</button>
    </form>

    <!-- Liste des rôles existants -->
    <h2>Rôles existants</h2>
    <ul>
        <?php foreach ($roles as $role): ?>
        <li>
            <?php echo htmlspecialchars($role['role_name']); ?>
            <form method="POST" action="" style="display:inline;">
                <input type="hidden" name="role_id" value="<?php echo $role['id']; ?>">
                <button type="submit" name="supprimer_role"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')">Supprimer</button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>