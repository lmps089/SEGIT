<?php


	include 'plantilla.php';
	require 'funts/conexionBD.php';


	$sql = "SELECT numero_cuentaH,nombreH,apellido_maternoH,apellido_paternoH FROM historial_alumnos " ;
	//$resultado = $mysqli->query($query);
	$resultado = $mysqli->query($sql);


	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,132);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(45,10,'NUMERO DE CUENTA',1,0,'C',1);
	$pdf->Cell(45,10,'NOMBRE',1,0,'C',1);
	$pdf->Cell(45,10,'APELLIDO MATERNO',1,0,'C',1);
	$pdf->Cell(45,10,'APELLIDO PATERNO',1,1,'C',1);
	
	$pdf->SetFont('Arial','',10);
	
   
	
	while($row =  $resultado->fetch_array(MYSQLI_ASSOC)){
  

		//return [
  		$pdf->Cell(45,10,utf8_decode($row['numero_cuentaH']),1,0,'C');
		$pdf->Cell(45,10,utf8_decode($row['nombreH']),1,0,'C');
		$pdf->Cell(45,10,utf8_decode($row['apellido_maternoH']),1,0,'C');
		$pdf->Cell(45,10,utf8_decode($row['apellido_paternoH']),1,1,'C');
		//];
		 //]
	}   
	
	$pdf->Output();


?>