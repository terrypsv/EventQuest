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

    // Si aucun événement n'est trouvé, afficher un message à l'utilisateur
    if (!$event) {
        $event_not_found = true;
    }
} else {
    // Si aucun ID n'est fourni, afficher un message d'erreur
    $event_not_found = true;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Détails de l'événement <?php echo isset($event['titre']) ? htmlspecialchars($event['titre']) : 'Événement non trouvé'; ?>.">
    <title><?php echo isset($event['titre']) ? htmlspecialchars($event['titre']) : 'Événement non trouvé'; ?> - Détails
    </title>
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

    .event-placeholder {
        height: 200px;
        background-color: #f0f0f0;
        border: 2px dashed #ccc;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #999;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <!-- Header avec le bouton de mode sombre -->
    <header class="py-3" style="background-color: var(--primary-color);">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="../index.php">
                    <img class="me-2" src="../assets/images/logo.png" alt="Logo EventQuest" width="40" height="40" />
                </a>
                <a class="navbar-brand text-white" href="../index.php" style="font-size: 1.5rem;">EventQuest</a>
            </div>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link text-white" href="../index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="../pages/event_details.php">Événements</a>
                </li>
                <li class="nav-item"><a class="nav-link text-white" href="../pages/about.php">À propos</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="../pages/contact.php">Contact</a></li>
            </ul>
            <button id="dark-mode-toggle" class="btn btn-dark">Mode Sombre</button>
        </div>
    </header>

    <!-- Détails de l'événement -->
    <main class="container my-5">
        <?php if (isset($event_not_found) && $event_not_found): ?>
        <div class="text-center">
            <h1 style="color: var(--primary-color);">Événement non trouvé</h1>
            <p>Aucun événement correspondant à cet identifiant n'a été trouvé. Veuillez vérifier l'URL ou revenir à la
                page des événements.</p>
        </div>
        <?php else: ?>
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
        <?php endif; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>