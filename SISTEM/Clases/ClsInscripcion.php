<?php
require_once ("ClsConex.php");

class ClsInscripcion extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
	var $division;
	var $grupo;
	var $anio;
	var $periodo;
	
	function __construct(){
		$this->division = 1;
		$this->grupo = 1;
		$this->anio = date("Y");
		$this->periodo = 0;
		$this->activo = 0;
		
		$this->base_inscripciones();
	}	
   
    function get_alumno($cui,$nom = '',$ape = '',$sit = '',$codigo = '') {
		$cui = trim($cui);
		$division = $this->division;
		$grupo = $this->grupo;
		$periodo = $this->periodo;
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT stat_contrato FROM inscripcion_status WHERE stat_alumno = alu_cui_new ORDER BY stat_contrato DESC LIMIT 0 , 1) as alu_contrato,"; //trae el ultimo contrato activo (si tiene))
		$sql.= " (SELECT stat_situacion FROM inscripcion_status WHERE stat_alumno = alu_cui_new ORDER BY stat_contrato DESC LIMIT 0 , 1) as alu_contrato_situacion,"; //trae la situacion del ultimo contrato activo (si tiene))
		$sql.= " (SELECT bol_codigo FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_inscripcion,"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT bol_referencia FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_numero_boleta_inscripcion,"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT bol_situacion FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_situacion,"; //trae la situacion de la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,inscripcion_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui_new ORDER BY pad_cui LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_telefono) FROM app_padres,inscripcion_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui_new ORDER BY pad_cui LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,inscripcion_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui_new ORDER BY pad_cui LIMIT 0 , 1) as alu_mail_padres";
		$sql.= " FROM inscripcion_alumnos";
		$sql.= " WHERE 1 = 1";
		if(strlen($cui)>0) { 
			  $sql.= " AND alu_cui_new = '$cui'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND UPPER(alu_nombre) like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND UPPER(alu_apellido) like '%$ape%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = '$sit'"; 
		}
		if(strlen($codigo)>0) { 
			  $sql.= " AND alu_codigo_interno = '$codigo'"; 
		}
		$sql.= " ORDER BY alu_fecha_nacimiento ASC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}

	
	function get_alumno_codigo_interno($codigo){
		$codigo = str_replace('-','',$codigo);
		$division = $this->division;
		$grupo = $this->grupo;
		$periodo = $this->periodo;
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT stat_contrato FROM inscripcion_status WHERE stat_alumno = alu_cui_new ORDER BY stat_contrato DESC LIMIT 0 , 1) as alu_contrato,"; //trae el ultimo contrato activo (si tiene))
		$sql.= " (SELECT stat_situacion FROM inscripcion_status WHERE stat_alumno = alu_cui_new ORDER BY stat_contrato DESC LIMIT 0 , 1) as alu_contrato_situacion,"; //trae la situacion del ultimo contrato activo (si tiene))
		$sql.= " (SELECT bol_codigo FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_inscripcion,"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT bol_referencia FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_numero_boleta_inscripcion,"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT bol_situacion FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_situacion,"; //trae la situacion de la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,inscripcion_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui_new ORDER BY pad_cui LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_telefono) FROM app_padres,inscripcion_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui_new ORDER BY pad_cui LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,inscripcion_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui_new ORDER BY pad_cui LIMIT 0 , 1) as alu_mail";
		$sql.= " FROM inscripcion_alumnos";
		$sql.= " WHERE REPLACE(alu_codigo_interno,'-','') = '$codigo'";
		$sql.= " ORDER BY alu_fecha_nacimiento DESC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function insert_alumno($cuinew,$cuiold,$tipocui,$codigo,$nom,$ape,$fecnac,$nacionalidad,$religion,$idioma,$genero,$sangre,$alergico,$emergencia,$emergencia_tel,$mail){
		$nom = trim($nom);
		$ape = trim($ape);
		$nacionalidad = trim($nacionalidad);
		$religion = trim($religion);
		$idioma = trim($idioma);
		$mail = trim($mail);
		
		//--
		$fecnac = $this->regresa_fecha($fecnac);
		$freg = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		
		$sql = "INSERT INTO inscripcion_alumnos";
		$sql.= " VALUES ('$cuinew','$cuiold','$tipocui','$codigo','$nom','$ape','$fecnac','$nacionalidad','$religion','$idioma','$genero','$sangre','$alergico','$emergencia','$emergencia_tel','CF','Consumidor Final','Ciudad','$mail','$freg','$freg','$usu',1);";
		//echo $sql;
		return $sql;
	}
	
	
	function insert_alumno_existente($cui) {
		$fsis = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		/// Tabla Alumnos ////
		$sql = "INSERT INTO inscripcion_alumnos (alu_cui_new, alu_cui_old, alu_tipo_cui, alu_codigo_interno, alu_nombre, alu_apellido, alu_fecha_nacimiento, alu_nacionalidad, alu_religion, alu_idioma, alu_genero, alu_tipo_sangre, alu_alergico_a, alu_emergencia,";
		$sql.= " alu_emergencia_telefono, alu_nit, alu_cliente_nombre, alu_cliente_direccion, alu_mail, alu_fec_registro, alu_fecha_edit, alu_usuario_edit, alu_situacion)";
		$sql.= " SELECT alu_cui, alu_cui, alu_tipo_cui, alu_codigo_interno, alu_nombre, alu_apellido, alu_fecha_nacimiento, alu_nacionalidad, alu_religion, alu_idioma, alu_genero, alu_tipo_sangre, alu_alergico_a, alu_emergencia,";
		$sql.= " alu_emergencia_telefono, alu_nit, alu_cliente_nombre, alu_cliente_direccion, alu_mail, alu_fec_registro, '$fsis', $usu, 1 ";
		$sql.= " FROM app_alumnos";
		$sql.= " WHERE app_alumnos.alu_cui = '$cui'; ";
		
		///// Tabla Padre Alumnos ///////
		$sql.= "INSERT INTO inscripcion_padre_alumno (pa_padre, pa_alumno, pa_fec_registro)";
		$sql.= " SELECT pa_padre, pa_alumno, pa_fec_registro FROM app_padre_alumno";
		$sql.= " WHERE app_padre_alumno.pa_alumno = '$cui'";
		$sql.= " ON DUPLICATE KEY UPDATE inscripcion_padre_alumno.pa_fec_registro = app_padre_alumno.pa_fec_registro; ";
		
		///// Tabla Seguro ///////
		$sql.= "INSERT INTO inscripcion_seguro (seg_alumno, seg_tiene_seguro, seg_poliza, seg_aseguradora, seg_plan, seg_asegurado_principal, seg_instrucciones, seg_comentarios)";
		$sql.= " SELECT seg_alumno, seg_tiene_seguro, seg_poliza, seg_aseguradora, seg_plan, seg_asegurado_principal, seg_instrucciones, seg_comentarios";
		$sql.= " FROM app_seguro";
		$sql.= " WHERE app_seguro.seg_alumno = '$cui'";
		$sql.= " ON DUPLICATE KEY UPDATE inscripcion_seguro.seg_tiene_seguro = app_seguro.seg_tiene_seguro,";
		$sql.= " inscripcion_seguro.seg_poliza = app_seguro.seg_poliza,";
		$sql.= " inscripcion_seguro.seg_plan = app_seguro.seg_plan,";
		$sql.= " inscripcion_seguro.seg_asegurado_principal = app_seguro.seg_asegurado_principal,";
		$sql.= " inscripcion_seguro.seg_instrucciones = app_seguro.seg_instrucciones,";
		$sql.= " inscripcion_seguro.seg_comentarios = app_seguro.seg_comentarios; ";
		
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_alumno($cui,$tipocui,$codigo,$nom,$ape,$fecnac,$nacionalidad,$religion,$idioma,$genero,$sangre,$alergico,$emergencia,$emergencia_tel,$mail){
		$tipocui = trim($tipocui);
		$nom = trim($nom);
		$ape = trim($ape);
		$nacionalidad = trim($nacionalidad);
		$religion = trim($religion);
		$idioma = trim($idioma);
		$genero = trim($genero);
		$sangre = trim($sangre);
		$alergico = trim($alergico);
		$emergencia = trim($emergencia);
		$emergencia_tel = trim($emergencia_tel);
		$mail = trim($mail);
		//--
		$fecnac = $this->regresa_fecha($fecnac);
		$freg = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "UPDATE inscripcion_alumnos SET ";
		$sql.= "alu_tipo_cui = '$tipocui',"; 
		$sql.= "alu_codigo_interno = '$codigo',"; 
		$sql.= "alu_nombre = '$nom',"; 
		$sql.= "alu_apellido = '$ape',"; 
		$sql.= "alu_fecha_nacimiento = '$fecnac',";
		$sql.= "alu_nacionalidad = '$nacionalidad',";
		$sql.= "alu_religion = '$religion',";
		$sql.= "alu_idioma = '$idioma',";
		$sql.= "alu_genero = '$genero',";
		$sql.= "alu_tipo_sangre = '$sangre',"; 
		$sql.= "alu_alergico_a = '$alergico',"; 
		$sql.= "alu_emergencia = '$emergencia',"; 
		$sql.= "alu_emergencia_telefono = '$emergencia_tel',";
		$sql.= "alu_mail = '$mail',";
		$sql.= "alu_fecha_edit = '$freg',"; 
		$sql.= "alu_usuario_edit = '$usu'"; 
		
		$sql.= " WHERE alu_cui_new = '$cui'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function modifica_alumno_cliente($cui,$nit,$clinombre,$clidireccion){
		$cliente = trim($cliente);
		
		$sql = "UPDATE inscripcion_alumnos SET ";
		$sql.= "alu_nit = '$nit',"; 
		$sql.= "alu_cliente_nombre = '$clinombre',"; 
		$sql.= "alu_cliente_direccion = '$clidireccion'"; 
				
		$sql.= " WHERE alu_cui_new = '$cui'; "; 	
		
		return $sql;
	}
	
	
	function cambia_sit_alumno($cui,$sit){
		
		$sql = "UPDATE inscripcion_alumnos SET ";
		$sql.= "alu_situacion = $sit"; 
				
		$sql.= " WHERE alu_cui_new = '$cui'; "; 	
		
		return $sql;
	}
	
	
	function delete_alumno($cui){
		
		$sql = "DELETE FROM inscripcion_seguro ";
		$sql.= " WHERE seg_alumno = '$cui'; "; 	
		
		$sql = "DELETE FROM inscripcion_alumnos ";
		$sql.= " WHERE alu_cui_new = '$cui'; "; 	
		return $sql;
	}
	
	
//////////////////// Alumno - Padres //////////////////////////
	function asignacion_alumno_padre($padre,$alumno){
		///--
		$fec = date("Y-m-d H:i:s");
		$sql = "INSERT INTO inscripcion_padre_alumno";
		$sql.= " VALUES ('$padre','$alumno','$fec') ";
		$sql.= " ON DUPLICATE KEY UPDATE pa_fec_registro = '$fec'; ";
		//echo $sql;
		return $sql;
	}

	function desasignacion_alumno_padre($padre,$alumno){
	    $sql = "DELETE FROM inscripcion_padre_alumno";
		$sql.= " WHERE pa_padre = '$padre'";
		$sql.= " AND pa_alumno = '$alumno';";  	
		//echo $sql;
		return $sql;
	}
	
	function desasignacion_alumno_general($alumno){
	    $sql = "DELETE FROM inscripcion_padre_alumno";
		$sql.= " WHERE pa_alumno = '$alumno';";  	
		//echo $sql;
		return $sql;
	}
	
	function get_alumno_padre($padre,$alumno) {
		$division = $this->division;
		$grupo = $this->grupo;
		$periodo = $this->periodo;
		
		$sql= "SELECT *, ";
		$sql.= " (SELECT stat_contrato FROM inscripcion_status WHERE stat_alumno = pa_alumno ORDER BY stat_contrato DESC LIMIT 0 , 1) as alu_contrato,"; //trae el ultimo contrato activo (si tiene))
		$sql.= " (SELECT stat_situacion FROM inscripcion_status WHERE stat_alumno = pa_alumno ORDER BY stat_contrato DESC LIMIT 0 , 1) as alu_contrato_situacion,"; //trae la situacion del ultimo contrato activo (si tiene))
		$sql.= " (SELECT bol_codigo FROM boletas_boleta_cobro WHERE bol_alumno = pa_alumno AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_inscripcion,"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT bol_referencia FROM boletas_boleta_cobro WHERE bol_alumno = pa_alumno AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_numero_boleta_inscripcion,"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT bol_pagado FROM boletas_boleta_cobro WHERE bol_alumno = pa_alumno AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_situacion"; //trae la situacion de la ultima boleta de inscripción generada (si tiene))
		$sql.= " FROM inscripcion_padre_alumno,app_padres,inscripcion_alumnos";
		$sql.= " WHERE pa_padre = pad_cui";
		$sql.= " AND pa_alumno = alu_cui_new";
		if(strlen($padre)>0) { 
			  $sql.= " AND pa_padre = '$padre'";
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND pa_alumno = '$alumno'";
		}
		$sql.= " ORDER BY alu_fecha_nacimiento ASC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	 

//////////////////// Seguro //////////////////////////

	function get_seguro($cui){
		
	   $sql ="SELECT * ";
	   $sql.=" FROM inscripcion_seguro";
	   $sql.=" WHERE seg_alumno = '$cui'";
	   $sql.=" ORDER BY seg_alumno ASC";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
	
	
	function insert_seguro($cui,$sino,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios){
		//--
		$poliza = trim($poliza);
		$aseguradora = trim($aseguradora);
		$plan = trim($plan);
		$asegurado = trim($asegurado);
		$instrucciones = trim($instrucciones);
		$comentarios = trim($comentarios);
		//--
		
		$sql = "INSERT INTO inscripcion_seguro";
		$sql.= " VALUES ('$cui','$sino','$poliza','$aseguradora','$plan','$asegurado','$instrucciones','$comentarios');";
		//echo $sql;
		return $sql;
	}
	
	
	function update_seguro($cui,$sino,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios){
	    $poliza = trim($poliza);
		$aseguradora = trim($aseguradora);
		$plan = trim($plan);
		$asegurado = trim($asegurado);
		$instrucciones = trim($instrucciones);
		$comentarios = trim($comentarios);
		
	    $sql ="UPDATE inscripcion_seguro SET ";
	    $sql.="seg_tiene_seguro = '$sino',";
	    $sql.="seg_poliza = '$poliza',";
	    $sql.="seg_aseguradora = '$aseguradora',";
	    $sql.="seg_plan = '$plan',";
	    $sql.="seg_asegurado_principal = '$asegurado',";
	    $sql.="seg_instrucciones = '$instrucciones',";
	    $sql.="seg_comentarios = '$comentarios'";
	   
	    $sql.=" WHERE seg_alumno = '$cui';";
	   
		return $sql;
	}
	
	
	
//////////////////// STATUS //////////////////////////

	function get_status($alumno,$status = ''){
		$division = $this->division;
		$grupo = $this->grupo;
		$periodo = $this->periodo;
		
		$sql ="SELECT *, ";
		$sql.= "(SELECT bol_codigo FROM boletas_boleta_cobro WHERE bol_alumno = stat_alumno AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_inscripcion,"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= "(SELECT bol_referencia FROM boletas_boleta_cobro WHERE bol_alumno = stat_alumno AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_numero_boleta_inscripcion,"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= "(SELECT bol_situacion FROM boletas_boleta_cobro WHERE bol_alumno = stat_alumno AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_situacion,"; //trae la situacion de la ultima boleta de inscripción generada (si tiene))
		$sql.= "(SELECT bol_pagado FROM boletas_boleta_cobro WHERE bol_alumno = stat_alumno AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_pagado,"; //trae la situacion de la ultima boleta de inscripción generada (si tiene))
		$sql.= "(SELECT dm_desc FROM mast_mundep WHERE dm_codigo = stat_departamento) as contrato_departamento_desc, ";
		$sql.= "(SELECT dm_desc FROM mast_mundep WHERE dm_codigo = stat_municipio) as contrato_municipio_desc ";	
		$sql.=" FROM inscripcion_status, inscripcion_alumnos";
		$sql.=" WHERE alu_cui_new = stat_alumno";
		if(strlen($alumno)>0) { 
		   $sql.= " AND stat_alumno = '$alumno'";
		}
		if(strlen($status)>0) { 
		   $sql.= " AND stat_situacion IN($status)";
		}
		$sql.=" ORDER BY stat_situacion ASC, stat_alumno ASC";
		//echo $sql."<br><br>";
		$result = $this->exec_query($sql);
		return $result;
	}
	
	
	function get_status_grado_alumno($sit = '',$nivel = '',$grado = '',$alumno = ''){
		$division = $this->division;
		$grupo = $this->grupo;
		$periodo = $this->periodo;
		
		$sql= "SELECT *,";
		$sql.= " (SELECT bol_codigo FROM boletas_boleta_cobro WHERE bol_alumno = stat_alumno AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_inscripcion,"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT bol_referencia FROM boletas_boleta_cobro WHERE bol_alumno = stat_alumno AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_numero_boleta_inscripcion,"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT bol_situacion FROM boletas_boleta_cobro WHERE bol_alumno = stat_alumno AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_situacion,"; //trae la situacion de la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT bol_pagado FROM boletas_boleta_cobro WHERE bol_alumno = stat_alumno AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_boleta_pagado,"; //trae la situacion de la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT bol_monto FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_monto_boleta_inscripcion,"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= " (SELECT bol_descuento FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new AND bol_tipo = 'I' AND bol_periodo_fiscal = $periodo ORDER BY bol_codigo DESC LIMIT 0 , 1) as alu_descuento_boleta_inscripcion"; //trae la ultima boleta de inscripción generada (si tiene))
		$sql.= " FROM inscripcion_status, inscripcion_nivel, inscripcion_grado, inscripcion_grado_alumno, inscripcion_alumnos";
		$sql.= " WHERE stat_alumno = alu_cui_new";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND graa_nivel = gra_nivel";
		$sql.= " AND graa_grado = gra_codigo";
		$sql.= " AND graa_alumno = alu_cui_new";
		if(strlen($sit)>0) { 
			$sql.= " AND stat_situacion IN($sit)"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND graa_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND graa_grado = $grado"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND graa_alumno = '$alumno'"; 
		}
		$sql.= " ORDER BY stat_situacion ASC, graa_nivel ASC, gra_codigo ASC, alu_apellido ASC, alu_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_status_correccion(){
		
		$sql= "SELECT *, COUNT(comen_alumno) as comen_cantidad,";
		$sql.= " (SELECT comen_comentario FROM inscripcion_comentarios WHERE comen_alumno = stat_alumno ORDER BY comen_codigo DESC LIMIT 0,1) as comen_ultimo_comentario"; 
		$sql.= " FROM inscripcion_status, inscripcion_nivel, inscripcion_grado, inscripcion_grado_alumno, inscripcion_alumnos, inscripcion_comentarios"; 
		$sql.= " WHERE stat_alumno = alu_cui_new"; 
		$sql.= " AND comen_alumno = stat_alumno"; 
		$sql.= " AND niv_codigo = gra_nivel"; 
		$sql.= " AND graa_nivel = gra_nivel"; 
		$sql.= " AND graa_grado = gra_codigo"; 
		$sql.= " AND graa_alumno = alu_cui_new";
		$sql.= " AND stat_situacion = 1"; 
		$sql.= " GROUP BY comen_alumno"; 
		$sql.= " ORDER BY stat_situacion ASC, graa_nivel ASC, gra_codigo ASC, alu_apellido ASC, alu_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function insert_status($contrato,$alumno,$dpi,$tipodpi,$nombre,$apellido,$fecnac,$parentesco,$ecivil,$nacionalidad,$mail,$telcasa,$celular,$direccion,$departamento,$municipio,$trabajo,$teltrabajo,$profesion){
		//pasa a mayusculas
		$nombre = trim($nombre);
		$apellido = trim($apellido);
		$nacionalidad = trim($nacionalidad);
		$direccion = trim($direccion);
		$trabajo = trim($trabajo);
		$profesion = trim($profesion);
		//--
		$mail = strtolower($mail);
		//--------
		$fecnac = $this->regresa_fecha($fecnac);
		$freg = date("Y-m-d H:i:s");
		//--
		
		$sql = "INSERT INTO inscripcion_status";
		$sql.= " VALUES ('$contrato','$alumno','$dpi','$tipodpi','$nombre','$apellido','$fecnac','$parentesco','$ecivil','$nacionalidad','$mail','$telcasa','$celular','$direccion','$departamento','$municipio','$trabajo','$teltrabajo','$profesion','$freg',1);";
		//echo $sql;
		return $sql;
	}
	
	
	function update_status($contrato,$alumno,$dpi,$tipodpi,$nombre,$apellido,$fecnac,$parentesco,$ecivil,$nacionalidad,$mail,$telcasa,$celular,$direccion,$departamento,$municipio,$trabajo,$teltrabajo,$profesion){
	      //pasa a mayusculas
		$nombre = trim($nombre);
		$apellido = trim($apellido);
		$nacionalidad = trim($nacionalidad);
		$direccion = trim($direccion);
		$trabajo = trim($trabajo);
		$profesion = trim($profesion);
		//--
		$mail = strtolower($mail);
		//--------
		$fecnac = $this->regresa_fecha($fecnac);
		$freg = date("Y-m-d H:i:s");
		
		$sql ="UPDATE inscripcion_status SET ";
		$sql.="stat_alumno = '$alumno',";
		$sql.="stat_dpi_firmante = '$dpi',";
		$sql.="stat_tipo_dpi = '$tipodpi',"; 
		$sql.="stat_nombre = '$nombre',"; 
		$sql.="stat_apellido = '$apellido',"; 
		$sql.="stat_fec_nac = '$fecnac',"; 		
		$sql.="stat_parentesco = '$parentesco',"; 		
		$sql.="stat_estado_civil = '$ecivil',"; 		
		$sql.="stat_nacionalidad = '$nacionalidad',"; 		
		$sql.="stat_mail = '$mail',";
		$sql.="stat_telefono = '$telcasa',"; 		
		$sql.="stat_celular = '$celular',"; 		
		$sql.="stat_direccion = '$direccion',";
		$sql.="stat_departamento = '$departamento',";
		$sql.="stat_municipio = '$municipio',";
		$sql.="stat_lugar_trabajo = '$trabajo',";
		$sql.="stat_telefono_trabajo = '$teltrabajo',";
		$sql.="stat_profesion = '$profesion',";
		$sql.="stat_fechor_registro = '$freg'";
	     
		$sql.=" WHERE stat_contrato = '$contrato';";
	   
		return $sql;
	}
	
	
	function cambia_sit_status($contrato,$sit){
		
		$sql = "UPDATE inscripcion_status SET ";
		$sql.= "stat_situacion = $sit"; 
				
		$sql.= " WHERE stat_contrato = '$contrato';"; 	
		
		return $sql;
	}
	
	function delete_status($alumno){
		
		$sql = "DELETE FROM inscripcion_status ";
		$sql.= " WHERE stat_alumno = '$alumno';"; 	
		
		return $sql;
	}
	
	
	function max_status(){
		
		$sql = "SELECT max(stat_contrato) as max ";
		$sql.= " FROM inscripcion_status";
		$sql.= " WHERE 1 = 1"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
//---------- GRADO - ALUMNO ---------//


	function get_nivel($cod = '',$sit = ''){
		
		$sql= "SELECT * ";
		$sql.= " FROM inscripcion_nivel";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND niv_codigo = $cod"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND niv_situacion = $sit"; 
		}
		$sql.= " ORDER BY niv_codigo ASC, niv_situacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
    
    function get_grado($nivel,$cod = '',$sit = ''){
		
		$sql= "SELECT * ";
		$sql.= " FROM inscripcion_grado, inscripcion_nivel";
		$sql.= " WHERE niv_codigo = gra_nivel";
		if(strlen($nivel)>0) { 
			  $sql.= " AND gra_nivel = $nivel"; 
		}
		if(strlen($cod)>0) { 
			  $sql.= " AND gra_codigo = $cod"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND gra_situacion = $sit"; 
		}
		$sql.= " ORDER BY niv_codigo ASC, gra_codigo ASC, gra_situacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}

	function get_grado_alumno($nivel,$grado = '',$alumno = '',$sit = ''){
		$tipo = trim($tipo);
		
		$sql= "SELECT * ";
		$sql.= " FROM inscripcion_nivel, inscripcion_grado, inscripcion_grado_alumno, inscripcion_alumnos";
		$sql.= " WHERE niv_codigo = gra_nivel";
		$sql.= " AND graa_nivel = gra_nivel";
		$sql.= " AND graa_grado = gra_codigo";
		$sql.= " AND graa_alumno = alu_cui_new";
		$sql.= " AND alu_situacion = 1"; 
		if(strlen($nivel)>0) { 
			  $sql.= " AND graa_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND graa_grado = $grado"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND graa_alumno = '$alumno'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = $sit"; 
		}
		$sql.= " ORDER BY graa_nivel ASC, gra_codigo ASC, alu_apellido ASC, alu_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
		
	function insert_grado_alumno($nivel,$grado,$alumno){
		
        $sql = "INSERT INTO inscripcion_grado_alumno ";
		$sql.= " VALUES ($nivel,$grado,'$alumno',1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_grado_alumno($alumno){
		
		$sql = "DELETE FROM inscripcion_grado_alumno ";
		$sql.= " WHERE graa_alumno = '$alumno';";
		
		//echo $sql;
		return $sql;
	}

//////////////------------------- BOLETAS DE INSCRIPCION ----------------------//////////

	public function get_boleta_cobro($cod, $division = '', $grupo = '', $alumno = '', $referencia = '', $periodo = '', $empresa = '', $fini = '', $ffin = '', $sit = '', $orderby = '', $pagado = ''){

        $sql= "SELECT *, ";
        //-- subquery grado
        $sql.= " (SELECT TRIM(gra_descripcion) FROM inscripcion_grado, inscripcion_grado_alumno";
        $sql.= " WHERE graa_nivel = gra_nivel";
        $sql.= " AND graa_grado = gra_codigo";
        $sql.= " AND graa_alumno = bol_alumno ORDER BY graa_grado DESC LIMIT 0 , 1) AS alu_grado_descripcion";
        //--
        $sql.= " FROM  boletas_boleta_cobro, boletas_division, boletas_division_grupo, fin_moneda, inscripcion_alumnos";
        $sql.= " WHERE bol_division = div_codigo";
        $sql.= " AND bol_grupo = div_grupo";
        $sql.= " AND div_grupo = gru_codigo";
        $sql.= " AND div_moneda = mon_id";
        $sql.= " AND bol_alumno = alu_cui_new";
		//--INSCRIPCIONES--/
		$sql.= " AND bol_tipo = 'I'";
        if(strlen($cod)>0) {
            $sql.= " AND bol_codigo = $cod";
        }
        if(strlen($division)>0) {
            $sql.= " AND bol_division = $division";
        }
        if(strlen($grupo)>0) {
            $sql.= " AND bol_grupo = $grupo";
        }
        if(strlen($alumno)>0) {
            $sql.= " AND bol_alumno = '$alumno'";
        }
        if(strlen($referencia)>0) {
            $sql.= " AND bol_referencia = $referencia";
        }
        if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo";
        }
        if(strlen($empresa)>0) {
            $sql.= " AND cueb_sucursal = $empresa";
        }
        if($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND bol_fecha_registro BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'";
        }
        if(strlen($sit)>=0) {
            $sql.= " AND bol_situacion IN($sit)";
        }
        if(strlen($pagado)>=0) {
            $sql.= " AND bol_pagado  IN($pagado)";
        }
        if(strlen($orderby)>0) {
            switch ($orderby) {
                case 1: $sql.= " ORDER BY gru_codigo ASC, div_codigo ASC, bol_alumno ASC, bol_referencia ASC"; break;
                case 2: $sql.= " ORDER BY bol_fecha_pago ASC, gru_codigo ASC, div_codigo ASC, bol_alumno ASC, bol_referencia ASC"; break;
                default: $sql.= " ORDER BY gru_codigo ASC, div_codigo ASC, bol_alumno ASC, bol_referencia ASC"; break;
            }
        } else {
            $sql.= " ORDER BY gru_codigo ASC, div_codigo ASC, bol_alumno ASC, bol_referencia ASC";
        }
        $result = $this->exec_query($sql);
       //echo $sql;
        return $result;
    }
	
	public function get_cartera_inscripciones($division, $grupo, $tipo, $anio, $periodo, $mes, $pensum = '', $nivel = '', $grado = ''){
        $sql= "SELECT *,";
        ///---cargos----//
        if($mes == 1 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-01-01' AND '$anio-01-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 1";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_enero,";
        }
        if($mes == 2 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-02-01' AND '$anio-02-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 2";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_febrero,";
        }
        if($mes == 3 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-03-01' AND '$anio-03-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 3";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_marzo,";
        }
        if($mes == 4 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-04-01' AND '$anio-04-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 4";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_abril,";
        }
        if($mes == 5 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-05-01' AND '$anio-05-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 5";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_mayo,";
        }
        if($mes == 6 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-06-01' AND '$anio-06-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 6";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_junio,";
        }
        if($mes == 7 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-07-01' AND '$anio-07-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 7";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_julio,";
        }
        if($mes == 8 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-08-01' AND '$anio-08-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 8";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_agosto,";
        }
        if($mes == 9 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-09-01' AND '$anio-09-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 9";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_septiembre,";
        }
        if($mes == 10 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-10-01' AND '$anio-10-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 10";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_octubre,";
        }
        if($mes == 11 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-11-01' AND '$anio-11-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 11";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_noviembre,";
        }
        if($mes == 12 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-12-01' AND '$anio-12-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 12";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_diciembre,";
        }
        ///---descuentos---///
        if($mes == 1 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-01-01' AND '$anio-01-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 1";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_enero,";
        }
        if($mes == 2 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-02-01' AND '$anio-02-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 2";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_febrero,";
        }
        if($mes == 3 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-03-01' AND '$anio-03-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 3";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_marzo,";
        }
        if($mes == 4 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-04-01' AND '$anio-04-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 4";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_abril,";
        }
        if($mes == 5 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-05-01' AND '$anio-05-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 5";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_mayo,";
        }
        if($mes == 6 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-06-01' AND '$anio-06-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 6";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_junio,";
        }
        if($mes == 7 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-07-01' AND '$anio-07-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 7";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_julio,";
        }
        if($mes == 8 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-08-01' AND '$anio-08-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 8";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_agosto,";
        }
        if($mes == 9 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-09-01' AND '$anio-09-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 9";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_septiembre,";
        }
        if($mes == 10 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-10-01' AND '$anio-10-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 10";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_octubre,";
        }
        if($mes == 11 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-11-01' AND '$anio-11-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 11";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_noviembre,";
        }
        if($mes == 12 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-12-01' AND '$anio-12-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 12";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_diciembre,";
        }
        ///---pagos---///
        if($mes == 1 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-01-01 00:00:00' AND '$anio-01-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 1";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_enero,";
        }
        if($mes == 2 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-02-01 00:00:00' AND '$anio-02-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 2";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_febrero,";
        }
        if($mes == 3 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-03-01 00:00:00' AND '$anio-03-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 3";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_marzo,";
        }
        if($mes == 4 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-04-01 00:00:00' AND '$anio-04-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 4";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_abril,";
        }
        if($mes == 5 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-05-01 00:00:00' AND '$anio-05-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 5";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_mayo,";
        }
        if($mes == 6 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-06-01 00:00:00' AND '$anio-06-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 6";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_junio,";
        }
        if($mes == 7 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-07-01 00:00:00' AND '$anio-07-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 7";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_julio,";
        }
        if($mes == 8 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-08-01 00:00:00' AND '$anio-08-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 8";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_agosto,";
        }
        if($mes == 9 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-09-01 00:00:00' AND '$anio-09-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 9";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_septiembre,";
        }
        if($mes == 10 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-10-01 00:00:00' AND '$anio-10-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 10";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_octubre,";
        }
        if($mes == 11 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-11-01 00:00:00' AND '$anio-11-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 11";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_noviembre,";
        }
        if($mes == 12 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui_new";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-12-01 00:00:00' AND '$anio-12-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 12";
            }
            $sql.= " AND pag_cuenta = $division AND pag_banco = $grupo) as pagos_diciembre,";
        }
        //--
        $sql = substr($sql, 0, -1); //limpia la ultima coma de los subquerys
        //--
		$sql.= " FROM inscripcion_grado, inscripcion_grado_alumno, inscripcion_alumnos";
		$sql.= " WHERE graa_nivel = gra_nivel";
		$sql.= " AND graa_grado = gra_codigo";
		$sql.= " AND graa_alumno = alu_cui_new";
		$sql.= " AND alu_situacion != 0";
		$sql.= " AND alu_cui_new NOT IN(";
			$sql.= " SELECT alu_cui FROM app_alumnos, academ_grado_alumno";
			$sql.= " WHERE alu_cui = graa_alumno";
			$sql.= " AND graa_pensum = $pensum";
			if(strlen($nivel)>0) {
			$sql.= " AND graa_nivel = $nivel";
			}
			if(strlen($grado)>0) {
			$sql.= " AND graa_grado = $grado";
			}
			$sql.= " AND alu_situacion != 0)";
		if(strlen($nivel)>0) {
            $sql.= " AND graa_nivel = $nivel";
        }
        if(strlen($grado)>0) {
            $sql.= " AND graa_grado = $grado";
        }
        $sql.= " ORDER BY graa_nivel ASC, graa_grado ASC, gra_codigo ASC, alu_apellido ASC, alu_nombre ASC";

        $result = $this->exec_query($sql);
        //echo $sql."<br><br>";
        return $result;
    }
	
	
//---------- COMENTARIOS DE C ORRECCIONES DE CONTRATO ---------//

	function get_comentario($codigo,$alumno = '', $contrato = '', $sit = ''){
		
		$sql= "SELECT *,";
		$sql.= " (SELECT usu_nombre FROM seg_usuarios WHERE usu_id = comen_usuario_registro) as usu_nombre_registro";
		$sql.= " FROM inscripcion_status, inscripcion_alumnos, inscripcion_comentarios";
		$sql.= " WHERE comen_contrato = stat_contrato";
		$sql.= " AND comen_alumno = alu_cui_new";
		if(strlen($codigo)>0) { 
			$sql.= " AND comen_codigo = $codigo"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND comen_alumno = '$alumno'"; 
		}
		if(strlen($contrato)>0) { 
			$sql.= " AND comen_contrato = $contrato"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND comen_situacion = $sit"; 
		}
		$sql.= " ORDER BY comen_fechor_registro DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;

	}
	
		
	function insert_comentario($codigo,$contrato,$alumno,$comentario){
		$comentario = trim($comentario);
		//--
		$usu = $_SESSION["codigo"];
		$fsis = date("Y-m-d H:m:s");
		
		$sql = "INSERT INTO inscripcion_comentarios ";
		$sql.= " VALUES ('$codigo','$contrato','$alumno','$comentario',$usu,'$fsis',1); ";
		//echo $sql;
		return $sql;
	}	
	
		
	function update_comentario($codigo,$contrato,$alumno,$comentario){
		$comentario = trim($comentario);
		//--
		$usu = $_SESSION["codigo"];
		$fsis = date("Y-m-d H:m:s");
		
		$sql = "UPDATE inscripcion_comentarios SET";
		$sql.= " comen_comentario = '$comentario',";
		$sql.= " comen_usuario_registro = $usu,";
		$sql.= " comen_fechor_registro = '$fsis'"; 
				
		$sql.= " WHERE comen_codigo = $codigo"; 	
		$sql.= " AND comen_contrato = '$contrato'"; 	
		$sql.= " AND comen_alumno = '$alumno';"; 	
		
		return $sql;
	}
	
    
	function cambia_situacion_comentario($codigo,$contrato,$alumno,$sit){
		
		$sql = "UPDATE inscripcion_comentarios SET ";
		$sql.= "comen_situacion = $sit"; 
				
		$sql.= " WHERE comen_codigo = $codigo"; 	
		$sql.= " AND comen_contrato = '$contrato'"; 	
		$sql.= " AND comen_alumno = '$alumno';";
		
		return $sql;
	}
	
    
	function max_comentario($contrato,$alumno){
		
        $sql = "SELECT max(comen_codigo) as max ";
		$sql.= " FROM inscripcion_comentarios";
		$sql.= " WHERE comen_contrato = '$contrato'"; 	
		$sql.= " AND comen_alumno = '$alumno';";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
//////////////////// CAMBO DE CUI //////////////////////////
	
	function cambia_CUI($cui,$cuinew){
		
		$sql = "UPDATE inscripcion_alumnos SET alu_cui_new = '$cuinew'"; 
		$sql.= " WHERE alu_cui_new = '$cui';";
		$sql.= "UPDATE inscripcion_padre_alumno SET pa_alumno = '$cuinew'"; 
		$sql.= " WHERE pa_alumno = '$cui';";
		$sql.= "UPDATE inscripcion_grado_alumno SET graa_alumno = '$cuinew'"; 
		$sql.= " WHERE graa_alumno = '$cui';";
		$sql.= "UPDATE inscripcion_seguro SET seg_alumno = '$cuinew'"; 
		$sql.= " WHERE seg_alumno = '$cui';";
		$sql.= "UPDATE inscripcion_status SET stat_alumno = '$cuinew'"; 
		$sql.= " WHERE stat_alumno = '$cui';";
		$sql.= "UPDATE inscripcion_comentarios SET comen_alumno = '$cuinew'"; 
		$sql.= " WHERE comen_alumno = '$cui';";
		$sql.= "UPDATE boletas_boleta_cobro SET bol_alumno = '$cuinew'"; 
		$sql.= " WHERE bol_alumno = '$cui'";
		$sql.= " AND bol_tipo = 'I';";
		
		return $sql;
	}
	
//////////////////// BOQUEOS //////////////////////////

	function get_bloqueados(){
		
		$sql= "SELECT *";
		$sql.= " FROM inscripcion_bloqueo";
		$sql.= " WHERE 1 = 1";
		$sql.= " ORDER BY blo_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function delete_bloaqueados($cui){
		
		$sql = "DELETE FROM inscripcion_bloqueo ";
		$sql.= " WHERE blo_cui = '$cui';"; 	
		
		return $sql;
	}
	
	
	function insert_bitacora_bloaqueados($cui){
		$usu = $_SESSION["codigo"];
		$fsis = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO inscripcion_bitacora_bloqueo (bit_cui,bit_codigo_interno,bit_nombre,bit_grado,bit_observaciones,bit_usuario,bit_fecha_hora)";
		$sql.= " SELECT blo_cui,blo_codigo_interno,blo_nombre,blo_grado,blo_observaciones, $usu, '$fsis'";
		$sql.= " FROM inscripcion_bloqueo";
		$sql.= " WHERE blo_cui = '$cui'; ";
	
		return $sql;
	}
	
	function base_inscripciones(){
		
        $sql = "SELECT *";
		$sql.= " FROM inscripcion_datos_base";
		$sql.= " WHERE 1 = 1;";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$this->division = $row["base_cuenta"];
				$this->grupo = $row["base_banco"];
				$this->anio = $row["base_anio"];
				$this->periodo = $row["base_periodo_fiscal"];
				$this->activo = $row["base_activo"];
			}
			//echo $sql;
		}
		return;
	}
}	
?>
