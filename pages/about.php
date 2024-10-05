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
                <a href="../index.php">
                    <img class="me-2" src="../assets/images/logo.png" alt="Logo EventQuest" width="40" height="40" />
                </a>
                <a class="navbar-brand text-white" href="../index.php" style="font-size: 1.5rem;">EventQuest</a>
            </div>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link text-white" href="../index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="contact.php">Contact</a></li>
            </ul>
            <!-- Bouton de bascule du mode sombre -->
            <button id="dark-mode-toggle" class="btn btn-dark">Mode Sombre</button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container py-5">
        <h1 class="text-center mb-4" style="color: var(--primary-color);">EventQuest, c'est quoi ?</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <p class="text-center">
                    EventQuest est une plateforme permettant de découvrir et de participer aux événements les plus
                    excitants
                    de Paris. Que vous soyez passionné de concerts, d'expositions, ou d'événements sportifs, EventQuest
                    est
                    là pour vous permettre de trouver l'événement parfait.
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>

</html>