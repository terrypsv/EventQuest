<?php
require '../includes/db_connection.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_utilisateur = trim($_POST['nom_utilisateur']);
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $nom_complet = trim($_POST['nom_complet']);
    $role = $_POST['role'];

    // Validation de l'email et des champs requis
    if (empty($nom_utilisateur) || empty($email) || empty($mot_de_passe)) {
        echo "Tous les champs obligatoires doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse email invalide.";
    } else {
        // Hachage du mot de passe
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

        // Insertion dans la base de données
        $sql = "INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, nom_complet, role, cree_le) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nom_utilisateur, $email, $mot_de_passe_hash, $nom_complet, $role])) {
            echo "Utilisateur créé avec succès.";
        } else {
            echo "Erreur lors de la création de l'utilisateur.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer Utilisateur</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <h1>Créer un nouvel utilisateur</h1>
    <form method="POST" action="">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>

        <label for="nom_complet">Nom complet :</label>
        <input type="text" id="nom_complet" name="nom_complet">

        <label for="role">Rôle :</label>
        <select id="role" name="role">
            <option value="admin">Admin</option>
            <option value="agence">Agence</option>
            <option value="client">Client</option>
        </select>

        <button type="submit">Créer</button>
    </form>
</body>

</html>