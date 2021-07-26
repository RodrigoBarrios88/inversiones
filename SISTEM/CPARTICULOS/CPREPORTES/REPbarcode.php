<?php
  //Incluir las librerias de FPDF 
  //include_once('../../html_fns.php');
	require_once("../../Clases/ClsArticulo.php");
	require_once('../../recursos/fpdf/code128.php');
 //post
	$grup = trim($_REQUEST["gru"]);
	$art = trim($_REQUEST["art"]);
	$marca = trim($_REQUEST["marca"]);
	$nom = trim($_REQUEST["artnom"]);
	$cant = trim($_REQUEST["cant"]);
	$sit = trim($_REQUEST["sit"]);
	
/// Inicio de PDF Pagina 1
  $pdf = new PDF_Code128('P','mm','etiquetacorta');  // si quieren el reporte horizontal
	

//llena valores
$ClsArt = new ClsArticulo();
$result = $ClsArt->get_articulo($art,$grup,$nom,'',$marca,'','','',$sit);

if(is_array($result)){
	$i = 1; // cuenta las etiquetas y ayuda a setear posisiones
	$j = 1; // cuenta las etiquetas para cambiar de hoja
	$x = 0.4;
	$y = 0.4;
	foreach($result as $row){
		$barcode = $row["art_barcode"];
		$nom =  utf8_decode($row["art_nombre"])." / ".utf8_decode($row["art_marca"]);
		if(strlen($nom) > 35){ // valida recortar el nombre
			$nom = substr($nom,0,32);
		}
		$mon = $row["mon_simbolo"];
		$prec = $row["art_precio"];
		$prec = number_format($prec,2,'.','');
	}	
		
	for($i = 1; $i <= $cant; $i++){
		$pdf->AddPage();
		$pdf->SetAutoPageBreak(false,2);
		$mleft = 10;
		$mtop = 10;
		$pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
		//******************* Etiqueta 1 *****************
			//inicia Escritura del PDF
			$pdf->SetFont('Arial','B',5);	
			$pdf->SetXY(7,13);
			$pdf->MultiCell(40,2.5,$nom,0,'L',false);
			$pdf->SetFont('Arial','B',6);
			$pdf->SetXY(7,15.5);
			$pdf->MultiCell(15,2.5,"$mon. $prec",0,'L',false);
			$pdf->SetXY(22,15.5);
			$pdf->MultiCell(23,2.5,$barcode,0,'R',false);
			//codigo de barras
			$pdf->SetFont('Arial','',5);	
			$pdf->Code128(7,18,$barcode,38,10);
			$pdf->SetFont('Arial','',5);	
		/*//******************* Etiqueta 2 *****************
			//inicia Escritura del PDF
			$pdf->SetFont('Arial','B',5);	
			$pdf->SetXY(50,3);
			$pdf->MultiCell(45,3,$nom,0,'L',false);
			$pdf->SetFont('Arial','B',6);
			$pdf->SetXY(50,6);
			$pdf->MultiCell(15,3,"$mon. $prec",0,'L',false);
			$pdf->SetXY(65,6);
			$pdf->MultiCell(23,3,$barcode,0,'R',false);
			//codigo de barras
			$pdf->SetFont('Arial','',5);	
			$pdf->Code128(50,10,$barcode,38,15);
			$pdf->SetFont('Arial','',5);	*/
	} 

}	
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output();
  
?>