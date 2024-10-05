<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Paramètres de connexion à la base de données
$host = 'localhost:8889'; // Pour un environnement local, remplacer l'IP par localhost
$dbname = 'eventquest';
$username = 'eventquest_user';
$password = 'root';

// Fonction pour établir la connexion à la base de données
function getDatabaseConnection() {
    global $host, $dbname, $username, $password;
    
    try {
        // Initialiser la connexion PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Retourner l'objet PDO pour les opérations
        return $pdo;
    } catch (PDOException $e) {
        // Enregistrer les erreurs dans le fichier log
        error_log("Erreur de connexion à la base de données : " . $e->getMessage(), 0);
        // Afficher un message générique sans détails sensibles
        die("Erreur de connexion. Veuillez réessayer plus tard.");
    }
}

// Exemple d'utilisation :
// $db = getDatabaseConnection();