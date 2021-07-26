<?php
  //Incluir las librerias de FPDF 
  include_once('html_fns_reportes.php');
  require_once("../../Clases/ClsNumLetras.php");
	
  //llena valores
  $ClsBol = new ClsBoletaCobro();
  $ClsPer = new ClsPeriodoFiscal();
  $NumToWords = new NumberToLetterConverter();
  $ClsAcadem = new ClsAcademico();
  $usuario = $_SESSION["codigo"];
  //$_POST
  $grupo = $_REQUEST["grupo"];
 
	////-- trae datos de la venta 
	$pensum = $_SESSION["pensum"];
	$periodo = $ClsPer->get_periodo_pensum($pensum);
  
  // INICIA ESCRITURA DE PDF 
  $pdf = new PDF('P','mm','boleta'); 
	
	$result = $ClsBol->get_mora('','','','','','','','', '', '', '', '', 1, 1,'',$grupo);
	if(is_array($result)){
			$i = 1;
			foreach($result as $row){
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(false,2);
      
        $mleft = 0;
        $mtop = 0;
        $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
        
				$codigo = $row["bol_codigo"];
				$codigo = '# '.Agrega_Ceros($codigo);
        ///--//boleta
        $referencia = $row["bol_referencia"];
			  //--
				$num = $row["cueb_ncuenta"];
				//banco
				$bann = utf8_decode($row["ban_desc_ct"]);
				//alumno
				$cui = $row["alu_cui"];
				$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
        //grado
        $grado = utf8_decode($row["gra_descripcion"]);
				//seccion
				$seccion = utf8_decode($row["sec_descripcion"]);
				//fehca
				$freg = $row["bol_fecha_registro"];
				$freg = $ClsBol->cambia_fechaHora($freg);
        $mes = substr($freg,3,2);
				$mes = trim(Meses_Letra($mes));
				//fehca
				$fec = $row["bol_fecha_pago"];
				$fec = $ClsBol->cambia_fechaHora($fec);
				//Monto
				$simbolo = $row["mon_simbolo"];
				$monto = $row["bol_monto"];
				//descripcion
				$descripcion = utf8_decode($row["bol_motivo"]);
	
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
				$pdf->Cell(35, 3, $freg, 0, 0);
				
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
				$pdf->Cell(35, 5, "Boleta No. $referencia", 0, 0);
				
				//----------- descripcion ------//
				$pdf->SetXY(20,70);
				$pdf->Cell(35, 5, $descripcion, 0, 0);
		
    		$i++;
			}
			$i--; //resta 1 vuelta porq inicia con 1
	}
		
  /*	
	if($cue != "" && $ban != ""){
		$ClsBan = new ClsBanco();
		$result = $ClsBan->get_cuenta_banco($cue,$ban);
		if(is_array($result)){
			foreach($result as $row){
				$cuenta_desc = utf8_decode($row["cueb_nombre"]);
				$cuenta_num = utf8_decode($row["cueb_ncuenta"]);
				$banco_desc = utf8_decode($row["ban_desc_ct"]);
			}	
		}
		$cuenta_titulo = "_Cuenta No. $cuenta_num";
	}
	
	if($empresa != ""){
		$ClsEmp = new ClsEmpresa();
		$result = $ClsEmp->get_sucursal($empresa);
		if(is_array($result)){
			foreach($result as $row){
				$empresa_nombre = utf8_decode($row["suc_nombre"]);
			}	
		}
		$empresa_titulo = "_$empresa_nombre";
	}*/
  
  $documento = "Moras del grupo $grupo el ".date("d/m/Y");
  
  //Salida de PDF, en esta parte se puede definir la salida, si es a pantalla o forzar la descarga
  $pdf->Output($documento,"I");
  
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