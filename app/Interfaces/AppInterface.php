<?php

namespace App\Interfaces;

use stdClass;

interface AppInterface
{
  public function show(): array;
  public function showOne(string $id): stdClass;
  public function insert(array $data): string;
  public function update(array $data): string;
}