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

  public static function calculateVat(int $price): float
  {
    return $price * (5 / 100);
  }

  public static function convertUnit(string $value, string $unit, string $type = ''): float
  {
    $unit_value = 0;

    if ($unit === 'milliliter') {
      $unit_value = $value;
    } elseif ($unit === 'liter') {
      $unit_value = $type === '' ? $value * 1000 : $value / 1000;
    } elseif ($unit === 'milligram') {
      $unit_value = $value;
    } elseif ($unit === 'gram') {
      $unit_value = $type === '' ? $value * 1000 : $value / 1000;
    } else {
      $unit_value = $type === '' ? $value * 1000000 : $value / 1000000;
    }

    return $unit_value;
  }

  public static function convertUnitValue(string $value, string $unit): string
  {
    $newUnitName = "";

    if ($unit === 'liter' && $value < 1000) {
      $newUnitName = "milliliter";
    }  elseif ($unit === 'gram' && $value < 1000) {
      $newUnitName = "milligram";
    } elseif ($unit === 'kilogram' && $value < 1000000) {
      $newUnitName = "gram";
    } else {
      $newUnitName = $unit;
    }

    return $newUnitName;
  }

  public static function getEquivalentUnitName(string $acronym): string
  {
    $equivalentName = "";

    if ($acronym === "ml" || $acronym === "Ml" || $acronym === "ML") {
      $equivalentName = "milliliter";    
    } elseif ($acronym === "l" || $acronym === "L") {
      $equivalentName = "liter";    
    } elseif ($acronym === "mg" || $acronym === "Mg" || $acronym === "MG") {
      $equivalentName = "milligram";    
    } elseif ($acronym === "g" || $acronym === "G") {
      $equivalentName = "gram";    
    } else {
      $equivalentName = "kilogram";
    }

    return $equivalentName;
  }

  public static function getEquivalentAcronym(string $name): string
  {
    $acronym = "";

    if ($name === "milliliter") {
      $acronym = "ml";    
    } elseif ($name === "liter") {
      $acronym = "l";    
    } elseif ($name === "milligram") {
      $acronym = "mg";    
    } elseif ($name === "gram") {
      $acronym = "g";    
    } else {
      $acronym = "kg";
    }

    return $acronym;
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