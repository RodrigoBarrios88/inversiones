<?php
require_once ("ClsConex.php");

class ClsAlumno extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
	
	function __construct(){
		$this->anio = date("Y");
        if($_SESSION["pensum"] == "") {
            require_once("ClsPensum.php");
            $ClsPen = new ClsPensum();
            $this->pensum = $ClsPen->get_pensum_activo();
        }else{
            $this->pensum = $_SESSION["pensum"];
        }
	}	
   
    function get_alumno($cui,$nom = '',$ape = '',$sit = '',$codigo = '') {
		$cui = trim($cui);
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = alu_cui) as alu_foto,";
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_telefono) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_mail_padre";
		$sql.= " FROM app_alumnos";
		$sql.= " WHERE 1 = 1";
		if(strlen($cui)>0) { 
			  $sql.= " AND alu_cui = '$cui'"; 
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
		$sql.= " ORDER BY alu_fecha_nacimiento DESC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_alumno($cui,$nom = '',$ape = '',$sit = '',$codigo = '') {
		$cui = trim($cui);
		$nom = trim($nom);
		$ape = trim($ape);
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_alumnos";
		$sql.= " WHERE 1 = 1";
		if(strlen($cui)>0) { 
			  $sql.= " AND alu_cui = '$cui'"; 
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
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function get_alumno_grados_secciones($cui,$nom = '',$ape = '',$sit = '',$codigo = '') {
		$cui = trim($cui);
		$pensum = $this->pensum;
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno WHERE graa_pensum = gra_pensum AND graa_nivel = gra_nivel AND graa_grado = gra_codigo AND graa_alumno = alu_cui AND graa_pensum = $pensum ORDER BY graa_grado LIMIT 0 , 1) as alu_grado,";
		$sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno WHERE seca_pensum = sec_pensum AND seca_nivel = sec_nivel AND seca_grado = sec_grado AND seca_seccion = sec_codigo AND seca_alumno = alu_cui AND seca_pensum = $pensum ORDER BY seca_seccion LIMIT 0 , 1) as alu_seccion ";
		$sql.= " FROM app_alumnos";
		$sql.= " WHERE 1 = 1";
		if(strlen($cui)>0) { 
			  $sql.= " AND alu_cui = '$cui'"; 
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
		$sql.= " ORDER BY alu_fecha_nacimiento DESC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_alumno_codigo_interno($codigo){
		$codigo = str_replace('-','',$codigo);
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_telefono) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_mail";
		$sql.= " FROM app_alumnos";
		$sql.= " WHERE REPLACE(alu_codigo_interno,'-','') = '$codigo'";
		$sql.= " ORDER BY alu_fecha_nacimiento DESC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_alumno_reportes($cui,$tipocui = '',$codigo = '',$nom = '',$ape = '',$pensum = '', $nivel = '', $grado = '', $seccion = '',$sit = '') {
		$cui = trim($cui);
		
	    $sql= "SELECT *";
		$sql.= " FROM app_alumnos";
		$sql.= " LEFT JOIN vista_padre ON alu_cui = padre_alumno";
		$sql.= " LEFT JOIN vista_madre ON alu_cui = madre_alumno";
		$sql.= " LEFT JOIN vista_encargado_unique ON alu_cui = encargado_alumno";
		$sql.= " LEFT JOIN vista_grado ON alu_cui = vgra_alumno";
		$sql.= " LEFT JOIN vista_seccion ON alu_cui = vsec_alumno";
		$sql.= " INNER JOIN app_seguro ON alu_cui = seg_alumno";
		$sql.= " WHERE 1 = 1";
		if(strlen($cui)>0) { 
			$sql.= " AND alu_cui = '$cui'"; 
		}
		if(strlen($tipocui)>0) { 
			$sql.= " AND alu_tipo_cui = '$tipocui'"; 
		}
		if(strlen($codigo)>0) { 
			$sql.= " AND alu_codigo_interno = '$codigo'"; 
		}
		if(strlen($nom)>0) { 
			$sql.= " AND UPPER(alu_nombre) like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			$sql.= " AND UPPER(alu_apellido) like '%$ape%'"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND vgra_pensum = $pensum"; 
			$sql.= " AND vsec_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND vgra_nivel = $nivel";
			$sql.= " AND vsec_nivel = $nivel";
		}
		if(strlen($grado)>0) { 
			$sql.= " AND vgra_grado = $grado"; 
			$sql.= " AND vsec_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND vsec_seccion = '$seccion'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND alu_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY alu_fecha_nacimiento DESC, alu_apellido ASC, alu_nombre ASC, vgra_pensum ASC, vgra_nivel ASC, vgra_grado ASC, vsec_seccion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function insert_alumno($cui,$codigo,$nom,$ape,$fecnac,$nacionalidad,$genero,$nit,$clinombre,$clidireccion,$mail){
		$nom = trim($nom);
		$ape = trim($ape);
		//--
		$fecnac = $this->regresa_fecha($fecnac);
		$freg = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		$usu = ($usu == "")?1:$usu;
		$id_mineduc = "";
		$religion = "";
		$idioma = "Español";
		//--
		
		$sql = "INSERT INTO app_alumnos";
		$sql.= " VALUES ('$cui','CUI','$codigo','$id_mineduc','$nom','$ape','$fecnac','$nacionalidad','$religion','$idioma','$genero','','','','','$nit','$clinombre','$clidireccion','$mail','','','$freg','$freg',$usu,0,1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_alumno($cui,$tipocui,$codigo,$nombre,$apellido,$fecnac,$nacionalidad,$religion,$idioma,$genero,$sangre,$alergico,$emergencia,$emergencia_tel,$mail,$recoge,$redesociales){
		$tipocui = trim($tipocui);
		$codigo = trim($codigo);
		//--
		$nombre = trim($nombre);
		$apellido = trim($apellido);
		$genero = trim($genero);
		$sangre = trim($sangre);
		$alergico = trim($alergico);
		$emergencia = trim($emergencia);
		$emergencia_tel = trim($emergencia_tel);
		//--
		$fecnac = $this->regresa_fecha($fecnac);
		$freg = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "UPDATE app_alumnos SET ";
		if(strlen($tipocui)>0) { 
			$sql.= "alu_tipo_cui = '$tipocui',";
		}
		if(strlen($codigo)>0) { 
			$sql.= "alu_codigo_interno = '$codigo',";
		}
		$sql.= "alu_nombre = '$nombre',"; 
		$sql.= "alu_apellido = '$apellido',"; 
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
		$sql.= "alu_recoge = '$recoge',"; 
		$sql.= "alu_redes_sociales = '$redesociales',"; 
		$sql.= "alu_fecha_edit = '$freg',"; 
		$sql.= "alu_usuario_edit = '$usu'"; 
		
		$sql.= " WHERE alu_cui = '$cui'; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_codigo_mineduc($cui,$codigo_mineduc){
		
		$sql = "UPDATE app_alumnos SET";
		$sql.= " alu_codigo_mineduc = '$codigo_mineduc'"; 
		$sql.= " WHERE alu_cui = '$cui'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function modificar_cliente($cui,$nit,$clinombre,$clidireccion){
		$cliente = trim($cliente);
		
		$sql = "UPDATE app_alumnos SET ";
		$sql.= "alu_nit = '$nit',"; 
		$sql.= "alu_cliente_nombre = '$clinombre',"; 
		$sql.= "alu_cliente_direccion = '$clidireccion'"; 
				
		$sql.= " WHERE alu_cui = '$cui'; "; 	
		
		return $sql;
	}
	
	
	function modificar_mail($cui,$mail){
		$mail = strtolower($mail);
		
		$sql = "UPDATE app_alumnos SET ";
		$sql.= "alu_mail = '$mail'"; 
				
		$sql.= " WHERE alu_cui = '$cui'; "; 	
		
		return $sql;
	}
	
	
	function modificar_campo($usuario,$campo,$valor,$cui){
		$valor = trim($valor);
		$fedit = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_alumnos SET ";
		$sql.= "$campo = '$valor',"; 
		$sql.= "alu_usuario_edit = '$usuario',"; 
		$sql.= "alu_fecha_edit = '$fedit'";
		
		$sql.= " WHERE alu_cui = '$cui'; "; 	
		
		return $sql;
	}
	
	
	function cambia_sit_alumno($cui,$sit){
		
		$sql = "UPDATE app_alumnos SET ";
		$sql.= "alu_situacion = $sit"; 
				
		$sql.= " WHERE alu_cui = '$cui'"; 	
		
		return $sql;
	}
	
	
	function cambia_foto($cui,$string){
		$freg = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		
		$sql.= "INSERT INTO app_foto_alumno (fot_cui, fot_string , fot_fecha_registro, fot_usuario_registro)";
		$sql.= " VALUES('$cui','$string','$freg','$usu')";
		$sql.= " ON DUPLICATE KEY UPDATE";
		$sql.= " fot_string = '$string',";
		$sql.= " fot_fecha_registro = '$freg',";
		$sql.= " fot_usuario_registro = '$usu';";
		
		return $sql;
	}
	
	
	function max_alumno(){
	    $sql = "SELECT max(alu_cui) as max ";
		$sql.= " FROM app_alumnos";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	function last_foto_alumno($cui){
	      $sql = "SELECT fot_string as last ";
		$sql.= " FROM app_foto_alumno";
		$sql.= " WHERE fot_cui = '$cui'"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$last = $row["last"];
		}
		//echo $sql;
		return $last;
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////// Importacion de Tabla Temporal de Alumnos en Inscripciones ////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////

	function get_alumno_pensum($pensum,$alumno){
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_grado_alumno";
		$sql.= " WHERE graa_pensum = $pensum"; 
		$sql.= " AND graa_alumno = '$alumno'"; 
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}


	function update_inscripcion_alumno_existente($cui) {
		/// Tabla Alumnos ////
		$sql = "UPDATE app_alumnos INNER JOIN inscripcion_alumnos";
		$sql.= " ON app_alumnos.alu_cui = inscripcion_alumnos.alu_cui_new";
		$sql.= " SET app_alumnos.alu_tipo_cui = inscripcion_alumnos.alu_tipo_cui,";
		$sql.= "app_alumnos.alu_nombre = inscripcion_alumnos.alu_nombre,";
		$sql.= "app_alumnos.alu_apellido = inscripcion_alumnos.alu_apellido,";
		$sql.= "app_alumnos.alu_fecha_nacimiento = inscripcion_alumnos.alu_fecha_nacimiento,";
		$sql.= "app_alumnos.alu_genero = inscripcion_alumnos.alu_genero,";
		$sql.= "app_alumnos.alu_tipo_sangre = inscripcion_alumnos.alu_tipo_sangre,";
		$sql.= "app_alumnos.alu_alergico_a = inscripcion_alumnos.alu_alergico_a,";
		$sql.= "app_alumnos.alu_emergencia = inscripcion_alumnos.alu_emergencia,";
		$sql.= "app_alumnos.alu_emergencia_telefono = inscripcion_alumnos.alu_emergencia_telefono,";
		$sql.= "app_alumnos.alu_nit = inscripcion_alumnos.alu_nit,";
		$sql.= "app_alumnos.alu_cliente_nombre = inscripcion_alumnos.alu_cliente_nombre,";
		$sql.= "app_alumnos.alu_cliente_direccion = inscripcion_alumnos.alu_cliente_direccion,";
		$sql.= "app_alumnos.alu_fecha_edit = inscripcion_alumnos.alu_fecha_edit";
		$sql.= " WHERE app_alumnos.alu_cui = '$cui'; ";
		
		///// Tabla Padre Alumnos ///////
		$sql.= "INSERT INTO app_padre_alumno (pa_padre, pa_alumno, pa_fec_registro)";
		$sql.= " SELECT pa_padre, pa_alumno, pa_fec_registro FROM inscripcion_padre_alumno";
		$sql.= " WHERE inscripcion_padre_alumno.pa_alumno = '$cui'";
		$sql.= " ON DUPLICATE KEY UPDATE app_padre_alumno.pa_fec_registro = inscripcion_padre_alumno.pa_fec_registro; ";
		
		///// Tabla Seguro ///////
		$sql.= "INSERT INTO app_seguro (seg_alumno, seg_tiene_seguro, seg_poliza, seg_aseguradora, seg_plan, seg_asegurado_principal, seg_instrucciones, seg_comentarios)";
		$sql.= " SELECT seg_alumno, seg_tiene_seguro, seg_poliza, seg_aseguradora, seg_plan, seg_asegurado_principal, seg_instrucciones, seg_comentarios";
		$sql.= " FROM inscripcion_seguro";
		$sql.= " WHERE inscripcion_seguro.seg_alumno = '$cui'";
		$sql.= " ON DUPLICATE KEY UPDATE app_seguro.seg_tiene_seguro = inscripcion_seguro.seg_tiene_seguro,";
		$sql.= " app_seguro.seg_poliza = inscripcion_seguro.seg_poliza,";
		$sql.= " app_seguro.seg_plan = inscripcion_seguro.seg_plan,";
		$sql.= " app_seguro.seg_asegurado_principal = inscripcion_seguro.seg_asegurado_principal,";
		$sql.= " app_seguro.seg_instrucciones = inscripcion_seguro.seg_instrucciones,";
		$sql.= " app_seguro.seg_comentarios = inscripcion_seguro.seg_comentarios; ";
		
		//echo $sql;
		return $sql;
	}
	
	
	function update_cui_alumno_todo($cuinew,$cuiold) {
		
		$sql = "UPDATE app_alumnos SET alu_cui = '$cuinew' WHERE alu_cui = '$cuiold';";
		$sql.= "UPDATE academ_grado_alumno SET graa_alumno = '$cuinew' WHERE graa_alumno = '$cuiold';";
		$sql.= "UPDATE academ_nomina_detalle SET det_alumno = '$cuinew' WHERE det_alumno = '$cuiold';";
		$sql.= "UPDATE academ_nomina_detalle_notas SET not_alumno = '$cuinew' WHERE not_alumno = '$cuiold';";
		$sql.= "UPDATE academ_nomina_recuperacion_detalle SET det_alumno = '$cuinew' WHERE det_alumno = '$cuiold';";
		$sql.= "UPDATE academ_nomina_recuperacion_detalle_notas SET not_alumno = '$cuinew' WHERE not_alumno = '$cuiold';";
		$sql.= "UPDATE academ_notas SET not_alumno = '$cuinew' WHERE not_alumno = '$cuiold';";
		$sql.= "UPDATE academ_notas_recuperacion SET not_alumno = '$cuinew' WHERE not_alumno = '$cuiold';";
		$sql.= "UPDATE academ_psicopedagogica SET psi_alumno = '$cuinew' WHERE psi_alumno = '$cuiold';";
		$sql.= "UPDATE academ_seccion_alumno SET seca_alumno = '$cuinew' WHERE seca_alumno = '$cuiold';";
		//--
		$sql.= "UPDATE app_asistencia SET asi_alumno = '$cuinew' WHERE asi_alumno = '$cuiold';";
		$sql.= "UPDATE app_grupo_alumno SET ag_alumno = '$cuinew' WHERE ag_alumno = '$cuiold';";
		$sql.= "UPDATE app_padre_alumno SET pa_alumno = '$cuinew' WHERE pa_alumno = '$cuiold';";
		$sql.= "UPDATE app_seguro SET seg_alumno = '$cuinew' WHERE seg_alumno = '$cuiold';";
		//--
		$sql.= "UPDATE app_postit SET post_target = '$cuinew' WHERE post_target = '$cuiold';";
		$sql.= "UPDATE app_golpe SET gol_alumno = '$cuinew' WHERE gol_alumno = '$cuiold';";
		$sql.= "UPDATE app_enfermedad SET enf_alumno = '$cuinew' WHERE enf_alumno = '$cuiold';";
		$sql.= "UPDATE app_panial SET pan_alumno = '$cuinew' WHERE pan_alumno = '$cuiold';";
		$sql.= "UPDATE app_conducta SET con_alumno = '$cuinew' WHERE con_alumno = '$cuiold';";
		$sql.= "UPDATE app_foto_alumno SET fot_cui = '$cuinew' WHERE fot_cui = '$cuiold';";
		//--
		$sql.= "UPDATE boletas_boleta_cobro SET bol_alumno = '$cuinew' WHERE bol_alumno = '$cuiold';";
		$sql.= "UPDATE boletas_factura_boleta SET fac_alumno = '$cuinew' WHERE fac_alumno = '$cuiold';";
		$sql.= "UPDATE boletas_pago_boleta SET pag_alumno = '$cuinew' WHERE pag_alumno = '$cuiold';";
		$sql.= "UPDATE boletas_recibo_boleta SET rec_alumno = '$cuinew' WHERE rec_alumno = '$cuiold';";
		
		//echo $sql;
		return $sql;

	}
	
	
	
	function insert_inscripcion_nuevo_alumno($cui) {
		$fsis = date("Y-m-d H:i:s");
		/// Tabla Alumnos ////
		$sql = "INSERT INTO app_alumnos (alu_cui, alu_tipo_cui, alu_codigo_interno, alu_codigo_mineduc, alu_nombre, alu_apellido, alu_fecha_nacimiento, alu_nacionalidad, alu_religion, alu_idioma, alu_genero, alu_tipo_sangre, alu_alergico_a, alu_emergencia, alu_emergencia_telefono, alu_nit, alu_cliente_nombre, alu_cliente_direccion, alu_mail, alu_recoge, alu_redes_sociales,  alu_fec_registro, alu_fecha_edit, alu_usuario_edit, alu_situacion)";      
		$sql.= " SELECT alu_cui_new, alu_tipo_cui, alu_codigo_interno, '', alu_nombre, alu_apellido, alu_fecha_nacimiento, alu_nacionalidad, alu_religion, alu_idioma, alu_genero, alu_tipo_sangre, alu_alergico_a, alu_emergencia, alu_emergencia_telefono, alu_nit, alu_cliente_nombre, alu_cliente_direccion, alu_mail, '', '', alu_fec_registro, alu_fecha_edit, alu_usuario_edit, alu_situacion ";
		$sql.= " FROM inscripcion_alumnos";
		$sql.= " WHERE inscripcion_alumnos.alu_cui_new = '$cui'; ";
		
		///// Tabla Padre Alumnos ///////
		$sql.= "INSERT INTO app_padre_alumno (pa_padre, pa_alumno, pa_fec_registro)";
		$sql.= " SELECT pa_padre, pa_alumno, pa_fec_registro FROM inscripcion_padre_alumno";
		$sql.= " WHERE inscripcion_padre_alumno.pa_alumno = '$cui'";
		$sql.= " ON DUPLICATE KEY UPDATE app_padre_alumno.pa_fec_registro = inscripcion_padre_alumno.pa_fec_registro; ";
		
		///// Tabla Seguro ///////
		$sql.= "INSERT INTO app_seguro (seg_alumno, seg_tiene_seguro, seg_poliza, seg_aseguradora, seg_plan, seg_asegurado_principal, seg_instrucciones, seg_comentarios)";
		$sql.= " SELECT seg_alumno, seg_tiene_seguro, seg_poliza, seg_aseguradora, seg_plan, seg_asegurado_principal, seg_instrucciones, seg_comentarios";
		$sql.= " FROM inscripcion_seguro";
		$sql.= " WHERE inscripcion_seguro.seg_alumno = '$cui'";
		$sql.= " ON DUPLICATE KEY UPDATE app_seguro.seg_tiene_seguro = inscripcion_seguro.seg_tiene_seguro,";
		$sql.= " app_seguro.seg_poliza = inscripcion_seguro.seg_poliza,";
		$sql.= " app_seguro.seg_plan = inscripcion_seguro.seg_plan,";
		$sql.= " app_seguro.seg_asegurado_principal = inscripcion_seguro.seg_asegurado_principal,";
		$sql.= " app_seguro.seg_instrucciones = inscripcion_seguro.seg_instrucciones,";
		$sql.= " app_seguro.seg_comentarios = inscripcion_seguro.seg_comentarios; ";
		
		//echo $sql;
		return $sql;

	}
	

	
}	
?>