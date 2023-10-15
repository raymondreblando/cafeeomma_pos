<?php

namespace App\Utils;

use Ramsey\Uuid\Uuid;
use DateTime;

class Utilities
{
  public static function sanitize(string $data): string
  {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
  }

  public static function uuid(): string
  {
    $uuid = Uuid::uuid4();
    return $uuid->toString();
  }

  public static function hashPassword(string $password): string
  {
    return password_hash($password, PASSWORD_BCRYPT, [10]);
  }

  public static function formatDate(string $date, string $format): string
  {
    return date($format, strtotime($date));
  }

  public static function getPercentage(int $total, int $count): int
  {
    return ($count / $total) * 100;
  }

  public static function generateOrderNo(): int
  {
    return rand(000000, 999999);
  }

  public static function response(string $type, string $message): string
  {
    return json_encode(
      array(
        "type" => $type,
        "message" => $message
      )
    );
  }

  public static function isAdmin(): bool
  {
    return isset($_SESSION['role']) AND $_SESSION['role'] == "b2fd54eb-4e49-11ee-8673-088fc30176f9" ? true : false;
  }

  public static function isEmployee(): bool
  {
    return isset($_SESSION['role']) AND $_SESSION['role'] == "b2fd6f62-4e49-11ee-8673-088fc30176f9" ? true : false;
  }

  public static function redirectUnauthorize(): void
  {
    if(!isset($_SESSION['uid']) AND !isset($_SESSION['role'])){
      header('Location: '.SYSTEM_URL.'');
      exit();
    }
  }

  public static function redirectAuthorize(string $route): void
  {
    if(isset($_SESSION['uid']) AND isset($_SESSION['role'])){
      header('Location: '.SYSTEM_URL.''.$route.'');
      exit();
    }
  }
}