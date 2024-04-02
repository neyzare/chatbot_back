<?php

// Assurez-vous que les en-têtes CORS sont définis pour permettre les requêtes depuis votre domaine JavaScript
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

// Vérifiez que la méthode de la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez les données envoyées depuis JavaScript
    $message = $_POST['message'];
    $date = date('Y-m-d H:i:s'); // Récupérez la date actuelle

    // Insérez les données dans la base de données
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "chatbot";

    try {
        $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $bdd->prepare("INSERT INTO messages (text_message, date) VALUES (:message, :date)");
        $sql->bindParam(':message', $message);
        $sql->bindParam(':date', $date);
        $sql->execute();

        echo json_encode(['success' => true]);
    } catch(PDOException $e) {
        echo json_encode(['error' => 'Erreur lors de l\'insertion dans la base de données: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Méthode non autorisée']);
}
