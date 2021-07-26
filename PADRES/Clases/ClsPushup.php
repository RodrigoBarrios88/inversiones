<?php
require_once ("ClsConex.php");

class ClsPushup extends ClsConex{
   
    function get_push_user($user_id = '',$push_user_id = '',$device_type = '',$device_id = '',$device_token = '') {
        
        $sql= "SELECT * ";
		$sql.= " FROM push_user";
		$sql.= " WHERE 1 = 1";
        if(strlen($user_id)>0) { 
			  $sql.= " AND user_id = $user_id"; 
		}
		if(strlen($push_user_id)>0) { 
			  $sql.= " AND push_user_id = '$push_user_id'"; 
		}
		if(strlen($device_type)>0) { 
			  $sql.= " AND device_type = '$device_type'"; 
		}
		if(strlen($device_id)>0) { 
			  $sql.= " AND device_id = '$device_id'"; 
		}
		if(strlen($device_token)>0) { 
			  $sql.= " AND device_token = '$device_token'"; 
		}
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
    
    
    function get_users($user_id) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM push_user, seg_usuarios";
		$sql.= " WHERE user_id IN($user_id)";
		$sql.= " ORDER BY user_id ASC, device_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
    
	}
	
	
	function get_alumno_users($alumno) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_padre_alumno ";
		$sql.= " LEFT JOIN push_user ON pa_padre = user_id";
		$sql.= " WHERE pa_alumno IN($alumno)";
		$sql.= " ORDER BY pa_padre ASC, device_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
    
	}
    
    
    function get_alumnos_users($alumno) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_padre_alumno ";
		$sql.= " LEFT JOIN push_user ON pa_padre = user_id";
		$sql.= " WHERE pa_alumno IN($alumno)";
		$sql.= " ORDER BY pa_alumno ASC, user_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
    
	}
	 
	 
	 
    function get_nivel_grado_seccion_users($pensum,$nivel,$grado,$seccion){
		
	    $sql= "SELECT * ";
		$sql.= " FROM academ_seccion_alumno";
		$sql.= " JOIN app_alumnos ON seca_alumno = alu_cui";
        $sql.= " JOIN app_padre_alumno ON seca_alumno = pa_alumno";
        $sql.= " LEFT JOIN push_user ON pa_padre = user_id";
		$sql.= " WHERE 1 = 1";
		$sql.= " AND alu_situacion=1";
		if(strlen($pensum)>0) { 
			$sql.= " AND seca_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND seca_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND seca_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND seca_seccion IN($seccion)"; 
		}
		$sql.= " ORDER BY pa_alumno ASC, pa_padre ASC, device_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_grupos_users($grupo){
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_grupo_alumno, app_padre_alumno, push_user";
		$sql.= " WHERE ag_alumno = pa_alumno";
		$sql.= " AND pa_padre = user_id";
		if(strlen($grupo)>0) {
			$sql.= " AND ag_grupo IN($grupo)";
		}
		$sql.= " ORDER BY pa_padre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function insert_push_user($user_id,$device_id,$device_token,$device_type,$certificate_type,$status,$created_at,$updated_at){
		
		$sql = "INSERT INTO push_user ";
		$sql.= " VALUES ('$user_id','$device_id','$device_token','$device_type','$certificate_type','$status','$created_at','$updated_at')";
		$sql.= " ON DUPLICATE KEY UPDATE device_token = '$device_token', device_type = '$device_type', certificate_type = '$certificate_type', status = '$status', updated_at = '$updated_at'";
		
		//echo $sql;
		return $sql;
	}
	
	
	function delete_push_user($user_id,$device_id){
		
		$sql = "DELETE FROM push_user";
		$sql.= " WHERE user_id = '$user_id' ";
		$sql.= " AND device_id = '$device_id'; "; 	
		
		return $sql;
	}
    
    
    function situacion_push_user($user_id,$device_id,$sit){
		
		$sql = "UPDATE push_user SET status = $sit";
		$sql.= " WHERE user_id = '$user_id' ";
		$sql.= " AND device_id = '$device_id'; "; 	
		
		return $sql;
	}
	
	function max_push_user(){
	    $sql = "SELECT max(push_user_id) as max ";
		$sql.= " FROM push_user";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	//////////// NOTIFICACIONES ////////////////////////////
	
	function get_push_notification($user_id = '',$type = '',$target = '',$type_id = '',$limit1 = '',$limit2 = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql= "SELECT * ";
		$sql.= " FROM push_notification";
		$sql.= " WHERE 1 = 1";
        $sql.= " AND YEAR(created_at) BETWEEN $anio1 AND $anio2";
		if(strlen($user_id)>0) { 
			$sql.= " AND user_id = $user_id"; 
		}
		if(strlen($push_user_id)>0) { 
			$sql.= " AND push_user_id = '$push_user_id'"; 
		}
		if(strlen($type)>0) { 
			$sql.= " AND push_type = '$type'"; 
		}
		if(strlen($type_id)>0) { 
			$sql.= " AND type_id IN($type_id)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND target = '$target'"; 
		}
        if(strlen($limit1)>0 && strlen($limit2)>0) { 
			$limite = "LIMIT $limit1,$limit2"; 
		}
		$sql.= " GROUP BY user_id, created_at";
		$sql.= " ORDER BY created_at DESC, user_id ASC $limite";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
    
    
    
    function get_push_notification_user($user_id = '',$type = '',$target = '',$type_id = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql= "SELECT * ";
		$sql.= " FROM push_notification, push_user";
		$sql.= " WHERE push_notification.user_id = push_user.user_id";
        $sql.= " AND YEAR(push_notification.created_at) BETWEEN $anio1 AND $anio2";
		if(strlen($user_id)>0) { 
			$sql.= " AND push_notification.user_id = $user_id"; 
		}
		if(strlen($push_user_id)>0) { 
			$sql.= " AND push_user_id = '$push_user_id'"; 
		}
		if(strlen($type)>0) { 
			$sql.= " AND push_type = '$type'"; 
		}
		if(strlen($type_id)>0) { 
			$sql.= " AND type_id IN($type_id)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND target = '$target'"; 
		}
		$sql.= " GROUP BY push_user.user_id, push_user.device_id";
		$sql.= " ORDER BY push_notification.created_at DESC, push_notification.user_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;
	}
	
	
	function count_pendientes_leer($user_id,$target = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql = "SELECT user_id";
		$sql.= " FROM push_notification";
		$sql.= " WHERE user_id = $user_id";
        $sql.= " AND YEAR(created_at) BETWEEN $anio1 AND $anio2";
		if(strlen($target)>0) { 
			$sql.= " AND target = '$target'"; 
		}
		$sql.= " AND status = 0";
        $sql.= " GROUP BY push_type, type_id"; 
		
		//echo $sql;
		$result = $this->exec_query($sql);
        $i=0;
        if(is_array($result)){
            foreach($result as $row){
                $total = $row['user_id'];
                $i++;
            }   
        }
		return $i;
	}
	
	
	function count_pendientes_leer_type($user_id,$type,$target = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql= "SELECT type_id,COUNT(*) as total";
		$sql.= " FROM push_notification";
		$sql.= " WHERE user_id = $user_id";
		$sql.= " AND push_type = '$type'";
        $sql.= " AND YEAR(created_at) BETWEEN $anio1 AND $anio2";
        if(strlen($target)>0) { 
			$sql.= " AND target = '$target'"; 
		}
		$sql.= " AND status = 0";
        $sql.= " GROUP BY type_id"; 
		$sql.= " ORDER BY type_id"; 
		
		//echo $sql."<br><br>";
		$result = $this->exec_query($sql);
        $total = 0;
        if(is_array($result)){
            foreach($result as $row){
                $type_id = $row['type_id'];
                $total++;
            }
        }
		return $total;
	}
	
	
	function insert_push_notification($user_id,$message,$type,$type_id = '',$target = ''){
		$type_id = trim($type_id);
		$fecsist = date("Y-m-d H:i:s");
        $target = trim($target);
		$sql = "INSERT INTO push_notification (user_id, message, push_type, type_id, target, status, created_at, updated_at) ";
		$sql.= " VALUES ('$user_id','$message','$type','$type_id','$target',0,'$fecsist','$fecsist');";
		//echo $sql;
		return $sql;
	
	}
	
	
	function update_push_status($user_id){
		
		$fecsist = date("Y-m-d H:i:s");
		$sql = "UPDATE push_notification SET status = 1, updated_at = '$fecsist'";
		$sql.= " WHERE user_id = '$user_id'";
        $sql.= " AND status = 0;";
		//echo $sql;
		return $sql;
	}
    
    
    function update_push_status_type($user_id,$type){
		
		$fecsist = date("Y-m-d H:i:s");
		$sql = "UPDATE push_notification SET status = 1, updated_at = '$fecsist'";
		$sql.= " WHERE user_id = '$user_id'";
		$sql.= " AND push_type = '$type';";
		$rs = $this->exec_sql($sql);
		//echo $sql;
		return;
	}
    
    
    function update_push_status_type_alumno($user_id,$type,$alumno){
		
		$fecsist = date("Y-m-d H:i:s");
		$sql = "UPDATE push_notification SET status = 1, updated_at = '$fecsist'";
		$sql.= " WHERE user_id = '$user_id'";
		$sql.= " AND push_type = '$type'";
		$sql.= " AND target = '$alumno';";
		$rs = $this->exec_sql($sql);
		//echo $sql;
		return;
	}
	
    
	function update_push_status_especifica($user_id,$type,$type_id){
		
		$fecsist = date("Y-m-d H:i:s");
		$sql = "UPDATE push_notification SET status = 1, updated_at = '$fecsist'";
		$sql.= " WHERE user_id = '$user_id'";
		$sql.= " AND push_type = '$type'";
		$sql.= " AND type_id = '$type_id';";
		$rs = $this->exec_sql($sql);
		//echo $sql;
		return;
	}
    
    function delete_push_especifica($type,$type_id){
		
		$fecsist = date("Y-m-d H:i:s");
		$sql = "DELETE FROM push_notification";
		$sql.= " WHERE push_type = $type";
		$sql.= " AND type_id IN($type_id);";
		//echo $sql;
		return $sql;
	}
	
	
	function get_notification_status($push_type,$type_id, $nivel = '', $grado = '', $seccion = ''){
		$pensum = $_SESSION["pensum"];
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno WHERE graa_pensum = gra_pensum AND graa_nivel = gra_nivel AND graa_grado = gra_codigo AND graa_alumno = alu_cui AND graa_pensum = $pensum ORDER BY graa_grado LIMIT 0 , 1) as alu_grado,";
		$sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno WHERE seca_pensum = sec_pensum AND seca_nivel = sec_nivel AND seca_grado = sec_grado AND seca_seccion = sec_codigo AND seca_alumno = alu_cui AND seca_pensum = $pensum ORDER BY seca_seccion LIMIT 0 , 1) as alu_seccion ";
		$sql.= " FROM app_padre_alumno,app_padres,app_alumnos,academ_seccion_alumno,push_notification";
		$sql.= " WHERE pa_padre = pad_cui";
		$sql.= " AND pa_alumno = alu_cui";
		$sql.= " AND alu_situacion = 1";
		$sql.= " AND seca_alumno = alu_cui";
		$sql.= " AND pa_padre = user_id";
		//--
		$sql.= " AND push_type = $push_type";
		$sql.= " AND type_id = $type_id";
		//--
		$sql.= " AND seca_pensum = $pensum";
		
		if(strlen($nivel)>0) { 
			  $sql.= " AND seca_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND seca_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND seca_seccion IN($seccion)"; 
		}
		//--
		$sql.= " GROUP BY pa_padre, alu_cui";
		$sql.= " ORDER BY updated_at ASC, alu_apellido ASC, alu_nombre ASC, alu_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
		
	
}	
?>