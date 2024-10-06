<?php

require __DIR__ . '/../vendor/autoload.php'; // Charger Composer et dotenv

use Dotenv\Dotenv;  // Utilisation correcte de la classe Dotenv

// Charger le fichier .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Utilisation correcte du chemin pour charger .env
$dotenv->load();

// Paramètres de connexion à la base de données
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

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