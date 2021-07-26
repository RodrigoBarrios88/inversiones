<?php
   //Incluir las librerias de FPDF 
   include_once('html_fns_reportes.php');
 	$usu = $_SESSION["codigo"];
   $colegio = $_SESSION["colegio_nombre_reporte"];
   
   //llena valores
   $ClsBol = new ClsBoletaCobro();
   $NumToWords = new NumberToLetterConverter();
   $usuario = $_SESSION["codigo"];
   $hashkey = $_REQUEST["hashkey"];
   $carga = $ClsBol->decrypt($hashkey, $usuario);
	
   // INICIA ESCRITURA DE PDF 
   $pdf = new PDF('P','mm','Letter'); 
         
	////-- trae datos de la venta 
	$result = $ClsBol->get_recibo('','',$carga,'','','','','',1);
	if(is_array($result)){
      $i = 1;
      foreach($result as $row){
         //--
         $serie =  trim($row["ser_numero"]);
         $recibo =  trim($row["rec_numero"]);
         //--
         $nit =  trim($row["cli_nit"]);
         $nombre =  utf8_decode($row["cli_nombre"]);
         $dir =  trim($row["cli_direccion"]);
         //--
         $referencia = $row["rec_referencia"];
         $cui = $row["rec_alumno"];
         $alumno = utf8_decode($row["alu_nombre_completo"]);
         $grado = utf8_decode($row["alu_grado_descripcion"]);
         $seccion = utf8_decode($row["alu_seccion_descripcion"]);
         $fec = $row["rec_fecha"];
         $fec = cambia_fecha($fec);
         $monto = $row["rec_monto"];
         $simbolo = $row["mon_simbolo"];
         $moneda = $row["mon_desc"];
         $tcamb = $row["rec_tcambio"];
         $situacion = $row["ven_situacion"];
         $desc = utf8_decode($row["rec_descripcion"]);
	 
         $pdf->AddPage();
         $pdf->SetAutoPageBreak(false,2);
      
         $mleft = 0;
         $mtop = 0;
         $pdf->SetMargins($mleft,$mtop); //0.5 centimetro de margen izquierdo
          
         //******************* SELLO DE AGUA *****************
         $pdf->Image('../images/sello_agua.jpg' , 10 ,40, 190 , 100,'JPG', '');
         //***************************************************
         
         //*******************Recuadro del Encabezado *****************
         $pdf->SetLineWidth(0.6);
         $pdf->SetDrawColor(100, 138, 175);
         $pdf->SetTextColor(42,90,138); // azul
         $pdf->SetXY(10,10);
         //Borde recuadro
         $pdf->Cell(195,20,'',1);
         //Titulo
         $pdf->SetXY(10,10);
         $pdf->SetFont('Arial','',15);
         $pdf->Cell(195,20,$colegio,0,1,'C');
         //logo
         $pdf->Image('../images/replogo.jpg' , 20 ,12.5, 15 , 15, 'JPG', '');
         
         $pdf->SetXY(175,15);
         $pdf->SetFont('Arial','',10);
         $pdf->Cell(20,5,'Recibo No. ',0,1,'');
         
         $pdf->SetTextColor( 225, 9, 26 ); // Letras de color rgb
         $pdf->SetXY(175,20);
         $pdf->SetFont('Arial','B',14);
         $pdf->Cell(20,5,$serie.' '.Agrega_Ceros($recibo),0,1,'');
         $pdf->SetTextColor(42,90,138); // azul
        
         //******************* Cliente, Sede y  Contacto *****************
         $pdf->SetLineWidth(0.3);
         //Alumno
         $pdf->SetXY(10,35);
         $pdf->SetFont('Arial','',12);
         $pdf->Cell(80,7,'Alumno:',1,1,'');
         $pdf->SetXY(90,35);
         $pdf->SetFont('Arial','B',10);
         $pdf->Cell(115,7,$alumno,'B',1,'L');
         //ID
         $pdf->SetXY(10,45);
         $pdf->SetFont('Arial','',12);
         $pdf->Cell(80,7,'CUI o Pasaporte:',1,1,'');
         $pdf->SetXY(90,45);
         $pdf->SetFont('Arial','B',10);
         $pdf->Cell(115,7,$cui,'B',1,'L');
         
         //grado
         $pdf->SetXY(10,55);
         $pdf->SetFont('Arial','',12);
         $pdf->Cell(80,7,utf8_decode('Grado y Sección:'),1,1,'');
         $pdf->SetXY(90,55);
         $pdf->SetFont('Arial','B',10);
         $pdf->Cell(115,7,$grado." ".$seccion,'B',1,'L');
         //fecha
         $pdf->SetXY(10,65);
         $pdf->SetFont('Arial','',12);
         $pdf->Cell(80,7,utf8_decode('Fecha:'),1,1,':');
         $pdf->SetXY(90,65);
         $pdf->SetFont('Arial','B',10);
         $pdf->Cell(115,7,$fec,'B',1,'L');
          
         $pdf->SetLineWidth(0.6);
         $pdf->Line(10, 80, 205, 80);
         $pdf->SetLineWidth(0.3);
         
         //Cliente
         $pdf->SetXY(10,90);
         $pdf->SetFont('Arial','',12);
         $pdf->Cell(80,7,utf8_decode('Recibí de:'),1,1,'');
         $pdf->SetXY(90,90);
         $pdf->SetFont('Arial','B',10);
         $pdf->Cell(115,7,$nombre,'B',1,'L');
         //Direcccion
         $pdf->SetXY(10,100);
         $pdf->SetFont('Arial','',12);
         $pdf->Cell(80,7,utf8_decode('Dirección:'),1,1,'');
         $pdf->SetXY(90,100);
         $pdf->SetFont('Arial','B',10);
         $pdf->Cell(115,7,$dir,'B',1,'L');
         
         //Descripcion
         $pdf->SetXY(10,120);
         $pdf->SetFont('Arial','B',10);
         $pdf->Cell(80,7,utf8_decode('Descripción del Recibo:'),0,0,'');
         $pdf->SetLineWidth(0.6);
         $pdf->SetXY(10,128);
         $pdf->Cell(195,70,'',1,1,'');
         $pdf->SetXY(12,130);
         $pdf->SetFont('Arial','',12);
         $pdf->Multicell(191,7,$desc, 0, 'C', false);
         $pdf->SetXY(12,137);
         $pdf->MultiCell(191, 7, "Alumno(a): $alumno" , 0 , "C", false);
         $pdf->SetXY(12,144);
         $pdf->MultiCell(191, 7, "No. de Referencia # $referencia" , 0 , "C", false);
         $pdf->SetXY(12,151);
         $pdf->MultiCell(191, 7, "Grado: $grado ".utf8_decode("Sección")." $seccion" , 0 , "C", false);
         //
   		}
			$i--; //resta 1 vuelta porq inicia con 1
	}
    
   $carga = Agrega_Ceros($carga);
   $pdf->Output("Recibos de Carga No. $carga.pdf","I");
  
  
?>