<?php

namespace App\Models;

use \PDO;

class MessageModel {
  protected $db;

  public function __construct() {
    $this->db = $this->getDbConnection();
  }

  protected function getDbConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "chatbot";

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      // Définir le mode d'erreur PDO sur exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch(PDOException $e) {
      throw new Exception("Erreur de connexion à la base de données: " . $e->getMessage());
    }
  }

  public function getMessages() {
    $stmt = $this->db->prepare("SELECT * FROM messages");
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $messages;
  }
}

?>
