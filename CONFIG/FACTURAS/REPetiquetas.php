<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
  
  //llena valores
	$pensum = $_SESSION["pensum"];
  
  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('L','mm',array(120,29)); 
  
  $mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
  
	////-- trae datos de la venta 
	$ClsAacadem = new ClsAcademico();
	$result = $ClsAacadem->get_seccion_alumno($pensum,'','','','','','',1);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			$cui = trim($row["alu_cui"]);
			//nombre
			$nombre = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$nombre = (strlen($nombre) > 40)? substr($nombre,0,40):$nombre;
			//grado
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			//seccion
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
							
			$pdf->AddPage();
			$pdf->SetAutoPageBreak(false,2);
							
					//inicia Escritura del PDF
					//----------- No. ------//
					$pdf->SetFont('Arial','',20);
					$pdf->SetXY(2,5);
					$pdf->Cell(85, 10, $nombre, 0, 0, 'L');
					$pdf->SetFont('Arial','',18);
					$pdf->SetXY(2,15);
					$pdf->Cell(85, 7, "$grado_desc $seccion_desc", 0, 0, 'L');
					$pdf->SetXY(2,20);
					//$pdf->Cell(80, 5, $cui, 1, 0, 'L');
					$i++;
		}
		$i--; //resta 1 vuelta porq inicia con 1
	}
  
	//-
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
	$carga = Agrega_Ceros($carga);
  $pdf->Output("Facturas de Carga No. $carga.pdf","I");
  
  
?>