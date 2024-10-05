<?php
include '../includes/db_connection.php';
include_once __DIR__ . '/../sessions/session_start.php';

// Vérifie si l'utilisateur est un administrateur
verifier_role('admin');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom_utilisateur = trim($_POST['nom_utilisateur']);
    $email = trim($_POST['email']);
    $mot_de_passe = password_hash(trim($_POST['mot_de_passe']), PASSWORD_DEFAULT);
    $role = trim($_POST['role']);

    // Insertion dans la base de données
    $sql = "INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, role) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom_utilisateur, $email, $mot_de_passe, $role]);

    header("Location: liste_utilisateurs.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <h1>Ajouter un utilisateur</h1>
    <form action="ajouter_utilisateur.php" method="POST">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" name="nom_utilisateur" id="nom_utilisateur" required><br><br>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" required><br><br>

        <label for="role">Rôle :</label>
        <select name="role" id="role">
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select><br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>

</html>