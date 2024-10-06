<?php
// Activer les rapports d'erreurs en développement
ini_set('display_errors', 1); // À désactiver en production (mettre à 0)
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/error.log'); // Chemin vers le fichier log

// Afficher un message générique en cas d'erreur
function errorHandler($errno, $errstr, $errfile, $errline) {
    echo "<h1>Erreur interne du serveur. Veuillez réessayer plus tard.</h1>";
    exit();
}

// Utiliser une fonction personnalisée pour gérer les erreurs
set_error_handler('errorHandler');