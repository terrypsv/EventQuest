<?php
// Démarre une session si elle n'a pas encore été démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Fonction pour vérifier si un utilisateur est connecté.
 * 
 * @return bool Retourne true si l'utilisateur est connecté, sinon false.
 */
function estConnecte() {
    return isset($_SESSION['user_id']); // Vérifie si l'ID utilisateur est défini dans la session
}

/**
 * Fonction pour vérifier le rôle de l'utilisateur connecté.
 * Cette fonction permet de restreindre l'accès à certaines pages selon le rôle.
 * 
 * @param string $role Le rôle à vérifier (admin, agence, utilisateur, etc.).
 * 
 * @return bool Retourne true si l'utilisateur a le rôle requis, sinon false.
 */
function verifier_role($role) {
    if (!estConnecte()) {
        // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
        header('Location: /pages/login.php');
        exit();
    }

    // Vérifier si le rôle de l'utilisateur correspond à celui attendu
    if (isset($_SESSION['role']) && $_SESSION['role'] === $role) {
        return true;
    } else {
        // Si le rôle ne correspond pas, rediriger vers une page d'accès refusé ou d'erreur
        header('Location: /errors/403.php'); // Page d'erreur pour accès non autorisé
        exit();
    }
}

/**
 * Fonction pour terminer la session et déconnecter l'utilisateur.
 */
function deconnexion() {
    // Détruit toutes les variables de session
    $_SESSION = [];

    // Si vous voulez détruire complètement la session, utilisez également session_destroy()
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Détruire la session
    session_destroy();

    // Rediriger vers la page de connexion ou d'accueil après la déconnexion
    header('Location: /pages/login.php');
    exit();
}