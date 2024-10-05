<?php
include_once __DIR__ . '/../sessions/session_start.php';
include_once __DIR__ . '/../includes/db_connection.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: /php/login.php');
    exit;
}

$utilisateur_id = $_SESSION['utilisateur_id'];
$message = ''; // Variable pour afficher des messages d'erreur ou succès

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Protection contre les attaques CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "Échec de la vérification CSRF. Veuillez réessayer.";
    } else {
        $email = trim($_POST['email']);
        $nom_complet = trim($_POST['nom_complet']);

        // Validation des champs
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Adresse email invalide.";
        } elseif (empty($nom_complet)) {
            $message = "Le nom complet ne peut pas être vide.";
        } else {
            // Mettre à jour les informations de l'utilisateur
            $query = "UPDATE utilisateurs SET email = :email, nom_complet = :nom_complet, mis_a_jour_le = NOW() WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nom_complet', $nom_complet);
            $stmt->bindParam(':id', $utilisateur_id);

            if ($stmt->execute()) {
                $message = "Profil mis à jour avec succès.";
            } else {
                $message = "Erreur lors de la mise à jour du profil.";
            }
        }
    }
}

// Générer un token CSRF pour ce formulaire
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Récupérer les informations de l'utilisateur pour pré-remplir le formulaire
$query = "SELECT email, nom_complet FROM utilisateurs WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $utilisateur_id);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$utilisateur) {
    echo "Utilisateur introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <h1>Modifier le Profil</h1>

    <?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($utilisateur['email']); ?>"
            required>
        <br>
        <label for="nom_complet">Nom complet :</label>
        <input type="text" id="nom_complet" name="nom_complet"
            value="<?php echo htmlspecialchars($utilisateur['nom_complet']); ?>" required>
        <br>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <button type="submit">Mettre à jour</button>
    </form>

    <a href="/php/profil.php">Retour au profil</a>

    <footer>
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>
</body>

</html>