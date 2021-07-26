<?php
require_once ("ClsConex.php");

class ClsFicha extends ClsConex{
   
////////  INFORMACION DE COLEGIOS ////////////////////////
	function get_info_colegio($cui){
		$sql ="SELECT *";
		$sql.=" FROM prepri_colegio";
		$sql.=" WHERE col_cui = '$cui'";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	function insert_info_colegio($cui,$edad,$adaptado,$repitente,$repite_grado,$otros_col,$retirado_por,$porque_este,$hermanos_aqui,$estudiaron_aqui,$hermanos,$lugar_hermanos,$vive_con) {
		$fsis = date("Y-m-d H:i:s");
		$sql = "INSERT INTO prepri_colegio VALUES ('$cui','$edad','$adaptado','$repitente','$repite_grado','$otros_col','$retirado_por','$porque_este','$hermanos_aqui','$estudiaron_aqui','$hermanos','$lugar_hermanos','$vive_con','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "col_edad_colegio = '$edad',"; 
		$sql.= "col_adaptado = '$adaptado',"; 
		$sql.= "col_repitente = '$repitente',";
		$sql.= "col_repite_grado = '$repite_grado',"; 
		$sql.= "col_colegios_anteriores = '$otros_col',"; 
		$sql.= "col_retirado_por = '$retirado_por',"; 
		$sql.= "col_porque_este = '$porque_este',"; 
		$sql.= "col_hermanos_aqui = '$hermanos_aqui',";
		$sql.= "col_estudiaron_aqui = '$estudiaron_aqui',"; 
		$sql.= "col_hermanos  = '$hermanos',"; 
		$sql.= "col_lugar_hermanos = '$lugar_hermanos',"; 
		$sql.= "col_vive_con = '$vive_con', ";
		$sql.= "col_fecha_actualiza = '$fsis'; ";
		
		return $sql;
	}
	
//////////////  EMBARAZO ////////////////////////
	function get_embarazo($cui){
		$sql ="SELECT *";
		$sql.=" FROM prepri_embarazo";
		$sql.=" WHERE emb_cui = '$cui'";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	function insert_embarazo($cui,$planificado,$duracion,$complicaciones,$tipo_complicaciones,$rayos_x,$depresion,$otros) {
		$fsis = date("Y-m-d H:i:s");
		$sql = "INSERT INTO prepri_embarazo VALUES ('$cui','$planificado','$duracion','$complicaciones','$tipo_complicaciones','$rayos_x','$depresion','$otros','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "emb_planificado = '$planificado',"; 
		$sql.= "emb_duracion = '$duracion',"; 
		$sql.= "emb_complicaciones = '$complicaciones',";
		$sql.= "emb_tipo_complicaciones = '$tipo_complicaciones',"; 
		$sql.= "emb_rayos_x = '$rayos_x',"; 
		$sql.= "emb_depresion = '$depresion',"; 
		$sql.= "emb_otros = '$otros', ";
		$sql.= "emb_fecha_actualiza = '$fsis'; ";
		
		return $sql;
	}	

	
//////////////  PARTO ////////////////////////
	function get_parto($cui){
		$sql ="SELECT *";
		$sql.=" FROM prepri_parto";
		$sql.=" WHERE par_cui = '$cui'";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	function insert_parto($cui,$tipo,$anestesia,$inducido,$forceps,$otros) {
		$fsis = date("Y-m-d H:i:s");
		$sql = "INSERT INTO prepri_parto VALUES ('$cui','$tipo','$anestesia','$inducido','$forceps','$otros','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "par_tipo = '$tipo',"; 
		$sql.= "par_anestesia = '$anestesia',"; 
		$sql.= "par_inducido = '$inducido',";
		$sql.= "par_forceps = '$forceps',"; 
		$sql.= "par_otro = '$otros', ";
		$sql.= "par_fecha_actualiza = '$fsis'; ";
		
		return $sql;
	}	

//////////////  LACTANCIA ////////////////////////
	function get_lactancia($cui){
		$sql ="SELECT *";
		$sql.=" FROM prepri_lactancia";
		$sql.=" WHERE lac_cui = '$cui'";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	function insert_lactancia($cui,$pecho,$pacha,$vomitos,$colicos) {
		$fsis = date("Y-m-d H:i:s");
		$sql = "INSERT INTO prepri_lactancia VALUES ('$cui','$pecho','$pacha','$vomitos','$colicos','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "lac_pecho = '$pecho',"; 
		$sql.= "lac_pacha = '$pacha',"; 
		$sql.= "lac_vomitos = '$vomitos',";
		$sql.= "lac_colicos = '$colicos', ";
		$sql.= "lac_fecha_actualiza = '$fsis'; ";
		
		return $sql;
	}	

//////////////  MOTOR ////////////////////////
	function get_motor($cui){
		$sql ="SELECT *";
		$sql.=" FROM prepri_motor";
		$sql.=" WHERE mot_cui = '$cui'";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	function insert_motor($cui,$cabeza,$sento,$camino,$gateo,$balanceo,$babeo) {
		$fsis = date("Y-m-d H:i:s");
		$sql = "INSERT INTO prepri_motor VALUES ('$cui','$cabeza','$sento','$camino','$gateo','$balanceo','$babeo','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "mot_cabeza = '$cabeza',"; 
		$sql.= "mot_sento = '$sento',"; 
		$sql.= "mot_camino = '$camino',";
		$sql.= "mot_gateo = '$gateo',";
		$sql.= "mot_balanceo = '$balanceo',";
		$sql.= "mot_babeo = '$babeo', ";
		$sql.= "mot_fecha_actualiza = '$fsis'; ";
		
		return $sql;
	}
	
	
//////////////  LENGUAJE ////////////////////////
	function get_lenguaje($cui){
		$sql ="SELECT *";
		$sql.=" FROM prepri_lenguaje";
		$sql.=" WHERE len_cui = '$cui'";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	function insert_lenguaje($cui,$dientes,$balbuceo,$palabras,$oraciones,$articula,$entiende) {
		$fsis = date("Y-m-d H:i:s");
		$sql = "INSERT INTO prepri_lenguaje VALUES ('$cui','$dientes','$balbuceo','$palabras','$oraciones','$articula','$entiende','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "len_dientes = '$dientes',"; 
		$sql.= "len_balbuceo = '$balbuceo',"; 
		$sql.= "len_palabras = '$palabras',";
		$sql.= "len_oraciones = '$oraciones',";
		$sql.= "len_articula = '$articula',";
		$sql.= "len_entiende = '$entiende', ";
		$sql.= "len_fecha_actualiza = '$fsis'; ";
		
		return $sql;
	}	

//////////////  SUENIO ////////////////////////
	function get_suenio($cui){
		$sql ="SELECT *";
		$sql.=" FROM prepri_suenio";
		$sql.=" WHERE sue_cui = '$cui'";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	function insert_suenio($cui,$duerme,$despierta,$terror,$insomnio,$crujido,$horas,$duerme_con) {
		$fsis = date("Y-m-d H:i:s");
		$sql = "INSERT INTO prepri_suenio VALUES ('$cui','$duerme','$despierta','$terror','$insomnio','$crujido','$horas','$duerme_con','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "sue_duerme = '$duerme',"; 
		$sql.= "sue_despierta = '$despierta',";
		$sql.= "sue_terror = '$terror',";
		$sql.= "sue_insomnio = '$insomnio',";
		$sql.= "sue_crujido_dientes = '$crujido',";
		$sql.= "sue_horas = '$horas',";
		$sql.= "sue_duerme_con = '$duerme_con', ";
		$sql.= "sue_fecha_actualiza = '$fsis'; ";
		
		return $sql;
	}	

//////////////  ALIMENTACION ////////////////////////
	function get_alimentacion($cui){
		$sql ="SELECT *";
		$sql.=" FROM prepri_alimentacion";
		$sql.=" WHERE ali_cui = '$cui'";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	function insert_alimentacion($cui,$solo,$exceso,$poco,$obligado,$habitos,$peso,$talla) {
		$fsis = date("Y-m-d H:i:s");
		$sql = "INSERT INTO prepri_alimentacion VALUES ('$cui','$solo','$exceso','$poco','$obligado','$habitos','$peso','$talla','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "ali_solo = '$solo',"; 
		$sql.= "ali_exceso = '$exceso',";
		$sql.= "ali_poco = '$poco',";
		$sql.= "ali_obligado = '$obligado',";
		$sql.= "ali_habitos = '$habitos',";
		$sql.= "ali_peso = '$peso',";
		$sql.= "ali_talla = '$talla', ";
		$sql.= "ali_fecha_actualiza = '$fsis'; ";
		
		return $sql;
	}	

	
//////////////  VISTA ////////////////////////
	function get_vista($cui){
		$sql ="SELECT *";
		$sql.=" FROM prepri_vista";
		$sql.=" WHERE vis_cui = '$cui'";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	function insert_vista($cui,$lentes,$uso,$irritacion,$secrecion,$se_acerca,$dolor,$desviacion,$otro) {
		$fsis = date("Y-m-d H:i:s");
		$sql = "INSERT INTO prepri_vista VALUES ('$cui','$lentes','$uso','$irritacion','$secrecion','$se_acerca','$dolor','$desviacion','$otro','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "vis_lentes = '$lentes',"; 
		$sql.= "vis_uso = '$uso',";
		$sql.= "vis_irritacion = '$irritacion',";
		$sql.= "vis_secrecion = '$secrecion',";
		$sql.= "vis_se_acerca = '$se_acerca',";
		$sql.= "vis_dolor_cabeza = '$dolor',";
		$sql.= "vis_desviacion_ocular = '$desviacion',";
		$sql.= "vis_otros = '$otro', ";
		$sql.= "vis_fecha_actualiza = '$fsis'; ";
		
		return $sql;
	}	


//////////////  OIDO ////////////////////////
	function get_oido($cui){
		$sql ="SELECT *";
		$sql.=" FROM prepri_oido";
		$sql.=" WHERE oid_cui = '$cui'";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	function insert_oido($cui,$afecciones,$cuales,$esfuerzo,$responde,$no_escucha) {
		$fsis = date("Y-m-d H:i:s");
		$sql = "INSERT INTO prepri_oido VALUES ('$cui','$afecciones','$cuales','$esfuerzo','$responde','$no_escucha','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "oid_afecciones = '$afecciones',"; 
		$sql.= "oid_cuales = '$cuales',";
		$sql.= "oid_esfuerzo = '$esfuerzo',";
		$sql.= "oid_responde = '$responde',";
		$sql.= "oid_no_escucha = '$no_escucha', ";
		$sql.= "oid_fecha_actualiza = '$fsis'; ";
		
		return $sql;
	}	

//////////////  CONDUCTA Y CARACTER ////////////////////////
	function get_caracter(){
		$sql ="SELECT *";
		$sql.=" FROM prepri_caracter";
		$sql.=" WHERE 1 = 1";
        $sql.=" ORDER BY car_codigo ASC";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
    
	function get_conducta_caracter($cui,$caracter = ''){
		$sql ="SELECT *";
		$sql.=" FROM prepri_conducta_caracter";
		$sql.=" WHERE con_cui = '$cui'";
		if(strlen($caracter) > 0){
			$sql.=" AND con_caracter = '$caracter'";
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	function insert_conducta_caracter($cui,$caracter) {
		$fsis = date("Y-m-d H:i:s");
		$sql = "INSERT INTO prepri_conducta_caracter VALUES ('$cui','$caracter','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "con_fecha_actualiza = '$fsis'; ";
		
		return $sql;
	}
	
	function delete_conducta_caracter($cui) {
		$sql = "DELETE FROM prepri_conducta_caracter";
		$sql.= " WHERE con_cui = '$cui'; ";
		
		return $sql;
	}
	
	
	//---------- SECCION - ALUMNO ---------//

	function get_seccion_alumno($pensum,$nivel,$grado,$seccion = '',$alumno = ''){
		
        $sql= "SELECT *, ";
		$sql.= " (SELECT col_fecha_actualiza FROM prepri_colegio WHERE col_cui = alu_cui ORDER BY alu_cui LIMIT 0 , 1) as info_colegio,";
		$sql.= " (SELECT emb_fecha_actualiza FROM prepri_embarazo WHERE emb_cui = alu_cui ORDER BY alu_cui LIMIT 0 , 1) as info_embarazo,";
		$sql.= " (SELECT par_fecha_actualiza FROM prepri_parto WHERE par_cui = alu_cui ORDER BY alu_cui LIMIT 0 , 1) as info_parto,";
		$sql.= " (SELECT lac_fecha_actualiza FROM prepri_lactancia WHERE lac_cui = alu_cui ORDER BY alu_cui LIMIT 0 , 1) as info_lactancia,";
		$sql.= " (SELECT mot_fecha_actualiza FROM prepri_motor WHERE mot_cui = alu_cui ORDER BY alu_cui LIMIT 0 , 1) as info_motor,";
		$sql.= " (SELECT len_fecha_actualiza FROM prepri_lenguaje WHERE len_cui = alu_cui ORDER BY alu_cui LIMIT 0 , 1) as info_lenguaje,";
		$sql.= " (SELECT sue_fecha_actualiza FROM prepri_suenio WHERE sue_cui = alu_cui ORDER BY alu_cui LIMIT 0 , 1) as info_suenio,";
		$sql.= " (SELECT ali_fecha_actualiza FROM prepri_alimentacion WHERE ali_cui = alu_cui ORDER BY alu_cui LIMIT 0 , 1) as info_alimentacion,";
		$sql.= " (SELECT vis_fecha_actualiza FROM prepri_vista WHERE vis_cui = alu_cui ORDER BY alu_cui LIMIT 0 , 1) as info_vista,";
		$sql.= " (SELECT oid_fecha_actualiza FROM prepri_oido WHERE oid_cui = alu_cui ORDER BY alu_cui LIMIT 0 , 1) as info_oido,";
		$sql.= " (SELECT con_fecha_actualiza FROM prepri_conducta_caracter WHERE con_cui = alu_cui ORDER BY alu_cui LIMIT 0 , 1) as info_conducta ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_seccion_alumno, app_alumnos";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum"; 
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND seca_pensum = sec_pensum";
		$sql.= " AND seca_nivel = sec_nivel";
		$sql.= " AND seca_grado = sec_grado";
		$sql.= " AND seca_seccion = sec_codigo";
		$sql.= " AND seca_alumno = alu_cui";
		$sql.= " AND alu_situacion != 0"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND seca_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND seca_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND seca_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND seca_seccion = $seccion"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND seca_alumno = '$alumno'"; 
		}
		$sql.= " ORDER BY pen_anio ASC, seca_pensum ASC, seca_nivel ASC, seca_grado ASC, sec_situacion DESC, sec_tipo ASC, sec_descripcion ASC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}


}	
?>