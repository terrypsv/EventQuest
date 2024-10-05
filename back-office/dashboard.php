<?php

include 'includes/db_connection.php';
include 'includes/header.php';
include_once __DIR__ . '/../sessions/session_start.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

verifier_role('admin'); // Vérifie si l'utilisateur est un administrateur

// Récupérer le nombre d'utilisateurs
$sql_users = "SELECT COUNT(*) AS total_users FROM utilisateurs";
$stmt_users = $pdo->query($sql_users);
$total_users = $stmt_users->fetch(PDO::FETCH_ASSOC)['total_users'];

// Récupérer le nombre d'événements
$sql_events = "SELECT COUNT(*) AS total_events FROM evenements";
$stmt_events = $pdo->query($sql_events);
$total_events = $stmt_events->fetch(PDO::FETCH_ASSOC)['total_events'];

// Récupérer le nombre d'agences
$sql_agences = "SELECT COUNT(*) AS total_agences FROM agences";
$stmt_agences = $pdo->query($sql_agences);
$total_agences = $stmt_agences->fetch(PDO::FETCH_ASSOC)['total_agences'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="dashboard">
        <h1>Tableau de bord</h1>

        <div class="stats">
            <div class="stat-box">
                <h2><?php echo $total_users; ?></h2>
                <p>Utilisateurs enregistrés</p>
            </div>
            <div class="stat-box">
                <h2><?php echo $total_events; ?></h2>
                <p>Événements organisés</p>
            </div>
            <div class="stat-box">
                <h2><?php echo $total_agences; ?></h2>
                <p>Agences inscrites</p>
            </div>
        </div>
    </div>
</body>

</html>