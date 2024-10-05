<?php
include '../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php';

// Vérifie si l'utilisateur est un administrateur
verifier_role('admin');

$id = $_GET['id']; // Récupérer l'ID de l'utilisateur

// Récupérer les informations actuelles de l'utilisateur
$sql = "SELECT * FROM utilisateurs WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mise à jour des informations utilisateur
    $nom_utilisateur = trim($_POST['nom_utilisateur']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);

    $sql = "UPDATE utilisateurs SET nom_utilisateur = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom_utilisateur, $email, $role, $id]);

    header("Location: liste_utilisateurs.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <h1>Modifier un utilisateur</h1>
    <form action="modifier_utilisateur.php?id=<?php echo $id; ?>" method="POST">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" name="nom_utilisateur" id="nom_utilisateur"
            value="<?php echo htmlspecialchars($user['nom_utilisateur']); ?>" required><br><br>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>"
            required><br><br>

        <label for="role">Rôle :</label>
        <select name="role" id="role">
            <option value="admin" <?php if($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="user" <?php if($user['role'] == 'user') echo 'selected'; ?>>User</option>
        </select><br><br>

        <button type="submit">Mettre à jour</button>
    </form>
</body>

</html>