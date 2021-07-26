<?php
  //Incluir las librerias de FPDF 
  include_once('../../html_fns.php');
 //post
	$grup = trim($_REQUEST["gru"]);
	$art = trim($_REQUEST["art"]);
	$marca = trim($_REQUEST["marca"]);
	$nom = trim($_REQUEST["artnom"]);
	$cant = trim($_REQUEST["cant"]);
	$sit = trim($_REQUEST["sit"]);
	
/// Inicio de PDF Pagina 1
  $pdf=new PDF('P','cm','Letter');  // si quieren el reporte horizontal
  $pdf->AddPage();
  $mleft = 0.2;
  $mtop = 0.2;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
  //Asignar tamano de fuente
	$pdf->SetFont('Arial','B',6);

//llena valores
$ClsArt = new ClsSuministro();
$result = $ClsArt->get_articulo($art,$grup,$nom,'',$marca,'','','',$sit);
if(is_array($result)){
	$i = 1; // cuenta las etiquetas y ayuda a setear posisiones
	$j = 1; // cuenta las etiquetas para cambiar de hoja
	$x = 0.4;
	$y = 0.4;
	foreach($result as $row){
		$barcode = $row["art_barcode"];
		$nom =  trim($row["art_nombre"]);
		$nom = substr($nom,0,12)."...";
		$mon = $row["mon_simbolo"];
		$prec = $row["art_precio"];
		$prec = round($prec,2);
		
		for($a = 1; $a <= $cant; $a++){
			//inicia Escritura del PDF
			  $pdf->SetFont('Arial','B',6);	
			  $pdf->SetXY($x,$y);
			  $pdf->MultiCell(3.5,0.3,$nom,0,'L',false);
			  $pdf->SetFont('Arial','B',8);
			  $pdf->SetXY($x,$y + 0.3);
			  $pdf->MultiCell(3.5,0.3,"$mon. $prec",0,'L',false);
			  //Primer recuadro
			  
			  //*******************  RECUADRO DEL CARNET *****************
			  //codigo de barras
			  $X = $x;
			  $Y = $y + 0.6;
			  $pdf->Code39($X,$Y,$barcode,true,false,.015,0.8,true);
		
			 $i++;
			 $j++;
			 $x+=4.2;
			 if($j > 5){
				$x= 0.4;
				$y+= 2.3;
				$j = 1;
				//$pdf->SetXY(0.2,$y-.2); 
				//$pdf->Cell(2,0.3,"Y es $y",0);  //revisa que No. lleva $y
			 }
			 if($a == $cant){
				$pdf->Line(0.4,$y,20.5,$y);
				$y+= .5;
			 }
			 if($y >= 25){ //si $y excede de 25 hay que hacer cambio de pagina
				$pdf->AddPage();
				$mleft = 0.4;
				$mtop = 0.4;
				$pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
				//Asignar tamano de fuente
				$pdf->SetFont('Arial','B',6);
				$x=0.4;
				$y=0.4;
				$j = 1;
				$i = 1;
			 }
		} 
		
	} /// Finaliza el Ciclo
}	
  
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output();
  
?>