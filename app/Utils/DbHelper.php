<?php

namespace App\Utils;

use Config\Database;
use PDO;
use stdClass;

class DbHelper
{
  private $stmt;
  private $conn;

  public function __construct(PDO $db)
  {
    $this->conn = $db;
  }

  public function query(string $query, array $values = []): string
  {
    $this->stmt = $this->conn->prepare($query);
    
    return empty($values) 
      ? $this->stmt->execute() 
      : $this->stmt->execute($values);
  }

  public function rowCount(): int
  {
    return $this->stmt->rowCount();
  }

  public function fetch(): stdClass
  {
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  public function fetchAll(): array
  {
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getInsertId(): int
  {
    return $this->conn->lastInsertId();
  }

  public function startTransaction(): void
  {
    $this->conn->beginTransaction();
  }

  public function commit(): void
  {
    $this->conn->commit();
  }

  public function rollback(): void
  {
    $this->conn->rollBack();
  }
}