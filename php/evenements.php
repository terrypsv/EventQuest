<?php
require '../includes/db_connection.php'; // Connexion à la base de données
include_once __DIR__ . '/../sessions/session_start.php'; // Démarrer la session

// Vérifier si l'utilisateur a les permissions nécessaires (exemple : rôle "agence")
if ($_SESSION['role'] !== 'agence') {
    echo "Vous n'avez pas les permissions nécessaires pour créer un événement.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer et valider les champs
    $titre = trim($_POST['titre']);
    $agence_id = intval($_POST['agence_id']);
    $description = trim($_POST['description']);
    $categorie = trim($_POST['categorie']);
    $date_evenement = $_POST['date_evenement'];
    $emplacement = trim($_POST['emplacement']);
    $prix_billet = floatval($_POST['prix_billet']);
    $participants_max = intval($_POST['participants_max']);

    // Validation basique
    if (!empty($titre) && !empty($agence_id) && !empty($categorie) && !empty($date_evenement) && !empty($emplacement) && $prix_billet >= 0) {
        // Insertion des données dans la table evenements
        $sql = "INSERT INTO evenements (titre, agence_id, description, categorie, date_evenement, emplacement, prix_billet, participants_max, cree_le) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$titre, $agence_id, $description, $categorie, $date_evenement, $emplacement, $prix_billet, $participants_max])) {
            echo "Événement créé avec succès.";
        } else {
            echo "Erreur lors de la création de l'événement.";
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
    <title>Créer Événement</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Créer un nouvel événement</h1>
    <form method="POST" action="creer_evenement.php">
        <label for="titre">Titre de l'événement :</label>
        <input type="text" id="titre" name="titre" required>

        <label for="agence_id">ID Agence :</label>
        <input type="number" id="agence_id" name="agence_id" value="<?php echo $_SESSION['agence_id']; ?>" readonly>

        <label for="description">Description :</label>
        <textarea id="description" name="description"></textarea>

        <label for="categorie">Catégorie :</label>
        <input type="text" id="categorie" name="categorie" required>

        <label for="date_evenement">Date de l'événement :</label>
        <input type="datetime-local" id="date_evenement" name="date_evenement" required>

        <label for="emplacement">Emplacement :</label>
        <input type="text" id="emplacement" name="emplacement" required>

        <label for="prix_billet">Prix du billet :</label>
        <input type="number" step="0.01" id="prix_billet" name="prix_billet" required>

        <label for="participants_max">Nombre maximum de participants :</label>
        <input type="number" id="participants_max" name="participants_max">

        <button type="submit">Créer</button>
    </form>
</body>

</html>