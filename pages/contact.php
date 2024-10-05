<?php
// Gestion des messages d'erreur et de succès après soumission du formulaire
if (isset($_GET['success'])) {
    echo "<div class='alert alert-success'>Votre message a bien été envoyé. Merci de nous avoir contacté.</div>";
}
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'email':
            echo "<div class='alert alert-danger'>Adresse email non valide.</div>";
            break;
        case 'fields':
            echo "<div class='alert alert-danger'>Tous les champs sont requis.</div>";
            break;
        case 'database':
            echo "<div class='alert alert-danger'>Erreur lors de l'envoi du message. Veuillez réessayer plus tard.</div>";
            break;
        case 'method':
            echo "<div class='alert alert-danger'>Méthode non supportée.</div>";
            break;
    }
}

$page = 'contact';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contactez EventQuest pour toutes vos questions ou informations supplémentaires.">
    <title>EventQuest - Contact</title>
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
        justify-content: space-between;
        background-color: var(--secondary-color);
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    main {
        flex: 1;
    }

    /* Brillance subtile pour les liens de navigation */
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

    @keyframes shine {
        0% {
            width: 0;
        }

        50% {
            width: 100%;
        }

        100% {
            width: 0;
        }
    }
    </style>
</head>

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
                <li class="nav-item">
                    <a class="nav-link text-white" href="../index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../pages/event_details.php">Événements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="about.php">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white active" href="contact.php">Contact</a>
                </li>
            </ul>
            <button id="dark-mode-toggle" class="btn btn-dark">Mode Sombre</button>
        </div>
    </header>


    <!-- Section de contact -->
    <main class="container py-5">
        <h1 class="text-center mb-4" style="color: var(--primary-color);">Contactez-nous</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form class="row g-3" action="../includes/traiter_contact.php" method="post">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nom :</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Écrivez votre nom"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email :</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Écrivez votre email" required>
                    </div>
                    <div class="col-12">
                        <label for="message" class="form-label">Message :</label>
                        <textarea class="form-control" id="message" name="message" rows="5"
                            placeholder="Écrivez votre message" required></textarea>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-3" style="background-color: var(--primary-color); color: var(--secondary-color);">
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>