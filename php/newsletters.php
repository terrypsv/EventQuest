<?php
require '../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php'; // Session pour vérifier si l'utilisateur est connecté

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

    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);

    if (!empty($titre) && !empty($contenu)) {
        $sql = "INSERT INTO newsletters (titre, contenu, envoye_le) VALUES (?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$titre, $contenu])) {
            echo "Newsletter créée avec succès.";
        } else {
            echo "Erreur lors de la création de la newsletter.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Newsletter</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Ajouter une Newsletter</h1>
    <form method="POST" action="">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required>

        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" required></textarea>

        <!-- Ajout d'un champ CSRF pour la protection -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <button type="submit">Ajouter</button>
    </form>

    <a href="/php/newsletter_liste.php">Voir la liste des newsletters</a>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>