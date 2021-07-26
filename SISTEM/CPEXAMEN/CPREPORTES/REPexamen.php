<?php

include_once('../../html_fns.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['colegio_nombre_reporte'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$ClsExa = new ClsExamen();
	$hashkey = $_REQUEST["hashkey"];
	$examen = $ClsExa->decrypt($hashkey, $id);
	
	$result = $ClsExa->get_examen($examen);
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$codigo = $row["exa_codigo"];
			$titulo = utf8_decode($row["exa_titulo"]);
			$descripcion = utf8_decode($row["exa_descripcion"]);
			//--
			$fini = trim($row["exa_fecha_inicio"]);
			$fini = cambia_fechaHora($fini);
			$ffin = trim($row["exa_fecha_limite"]);
			$ffin = cambia_fechaHora($ffin);
			//--
			$feclimit = trim($row["exa_fecha_limite"]);
			//--
			$situacion = trim($row["dexa_situacion"]);
		}
	}else{
		
	}
	
	$pdf=new PDF('P','mm','Letter');  // si quieren el reporte horizontal
	// $pdf=new PDF('P','mm','Letter');  // si quieren el reporte Vertical
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->Ln(2);

	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(0, 5, $titulo, 0 , 'L' , 0);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0, 6, 'Fecha/Hora de generación: '.date("d/m/Y H:i"), 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Generado por: '.$nombre, 0 , 'L' , 0);
	$pdf->MultiCell(0, 5, 'Colegio: '.$empresa, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 175 ,5, 40 , 30,'JPG', '');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell(0, 5, 'DESCRIPCI�N:', 0 , 'J' , 0);
	$pdf->SetFont('Arial','',8);
	$pdf->MultiCell(0, 5, $descripcion, 0 , 'J' , 0);
	$pdf->Ln(10);
	
		$result = $ClsExa->get_pregunta('',$examen);
		if(is_array($result)){
			$i = 1;	
			foreach ($result as $row){
				$codigo = $row["pre_codigo"];
				$pregunta = utf8_decode($row["pre_descripcion"]);
				$tipo = trim($row["pre_tipo"]);
				$puntos = trim($row["pre_puntos"]);
				//--
				$pdf->SetX(8);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(5,5,"$i. ",0,0,'L');
				$pdf->SetX(15);
				$pdf->MultiCell(190, 5, "$pregunta - $puntos Punto(s).", 0 , 'J' , 0);
				$pdf->Ln(5);
				
				if($tipo == 1){ /// ponderacion de 1-5
					for($x = 1; $x <= 5; $x++){ 
						$pdf->SetX(30*$x);
						$pdf->SetFont('Arial','',8);
						$pdf->Cell(5,5,"$x",0,0,'C');
					}
					$pdf->Ln(10);
				}else if($tipo == 2){
					$pdf->SetX(60);
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(5,5,"VERDADERO",'',0,'C');
					$pdf->SetX(130);
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(5,5,"FALSO",'',0,'C');
					$pdf->Ln(10);
				}else if($tipo == 3){
					$pdf->SetFont('Arial','',8);
					$pdf->SetX(15);
					$pdf->MultiCell(190, 5, "", 'B' , 'J' , 0);
					$pdf->Ln(10);
				}
				$i++;
			}
		}else{
							
		}
	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>