<?php
  //Incluir las librerias de FPDF 
  require_once("../../Clases/ClsProveedor.php");
	require_once("../../Clases/ClsCompra.php");
	require_once('../../recursos/fpdf/code128.php');
 //post
	$prov = trim($_REQUEST["prov"]);
	$suc = trim($_REQUEST["suc"]);
	$papel = trim($_REQUEST["papel"]);
	
/// Inicio de PDF Pagina 1
  $pdf=new PDF_Code128('P','mm',$papel);  // si quieren el reporte horizontal
  $pdf->AddPage();
  $mleft = 5;
  $mtop = 5;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	
	$ClsProv = new ClsProveedor();
	$result = $ClsProv->get_proveedor($prov,'','','');
	if(is_array($result)){
		foreach($result as $row){
			$nit = $row["prov_nit"];
			$proveedor = utf8_decode($row["prov_nombre"]);
			$contacto = utf8_decode($row["prov_contacto"]);
		}	
	}	
  //encabezados
	$pdf->SetXY(15,5);
	$pdf->SetFont('Arial','B',10);
	$pdf->MultiCell(100, 5, 'LISTADO DE ARTICULOS POR PROVEEDOR', 0 , 'L' , 0);
	$pdf->SetFont('Arial','',8);
	$pdf->SetX(15);
	$pdf->MultiCell(100, 6, 'PROVEEDOR: '.$proveedor, 0 , 'L' , 0);
	$pdf->SetX(15);
	$pdf->MultiCell(100, 5, 'NIT: '.$nit, 0 , 'L' , 0);
	$pdf->SetX(15);
	$pdf->MultiCell(100, 5, 'CONTACTO: '.$contacto, 0 , 'L' , 0);
	$pdf->Image('../../../CONFIG/images/replogo.jpg' , 185 ,5, 20 , 20,'JPG', '');
	
	//Asignar fuente
	$pdf->SetFont('Arial','B',6);

//llena valores
$ClsComp = new ClsCompra();
$result = $ClsComp->get_productos_proveedor('','C','',$prov,$suc);
if(is_array($result)){
	$i = 1; // cuenta las etiquetas y ayuda a setear posisiones
	$j = 1; // cuenta las etiquetas para cambiar de hoja
	$x = 15;
	$y = 30;
	foreach($result as $row){
		$art = $row["dcom_articulo"];
		$gru = $row["dcom_grupo"];
		$X1 = Agrega_Ceros($art);
		$X2 = Agrega_Ceros($gru);
		$barcode = "A".$X1."A".$X2;
		$nom = utf8_decode($row["dcom_detalle"]);
		$nom = (strlen($nom) <= 45)?$nom:substr($nom,0,42).'...';
		$mon = $row["mon_simbolo"];
		$prec = $row["dcom_precio"];
		$prec = number_format($prec,2,'.','');
		
		//inicia Escritura del PDF
		$pdf->SetFont('Arial','B',5);	
		$pdf->SetXY($x,$y);
		$pdf->MultiCell(55,5,$nom,0,'L',false);
		$pdf->SetFont('Arial','B',6);
		$pdf->SetXY($x,$y + 5);
		$pdf->MultiCell(25,5,"$mon. $prec",0,'L',false);
		$pdf->SetXY($x+25,$y + 5);
		$pdf->MultiCell(30,5,"$barcode",0,'R',false);
		//---
		//codigo de barras
		$pdf->Code128($x,$y + 11,$barcode,55,15);
		
		$i++;
		$j++;
		$x+= 65;
		if($j > 3){
			$x= 15;
			$y+= 30;
			$j = 1;
		}
		
		if(($i > 24 && $papel == "Letter") || ($i > 30 && $papel == "Legal")){ //si $y excede de 25 hay que hacer cambio de pagina
			$pdf->AddPage();
			$mleft = 5;
			$mtop = 5;
			$pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
			//Asignar tamano de fuente
			$pdf->SetFont('Arial','B',6);
			$x=15;
			$y=15;
			$j = 1;
			$i = 1;
		}
		//break;
	}	
}	
  
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output();
	
	
	
function Agrega_Ceros($dato){
    $len = strlen($dato);
	switch($len){
		case 1: $dato = "000$dato"; break;
		case 2: $dato = "00$dato"; break;
		case 3: $dato = "0$dato"; break;
	}
	return $dato;
}
  
?>