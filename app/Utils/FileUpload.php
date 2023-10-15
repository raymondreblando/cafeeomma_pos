<?php

namespace App\Utils;

use \Gumlet\ImageResize;

class FileUpload
{
  private $image;
  private $file;
  private $path;

  public function __construct(string $path)
  {
    $this->path = $path;
  }

  public function setFile(array $file): array
  {
    return $this->file = $file;
  }

  public function getExtension(): string
  {
    $file_data = explode('.', $this->file['name']);
    $extension = end($file_data);

    return $extension;
  }

  public function isUploading(): bool
  {
    return $this->file['size'] > 0 ? true : false;
  }

  public function isUploadSuccess(string $filename): bool
  {
    $this->image = new ImageResize($this->file['tmp_name']);
    $this->image->resizeToWidth(400);

    return $this->image->save($this->path.$filename) ? true : false;
  }
}