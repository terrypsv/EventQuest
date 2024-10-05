<?php
require '../includes/db_connection.php';

// Vérification si la requête est bien de type POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $evenement_id = $_POST['evenement_id'];
    $contenu = $_POST['contenu'];

    // Validation des données côté serveur
    if (empty($evenement_id) || empty($contenu)) {
        echo "Tous les champs sont requis.";
    } elseif (!is_numeric($evenement_id)) {
        echo "ID Événement invalide.";
    } else {
        // Insertion dans la base de données
        $sql = "INSERT INTO recherche_index (evenement_id, contenu) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$evenement_id, $contenu])) {
            echo "Index de recherche ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout à l'index de recherche.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Index de Recherche</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <h1>Ajouter un Index de Recherche</h1>

    <form method="POST" action="creer_index_recherche.php">
        <label for="evenement_id">ID Événement :</label>
        <input type="number" id="evenement_id" name="evenement_id" required>

        <label for="contenu">Contenu Indexé :</label>
        <textarea id="contenu" name="contenu" required></textarea>

        <button type="submit">Ajouter</button>
    </form>

    <!-- Message de confirmation -->
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($stmt) && $stmt->rowCount() > 0): ?>
    <p class="success-message">Index ajouté avec succès !</p>
    <?php endif; ?>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>