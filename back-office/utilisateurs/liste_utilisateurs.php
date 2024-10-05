<?php
// Connexion à la base de données
include '../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php';

// Vérifie si l'utilisateur est un administrateur
verifier_role('admin');

// Requête pour récupérer tous les utilisateurs
$sql = "SELECT * FROM utilisateurs";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <h1>Gestion des utilisateurs</h1>
    <a href="ajouter_utilisateur.php">Ajouter un utilisateur</a>

    <!-- Table des utilisateurs -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['nom_utilisateur']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <a href="modifier_utilisateur.php?id=<?php echo $user['id']; ?>">Modifier</a> |
                    <a href="supprimer_utilisateur.php?id=<?php echo $user['id']; ?>"
                        onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>