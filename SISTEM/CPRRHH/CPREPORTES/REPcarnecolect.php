<?php
  //Incluir las librerias de FPDF 
  require_once('../../recursos/fnsPDF.php');
  require_once('../../recursos/fpdf.php');
  include_once('../../html_fns.php');
  $emp = $_REQUEST["emp1"];
  $depto = $_REQUEST["dep1"];
  $nom = $_REQUEST["nom1"];
  $ape = $_REQUEST["ape1"];
  
/// Inicio de PDF Pagina 1
$pdf = new fnsPDF('P','cm','Letter');
 $pdf->AddPage();
  $mleft = 0.5;
  $mtop = 0.5;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
  //Asignar tamano de fuente
	$pdf->SetFont('Arial','B',12);
  
//llena valores
$ClsPer = new ClsPersonal();
$cont = $ClsPer->count_personal($id,$nom,$ape,$ced,$dpi,$nit,$lic,$igss,$irtra,$plaza,$depto,$emp);
if($cont>0){
	$result = $ClsPer->get_personal($id,$nom,$ape,$ced,$dpi,$nit,$lic,$igss,$irtra,$plaza,$depto,$emp);
	$i = 1; // cuenta los carnet y ayuda a setear posisiones
	$j = 1; // cuenta los carnet para cambiar de hoja
	$x = 1.5;
	$y = 0.5;
	foreach($result as $row){
		$cat = $row["per_id"];
		$nom = trim($row["per_nombres"])." ".trim($row["per_apellidos"]);
		$cedu = trim($row["per_cedula"]);
		$dpi = trim($row["per_dpi"]);
		$emp = trim($row["suc_nombre"]);
		if($dpi == ""){ //pregunta si ya tiene DPI o si le pide la cedula
			$id = "Cédula: ".$cedu;
		}else{
			$id = "DPI: ".$dpi;
		}
		
	//inicia Escritura del PDF
	  $pdf->SetXY($x,$y);
	  //Primer recuadro
	  $pdf->Cell(9,0.7,'',1,0,'C');
	  //imagen Primer recuadro
	  $X = 2.9+$x;
	  $Y = 0.1+$y;
	  $pdf->Image('../../../CONFIG/images/baner.png',$X,$Y,2.9,0.55);

	  //*******************  RECUADRO DEL CARNET *****************
	  $pdf->SetXY($x,$y);
	  //Borde Segundo recuadro
	  $pdf->Cell(9,6,'',1);
	 //***********************************************************
	 //imagen Fondo
	  $X = 1.3+$x;
	  $Y = 1.5+$y;
	  $pdf->Image('../../../CONFIG/images/FondoCarne.png',$X,$Y,3,3);
	  
	  //Impresion de Encabezados
	  $info = array('Código Único','Nombres y Apellidos','Identificacion','Empresa');
	  $pos_x = 0.1+$x;
	  $pos_y = 0.6+$y;
	  $altura = 1;
	  $pdf->outColumns($info,$pos_x,$pos_y,$altura);

	  //Impresion de Informacion
	  $info = array($cat,$nom,$id,$emp);	
	  $pos_x = 0.2+$x;
	  $pos_y = 1.1+$y;
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

	   //*******************  RECUADRO DE LA FOTO *****************
	  //foto
	  $X = 5.5+$x;
	  $Y = 1+$y;
	  if (file_exists ('../../../CONFIG/Fotos/RRHH/'.$cat.'.jpg')){
		$pdf->Image('../../../CONFIG/Fotos/RRHH/'.$cat.'.jpg',$X,$Y,3,3.5);
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
	  $X = 5.9+$x;
	  $Y = 4.6+$y;
	  $pdf->Code39($X,$Y,$cat,true,false,.0238,0.8,true);

	 $i++;
	 $j++;
	 $y+=6.4;	
	 if($j == 5){
		$x=11.5;
		$y=0.5;
	 }
	 if($j == 9){
		$pdf->AddPage();
		$mleft = 0.5;
		$mtop = 0.5;
		$pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
		//Asignar tamano de fuente
		$pdf->SetFont('Arial','B',12);
		$x=1.5;
		$y=0.5;
		$j = 1;
	 }
		
	} /// Finaliza el Ciclo
}	
  
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output();
  
?>