<?php
require('../fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'FACTURE');

$pdf->Ln();

$pdf->SetFont('Arial','',12);
$pdf->Cell(100,10,'Produit: '.$_GET['product']);
$pdf->Ln();
$pdf->Cell(100,10,'Client: '.$_GET['client']);
$pdf->Ln();
$pdf->Cell(100,10,'Total: '.$_GET['total'].' FCFA');

$pdf->Output();
?>