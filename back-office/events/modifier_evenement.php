<?php
include '../includes/db_connection.php';
include '../includes/header.php';
include_once __DIR__ . '/../sessions/session_start.php';

verifier_role('admin'); // Vérifie si l'utilisateur est un administrateur

// Récupérer l'ID de l'événement à modifier
$event_id = $_GET['id'];

// Requête pour récupérer les informations actuelles de l'événement
$sql = "SELECT * FROM evenements WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $date_evenement = $_POST['date_evenement'];
    $emplacement = trim($_POST['emplacement']);

    // Requête de mise à jour
    $sql_update = "UPDATE evenements SET titre = ?, description = ?, date_evenement = ?, emplacement = ? WHERE id = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$titre, $description, $date_evenement, $emplacement, $event_id]);

    // Redirection vers la liste des événements après modification
    header("Location: liste_evenements.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'événement</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <h1>Modifier l'événement</h1>
    <form action="modifier_evenement.php?id=<?php echo $event_id; ?>" method="POST">
        <label for="titre">Titre :</label>
        <input type="text" name="titre" id="titre" value="<?php echo htmlspecialchars($event['titre']); ?>"
            required><br><br>

        <label for="description">Description :</label>
        <textarea name="description" id="description"
            required><?php echo htmlspecialchars($event['description']); ?></textarea><br><br>

        <label for="date_evenement">Date de l'événement :</label>
        <input type="datetime-local" name="date_evenement" id="date_evenement"
            value="<?php echo htmlspecialchars($event['date_evenement']); ?>" required><br><br>

        <label for="emplacement">Emplacement :</label>
        <input type="text" name="emplacement" id="emplacement"
            value="<?php echo htmlspecialchars($event['emplacement']); ?>" required><br><br>

        <button type="submit">Mettre à jour</button>
    </form>
</body>

</html>