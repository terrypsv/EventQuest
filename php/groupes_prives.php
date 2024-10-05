<?php
require '../includes/db_connection.php'; // Connexion à la base de données
include_once __DIR__ . '/../sessions/session_start.php'; // Démarrer la session

// Vérifier si l'utilisateur est connecté et a le rôle approprié pour créer un groupe privé
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_groupe = trim($_POST['nom_groupe']);
    $proprietaire_id = $_SESSION['utilisateur_id']; // On récupère l'ID utilisateur de la session
    $description = trim($_POST['description']);

    // Validation basique des champs
    if (!empty($nom_groupe) && !empty($description)) {
        // Insertion dans la base de données
        $sql = "INSERT INTO groupes_prives (nom_groupe, proprietaire_id, description, cree_le) VALUES (?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$nom_groupe, $proprietaire_id, $description])) {
            echo "Groupe privé ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du groupe privé.";
        }
    } else {
        echo "Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Groupe Privé</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Ajouter un Groupe Privé</h1>
    <form method="POST" action="groupes_prives.php">
        <label for="nom_groupe">Nom du Groupe :</label>
        <input type="text" id="nom_groupe" name="nom_groupe" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>

        <button type="submit">Ajouter</button>
    </form>
</body>

</html>