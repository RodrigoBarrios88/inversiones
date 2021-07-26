<?php
include_once('html_fns_reportes.php');
	$usuario = $_SESSION["codigo"];
    $usunombre = $_SESSION["nombre"];
    $usunivel = $_SESSION["nivel"];
    $pensum = $_SESSION["pensum"];
    $tipo_usuario = $_SESSION['tipo_usuario'];
    $tipo_codigo = $_SESSION['tipo_codigo'];
	$colegio = $_SESSION["colegio_nombre_reporte"];
	//$_POST
	$ClsAcad = new ClsAcademico();
	
	$hashkey1 = $_REQUEST["hashkey1"];
    $pensum = $ClsAcad->decrypt($hashkey1, $usuario);
    $hashkey2 = $_REQUEST["hashkey2"];
    $nivel = $ClsAcad->decrypt($hashkey2, $usuario);
    $hashkey3 = $_REQUEST["hashkey3"];
    $grado = $ClsAcad->decrypt($hashkey3, $usuario);
    $hashkey4 = $_REQUEST["hashkey4"];
    $seccion = $ClsAcad->decrypt($hashkey4, $usuario);
	
	//Inicio de PDF
	$pdf=new PDF('L','mm','Letter');  // si quieren el reporte horizontal
	//$pdf->Open();
	
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombres = $apellido.", ".$nombre;
			//
			$nivel = utf8_decode($row["niv_descripcion"]);
			$grado = utf8_decode($row["gra_descripcion"]);
			$grado_desc = $grado.", Nivel ".$nivel;
	
			$pdf->AddPage();
			$pdf->SetMargins(0,0,0);
			$pdf->Ln(2);
		
			$pdf->SetFont('Arial','B',16);
			$pdf->Image('../../../CONFIG/images/diploma_fondo.jpg' , 0 , 0, 280 , 216,'JPG', '');
			
			///// LOGO ///////
			$pdf->Image('../../../CONFIG/images/replogo.jpg' , 117 ,5, 40 , 40,'JPG', '');
			
			///// COLEGIO ////////
			$pdf->SetXY(0,70);
			$pdf->SetFont('Arial','B',18);
			$pdf->MultiCell(0, 10, $colegio, 0 , 'C' , 0);
			
			///// NOMBRE DEL ALUMNO
			$pdf->SetFont('Arial','B',14);
			$pdf->SetXY(55,93);
			$pdf->Cell(170,8,$nombres,0,'','C',false);
			///// GRADO DE CURSA
			$pdf->SetXY(55,109);
			$pdf->Cell(170,8,$grado_desc,0,'','C',false);
			
			///// FECHA
			$pdf->SetXY(55,145);
			$pdf->SetFont('Arial','',14);
			switch(date("m")){
				case 1: $mes = "enero"; break;
				case 2: $mes = "febrero"; break;
				case 3: $mes = "marzo"; break;
				case 4: $mes = "abril"; break;
				case 5: $mes = "mayo"; break;
				case 6: $mes = "junio"; break;
				case 7: $mes = "julio"; break;
				case 8: $mes = "agosto"; break;
				case 9: $mes = "septiembre"; break;
				case 10: $mes = "octubre"; break;
				case 11: $mes = "noviembre"; break;
				case 12: $mes = "diciembre"; break;
			}
			$pdf->Cell(170,8,'Guatemala, '.date("d").' de '.$mes.' de '.date("Y").'.',0,'','C',false);
			
			///// FIRMAS
			$pdf->SetFont('Arial','B',12);
			$pdf->SetXY(25,175);
			$pdf->Cell(69,8,'Dirección General','T','','C',false);
			$pdf->SetXY(185,175);
			$pdf->Cell(69,8,'Dirección '.$nivel,'T','','C',false);
		}	
	}	

	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>