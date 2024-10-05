<?php
// On récupère l'URI demandée
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route les différentes URL vers les fichiers correspondants
switch ($request_uri) {
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
        include 'session_start.php';
        verifier_role('admin'); // Vérifie si l'utilisateur est un admin
        require 'pages/admin_dashboard.php';
        break;
        
    case '/agence':
        include 'session_start.php';
        verifier_role('agence'); // Vérifie si l'utilisateur est une agence
        require 'pages/agence_dashboard.php';
        break;
    
    default:
        // Si la route ne correspond à aucune des pages précédentes
        if (file_exists('pages' . $request_uri . '.php')) {
            require 'pages' . $request_uri . '.php';
        } else {
            require 'errors/404.php'; // Page d'erreur 404
        }
        break;
}