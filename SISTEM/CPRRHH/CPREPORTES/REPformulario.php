<?php
	include_once('../../html_fns.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPADMON"];
	$colegio = $_SESSION["colegio_nombre_reporte"];
	
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	
	$ClsPer = new ClsPersonal();
	$dpi = $ClsPer->decrypt($hashkey, $usuario);
	$result = $ClsPer->get_personal($dpi);
	if(is_array($result)){
		foreach($result as $row){
			//rrhh_personal 
			$per_dpi = utf8_decode($row["per_dpi"]);
			$per_nombres = utf8_decode($row["per_nombres"]);
			$per_apellidos = utf8_decode($row["per_apellidos"]);
			$per_nit = utf8_decode($row["per_nit"]);
			$per_profesion = utf8_decode($row["per_profesion"]);
			$per_religion = utf8_decode($row["per_religion"]);
			$per_pasaporte = utf8_decode($row["per_pasaporte"]);
			$per_genero = utf8_decode($row["per_genero"]);
			$per_ecivil = utf8_decode($row["per_ecivil"]);
			$per_lugar_nac = utf8_decode($row["per_depmun_nacimiento_desc"]);
			$per_pais_nac = utf8_decode($row["per_pais_nacimiento_desc"]);
			$per_fecnac = utf8_decode($row["per_fecnac"]);
			$per_fecnac = cambia_fecha($per_fecnac);
			$per_edad = Calcula_Edad($per_fecnac);
			$per_direccion_eventual = utf8_decode($row["per_direccion_eventual"]);
			$per_depmun_eventual = utf8_decode($row["per_depmun_eventual_desc"]);
			$per_dep_eventual = substr($per_depmun_eventual, 0, strlen($per_depmun_eventual) - 2)."00";
			$per_telefono_eventual = utf8_decode($row["per_telefono_eventual"]);
			$per_direccion_permanente = utf8_decode($row["per_direccion_permanente"]); 
			$per_depmun_permanente = utf8_decode($row["per_depmun_permanentper_desc"]);
			$per_dep_permanente = substr($per_depmun_permanente, 0, strlen($per_depmun_permanente) - 2)."00";
			$per_telefono_permanente = utf8_decode($row["per_telefono_permanente"]);
			$per_tipo_sangre = utf8_decode($row["per_tipo_sangre"]);
			$per_alergico = utf8_decode($row["per_alergico"]);
			$per_celular = utf8_decode($row["per_celular"]);
			$per_mail = utf8_decode($row["per_mail"]);
			$per_emergencia_nombre = utf8_decode($row["per_emergencia_nombre"]);
			$per_emergencia_apellido = utf8_decode($row["per_emergencia_apellido"]);
			$per_emergencia_dir = utf8_decode($row["per_emergencia_dir"]);
			$per_emergencia_tel = utf8_decode($row["per_emergencia_tel"]);
			$per_emergencia_cel = utf8_decode($row["per_emergencia_cel"]);
			$per_fec_alta = utf8_decode($row["per_fec_alta"]);
			$per_fec_alta = cambia_fecha($per_fec_alta);
			$per_talla_camisa = utf8_decode($row["per_talla_camisa"]);
			$per_talla_pantalon = utf8_decode($row["per_talla_pantalon"]);
			$per_chumpa = utf8_decode($row["per_chumpa"]);
			$per_talla_botas = utf8_decode($row["per_talla_botas"]);
			$per_talla_gorra = utf8_decode($row["per_talla_gorra"]);
			$per_estatura = utf8_decode($row["per_estatura"]);
			$per_peso = utf8_decode($row["per_peso"]);
			$per_tez = utf8_decode($row["per_tez"]);
			$per_ojos = utf8_decode($row["per_ojos"]);
			$per_nariz = utf8_decode($row["per_nariz"]);
			$per_tipo_lic_veh = utf8_decode($row["per_tipo_lic_veh"]);
			$per_num_lic_veh = utf8_decode($row["per_num_lic_veh"]);
			$per_num_lic_moto = utf8_decode($row["per_num_lic_moto"]);
			//$per_num_lic_digecam = utf8_decode($row["per_num_lic_digecam"]);
			//$per_digecam_fecini = utf8_decode($row["per_digecam_fecini"]);
			//$per_digecam_fecfin = utf8_decode($row["per_digecam_fecfin"]);
			$per_deportes = utf8_decode($row["per_deportes"]);
			//$per_fec_penales = utf8_decode($row["per_fec_penales"]);
			//$per_fec_penales = cambia_fecha($per_fec_penales);
			//$per_fec_policiacos = utf8_decode($row["per_fec_policiacos"]);
			//$per_fec_policiacos = cambia_fecha($per_fec_policiacos);
			$per_status = utf8_decode($row["per_status"]);
			
			//rrhh_economica   
			$eco_trabaja_conyugue = utf8_decode($row["eco_trabaja_conyugue"]);
			$eco_sueldo_conyugue = utf8_decode($row["eco_sueldo_conyugue"]);
			$eco_lugar_trabajo_conyuge = utf8_decode($row["eco_lugar_trabajo_conyuge"]);
			$eco_cargas_familiares = utf8_decode($row["eco_cargas_familiares"]);
			$eco_vivienda = utf8_decode($row["eco_vivienda"]);
			$eco_pago_vivienda = utf8_decode($row["eco_pago_vivienda"]);
			$eco_cuenta_banco = utf8_decode($row["eco_cuenta_banco"]);
			$eco_banco = utf8_decode($row["eco_banco"]);
			$eco_tarjeta = utf8_decode($row["eco_tarjeta"]);
			$eco_operador_tarjeta = utf8_decode($row["eco_operador_tarjeta"]);
			$eco_otros_ingresos = utf8_decode($row["eco_otros_ingresos"]);
			$eco_monto_otros = utf8_decode($row["eco_monto_otros"]);
			$eco_sueldo = utf8_decode($row["eco_sueldo"]);
			$eco_descuentos = utf8_decode($row["eco_descuentos"]);
			$eco_prestamos = utf8_decode($row["eco_prestamos"]);
			$eco_saldo_prestamos = utf8_decode($row["eco_saldo_prestamos"]);
			 //rrhh_penal  
			$pen_detenido = utf8_decode($row["pen_detenido"]);
			$pen_motivo_detenido = utf8_decode($row["pen_motivo_detenido"]);
			$pen_donde_detenido = utf8_decode($row["pen_donde_detenido"]);
			$pen_cuando_detenido = utf8_decode($row["pen_cuando_detenido"]);
			$pen_porque_detenido = utf8_decode($row["pen_porque_detenido"]);
			$pen_fec_libertad = utf8_decode($row["pen_fec_libertad"]);
			$pen_arraigado = utf8_decode($row["pen_arraigado"]);
			$pen_motivo_arraigo = utf8_decode($row["pen_motivo_arraigo"]);
			$pen_donde_arraigo = utf8_decode($row["pen_donde_arraigo"]);
			$pen_cuando_arraigo = utf8_decode($row["pen_cuando_arraigo"]);
			 //rrhh_laboral_anterior   
			$lab_empleo = utf8_decode($row["lab_empleo"]);
			$lab_telefono = utf8_decode($row["lab_telefono"]);
			$lab_direccion = utf8_decode($row["lab_direccion"]);
			$lab_puesto = utf8_decode($row["lab_puesto"]);
			$lab_sucursal = utf8_decode($row["lab_sucursal"]);
			$lab_sueldo = utf8_decode($row["lab_sueldo"]);
			$lab_fecha = utf8_decode($row["lab_fecha"]);
			//rrhh_educacion
			$edu_catalogo = utf8_decode($row["edu_catalogo"]);
			$edu_grado_primaria = utf8_decode($row["edu_grado_primaria"]);
			$edu_lugar_primaria = utf8_decode($row["edu_lugar_primaria"]);
			$edu_grado_secundaria = utf8_decode($row["edu_grado_secundaria"]);
			$edu_lugar_secundaria = utf8_decode($row["edu_lugar_secundaria"]);
			$edu_carrera_secundaria = utf8_decode($row["edu_carrera_secundaria"]);
		}
	}
	
	
	$pdf = new PDF('P','mm','Letter');  // si quieren el reporte horizontal
	// P Hoja vertical, tamaño carta, medida en milimetros, ancho total de la hoja 200.5mm
	
	//$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(0,0,0);
	
	//******************* Inicializacion de Abcisa y Ordenada *****************
	$x = 5;
	$y = 5;
	//******************* PRIVADO ARRIBA *****************
	$pdf->SetXY(10,5);
	// fuente
	$pdf->SetFont('Arial','B',15);
	//colore de letra
	$pdf->SetTextColor(172,56,33);
	//texto
	$pdf->Cell(195.7,10,trim('INFORMACIÓN CONFIDENCIAL'),0,0,'C');
	//regresa a negro
	$pdf->SetTextColor(3,3,3);
	
	//*******************Recuadro del logo *****************
	$pdf->SetLineWidth(1);
	$pdf->SetXY(10,20);
	//Borde recuadro
	$pdf->Cell(40,40,'',1);
	//logo
	$pdf->Image('../../../CONFIG/images/replogo.jpg',10.1,20.1,39.8,39.8);
	
	//*******************Recuadro del Fotografia *****************
	$pdf->SetXY(166,20);
	//Borde recuadro
	$pdf->Cell(40,40,'',1);
	
	if (file_exists ('../../../CONFIG/Fotos/RRHH/'.$dpi.'.jpg')){
		$pdf->Image('../../../CONFIG/Fotos/RRHH/'.$dpi.'.jpg',166.1,20.1,39.8,39.8);
	}else{
		$pdf->Image('../../../CONFIG/Fotos/nofoto.jpg',166.1,20.1,39.8,44.8);
	}
	
	//******************* Estado Mayor de la Defensa Nacional *****************
	//******************* FORMULARIO DE DATOS PERSONALES *****************
	$pdf->SetXY(50,25);
	$pdf->SetFont('Arial','B',14);
	$pdf->MultiCell(116, 10, $colegio, 0 , 'C' , 0);
	$pdf->SetXY(50,40);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(3,3,3);
	$pdf->MultiCell(116, 5, 'DEPARTAMENTO DE RECURSOS HUMANOS', 0 , 'C' , 0);
	$pdf->SetXY(50,45);
	$pdf->MultiCell(116, 5, 'FORMULARIO DE DATOS PERSONALES', 0 , 'C' , 0);
	
	//*******************Recuadro Hoja *****************
	$pdf->SetLineWidth(0.7);
	$pdf->Rect(10,70,196,198);
	$pdf->SetLineWidth(0.2);
	
	//******************* Status *****************
	
	//******************* Datos Individuales *****************
	$pdf->SetMargins(0,0,0);
	$x = 15;
	$y = 85;
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	$pdf->MultiCell(50, 5, 'DATOS INDIVIDUALES', 0 , 'L' , 0);
	$pdf->createHorLine($x,$y+5,50);
	
	$y+=5; //salto de linea para espaciar
	
	//-- Personal ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',11);
	$x = 15;
	$y+=5;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Personal', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	$y+=10;
	//-- IZQUIERDA ---//
	$cabecera = array('Nombres: ', 'Prof. u Oficio: ', 'Genero: ', 'Fecha de Nac.: ', 'Lugar de Nac.: ','Dir. Eventual: ','Dep. Dirección: ','Dir. Permanente: ','Dep. Dirección: ','Típo de Sangre: ','Celular: ');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($per_nombres,$per_profesion,$per_genero,$per_fecnac,$per_lugar_nac,$per_direccion_eventual,$per_depmun_eventual,$per_direccion_permanente,$per_depmun_permanente,$per_tipo_sangre,$per_celular);
	$pdf->outValues($valores,$x+30,$y,6,60,20,"Arial", 10, "", 1);
	//$pdf->createHorLine($x+90.1,$y+42,34.8); //linea extra en direccion eventual
	//$pdf->createHorLine($x+90.1,$y+54,34.8); //linea extra en direccion permanente
	$x = 110;
	//-- DERECHA ---//
	$cabecera = array('Apellidos: ','Religion: ', 'Estado Civil: ','Edad: ','Nacionalidad: ','','Tel. Eventual: ','','Tel. Permanente: ','Alergico a: ','e-mail: ');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($per_apellidos,$per_religion,$per_ecivil,$per_edad,$per_pais_nac,'',$per_telefono_eventual,'',$per_telefono_permanente,$per_alergico,$per_mail);
	$y = $pdf->outValues($valores,$x+30,$y,6,60,20,"Arial", 10, "", 1);
	//----------------//
	
	$y+=5; //salto de linea para espaciar
	
	//-- Documentos y pertenencias personales ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',11);
	$x = 15;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Documentos y Pertenencias Personales', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	$y+=10;
	//-- IZQUIERDA ---//
	$cabecera = array('DPI: ', 'Pasaporte Of.: ', 'Tipo Lic. Veh.: ', 'No. Lic. Moto: ');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($per_dpi,$per_pasaporte,$per_tipo_lic_veh,$per_num_lic_moto);
	$pdf->outValues($valores,$x+30,$y,6,60,20,"Arial", 10, "", 1);
	$x = 110;
	//-- DERECHA ---//
	$cabecera = array('NIT: ','Pasaporte Pers.: ', 'No. Lic. Veh.: ');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($per_nit,$per_pasaporte,$per_num_lic_veh);
	$y = $pdf->outValues($valores,$x+30,$y,6,60,20,"Arial", 10, "", 1);
	
//////////////_________________ Pagina 2 _________________////////////////////
	
	$pdf->AddPage();
	//******************* PRIVADO ARRIBA *****************
	$pdf->SetXY(10,5);
	// fuente
	$pdf->SetFont('Arial','B',15);
	//colore de letra
	$pdf->SetTextColor(172,56,33);
	//texto
	$pdf->Cell(195.7,10,trim('INFORMACIÓN CONFIDENCIAL'),0,0,'C');
	//regresa a negro
	$pdf->SetTextColor(3,3,3);
	//*******************Recuadro Hoja *****************
	$pdf->SetLineWidth(0.7);
	$pdf->Rect(10,15,196,255);
	$pdf->SetLineWidth(0.2);
	//////////////------------------/////////////////////
	$pdf->SetMargins(0,0,0);
	$x = 15;
	$y = 20;
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	
	//-- Tabla Vehiculos ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',9);
	$x = 15;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Informacion de los Vehiculos', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//--
	$y+=10;
	$ClsVeh = new ClsVehiculo();
	$result = $ClsVeh->get_vehiculos($dpi);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//rrhh_vehiculos   
			$veh_tipo = utf8_decode($row["veh_tipo"]);
			$veh_marca = utf8_decode($row["veh_marca"]);
			$veh_linea = utf8_decode($row["veh_linea"]);
			$veh_modelo = utf8_decode($row["veh_modelo"]);
			$veh_tarjeta = utf8_decode($row["veh_tarjeta"]);
			$veh_color = utf8_decode($row["veh_color"]);
			$veh_chasis = utf8_decode($row["veh_chasis"]);
			$veh_motor = utf8_decode($row["veh_motor"]);
			$veh_placas = utf8_decode($row["veh_placas"]);
			$veh_pais_reg = utf8_decode($row["pai_desc"]);
			
			//-- IZQUIERDA ---//
			$cabecera = array('Tipo: ','Linea: ','Tarjeta de Circulacion: ','Chasis: ','Placas: ');
			$pdf->outValues($cabecera,$x,$y,6,60,20,"Arial", 10, "B");
			$valores = array($veh_tipo,$veh_linea,$veh_tarjeta,$veh_chasis,$veh_placas);
			$pdf->outValues($valores,$x+45,$y,6,45,20,"Arial", 10, "", 1);
			$x = 110;
			//-- DERECHA ---//
			$cabecera = array('Marca: ','Modelo: ','Color: ','Motor: ','Pais de Registro: ');
			$pdf->outValues($cabecera,$x,$y,6,60,20,"Arial", 10, "B");
			$valores = array($veh_marca,$veh_modelo,$veh_color,$veh_motor,$veh_pais_reg);
			$y = $pdf->outValues($valores,$x+40,$y,6,45,20,"Arial", 10, "", 1);
			//----------------//
			$y+=5;
			$x = 15;
		}	
	}else{
		//-- IZQUIERDA ---//
			$cabecera = array('Tipo: ','Linea: ','Tarjeta de Circulacion: ','Chasis: ','Placas: ');
			$pdf->outValues($cabecera,$x,$y,6,60,20,"Arial", 10, "B");
			$valores = array('','','','','');
			$pdf->outValues($valores,$x+45,$y,6,45,20,"Arial", 10, "", 1);
			$x = 110;
		//-- DERECHA ---//
			$cabecera = array('Marca: ','Modelo: ','Color: ','Motor: ','Pais de Registro: ');
			$pdf->outValues($cabecera,$x,$y,6,60,20,"Arial", 10, "B");
			$valores = array('','','','','');
			$y = $pdf->outValues($valores,$x+40,$y,6,45,20,"Arial", 10, "", 1);
		//----------------//
	}
	
	//-- Documentos y pertenencias personales ---//  Habilitado solo si el cliente lo pide
	/*$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',9);
	$x = 15;
	$y+=10;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, utf8_decode('Informacion del Armamento'), 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	//-- IZQUIERDA ---//
	$cabecera = array('Licencia de Portacion: ', 'Fecha de Extencion: ');
	$pdf->outValues($cabecera,$x,$y,6,60,20,"Arial", 10, "B");
	$valores = array($per_num_lic_digecam,$per_digecam_fecfin);
	$pdf->outValues($valores,$x+45,$y,6,45,20,"Arial", 10, "", 1);
	$x = 110;
	//-- DERECHA ---//
	$cabecera = array('Fecha de Expiracion: ');
	$pdf->outValues($cabecera,$x,$y,6,60,20,"Arial", 10, "B");
	$valores = array($per_digecam_fecfin);
	$y = $pdf->outValues($valores,$x+40,$y,6,45,20,"Arial", 10, "", 1);
	///--------
	$x = 15;
	$y+=10;
	//--
	$ClsArm = new ClsArmamento();
	$result = $ClsArm->get_armamento($dpi);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//rrhh_vehiculos   
			$arm_tipo = utf8_decode($row["arm_tipo"]);
			$arm_marca = utf8_decode($row["arm_marca"]);
			$arm_calibre = utf8_decode($row["arm_calibre"]);
			$arm_num_reg = utf8_decode($row["arm_num_reg"]);
			
			//-- IZQUIERDA ---//
			$cabecera = array('Tipo de Arma: ','Calibre: ');
			$pdf->outValues($cabecera,$x,$y,6,60,20,"Arial", 10, "B");
			$valores = array($arm_tipo,$arm_calibre);
			$pdf->outValues($valores,$x+45,$y,6,45,20,"Arial", 10, "", 1);
			$x = 110;
			//-- DERECHA ---//
			$cabecera = array('Marca: ','Numero de Registro: ');
			$pdf->outValues($cabecera,$x,$y,6,60,20,"Arial", 10, "B");
			$valores = array($arm_marca,$arm_num_reg);
			$y = $pdf->outValues($valores,$x+40,$y,6,45,20,"Arial", 10, "", 1);
			//----------------//
			$y+=5;
			$x = 15;
		}	
	}else{
		//-- IZQUIERDA ---//
			$cabecera = array('Tipo de Arma: ','Calibre: ');
			$pdf->outValues($cabecera,$x,$y,6,60,20,"Arial", 10, "B");
			$valores = array($arm_tipo,$arm_calibre);
			$pdf->outValues($valores,$x+45,$y,6,45,20,"Arial", 10, "", 1);
			$x = 110;
		//-- DERECHA ---//
			$cabecera = array('Marca: ','Numero de Registro: ');
			$pdf->outValues($cabecera,$x,$y,6,60,20,"Arial", 10, "B");
			$valores = array($arm_marca,$arm_num_reg);
			$y = $pdf->outValues($valores,$x+40,$y,6,45,20,"Arial", 10, "", 1);
		//----------------//
			$y+=5;
			$x = 15;
	}*/
	
