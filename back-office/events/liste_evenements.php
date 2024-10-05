<?php
include '../includes/db_connection.php';
include '../includes/header.php';
include_once __DIR__ . '/../sessions/session_start.php';

verifier_role('admin'); // Vérifie si l'utilisateur est un administrateur

// Requête pour récupérer tous les événements
$sql = "SELECT * FROM evenements";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des événements</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <h1>Liste des événements</h1>
    <a href="ajouter_evenement.php">Ajouter un événement</a>

    <!-- Tableau des événements -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Date</th>
                <th>Emplacement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($evenements as $event): ?>
            <tr>
                <td><?php echo htmlspecialchars($event['id']); ?></td>
                <td><?php echo htmlspecialchars($event['titre']); ?></td>
                <td><?php echo htmlspecialchars($event['date_evenement']); ?></td>
                <td><?php echo htmlspecialchars($event['emplacement']); ?></td>
                <td>
                    <a href="modifier_evenement.php?id=<?php echo $event['id']; ?>">Modifier</a> |
                    <a href="supprimer_evenement.php?id=<?php echo $event['id']; ?>"
                        onclick="return confirm('Voulez-vous vraiment supprimer cet événement ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>