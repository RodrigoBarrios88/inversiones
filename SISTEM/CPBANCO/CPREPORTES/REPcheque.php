<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
	require_once("../../Clases/ClsNumLetras.php");
  
  //llena valores
   $ClsBan = new ClsBanco();
	 $NumToWords = new NumberToLetterConverter();
	 $usuario = $_SESSION["codigo"];
	 $hashkey1 = $_REQUEST["hashkey1"];
	 $hashkey2 = $_REQUEST["hashkey2"];
	 $hashkey3 = $_REQUEST["hashkey3"];
	 $cod = $ClsBan->decrypt($hashkey1, $usuario);
	 $cue = $ClsBan->decrypt($hashkey2, $usuario);
	 $ban = $ClsBan->decrypt($hashkey3, $usuario);
	 
  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('P','mm','cheque'); 
  $pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);

  $mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
	
	
	 ////-- trae datos del cheque 
	$result = $ClsBan->get_cheque($cod,$cue,$ban,'','','','','');
	if(is_array($result)){
			$i = 1;
			foreach($result as $row){
				$codigo = $row["che_codigo"];
				$cue = $row["cueb_codigo"];
				$ban = $row["ban_codigo"];
				$sit = $row["che_situacion"];
				$codigo = '# '.Agrega_Ceros($codigo);
			  //--
				$num = $row["che_ncheque"];
				//banco
				$bann = utf8_decode($row["ban_desc_ct"]);
				$numcue = $row["cueb_ncuenta"];
				//quien
				$quien = utf8_decode($row["che_quien"]);
				//fecha de pago
				$fec = $row["che_fechor"];
				$fec = $ClsBan->cambia_fechaHora($fec);
				$dia = substr($fec,0,2);
				$mes = substr($fec,3,2);
				$mes = strtolower(Meses_Letra($mes));
				$anio = substr($fec,6,4);
				$fecha = "$dia de $mes de $anio";
				//Monto
				$moneda = utf8_decode($row["mon_desc"]);
				$mons = $row["mon_simbolo"];
				$monto = $row["che_monto"];
				//$monto = "10111999.23"; prueba para conversión a letras
				$monto_letras = $NumToWords->to_word($monto);
				$secciona = explode(".", $monto);
				$decimales = $secciona[1];
				$exactos = (intval($decimales) == 0)?"EXACTOS":""; 
				$i++;
			}
			$i--; //resta 1 vuelta porq inicia con 1
	}
				// coordenadas iniciales
				$x = 2;
				$y = 10;
				
				//inicia Escritura del PDF
				//Borde recuadro / division en dos
				$pdf->SetDrawColor(0,0,0);
				$pdf->SetXY($x,$y);
				$pdf->Cell(278, 205, '', 0, 0);
				//Asignar tamano de fuente
				$pdf->SetFont('Courier','',10);

				//----------- # de Cheuqe ------//
				$pdf->SetXY(175,12);
				$cod = Agrega_Ceros($cod);
				$pdf->Cell(35, 5, "Cheque No. $num", 0, 0);
				
				//----------- Monto en numeros ------//
				$pdf->SetXY(180,20);
				$pdf->Cell(35, 5, "$simbolo $monto", 0, 0);
				
				//----------- Fecha en letras ------//
				$pdf->SetXY(10,20);
				$pdf->Cell(35, 5, "LUGAR Y FECHA:", 0, 0);
				$pdf->SetXY(50,20);
				$pdf->Cell(35, 5, "Guatemala, $fecha", 0, 0);
				
				//----------- Quien ------//
				$pdf->SetXY(10,30);
				$pdf->Cell(35, 5, "A:", 0, 0);
				$pdf->SetXY(50,30);
				$pdf->Cell(35, 5, $quien, 0, 0);
				
				//----------- Monto ------//
				$pdf->SetXY(10,40);
				$pdf->Cell(35, 5, "SUMA DE:", 0, 0);
				$pdf->SetXY(50,40);
				$pdf->Cell(35, 5, "$monto_letras $exactos", 0, 0);
				
			
	    //-
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output();
  
  
?>