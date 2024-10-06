<?php

session_start();
// Définir la variable pour surligner l'onglet actif
$page = 'about';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="EventQuest - Découvrez la plateforme qui vous permet de participer aux événements excitants de Paris.">
    <title>EventQuest - À propos</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background-color: var(--secondary-color);
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    main {
        flex: 1;
    }

    /* Surlignement blanc pour l'onglet actif */
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

    .dark-mode .nav-link.active {
        border-bottom: 2px solid #ffffff;
        color: var(--dark-text);
    }

    .dark-mode .container,
    .dark-mode .text-center {
        color: var(--dark-text);
    }

    /* Couleurs du bouton en mode sombre */
    .dark-mode .btn-primary {
        background-color: #333;
        color: white;
    }

    .dark-mode .btn-primary:hover {
        background-color: var(--btn-hover-bg);
        color: black;
    }

    .dark-mode footer {
        background-color: var(--dark-primary);
        color: var(--dark-secondary);
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

    <!-- Main Content -->
    <main class="container py-5">
        <h1 class="text-center mb-4" style="color: var(--primary-color);">EventQuest, c'est quoi ?</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <p class="text-center">
                    EventQuest est une plateforme permettant de découvrir et de participer aux événements les plus
                    excitants de Paris. Que vous soyez passionné de concerts, d'expositions, ou d'événements sportifs,
                    EventQuest est là pour vous permettre de trouver l'événement parfait.
                </p>
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