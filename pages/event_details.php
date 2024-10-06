<?php
// Démarrer la session pour la gestion des utilisateurs connectés
session_start();

// Inclusion de la connexion à la base de données
include '../includes/db_connection.php';

// Obtenir la connexion à la base de données
$pdo = getDatabaseConnection(); // Appelle la fonction pour récupérer la connexion PDO

if (!$pdo) {
    die("Erreur de connexion à la base de données.");
}
// Requête pour récupérer tous les événements
$sql = "SELECT * FROM evenements";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur est connecté
$loggedIn = isset($_SESSION['user_id']); // ou une autre condition selon ton système de connexion

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$page = 'event_details';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez nos événements à venir.">
    <title>EventQuest - Événements</title>
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

    .nav-link.active {
        border-bottom: 2px solid #ffffff;
        color: white !important;
    }

    .nav-link {
        padding-bottom: 5px;
    }

    .nav-link:hover {
        color: white;
        text-decoration: none;
    }

    .event-placeholder {
        height: 200px;
        background-color: #f8f9fa;
        border: 2px solid #dee2e6;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #6c757d;
        margin-bottom: 20px;
        border-radius: 10px;
    }

    .add-event-btn {
        background-color: #507bdc;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .add-event-btn:hover {
        background-color: #3b5bb2;
    }
    </style>
</head>

<body>
    <header class="py-3" style="background-color: var(--primary-color);">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <!-- Logo avec chemin absolu -->
                <a href="/index.php">
                    <img class="me-2" src="/assets/images/logo.png" alt="Logo EventQuest" width="40" height="40" />
                </a>
                <!-- Titre de la marque -->
                <a class="navbar-brand text-white" href="/index.php" style="font-size: 1.5rem;">EventQuest</a>
            </div>
            <ul class="nav">
                <!-- Liens de navigation avec gestion de la classe active dynamiquement -->
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($page === 'index') echo 'active'; ?>"
                        href="/index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($page === 'event_details') echo 'active'; ?>"
                        href="/pages/event_details.php">Événements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($page === 'about') echo 'active'; ?>"
                        href="/pages/about.php">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php if ($page === 'contact') echo 'active'; ?>"
                        href="/pages/contact.php">Contact</a>
                </li>
            </ul>
            <div class="d-flex">
                <!-- Vérification de la session utilisateur pour afficher les boutons appropriés -->
                <?php if (!isset($_SESSION['user_id'])): ?>
                <!-- Boutons S'inscrire et Se connecter si l'utilisateur n'est pas connecté -->
                <a href="/pages/signup.php" class="btn btn-primary me-2">S'inscrire</a>
                <a href="/pages/login.php" class="btn btn-outline-light me-3">Se connecter</a>
                <?php else: ?>
                <!-- Boutons Mon Profil et Se déconnecter si l'utilisateur est connecté -->
                <a href="/pages/profil.php" class="btn btn-success me-3">Mon Profil</a>
                <a href="/pages/logout.php" class="btn btn-danger">Se déconnecter</a>
                <?php endif; ?>
                <!-- Bouton Mode Sombre -->
                <button id="dark-mode-toggle" class="btn btn-dark">Mode Sombre</button>
            </div>
        </div>
    </header>

    <!-- Liste des événements -->
    <main class="container my-5">
        <h1 class="text-center mb-5" style="color: var(--primary-color);">Événements à venir</h1>

        <div class="row">
            <?php if (count($evenements) > 0): ?>
            <?php foreach ($evenements as $event): ?>
            <div class="col-md-4 mb-4">
                <div class="event-placeholder">
                    <p><?php echo htmlspecialchars($event['titre']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <!-- Si aucun événement, affiche trois blocs vides -->
            <div class="col-md-4 mb-4">
                <div class="event-placeholder">
                    <p>Aucun événement pour l'instant</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="event-placeholder">
                    <p>Aucun événement pour l'instant</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="event-placeholder">
                    <p>Aucun événement pour l'instant</p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Bouton pour ajouter un événement (visible seulement pour les utilisateurs connectés) -->
        <div class="text-center mt-5">
            <?php if ($loggedIn): ?>
            <button class="add-event-btn" onclick="window.location.href='add_event.php'">Ajouter un
                événement</button>
            <?php else: ?>
            <p><a href="../pages/login.php" class="btn btn-primary">Se connecter pour ajouter des événements</a></p>
            <?php endif; ?>
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

        // Vérifie si l'utilisateur a une préférence de mode sombre stockée dans le localStorage
        if (localStorage.getItem("darkMode") === "enabled") {
            body.classList.add("dark-mode");
        }

        // Bascule le mode sombre lorsque l'utilisateur clique sur le bouton
        darkModeToggle.addEventListener("click", function() {
            body.classList.toggle("dark-mode");

            // Sauvegarde la préférence dans le localStorage
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