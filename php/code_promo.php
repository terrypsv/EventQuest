<?php
require '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $description = $_POST['description'];
    $reduction = $_POST['reduction'];
    $valide_de = $_POST['valide_de'];
    $valide_jusqu_a = $_POST['valide_jusqu_a'];

    $sql = "INSERT INTO codes_promo (code, description, reduction, valide_de, valide_jusqu_a) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$code, $description, $reduction, $valide_de, $valide_jusqu_a])) {
        echo "Code promo ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du code promo.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Code Promo</title>
</head>

<body>
    <h1>Ajouter un Code Promo</h1>
    <form method="POST" action="creer_code_promo.php">
        <label for="code">Code Promo :</label>
        <input type="text" id="code" name="code" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description"></textarea>

        <label for="reduction">Réduction :</label>
        <input type="number" step="0.01" id="reduction" name="reduction" required>

        <label for="valide_de">Valide de :</label>
        <input type="datetime-local" id="valide_de" name="valide_de">

        <label for="valide_jusqu_a">Valide jusqu'à :</label>
        <input type="datetime-local" id="valide_jusqu_a" name="valide_jusqu_a">

        <button type="submit">Ajouter</button>
    </form>
</body>

</html>