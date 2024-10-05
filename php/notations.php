<?php
require '../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php'; // Pour gérer la session

// Protection CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Erreur de vérification. Veuillez réessayer.";
        exit;
    }

    $utilisateur_id = $_POST['utilisateur_id'];
    $evenement_id = $_POST['evenement_id'];
    $note = $_POST['note'];
    $commentaire = $_POST['commentaire'];

    // Validation des données
    if (!empty($utilisateur_id) && !empty($evenement_id) && !empty($note)) {
        $sql = "INSERT INTO notations (utilisateur_id, evenement_id, note, commentaire, cree_le) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$utilisateur_id, $evenement_id, $note, $commentaire])) {
            echo "Notation ajoutée avec succès.";
        } else {
            echo "Erreur lors de l'ajout de la notation.";
        }
    } else {
        echo "Tous les champs obligatoires doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Notation</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Ajouter une Notation</h1>
    <form method="POST" action="creer_notation.php">
        <label for="utilisateur_id">ID Utilisateur :</label>
        <input type="number" id="utilisateur_id" name="utilisateur_id" required>

        <label for="evenement_id">ID Événement :</label>
        <input type="number" id="evenement_id" name="evenement_id" required>

        <label for="note">Note :</label>
        <input type="number" id="note" name="note" min="1" max="5" required>

        <label for="commentaire">Commentaire (optionnel) :</label>
        <textarea id="commentaire" name="commentaire"></textarea>

        <!-- Ajout d'un champ CSRF pour la protection -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <button type="submit">Ajouter</button>
    </form>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>