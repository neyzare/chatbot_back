<?php

namespace App\Controllers;

class Messages {
  protected array $params;
  protected string $reqMethod;

  public function __construct($params) {
    $this->params = $params;
    $this->reqMethod = strtolower($_SERVER['REQUEST_METHOD']);

    $this->run();
  }

  protected function getMessages() {
    try {
      $bdd = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
      // Configure PDO pour qu'il lance des exceptions en cas d'erreur
      $bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

      // Requête pour récupérer les messages
      $stmt = $bdd->prepare("SELECT author, avatar, type, date, text, toto FROM messages");
      $stmt->execute();

      // Récupérer les résultats sous forme de tableau associatif
      $messages = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      return $messages;
  } catch(\PDOException $e) {
      // Gérer les erreurs de connexion à la base de données
      echo "Erreur de connexion à la base de données: " . $e->getMessage();
  }

  // Fermer la connexion PDO
  $bdd = null;
}
  }

  protected function header() {
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json; charset=utf-8');
  }

  protected function ifMethodExist() {
    $method = $this->reqMethod.'Messages';

    if (method_exists($this, $method)) {
      echo json_encode($this->$method());

      return;
    }

    header('HTTP/1.0 404 Not Found');
    echo json_encode([
      'code' => '404',
      'message' => 'Not Found'
    ]);

    return;
  }

  protected function run() {
    $this->header();
    $this->ifMethodExist();
  }
}
