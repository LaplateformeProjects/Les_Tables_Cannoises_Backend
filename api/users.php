<?php

require '../db/db.php';
require '../utils/connexion.php';
require '../utils/inscription.php';

header('Access-Control-Allow-Origin: http://localhost:3000'); // Autorisez l'origine du frontend
header('Access-Control-Allow-Methods: POST, OPTIONS'); // Autorisez les méthodes POST et OPTIONS
header('Access-Control-Allow-Headers: Content-Type'); // Autorisez l'en-tête Content-Type
header('Content-Type: application/json');

$response = ["success" => false, "message" => "Une erreur est survenue."];

try {
    // Vérifier les dépendances
    if (!file_exists('../db/db.php') || !file_exists('../utils/connexion.php') || !file_exists('../utils/inscription.php')) {
        throw new Exception("Erreur interne : fichiers nécessaires manquants.");
    }

    // Vérifier la méthode de requête
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Méthode non autorisée.");
    }

    // Récupérer les données
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['action'])) {
        throw new Exception("Action non spécifiée.");
    }

    // Exécuter l'action
    if ($data['action'] === 'inscription') {
        $response = inscription($pdo, $data);
    } elseif ($data['action'] === 'connexion') {
        $response = connexion($pdo, $data);
    } else {
        throw new Exception("Action inconnue.");
    }
} catch (Exception $e) {
    $response = ["success" => false, "message" => $e->getMessage()];
}

// Retourner la réponse
echo json_encode($response);

?>
