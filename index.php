<?php
// Inclusion de la connexion à la base de données
include 'includes/db_connection.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtenir la connexion PDO à la base de données
$pdo = getDatabaseConnection(); // Utilisation de la fonction pour récupérer l'objet PDO

// Requête pour récupérer les événements à venir
$sql = "SELECT * FROM evenements ORDER BY date_evenement ASC LIMIT 6";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page = 'index';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez les meilleurs événements près de chez vous avec EventQuest.">
    <title>EventQuest - Accueil</title>
    <!-- Bootstrap et CSS personnalisé -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">

    <style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        background-color: var(--primary-color);
    }

    main {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Section Hero avec image de fond */
    .hero-section {
        position: relative;
        height: 80vh;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        overflow: hidden;
        padding: 0 15px;
        /* Ajouté pour éviter de toucher les bords */
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("assets/images/event4.jpg") no-repeat center center/cover;
        opacity: 0.7;
        z-index: 0;
        backdrop-filter: blur(5px);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .hero-content h1 {
        font-size: 4rem;
        font-weight: bold;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        margin-bottom: 15px;
        /* Espace entre le titre et le texte */
    }

    .hero-content p {
        font-size: 1.5rem;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        margin-bottom: 20px;
        /* Espace entre le texte et le bouton */
    }

    .hero-content a {
        margin-top: 10px;
    }

    .scroll-down-arrow {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 2rem;
        color: white;
        animation: bounce 2s infinite;
        z-index: 2;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0) translateX(-50%);
        }

        50% {
            transform: translateY(10px) translateX(-50%);
        }
    }

    /* Centrage du contenu de la navbar */
    header .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        max-width: 1200px;
        /* Centrer tout le contenu dans une largeur maximale */
        margin: 0 auto;
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .navbar .nav {
        display: flex;
        gap: 20px;
    }

    .navbar-brand {
        font-size: 1.5rem;
        color: white;
    }

    .navbar-brand img {
        margin-right: 10px;
    }

    /* Section des événements */
    .events-section {
        background-color: rgba(0, 0, 0, 0.7);
        padding: 90px 0;
        color: white;
        text-align: center;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.8);
        color: black;
    }

    .card img {
        object-fit: cover;
        height: 200px;
    }

    /* Footer */
    footer {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        padding: 20px 0;
        text-align: center;
    }

    /* Surlignement blanc épuré pour l'onglet actif */
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

    /* Mode sombre */
    .dark-mode {
        background-color: var(--dark-bg);
        color: var(--dark-text);
    }

    .dark-mode header {
        background-color: var(--dark-primary);
    }

    .dark-mode .hero-section {
        background-color: var(--dark-primary);
    }

    .dark-mode .hero-section::before {
        background-color: rgba(0, 0, 0, 0.7);
    }

    .dark-mode .hero-content {
        background-color: transparent;
    }

    .dark-mode .btn-primary {
        background-color: var(--btn-bg);
        color: white;
    }

    .dark-mode .btn-primary:hover {
        background-color: var(--btn-hover-bg);
        color: black;
    }

    .dark-mode .events-section {
        background-color: rgba(0, 0, 0, 0.85);
    }
    </style>

</head>

<body>
    <header class="py-3" style="background-color: var(--primary-color);">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="index.php">
                    <img class="me-2" src="assets/images/logo.png" alt="Logo EventQuest" width="40" height="40" />
                </a>
                <a class="navbar-brand text-white" href="index.php" style="font-size: 1.5rem;">EventQuest</a>
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link text-white active" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="pages/event_details.php">Événements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="pages/about.php">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="pages/contact.php">Contact</a>
                </li>
            </ul>
            <button id="dark-mode-toggle" class="btn btn-dark">Mode Sombre</button>
        </div>
    </header>



    <!-- Hero Section avec la vidéo en fond -->
    <main>
        <section class="hero-section">
            <div class="hero-content">
                <h1>Bienvenue sur EventQuest</h1>
                <p>Découvrez les meilleurs événements près de chez vous</p>
                <a href="pages/event_details.php" class="btn btn-primary">Voir les événements</a>
            </div>
            <!-- Flèche incitant à descendre -->
            <div class="scroll-down-arrow">
                &#x2193;
                <!-- Symbole de flèche vers le bas -->
            </div>
        </section>

        <!-- Events Section légèrement visible dès l'arrivée -->
        <section class="events-section">
            <h2 class="mb-4">Événements à venir</h2>
            <div class="container">
                <div class="row">
                    <?php if (!empty($evenements)): ?>
                    <?php foreach ($evenements as $event): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="assets/images/event1.jpg" class="card-img-top" alt="Image de l'événement">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($event['titre']); ?></h5>
                                <p class="card-text">
                                    <?php echo htmlspecialchars(substr($event['description'], 0, 100)) . '...'; ?>
                                </p>
                                <a href="pages/event_details.php?id=<?php echo $event['id']; ?>"
                                    class="btn btn-primary mt-auto">En savoir plus</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>Aucun événement à afficher pour le moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
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