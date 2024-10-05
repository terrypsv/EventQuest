<?php
// Options de session pour renforcer la sécurité des cookies
$session_options = [
    'cookie_httponly' => true,  // Empêche l'accès des cookies via JavaScript
    'cookie_secure'   => isset($_SERVER['HTTPS']),  // Assure que les cookies ne sont transmis que via HTTPS (vérifie si HTTPS est utilisé)
    'cookie_samesite' => 'Strict' // Prévient les fuites de cookies lors des requêtes cross-site
];

// Démarre la session si aucune n'est active avec des options de sécurité supplémentaires
if (session_status() === PHP_SESSION_NONE) {
    session_start($session_options);
    
    // Regénère l'ID de session à chaque démarrage pour prévenir les attaques de fixation de session
    session_regenerate_id(true);
}

// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: /login.php");
    exit;
}

// Fonction pour vérifier si l'utilisateur a le bon rôle
function verifier_role($role_necessaire) {
    // Si l'utilisateur n'a pas le rôle nécessaire, il est redirigé vers une page d'erreur
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role_necessaire) {
        header("Location: /error/403.php");
        exit;
    }
}

// Définir une durée de vie maximale pour la session (par exemple, 30 minutes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 1800) {
    // Si la session est inactive depuis plus de 30 minutes, la détruire
    session_unset();  // Désactive toutes les variables de session
    session_destroy();  // Détruit la session
    header("Location: /login.php");
    exit;
}

$_SESSION['last_activity'] = time(); // Mise à jour de l'horodatage de l'activité