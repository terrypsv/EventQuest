<?php
require '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les valeurs du formulaire
    $utilisateur_id = $_POST['utilisateur_id'];
    $sujet = trim($_POST['sujet']);
    $priorite = $_POST['priorite'];
    $statut = $_POST['statut'];

    // Validation des données
    if (empty($sujet)) {
        echo "Le sujet est requis.";
    } elseif (!in_array($priorite, ['Haute', 'Moyenne', 'Basse'])) {
        echo "Priorité invalide.";
    } elseif (!in_array($statut, ['Ouvert', 'En cours', 'Fermé'])) {
        echo "Statut invalide.";
    } else {
        // Insertion dans la base de données
        $sql = "INSERT INTO tickets_support (utilisateur_id, sujet, priorite, statut, cree_le, mis_a_jour_le) 
                VALUES (?, ?, ?, ?, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$utilisateur_id, $sujet, $priorite, $statut])) {
            echo "Ticket de support ajouté avec succès.";
            // Optionnel : rediriger vers une page de confirmation
            // header("Location: confirmation.php");
            // exit;
        } else {
            echo "Erreur lors de l'ajout du ticket de support.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Ticket de Support</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <h1>Ajouter un Ticket de Support</h1>
    <form method="POST" action="">
        <label for="utilisateur_id">ID Utilisateur :</label>
        <input type="number" id="utilisateur_id" name="utilisateur_id" required>

        <label for="sujet">Sujet :</label>
        <input type="text" id="sujet" name="sujet" required>

        <label for="priorite">Priorité :</label>
        <select id="priorite" name="priorite" required>
            <option value="Haute">Haute</option>
            <option value="Moyenne">Moyenne</option>
            <option value="Basse">Basse</option>
        </select>

        <label for="statut">Statut :</label>
        <select id="statut" name="statut" required>
            <option value="Ouvert">Ouvert</option>
            <option value="En cours">En cours</option>
            <option value="Fermé">Fermé</option>
        </select>

        <button type="submit">Ajouter</button>
    </form>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>