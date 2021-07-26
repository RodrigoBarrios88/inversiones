<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
  require_once("../../Clases/ClsNumLetras.php");
	
  //llena valores
   $ClsBol = new ClsBoletaCobro();
	 $NumToWords = new NumberToLetterConverter();
	 $ClsAcadem = new ClsAcademico();
	 $usuario = $_SESSION["codigo"];
	 $pensum = $_SESSION["pensum"];
	 $hashkey1 = $_REQUEST["hashkey1"];
	 $hashkey2 = $_REQUEST["hashkey2"];
	 $hashkey3 = $_REQUEST["hashkey3"];
	 $cod = $ClsBol->decrypt($hashkey1, $usuario);
	 $cue = $ClsBol->decrypt($hashkey2, $usuario);
	 $ban = $ClsBol->decrypt($hashkey3, $usuario);
	 
	// INICIA ESCRITURA DE PDF 
  $pdf = new PDF('P','mm','boleta'); 
  $pdf->AddPage();
	$pdf->SetAutoPageBreak(false,2);

  $mleft = 0;
  $mtop = 0;
  $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
  
	////-- trae datos de la venta 
	$result = $ClsBol->get_boleta_cobro($cod,$cue,$ban);
	if(is_array($result)){
			$i = 1;
			foreach($result as $row){
				$codigo = $row["bol_codigo"];
				$codigo = '# '.Agrega_Ceros($codigo);
			  //--
				$num = $row["cueb_ncuenta"];
				//banco
				$bann = utf8_decode($row["ban_desc_ct"]);
				//alumno
				$cui = $row["alu_cui"];
				$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
				
				$result_grado = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
				if(is_array($result_grado)){
					foreach($result_grado as $row_grado){
						$grado = utf8_decode($row_grado["gra_descripcion"]);
					}
				}
				
				$result_seccion = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
				if(is_array($result_seccion)){
					foreach($result_seccion as $row_seccion){
						$seccion = utf8_decode($row_seccion["sec_descripcion"]);
					}
				}
				//Documento
				$doc = $row["bol_referencia"];
				//fehca
				$freg = $row["bol_fecha_registro"];
				$freg = $ClsBol->cambia_fechaHora($freg);
				//fehca
				$fec = $row["bol_fecha_pago"];
				$fec = $ClsBol->cambia_fechaHora($fec);
				$mes = substr($fec,3,2);
				$mes = trim(Meses_Letra($mes));
				//Monto
				$simbolo = $row["mon_simbolo"];
				$monto = $row["bol_monto"];
				//descripcion
				$descripcion = utf8_decode($row["bol_motivo"]);
				$i++;
			}
			$i--; //resta 1 vuelta porq inicia con 1
	}
				// coordenadas iniciales
				$x = 0;
				$y = 0;
				
			//inicia Escritura del PDF
			//Borde recuadro / division en dos
				$pdf->SetDrawColor(0,0,0);
				$pdf->SetXY($x,$y);
				$pdf->Cell(278, 205, '', 0, 0);
			//Asignar tamano de fuente
				$pdf->SetFont('Arial','',12);
				
			//----------- CUERPO ------//	
				//----------- Nombre del Alumno ------//
				$pdf->SetFont('Arial','',16);
				$pdf->SetXY(12,28.5);
				$pdf->Cell(35, 3, $alumno, 0, 0);
				
				//----------- Grado y Seccion ------//
				$pdf->SetXY(5,37);
				$pdf->Cell(30, 3, $grado, 0, 0);
				$pdf->SetXY(68,37);
				$pdf->Cell(30, 3, $seccion, 0, 0);
				
				//----------- Fecha ------//
				$pdf->SetXY(38,45.9);
				$pdf->Cell(35, 3, $fec, 0, 0);
				
		    //----------- CODO ------//
				//----------- CUI del Alumno ------//
				$pdf->SetFont('Arial','',16);
				$pdf->SetXY(130,12.5);
				$pdf->Cell(35, 3, $cui, 0, 0);
				
				//----------- Mes de la Boleta ------//
				$pdf->SetFont('Arial','',12);
				$pdf->SetXY(130,20);
				$pdf->Cell(35, 3, $mes, 0, 0);
				
				//----------- Monto ------//
				$pdf->SetFont('Arial','',12);
				$pdf->SetXY(147,36.5);
				$pdf->Cell(35, 3, "$simbolo. $monto", 0, 0);
				
				//----------- # de Boleta ------//
				$pdf->SetFont('Arial','',12);
				$pdf->SetXY(127,60);
				$pdf->Cell(35, 5, "Boleta No. $doc", 0, 0);
				
				//----------- descripcion ------//
				$pdf->SetXY(20,70);
				$pdf->Cell(35, 5, $descripcion, 0, 0);
				
	    //-
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output("Boleta No. $doc.pdf","I");
  
	function Meses($mes){
    switch($mes){
        case 1: $mes = "ENERO"; break;
        case 2: $mes = "FEBRERO"; break;
        case 3: $mes = "MARZO"; break;
        case 4: $mes = "ABRIL"; break;
        case 5: $mes = "MAYO"; break;
        case 6: $mes = "JUNIO"; break;
        case 7: $mes = "JULIO"; break;
        case 8: $mes = "AGOSTO"; break;
        case 9: $mes = "SEPTIEMBRE"; break;
        case 10: $mes = "OCTUBRE"; break;
        case 11: $mes = "NOVIEMBRE"; break;
        case 12: $mes = "DICIEMBRE"; break;
    }   
    return $mes;
  }  
  
?>