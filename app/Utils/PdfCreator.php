<?php

namespace App\Utils;

use setasign\Fpdi\Tcpdf\Fpdi; 

class PdfCreator 
{
  public $pdf;
  private $tempId;

  public function __construct(string $orientation, $size)
  {
    $this->pdf = new FPDI($orientation, 'mm', $size, true, 'UTF-8', false);
  }

  public function setHeaderFooter(bool $isSet): void
  {
    $this->pdf->setPrintHeader($isSet);
    $this->pdf->setPrintFooter($isSet);
  }
  
  public function setSource(string $file, int $pageNum): void
  {
    $this->pdf->setSourceFile($file);
    $this->pdf->AddPage();
    $this->tempId = $this->pdf->importPage($pageNum);
    $this->pdf->useTemplate($this->tempId, 0, 0, null, null, true);
  }

  public function write($x, $y, $text='', $addSpacing=true, $isRightAlign=false){
    $this->pdf->SetXY($x, $y);
    
    if ($text == '') {
        $this->pdf->write(0, 'X');
        return;
    }

    $formattedText = $addSpacing ? implode(' ', str_split(strtoupper($text))) : $text;

    if ($isRightAlign) {
        $docuMaxWidth = $this->pdf->GetPageWidth() - ($x + 5);
        $this->pdf->MultiCell($docuMaxWidth/1, 5, $formattedText, 0, 'C');
        return;
    }

    $this->pdf->write(0, $formattedText);
  }

  public function wrapText ($x, $y, $addPx, $h, $text, $alignment = 'J') {
    $this->pdf->SetXY($x, $y);
    $maxWidth = $this->pdf->GetPageWidth() - ($x + $addPx);
    $this->pdf->MultiCell($maxWidth, $h, $text, 0, $alignment);
}

  public function generatePdfFile(string $filename, string $type) {
      $this->pdf->Output($filename.'.pdf', $type);
  }
}