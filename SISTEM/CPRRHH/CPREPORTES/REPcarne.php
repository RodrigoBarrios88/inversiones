<?php
  //Incluir las librerias de FPDF 
  include_once('../../html_fns.php');
  $usuario = $_SESSION["codigo"];
  //$_POST
	$hashkey = $_REQUEST["hashkey"];
	
	$ClsPer = new ClsPersonal();
	$dpi = $ClsPer->decrypt($hashkey, $usuario);
	$result = $ClsPer->get_personal($dpi);
	if(is_array($result)){
			foreach($result as $row){
				$dpi = utf8_decode($row["per_dpi"]);
				$nombres = utf8_decode($row["per_nombres"])." ".utf8_decode($row["per_apellidos"]);
				$dep = trim($row["dep_desc_ct"]);
				$plaza = trim($row["plaz_desc_ct"]);
			}
  }	
   
  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('P','cm','carne');
  $pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);

  $mleft = 0.5;
  $mtop = 0.5;
  $pdf->SetMargins($mleft,$mtop); //1 centimetro de margen izquierdo
  
  //Asignar tamano de fuente
  $pdf->SetFont('Arial','B',10);
  
  // coordenadas iniciales
  $x = 0.5;
  $y = 0.5;
	
  //inicia Escritura del PDF
	$pdf->SetXY($x,$y);
	//Primer recuadro
	$pdf->Cell(9,0.7,'CARNÉ DE IDENTIFICACIÓN',1,0,'C');
	//imagen Primer recuadro
	$X = 2.9+$x;
	$Y = 0.1+$y;
	//$pdf->Image('../../../CONFIG/images/replogo.jpg',$X,$Y,2.9,0.55);

	//*******************RECUADRO DEL CARNET *****************
	$pdf->SetXY($x,$y);
	//Borde Segundo recuadro
	$pdf->Cell(9,6,'',1);
	 //***********************************************************
	 //imagen Fondo
	$X = 1+$x;
	$Y = 1.5+$y;
	$pdf->Image('../../../CONFIG/images/selloagua.jpg',$X,$Y,4,3);
	
	//Impresion de Encabezados
	$info = array('DPI','Nombres y Apellidos','Departamento','Empleo');
	$pos_x = 0.1+$x;
	$pos_y = 0.6+$y;
	$altura = 1;
	$pdf->outColumns($info,$pos_x,$pos_y,$altura);

	//Impresion de Informacion
	$info = array($dpi,$nombres,$dep,$plaza);	
	$pos_x = 0.2+$x;
	$pos_y = 1+$y;
	$altura = 1;
	$pdf->outValues($info,$pos_x,$pos_y,$altura);
	
	//Crear lineas
	//Lineas columna 1
	$lpos_x = 0.2+$x;
	$lpos_y = 2.3+$y;
	$longitud = 5.1;

	for($i=1;$i<=4;$i++) {
		$pdf->createHorLine($lpos_x,$lpos_y,$longitud);
		$lpos_y += $altura;
	} //for

	 //*******************RECUADRO DE LA FOTO *****************
	//foto
	$X = 5.5+$x;
	$Y = 1+$y;
	if(file_exists ('../../../CONFIG/Fotos/RRHH/'.$dpi.'.jpg')){
		$pdf->Image('../../../CONFIG/Fotos/RRHH/'.$dpi.'.jpg',$X,$Y,3,3.5);
	}else{
		$pdf->Image('../../../CONFIG/Fotos/nofoto.jpg',$X,$Y,3,3.5);
	}
	//recuadro de foto
	$X = 5.5+$x;
	$Y = 1+$y;
	$pdf->SetXY($X,$Y);
	$pdf->Cell(3,3.5,'',1);
	 //***********************************************************
	 
	 //codigo de barras
	$pdf->SetFont('Arial','B',6);
	$X = 5.5+$x;
	$Y = 4.6+$y;
	$pdf->Code39($X,$Y,$dpi,true,false,.0125,0.8,true);

  /// crea HTML para Link que regresa al Menu Principal
  $pdf->SetXY(11,1);
  $pdf->SetFont('','U');

  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output();
  
?>