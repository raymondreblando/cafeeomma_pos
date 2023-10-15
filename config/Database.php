<?php

namespace Config;

use Dotenv\Dotenv;
use PDO;

class Database
{
  protected $conn;

  public function getConnetion($host, $db, $username, $password): PDO
  {
    try {
      $this->conn = new PDO('mysql:host=' . $host . ';dbname=' . $db, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
      throw new Exception('Connection failed '. $e->getMessage());
    }

    return $this->conn;
  }
}