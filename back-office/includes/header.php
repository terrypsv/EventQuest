<!DOCTYPE html>
<html lang="fr">

<?php
include_once __DIR__ . '/../sessions/session_start.php';

verifier_role('admin'); // Vérifie si l'utilisateur a le rôle d'administrateur
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-office</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="/back-office/dashboard.php">Tableau de bord</a></li>
                <li><a href="/back-office/utilisateurs/liste_utilisateurs.php">Utilisateurs</a></li>
                <li><a href="/back-office/events/liste_evenements.php">Événements</a></li>
                <li><a href="/back-office/agences/liste_agences.php">Agences</a></li>
            </ul>
        </nav>
    </header>
</body>

</html>