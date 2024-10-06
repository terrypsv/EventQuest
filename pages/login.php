<?php
session_start();
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête pour récupérer l'utilisateur
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Si l'authentification est réussie
        $_SESSION['user_id'] = $user['id'];
        header('Location: ../pages/event_details.php');
        exit;
    } else {
        $error = "Identifiants incorrects.";
    }
}

$page = 'login'; // Pour l'active class dans le header
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connexion à EventQuest">
    <title>Connexion - EventQuest</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- En-tête -->
    <header class="py-3" style="background-color: var(--primary-color);">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <!-- Logo -->
                <a href="/index.php">
                    <img class="me-2" src="/assets/images/logo.png" alt="Logo EventQuest" width="40" height="40" />
                </a>
                <!-- Titre du site -->
                <a class="navbar-brand text-white" href="/index.php" style="font-size: 1.5rem;">EventQuest</a>
            </div>
            <ul class="nav">
                <!-- Navigation avec active class -->
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
                <!-- Boutons S'inscrire/Se connecter si pas connecté, ou Profil/Se déconnecter -->
                <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="/pages/signup.php" class="btn btn-primary me-2">S'inscrire</a>
                <a href="/pages/login.php" class="btn btn-outline-light me-3">Se connecter</a>
                <?php else: ?>
                <a href="/pages/profil.php" class="btn btn-success me-3">Mon Profil</a>
                <a href="/pages/logout.php" class="btn btn-danger">Se déconnecter</a>
                <?php endif; ?>
                <!-- Bouton Mode Sombre -->
                <button id="dark-mode-toggle" class="btn btn-dark">Mode Sombre</button>
            </div>
        </div>
    </header>

    <!-- Formulaire de connexion -->
    <main class="container my-5">
        <h1 class="text-center mb-4" style="color: var(--primary-color);">Connexion</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="login.php" class="p-4 border rounded shadow-sm bg-light">
                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>

                <div class="text-center mt-3">
                    <a href="/pages/signup.php" class="text-primary">Pas encore de compte ? S'inscrire ici</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-3" style="background-color: var(--primary-color); color: var(--secondary-color);">
        <p>&copy; 2024 EventQuest. Tous droits réservés.</p>
    </footer>

    <!-- JavaScript pour le mode sombre -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const darkModeToggle = document.getElementById("dark-mode-toggle");
        const body = document.body;

        if (localStorage.getItem("darkMode") === "enabled") {
            body.classList.add("dark-mode");
        }

        darkModeToggle.addEventListener("click", function() {
            body.classList.toggle("dark-mode");

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