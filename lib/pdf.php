<?php
require "./fpdf/fpdf.php";
include './class_mysql.php';
include './config.php';

$id = MysqlQuery::RequestGet('id');
$sql = Mysql::consulta("SELECT * FROM ticket WHERE id= '$id'");
$reg = mysqli_fetch_array($sql, MYSQLI_ASSOC);

class PDF extends FPDF
{
}

$pdf=new PDF('P','mm','Letter');
$pdf->SetMargins(15,20);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetTextColor(0,0,128);
$pdf->SetFillColor(0,255,255);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFont("Arial","b",9);
$pdf->Image('../img/unach.png',40,10,-300);
$pdf->Cell (0,5,utf8_decode('Universidad Autonóma de Chiapas'),0,1,'C');
$pdf->Cell (0,5,utf8_decode('Unidad de Infraestructura y Telecomunicaciones DTIC'),0,1,'C');

$pdf->Ln();
$pdf->Ln();
$pdf->Cell (0,5,utf8_decode('Copia del Administrador '),0,1,'C');
$pdf->Cell (0,5,utf8_decode(' Información de Ticket: '.utf8_decode($reg['serie'])),0,1,'C');

$pdf->Cell (35,10,'Fecha',1,0,'C',true);
$pdf->Cell (0,10,utf8_decode($reg['fecha']),1,1,'L');
$pdf->Cell (35,10,'Folio',1,0,'C',true);
$pdf->Cell (0,10,utf8_decode($reg['serie']),1,1,'L');
$pdf->Cell (35,10,'Estado',1,0,'C',true);
$pdf->Cell (0,10,utf8_decode($reg['estado_ticket']),1,1,'L');
$pdf->Cell (35,10,'Usuario',1,0,'C',true);
$pdf->Cell (0,10,utf8_decode($reg['nombre_usuario']),1,1,'L');
$pdf->Cell (35,10,'Email',1,0,'C',true);
$pdf->Cell (0,10,utf8_decode($reg['email_cliente']),1,1,'L');


$pdf->Cell (35,10,'Departamento',1,0,'C',true);
$pdf->Cell (0,10,utf8_decode($reg['departamento']),1,1,'L');
$pdf->Cell (35,10,'Asunto',1,0,'C',true);
$pdf->Cell (0,10,utf8_decode($reg['asunto']),1,1,'L');
$pdf->Cell (35,10,'Tipo de soporte',1,0,'C',true);
$pdf->Cell (0,10,utf8_decode($reg['tipo']),1,1,'L');
$pdf->Cell (35,45,'Problema',1,0,'C',true);
$pdf->Cell (0,45,utf8_decode($reg['mensaje']),1,1,'L');
$pdf->Cell (35,45,'Solucion',1,0,'C',true);
$pdf->Cell (0,45,utf8_decode($reg['solucion']),1,1,'L');

$pdf->Ln();

$pdf->cell(0,5,"Jose Lerin",0,0,'C');

$pdf->output();