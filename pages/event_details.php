<?php
// Inclusion de la connexion à la base de données
include '../includes/db_connection.php';

// Vérification de l'ID de l'événement dans l'URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Requête pour récupérer l'événement
    $sql = "SELECT * FROM evenements WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si aucun événement n'est trouvé, rediriger vers une page d'erreur
    if (!$event) {
        header("Location: ../errors/404.php");
        exit;
    }
} else {
    // Si aucun ID n'est fourni, rediriger vers une page d'erreur
    header("Location: ../errors/404.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Détails de l'événement <?php echo htmlspecialchars($event['titre']); ?>.">
    <title><?php echo htmlspecialchars($event['titre']); ?> - Détails</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }
    </style>
</head>

<body>
    <!-- Header avec le bouton de mode sombre -->
    <header class="py-3" style="background-color: var(--primary-color);">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="index.php">
                    <img class="me-2" src="assets/images/logo.png" alt="Logo EventQuest" width="40" height="40" />
                </a>
                <a class="navbar-brand text-white" href="index.php" style="font-size: 1.5rem;">EventQuest</a>
            </div>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link text-white" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="pages/event_details.php">Événements</a></li>
                <!-- Redirection vers event_details.php -->
                <li class="nav-item"><a class="nav-link text-white" href="pages/about.php">À propos</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="pages/contact.php">Contact</a></li>
            </ul>
            <!-- Bouton de bascule du mode sombre -->
            <button id="dark-mode-toggle" class="btn btn-dark">Mode Sombre</button>
        </div>
    </header>


    <!-- Détails de l'événement -->
    <main class="container my-5">
        <h1 class="text-center" style="color: var(--primary-color);"><?php echo htmlspecialchars($event['titre']); ?>
        </h1>
        <p class="text-center mb-4">Date et lieu : <?php echo htmlspecialchars($event['date_evenement']); ?> à
            <?php echo htmlspecialchars($event['emplacement']); ?></p>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>

                <!-- Bouton de réservation -->
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-primary btn-lg">Réserver maintenant</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-3" style="background-color: var(--primary-color); color: var(--secondary-color);">
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>

    <!-- JavaScript pour gérer le mode sombre -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const darkModeToggle = document.getElementById("dark-mode-toggle");
        const body = document.body;

        // Vérifier si l'utilisateur a une préférence de mode sombre stockée dans le localStorage
        if (localStorage.getItem("darkMode") === "enabled") {
            body.classList.add("dark-mode");
        }

        // Bascule le mode sombre lorsque l'utilisateur clique sur le bouton
        darkModeToggle.addEventListener("click", function() {
            body.classList.toggle("dark-mode");

            // Sauvegarder la préférence dans le localStorage
            if (body.classList.contains("dark-mode")) {
                localStorage.setItem("darkMode", "enabled");
            } else {
                localStorage.removeItem("darkMode");
            }
        });
    });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>

</html>