//////////////_________________ Pagina 3 _________________////////////////////
	$pdf->AddPage();
	//******************* PRIVADO ARRIBA *****************
	$pdf->SetXY(10,5);
	// fuente
	$pdf->SetFont('Arial','B',15);
	//colore de letra
	$pdf->SetTextColor(172,56,33);
	//texto
	$pdf->Cell(195.7,10,trim('INFORMACIÓN CONFIDENCIAL'),0,0,'C');
	//regresa a negro
	$pdf->SetTextColor(3,3,3);
	//*******************Recuadro Hoja *****************
	$pdf->SetLineWidth(0.7);
	$pdf->Rect(10,15,196,255);
	$pdf->SetLineWidth(0.2);
	//////////////------------------/////////////////////
	$pdf->SetMargins(0,0,0);
	$x = 15;
	$y = 15;
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	////////////////////////////////////////////////////////
	$pdf->MultiCell(100, 15, 'INFORMACIÓN PROFESIONAL', 0 , 'L' , 0);
	$pdf->createHorLine($x,$y+10,60);
	
	//-- Documentos y pertenencias personales ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$y += 10;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Educacion', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	$y += 15;
	//----------------//
	//primaria
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY($x,$y);
	$pdf->Cell(60,5,'Primaria (Último Grado Cursado): ',0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY($x+65,$y);
	$pdf->Cell(40,5,$edu_grado_primaria." GRADO",0,'L');
	$pdf->createHorLine($x+60,$y+5,120);
	$y += 10;
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY($x,$y);
	$pdf->Cell(40,5,'Establecimiento(s): ',0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY($x+40,$y);
	$pdf->Cell(40,5,$edu_lugar_primaria,0,'L');
	$pdf->createHorLine($x+40,$y+5,140);
	//secundaria
	$y += 10;
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY($x,$y);
	$pdf->Cell(90,5,'Secundaria y Diversificado (Último Grado Cursado): ',0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY($x+95,$y);
	$pdf->Cell(40,5,$edu_grado_secundaria,0,'L');
	$pdf->createHorLine($x+90,$y+5,90);
	//-
	$y += 10;
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY($x,$y);
	$pdf->Cell(40,5,'Carrera: ',0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY($x+40,$y);
	$pdf->Cell(40,5,$edu_carrera_secundaria,0,'L');
	$pdf->createHorLine($x+40,$y+5,140);
	//-
	$y += 10;
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY($x,$y);
	$pdf->Cell(40,5,'Establecimiento(s): ',0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY($x+40,$y);
	$pdf->Cell(40,5,$edu_lugar_secundaria,0,'L');
	$pdf->createHorLine($x+40,$y+5,140);
	
	////////// Titulos Universitarios
	$y += 10;
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',9);
	$x = 15;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Títulos Universitarios', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	////-- encabezados --/////
	$y += 10;
	$pdf->SetXY($x-2,$y);
	$pdf->SetWidths(array(35, 50, 40, 20, 15, 15, 15));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
    $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i = 1; $i <=1; $i++){  // ESTE ES EL ENCABEZADO DE LA TABLA,
		$pdf->Row(array("Nivel", 'Titulo', 'Universidad','Pais','Añoo','Sem.','Gradu.?'));
	}
	$y += 5;
	////-- cuerpo --/////
	$ClsEdu = new ClsEducacion();
	$result = $ClsEdu->get_cursos($dpi,"U");
	if(is_array($result)){
		foreach($result as $row){
			//rrhh_cursos   
			$cur_nivel = utf8_decode($row["cur_nivel"]);
			switch($cur_nivel){
				case "": $cur_nivel = ""; break;
				case "PROF": $cur_nivel = "PROFESORADO"; break;
				case "LIC": $cur_nivel = "LICENCIATURA"; break;
				case "POST": $cur_nivel = "POST-GRADO"; break;
				case "MAST": $cur_nivel = "MAESTRIA"; break;
				case "DOC": $cur_nivel = "DOCTORADO"; break;
			}
			$cur_titulo = utf8_decode($row["cur_titulo"]);
			$cur_lugar = utf8_decode($row["cur_lugar"]);
			$cur_pais = utf8_decode($row["pai_desc"]);
			$cur_anio = utf8_decode($row["cur_anio"]);
			$cur_semestre = utf8_decode($row["cur_semestre"]);
			$cur_graduado = utf8_decode($row["cur_graduado"]);
			//---
			$pdf->SetXY($x-2,$y);
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($cur_nivel,$cur_titulo,$cur_lugar,$cur_pais,$cur_anio,$cur_semestre,$cur_graduado)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$y += 5;
		}
	}else{
		
		$pdf->SetXY($x-2,$y);
		$pdf->SetFont('Arial','B',8); // ASIGNO EL TIPO Y TAMA„O DE LA LETRA
		$pdf->SetFillColor(255,255,255); // AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(190,5,'',1,'','C',true); // AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	}
	
	////////// Idiomas
	$y += 10;
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',9);
	$x = 15;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Idiomas', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	////-- encabezados --/////
	$y += 10;
	$pdf->SetXY($x-2,$y);
	$pdf->SetWidths(array(70, 40, 40, 40));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
        $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row(array('Idioma', '% Lee', '% Habla','% Escribe'));
	}
	$y += 5;
	////-- cuerpo --/////
	$pdf->SetAligns(array('L', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$ClsEdu = new ClsEducacion();
	$result = $ClsEdu->get_idiomas($dpi);
	if(is_array($result)){
		foreach($result as $row){
			//rrhh_idiomas  
			$idi_idioma = utf8_decode($row["idi_idioma"]);
			$idi_habla = utf8_decode($row["idi_habla"]);
			$idi_lee = utf8_decode($row["idi_lee"]);
			$idi_escribe = utf8_decode($row["idi_escribe"]);
			//---
			$pdf->SetXY($x-2,$y);
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($idi_idioma,$idi_lee,$idi_habla,$idi_escribe)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
			$y += 5;
		}
	}else{
		
		$pdf->SetXY($x-2,$y);
		$pdf->SetFont('Arial','B',8); // ASIGNO EL TIPO Y TAMA„O DE LA LETRA
		$pdf->SetFillColor(255,255,255); // AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(190,5,'',1,'','C',true); // AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	}
	
	////////// Cursos Civiles
	$y += 10;
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',9);
	$x = 15;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Cursos y Capacitaciones', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	////-- encabezados --/////
	$y += 10;
	$pdf->SetXY($x-2,$y);
	$pdf->SetWidths(array(40, 60, 45, 30, 15));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
        $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row(array('Nivel', 'Curso', 'Institución','Pais','Año'));
	}
	$y += 5;
	////-- cuerpo --/////
	$ClsEdu = new ClsEducacion();
	$result = $ClsEdu->get_cursos($dpi,"C");
	if(is_array($result)){
		foreach($result as $row){
			//rrhh_cursos   
			$cur_nivel = utf8_decode($row["cur_nivel"]);
			switch($cur_nivel){
				case "": $cur_nivel = ""; break;
				case "TALL": $cur_nivel = "TALLER"; break;
				case "SEM": $cur_nivel = "SEMINARIO"; break;
				case "DIP": $cur_nivel = "DIPLOMADO"; break;
				case "CAP": $cur_nivel = "CAPACITACION"; break;
			}
			$cur_titulo = utf8_decode($row["cur_titulo"]);
			$cur_lugar = utf8_decode($row["cur_lugar"]);
			$cur_pais = utf8_decode($row["pai_desc"]);
			$cur_anio = utf8_decode($row["cur_anio"]);
			$cur_semestre = utf8_decode($row["cur_semestre"]);
			$cur_graduado = utf8_decode($row["cur_graduado"]);
			//---
			$pdf->SetXY($x-2,$y);
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($cur_nivel,$cur_titulo,$cur_lugar,$cur_pais,$cur_anio)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY
			$y += 5;
		}
	}else{
		
		$pdf->SetXY($x-2,$y);
		$pdf->SetFont('Arial','B',8); // ASIGNO EL TIPO Y TAMA„O DE LA LETRA
		$pdf->SetFillColor(255,255,255); // AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(190,5,'',1,'','C',true); // AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	}
	
//////////////_________________ Pagina 4 _________________////////////////////
	$pdf->AddPage();
	//******************* PRIVADO ARRIBA *****************
	$pdf->SetXY(10,5);
	// fuente
	$pdf->SetFont('Arial','B',15);
	//colore de letra
	$pdf->SetTextColor(172,56,33);
	//texto
	$pdf->Cell(195.7,10,trim('INFORMACIÓN CONFIDENCIAL'),0,0,'C');
	//regresa a negro
	$pdf->SetTextColor(3,3,3);
	//*******************Recuadro Hoja *****************
	$pdf->SetLineWidth(0.7);
	$pdf->Rect(10,15,196,255);
	$pdf->SetLineWidth(0.2);
	//////////////------------------/////////////////////
	$pdf->SetMargins(0,0,0);
	$x = 15;
	$y = 15;
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	////////////////////////////////////////////////////////
	$pdf->MultiCell(100, 15, 'INFORMACIÓN FAMILIAR', 0 , 'L' , 0);
	$pdf->createHorLine($x,$y+10,50);
	
	//-- Padre ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$x = 15;
	$y += 10;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Datos del Padre', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	$y+=10;
	
	$ClsFam = new ClsFamilia();
	$result = $ClsFam->get_familia($dpi,"3");
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//rrhh_familia   
			$fam_nombres = utf8_decode($row["fam_nombres"]);
			$fam_apellidos = utf8_decode($row["fam_apellidos"]);
			$fam_direccion = utf8_decode($row["fam_direccion"]);
			$fam_telefono = utf8_decode($row["fam_telefono"]);
			$fam_celular = utf8_decode($row["fam_celular"]);
			$fam_profesion = utf8_decode($row["fam_profesion"]);
			$fam_religion = utf8_decode($row["fam_religion"]);
			$fam_pais = utf8_decode($row["pai_desc"]);
			$fam_fecnac = utf8_decode($row["fam_fecnac"]);
			$fam_fecnac = cambia_fecha($fam_fecnac);
			$fam_fecnac = ($fam_fecnac == "00/00/0000")?"":$fam_fecnac;
			$fam_edad = Calcula_Edad($fam_fecnac);
			$fam_edad = ($fam_fecnac == "00/00/0000")?"":$fam_edad;
			$fam_parentesco = utf8_decode($row["fam_parentesco"]);
		}
	}	
	
	//-- IZQUIERDA ---//
	$cabecera = array('Nombre: ', 'Nacionalidad: ', 'Dirección: ', 'Celular: ', 'Fec. Nacimiento: ', 'Profesion: ');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($fam_nombres,$fam_pais,$fam_direccion,$fam_celular,$fam_fecnac,$fam_profesion);
	$pdf->outValues($valores,$x+30,$y,6,60,20,"Arial", 10, "", 1);
	//$pdf->createHorLine($x+90.1,$y+24,34.8); //linea extra en direccion
	//$pdf->createHorLine($x+90.1,$y+42,34.8); //linea extra en profesion
	$x = 110;
	//-- DERECHA ---//
	$cabecera = array('Apellidos: ','Religion: ', '','Telefono: ', 'Edad: ','');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($fam_apellidos,$fam_religion,'',$fam_telefono,$fam_edad,'');
	$y = $pdf->outValues($valores,$x+30,$y,6,60,20,"Arial", 10, "", 1);
	
	//-- Madre ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$x = 15;
	$y += 10;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Datos de la Madre', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	$y+=10;
	
	$ClsFam = new ClsFamilia();
	$result = $ClsFam->get_familia($dpi,"2");
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//rrhh_familia   
			$fam_nombres = utf8_decode($row["fam_nombres"]);
			$fam_apellidos = utf8_decode($row["fam_apellidos"]);
			$fam_direccion = utf8_decode($row["fam_direccion"]);
			$fam_telefono = utf8_decode($row["fam_telefono"]);
			$fam_celular = utf8_decode($row["fam_celular"]);
			$fam_profesion = utf8_decode($row["fam_profesion"]);
			$fam_religion = utf8_decode($row["fam_religion"]);
			$fam_pais = utf8_decode($row["pai_desc"]);
			$fam_fecnac = utf8_decode($row["fam_fecnac"]);
			$fam_fecnac = cambia_fecha($fam_fecnac);
			$fam_fecnac = ($fam_fecnac == "00/00/0000")?"":$fam_fecnac;
			$fam_edad = Calcula_Edad($fam_fecnac);
			$fam_edad = ($fam_fecnac == "00/00/0000")?"":$fam_edad;
			$fam_parentesco = utf8_decode($row["fam_parentesco"]);
		}
	}	
	
	//-- IZQUIERDA ---//
	$cabecera = array('Nombre: ', 'Nacionalidad: ', 'Dirección: ', 'Celular: ', 'Fec. Nacimiento: ', 'Profesion: ');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($fam_nombres,$fam_pais,$fam_direccion,$fam_celular,$fam_fecnac,$fam_profesion);
	$pdf->outValues($valores,$x+30,$y,6,60,20,"Arial", 10, "", 1);
	//$pdf->createHorLine($x+90.1,$y+24,34.8); //linea extra en direccion
	//$pdf->createHorLine($x+90.1,$y+42,34.8); //linea extra en profesion
	$x = 110;
	//-- DERECHA ---//
	$cabecera = array('Apellidos: ','Religion: ', '','Telefono: ', 'Edad: ','');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($fam_apellidos,$fam_religion,'',$fam_telefono,$fam_edad,'');
	$y = $pdf->outValues($valores,$x+30,$y,6,60,20,"Arial", 10, "", 1);
	
	//-- Esposa ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$x = 15;
	$y += 10;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Datos de la Esposa', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	$y+=10;
	
	$ClsFam = new ClsFamilia();
	$result = $ClsFam->get_familia($dpi,"1");
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//rrhh_familia   
			$fam_nombres = utf8_decode($row["fam_nombres"]);
			$fam_apellidos = utf8_decode($row["fam_apellidos"]);
			$fam_direccion = utf8_decode($row["fam_direccion"]);
			$fam_telefono = utf8_decode($row["fam_telefono"]);
			$fam_celular = utf8_decode($row["fam_celular"]);
			$fam_profesion = utf8_decode($row["fam_profesion"]);
			$fam_religion = utf8_decode($row["fam_religion"]);
			$fam_pais = utf8_decode($row["pai_desc"]);
			$fam_fecnac = utf8_decode($row["fam_fecnac"]);
			$fam_fecnac = cambia_fecha($fam_fecnac);
			$fam_fecnac = ($fam_fecnac == "00/00/0000")?"":$fam_fecnac;
			$fam_edad = Calcula_Edad($fam_fecnac);
			$fam_edad = ($fam_fecnac == "00/00/0000")?"":$fam_edad;
			$fam_parentesco = utf8_decode($row["fam_parentesco"]);
		}
	}	
	
	//-- IZQUIERDA ---//
	$cabecera = array('Nombre: ', 'Nacionalidad: ', 'Dirección: ', 'Celular: ', 'Fec. Nacimiento: ', 'Profesion: ');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($fam_nombres,$fam_pais,$fam_direccion,$fam_celular,$fam_fecnac,$fam_profesion);
	$pdf->outValues($valores,$x+30,$y,6,60,20,"Arial", 10, "", 1);
	//$pdf->createHorLine($x+90.1,$y+24,34.8); //linea extra en direccion
	//$pdf->createHorLine($x+90.1,$y+42,34.8); //linea extra en profesion
	$x = 110;
	//-- DERECHA ---//
	$cabecera = array('Apellidos: ','Religion: ', '','Telefono: ', 'Edad: ','');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($fam_apellidos,$fam_religion,'',$fam_telefono,$fam_edad,'');
	$y = $pdf->outValues($valores,$x+30,$y,6,60,20,"Arial", 10, "", 1);
	
	//-- Hijos ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$x = 15;
	$y += 10;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Datos de los Hijos', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	////-- encabezados --/////
	$y += 10;
	$pdf->SetXY($x-2,$y);
	$pdf->SetWidths(array(8, 57, 45, 30, 30, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
        $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$y+= $pdf->Row(array('No.', 'Nombres', 'Nacionalidad', 'Religion','Fec. Nacimiento','Edad'));
	}
	$y += 5;
	////-- cuerpo --/////
	$ClsFam = new ClsFamilia();
	$result = $ClsFam->get_familia($dpi,"4");
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//rrhh_familia   
			$fam_nombres = utf8_decode($row["fam_nombres"]);
			$fam_apellidos = utf8_decode($row["fam_apellidos"]);
			$nombres = trim($fam_nombres)." ".trim($fam_apellidos);
			$fam_direccion = utf8_decode($row["fam_direccion"]);
			$fam_telefono = utf8_decode($row["fam_telefono"]);
			$fam_celular = utf8_decode($row["fam_celular"]);
			$fam_profesion = utf8_decode($row["fam_profesion"]);
			$fam_religion = utf8_decode($row["fam_religion"]);
			$fam_pais = utf8_decode($row["pai_desc"]);
			$fam_fecnac = utf8_decode($row["fam_fecnac"]);
			$fam_fecnac = cambia_fecha($fam_fecnac);
			$fam_fecnac = ($fam_fecnac == "00/00/0000")?"":$fam_fecnac;
			$fam_edad = Calcula_Edad($fam_fecnac);
			$fam_edad = ($fam_fecnac == "00/00/0000")?"":$fam_edad;
			//---
			$pdf->SetXY($x-2,$y);
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$y+= $pdf->Row(array($i,$nombres,$fam_pais,$fam_religion,$fam_fecnac,$fam_edad)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;
			$y += 5;
		}
	}else{
		
		$pdf->SetXY($x-2,$y);
		$pdf->SetFont('Arial','B',8); // ASIGNO EL TIPO Y TAMA„O DE LA LETRA
		$pdf->SetFillColor(255,255,255); // AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(190,5,'',1,'','C',true); // AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	}
	
	
	//-- Hermanos ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$x = 15;
	$y += 10;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Datos de los Hermanos', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	////-- encabezados --/////
	$y += 10;
	$pdf->SetXY($x-2,$y);
	$pdf->SetWidths(array(8, 57, 45, 30, 30, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
        $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$y+= $pdf->Row(array('No.', 'Nombres', 'Nacionalidad', 'Religion','Fec. Nacimiento','Edad'));
	}
	$y += 5;
	////-- cuerpo --/////
	$ClsFam = new ClsFamilia();
	$result = $ClsFam->get_familia($dpi,"7");
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//rrhh_familia   
			$fam_nombres = utf8_decode($row["fam_nombres"]);
			$fam_apellidos = utf8_decode($row["fam_apellidos"]);
			$nombres = trim($fam_nombres)." ".trim($fam_apellidos);
			$fam_direccion = utf8_decode($row["fam_direccion"]);
			$fam_telefono = utf8_decode($row["fam_telefono"]);
			$fam_celular = utf8_decode($row["fam_celular"]);
			$fam_profesion = utf8_decode($row["fam_profesion"]);
			$fam_religion = utf8_decode($row["fam_religion"]);
			$fam_pais = utf8_decode($row["pai_desc"]);
			$fam_fecnac = utf8_decode($row["fam_fecnac"]);
			$fam_fecnac = cambia_fecha($fam_fecnac);
			$fam_edad = Calcula_Edad($fam_fecnac);
			//---
			$pdf->SetXY($x-2,$y);
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$y+= $pdf->Row(array($i,$nombres,$fam_pais,$fam_religion,$fam_fecnac,$fam_edad)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;
			$y += 5;
		}
	}else{
		
		$pdf->SetXY($x-2,$y);
		$pdf->SetFont('Arial','B',8); // ASIGNO EL TIPO Y TAMA„O DE LA LETRA
		$pdf->SetFillColor(255,255,255); // AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(190,5,'',1,'','C',true); // AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	}
	
//////////////_________________ Pagina 5 _________________////////////////////
	$pdf->AddPage();
	//******************* PRIVADO ARRIBA *****************
	$pdf->SetXY(10,5);
	// fuente
	$pdf->SetFont('Arial','B',15);
	//colore de letra
	$pdf->SetTextColor(172,56,33);
	//texto
	$pdf->Cell(195.7,10,trim('INFORMACIÓN CONFIDENCIAL'),0,0,'C');
	//regresa a negro
	$pdf->SetTextColor(3,3,3);
	//*******************Recuadro Hoja *****************
	$pdf->SetLineWidth(0.7);
	$pdf->Rect(10,15,196,255);
	$pdf->SetLineWidth(0.2);
	//////////////------------------/////////////////////
	$pdf->SetMargins(0,0,0);
	$x = 20;
	$y = 20;
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	//-- En caso de Emergencia ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'En caso de Emergencia Avisar a', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	$y+=10;
	
	//-- IZQUIERDA ---//
	$cabecera = array('Nombre: ', 'Telefono: ', 'Dirección: ');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($per_emergencia_nombre,$per_emergencia_tel,$per_emergencia_dir);
	$pdf->outValues($valores,$x+30,$y,6,55,20,"Arial", 10, "", 1);
	$x = 110;
	//-- DERECHA ---//
	$cabecera = array('Apellidos: ','Celular: ');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($per_emergencia_apellido,$per_emergencia_cel);
	$y = $pdf->outValues($valores,$x+30,$y,6,55,20,"Arial", 10, "", 1);
	
	//-- Familia Militar ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$x = 15;
	$y += 10;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'Familiares dentro de la Institucion o halla sido parte de ella', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	////-- encabezados --/////
	$y += 10;
	$pdf->SetXY($x-2,57);
	$pdf->SetWidths(array(8, 45, 57, 30, 50, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
    $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO
	
	//echo $y;
	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$pdf->Row(array('No.', 'Nombre', 'Parentesco','Puesto','Año'));
	}
	//$y += 5;
	$pdf->SetWidths(array(8, 45, 57, 30, 50, 20));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	////-- cuerpo --/////
	$ClsFam = new ClsFamilia();
	$result = $ClsFam->get_familia_institucion($dpi);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//rrhh_familia   
			$famil_nombre = utf8_decode($row["fainst_nombre"]);
			$famil_parentesco = utf8_decode($row["fainst_parentesco"]);
			$famil_puesto = utf8_decode($row["fainst_puesto"]);
			$famil_anio = utf8_decode($row["fainst_anio"]);
			//---
			$pdf->SetXY($x-2,$y);
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$pdf->Row(array($i,$famil_nombre,$famil_parentesco,$famil_puesto,$famil_anio)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$i++;
			$y += 5;
		}
	}else{
		
		$pdf->SetXY($x-2,$y);
		$pdf->SetFont('Arial','B',8); // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
		$pdf->SetFillColor(255,255,255); // AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(190,5,'',1,'','C',true); // AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	}
	
	//-- Referencias Sociales ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$x = 15;
	$y += 15;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(186, 5, 'personas que NO son familiares suyos y que tienen conocimiento directo de su trabajo y honradez', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	//----------------//
	////-- encabezados --/////
	$y += 10;
	$pdf->SetXY($x-2,$y);
	$pdf->SetWidths(array(8, 45, 57, 20, 30, 30));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));  // AQUÍ LE DOY ANDHO A CADA UNA DE LAS COLUMNAS;
	
	// EN EL ARRAY, CADA DATO ES UNA COLUMNA, IGUAL SE HACE PARA INGRESAR LOS DATOS
	$pdf->SetFont('Arial','B',8);  // AQUI LE ASIGNO EL TIPO DE LETRA Y TAMAÑO
	$pdf->SetFillColor(216,216,216);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
        $pdf->SetTextColor(0,0,0);  // AQUI LE DOY COLOR AL TEXTO

	for($i=0;$i<1;$i++){  // ESTE ES EL ENCABEZADO DE LA TABLA, 
		$y+= $pdf->Row(array('No.', 'Nombre', 'Dirección', 'Telefono','Lugar de Trabajo','Cargo'));
	}
	$y += 5;
	////-- cuerpo --/////
	$ClsRefS = new ClsRefSocial();
	$result = $ClsRefS->get_referencia_social($dpi);
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			//rrhh_referencia_social   
			$refso_nombre = utf8_decode($row["refso_nombre"]);
			$refso_direccion = utf8_decode($row["refso_direccion"]);
			$refso_telefono = utf8_decode($row["refso_telefono"]);
			$refso_trabajo = utf8_decode($row["refso_trabajo"]);
			$refso_cargo = utf8_decode($row["refso_cargo"]);
			//---
			$pdf->SetXY($x-2,$y);
			$pdf->SetFont('Arial','',8);   // ASIGNO EL TIPO Y TAMAÑO DE LA LETRA
			$pdf->SetFillColor(255,255,255);	// AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
			$pdf->SetTextColor(0,0,0);  // LE ASIGNO EL COLOR AL TEXTO
			$no = $i.".";
			$y+= $pdf->Row(array($i,$refso_nombre,$refso_direccion,$refso_telefono,$refso_trabajo,$refso_cargo)); // AGREGO LOS DATOS A LA FILA, VIENE REPERESENTADO POR UN ARRAY 
			$y += 5;
		}
	}else{
		
		$pdf->SetXY($x-2,$y);
		$pdf->SetFont('Arial','B',8); // ASIGNO EL TIPO Y TAMA„O DE LA LETRA
		$pdf->SetFillColor(255,255,255); // AQUI LE DOY EL COLOR DE FONDO DE LAS CELDAS
		$pdf->Cell(190,5,'',1,'','C',true); // AQUI ASIGNO UNA CELDA DEL ANCHO DE LA TABLA PARA PONER LA CANTIDAD DE REGISTROS
	}
	
//////////////_________________ Pagina 6 _________________////////////////////
	$pdf->AddPage();
	//******************* PRIVADO ARRIBA *****************
	$pdf->SetXY(10,5);
	// fuente
	$pdf->SetFont('Arial','B',15);
	//colore de letra
	$pdf->SetTextColor(172,56,33);
	//texto
	$pdf->Cell(195.7,10,trim('INFORMACIÓN CONFIDENCIAL'),0,0,'C');
	//regresa a negro
	$pdf->SetTextColor(3,3,3);
	//*******************Recuadro Hoja *****************
	$pdf->SetLineWidth(0.7);
	$pdf->Rect(10,15,196,255);
	$pdf->SetLineWidth(0.2);
	//////////////------------------/////////////////////
	$pdf->SetMargins(0,0,0);
	$x = 15;
	$y = 15;
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	////////////////////////////////////////////////////////
	$pdf->MultiCell(100, 15, 'INFORMACIÓN ECONÓMICA', 0 , 'L' , 0);
	$pdf->createHorLine($x,$y+10,55);
	
	//-- economicas ---//
	$x = 15;
	$y += 15;
	//----------------//
	//-- IZQUIERDA ---//
	$cabecera = array('Esta su conyugue Empleada(o): ', 'Lugar donde Trabaja: ', 'Lugar de Vivienda: ', 'Posee Cuentas Bancarias?: ', 'Posee Tarjetas de Credito: ', 'Otros Ingresos: ', 'Monto Aprox.: ',  'Sueldo Liquido: ', 'Tiene Prestamos?: ');
	$pdf->outValues($cabecera,$x,$y,6,55,20,"Arial", 10, "B");
	$valores = array($eco_trabaja_conyugue,$eco_lugar_trabajo_conyuge,$eco_vivienda,$eco_cuenta_banco,$eco_tarjeta,$eco_otros_ingresos,"Q. ".$eco_monto_otros,"Q. ".$eco_sueldo,$eco_prestamos);
	$pdf->outValues($valores,$x+55,$y,6,45,20,"Arial", 10, "", 1);
	//$pdf->createHorLine($x+100.1,$y+42,39.8); //linea extra otros ingresos
	//$pdf->createHorLine($x+100.1,$y+48,39.8); //linea extra monto de otros ingresos
	$x = 115;
	//-- DERECHA ---//
	$cabecera = array('Ingresos Conyugue: ','Cargas Familiares: ', 'Cuanto Paga?: ', 'Bancos: ', 'Empresas o Bancos: ', '', '', 'Descuentos: ', 'Saldo: ');
	$pdf->outValues($cabecera,$x,$y,6,40,20,"Arial", 10, "B");
	$valores = array("Q. ".$eco_sueldo_conyugue,$eco_cargas_familiares,"Q. ".$eco_pago_vivienda,$eco_banco,$eco_operador_tarjeta,'', '',"Q. ".$eco_descuentos,"Q. ".$eco_saldo_prestamos);
	$y = $pdf->outValues($valores,$x+40,$y,6,45,20,"Arial", 10, "", 1);
	
	//////////////------------------/////////////////////
	$y += 5;
	$x = 15;
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	////////////////////////////////////////////////////////
	$pdf->MultiCell(100, 15, 'INFORMACIÓN PENAL', 0 , 'L' , 0);
	$pdf->createHorLine($x,$y+10,45);
	
	//-- Penal ---//
	$x = 15;
	$y += 15;
	//----------------//
	//-- IZQUIERDA ---//
	$cabecera = array('Ha sido detenido(a): ', 'Motivo: ', 'Donde: ', 'Cuando Recobro la Libertad: ', 'Ha sido Arraigado?: ', 'Motivo: ',  'Donde: ', 'Fecha de Penales: ');
	$pdf->outValues($cabecera,$x,$y,6,55,20,"Arial", 10, "B");
	$valores = array($pen_detenido,$pen_motivo_detenido,$pen_donde_detenido,$pen_fec_libertad,$pen_arraigado,$pen_motivo_arraigo,$pen_donde_arraigo,$per_fec_penales);
	$pdf->outValues($valores,$x+55,$y,6,45,20,"Arial", 10, "", 1);
	/*$pdf->createHorLine($x+100.1,$y+18,39.8); //linea extra en motivo de detencion
	$pdf->createHorLine($x+100.1,$y+24,39.8); //linea extra donde fue la detencion
	$pdf->createHorLine($x+100.1,$y+30,39.8); //linea extra en cuando recobro la libertad
	$pdf->createHorLine($x+100.1,$y+42,39.8); //linea extra en motivo de arraigo
	$pdf->createHorLine($x+100.1,$y+48,39.8); //linea extra donde fue el arraigo*/
	$x = 115;
	//-- DERECHA ---//
	$cabecera = array('Cuando: ','', '', '', 'Cuando: ', '', '', 'Fecha de Policiacos: ');
	$pdf->outValues($cabecera,$x,$y,6,40,20,"Arial", 10, "B");
	$valores = array($pen_cuando_detenido,'','','',$pen_cuando_arraigo,'', '',$per_fec_policiacos);
	$y = $pdf->outValues($valores,$x+40,$y,6,45,20,"Arial", 10, "", 1);

	//////////////------------------/////////////////////
	$y += 5;
	$x = 15;
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	////////////////////////////////////////////////////////
	$pdf->MultiCell(100, 15, 'INFORMACIÓN LABORAL ANTERIOR', 0 , 'L' , 0);
	$pdf->createHorLine($x,$y+10,72);
	
	//-- Penal ---//
	$x = 15;
	$y += 15;
	//----------------//
	//-- IZQUIERDA ---//
	$cabecera = array('Ultimo Empleo: ', 'Dirección del Ultimo Emp.: ', 'Puesto que desempeño: ', 'Sueldo: ');
	$pdf->outValues($cabecera,$x,$y,6,55,20,"Arial", 10, "B");
	$valores = array($lab_empleo,$lab_direccion,$lab_puesto,$lab_sueldo);
	$pdf->outValues($valores,$x+55,$y,6,45,20,"Arial", 10, "", 1);
	//$pdf->createHorLine($x+100.1,$y+18,39.8); //linea extra en motivo de detencion
	$x = 115;
	//-- DERECHA ---//
	$cabecera = array('Telefono: ','','Empresa: ','Fecha de Ingreso: ');
	$pdf->outValues($cabecera,$x,$y,6,40,20,"Arial", 10, "B");
	$valores = array($lab_telefono,'',$lab_sucursal,$lab_fecha);
	$y = $pdf->outValues($valores,$x+40,$y,6,45,20,"Arial", 10, "", 1);
	
	//////////////------------------/////////////////////
	$y += 5;
	$x = 15;
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',11);
	////////////////////////////////////////////////////////
	$pdf->MultiCell(100, 15, 'INFORMACIÓN SOMATOMETRICA', 0 , 'L' , 0);
	//$pdf->createHorLine($x,$y+10,66);
	
	//-- Hijos ---//
	$pdf->SetTextColor(164,164,164);
	$pdf->SetFont('Arial','U',10);
	$x = 15;
	$y += 15;
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(93, 5, 'Caracteristicas Físicas', 0 , 'C' , 0);
	$pdf->SetXY($x+93,$y);
	$pdf->MultiCell(93, 5, 'Uniforme', 0 , 'C' , 0);
	$pdf->SetTextColor(3,3,3);
	$x = 15;
	//----------------//
	$y += 10;
	//-- IZQUIERDA ---//
	$cabecera = array('Estatura: ', 'Peso: ', 'Color Tez: ', 'Color Ojos: ', 'Nariz: ');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($per_estatura." mts.",$per_peso." lbs.",$per_tez,$per_ojos,$per_nariz);
	$pdf->outValues($valores,$x+35,$y,6,60,20,"Arial", 10, "", 1);
	$x = 115;
	//-- DERECHA ---//
	$cabecera = array('Talla Camisa: ', 'Talla Pantalon: ', 'Talla Súeter: ', 'Talla Zapatos: ', 'Talla Gorra: ');
	$pdf->outValues($cabecera,$x,$y,6,35,20,"Arial", 10, "B");
	$valores = array($per_talla_camisa,$per_talla_pantalon,$per_chumpa,$per_talla_botas,$per_talla_gorra);
	$y = $pdf->outValues($valores,$x+33,$y,6,50,20,"Arial", 10, "", 1);

	
	//$pdf->SetDisplayMode(real,'default'); 
	$pdf->Output();

?>