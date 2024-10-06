<?php
// Nettoyer et récupérer l'URI demandée
$request_uri = filter_var(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), FILTER_SANITIZE_URL);

// Route les différentes URL vers les fichiers correspondants
switch ($request_uri) {
    case '/':
    case '/accueil':
        require 'pages/index.php';
        break;

    case '/inscription':
        require 'pages/signup.php';
        break;
        
    case '/connexion':
        require 'pages/login.php';
        break;

    case '/deconnexion':
        require 'pages/logout.php';
        break;

    case '/admin':
        include 'includes/session_start.php';
        verifier_role('admin'); // Vérifie si l'utilisateur est un admin
        require 'pages/admin_dashboard.php';
        break;
        
    case '/agence':
        include 'includes/session_start.php';
        verifier_role('agence'); // Vérifie si l'utilisateur est une agence
        require 'pages/agence_dashboard.php';
        break;
    
    default:
        // Gérer les autres fichiers dans le répertoire /pages
        $filepath = __DIR__ . '/pages' . $request_uri . '.php';
        if (file_exists($filepath)) {
            require $filepath;
        } else {
            header("HTTP/1.0 404 Not Found");
            require __DIR__ . '/errors/404.php'; // Page d'erreur 404
        }
        break;
}