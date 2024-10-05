<?php
include_once __DIR__ . '/../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php';

verifier_role('admin'); // Vérifie si l'utilisateur est un administrateur

// Traitement du formulaire d'ajout d'événement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $categorie = $_POST['categorie'];
    $date_evenement = $_POST['date_evenement'];
    $emplacement = $_POST['emplacement'];
    $prix_billet = $_POST['prix_billet'];
    $participants_max = $_POST['participants_max'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Insertion dans la base de données
    $query = "INSERT INTO evenements (agence_id, titre, description, categorie, date_evenement, emplacement, prix_billet, participants_max, latitude, longitude, cree_le, mis_a_jour_le) VALUES (:agence_id, :titre, :description, :categorie, :date_evenement, :emplacement, :prix_billet, :participants_max, :latitude, :longitude, NOW(), NOW())";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':agence_id', $_SESSION['utilisateur_id']);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':categorie', $categorie);
    $stmt->bindParam(':date_evenement', $date_evenement);
    $stmt->bindParam(':emplacement', $emplacement);
    $stmt->bindParam(':prix_billet', $prix_billet);
    $stmt->bindParam(':participants_max', $participants_max);
    $stmt->bindParam(':latitude', $latitude);
    $stmt->bindParam(':longitude', $longitude);

    if ($stmt->execute()) {
        echo "Événement ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'événement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Événement</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <h1>Ajouter un Événement</h1>
    <form method="POST" action="">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="categorie">Catégorie :</label>
        <input type="text" id="categorie" name="categorie" required><br>

        <label for="date_evenement">Date de l'événement :</label>
        <input type="datetime-local" id="date_evenement" name="date_evenement" required><br>

        <label for="emplacement">Emplacement :</label>
        <input type="text" id="emplacement" name="emplacement" required><br>

        <label for="prix_billet">Prix du billet :</label>
        <input type="number" step="0.01" id="prix_billet" name="prix_billet" required><br>

        <label for="participants_max">Nombre maximum de participants :</label>
        <input type="number" id="participants_max" name="participants_max" required><br>

        <label for="latitude">Latitude :</label>
        <input type="text" id="latitude" name="latitude"><br>

        <label for="longitude">Longitude :</label>
        <input type="text" id="longitude" name="longitude"><br>

        <button type="submit">Ajouter l'événement</button>
    </form>

    <a href="/php/profil.php">Retour au profil</a>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>