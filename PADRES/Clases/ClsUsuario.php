<?php
require_once ("ClsConex.php");
date_default_timezone_set('America/Guatemala');
//NOTA//
/*
 **EL CAMPO usu_avilita REGISTRA SI EL USUARIO YA INGRESO POR PRIMERAVEZ AL SISTEMA Y CAMBIO SU USUARIO Y CONTRASEÑA	
*/
class ClsUsuario extends ClsConex{
	
	function __construct(){
		
	}	

	function get_login($usu,$pass) {
		$usu = str_replace(" ","",$usu);
		$pass = str_replace(" ","",$pass);
		$pass = $this->encrypt($pass, $usu); //encrypta el pasword
		
		$sql= "SELECT *, ";
		$sql.= " (SELECT fot_string FROM app_foto_usuario WHERE fot_usuario = usu_id) as usu_foto";
		$sql.= " FROM seg_usuarios";
		$sql.= " WHERE usu_usuario = '$usu'"; 
		$sql.= " AND usu_pass = '$pass'"; 
		$sql.= " AND usu_situacion = 1"; 
		$sql.= " AND usu_seguridad = 0"; 
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_valida_pregunta_resp($id,$usu,$preg,$resp) {
		$preg = trim($preg);
		$resp = trim($resp);
		$resp = $this->encrypt($resp, $usu); //encrypta la respuesta
		
		$sql= "SELECT * ";
		$sql.= " FROM seg_usuarios";
		$sql.= " WHERE 1 = 1 ";
		$sql.= " AND usu_id = '$id'"; 
		$sql.= " AND usu_usuario = '$usu'"; 
		$sql.= " AND usu_pregunta like '%$preg%'"; 
		$sql.= " AND usu_respuesta = '$resp'"; 
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
		
		
	function get_usuario($id,$nom = '',$mail = '',$tipo = '',$band = '',$sit = '',$usu = '') {	
		$sql= "SELECT *, ";
		$sql.= " (SELECT fot_string FROM app_foto_usuario WHERE fot_usuario = usu_id) as usu_foto";
		$sql.= " FROM seg_usuarios";
		$sql.= " WHERE 1 = 1";
		if(strlen($id)>0) { 
			  $sql.= " AND usu_id = $id"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND usu_nombre like '%$nom%'"; 
		}
		if(strlen($mail)>0) { 
			  $sql.= " AND usu_mail = '$mail'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND usu_tipo = $tipo"; 
		}
		if(strlen($band)>0) { 
			  $sql.= " AND usu_avilita = $band"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND usu_situacion = $sit"; 
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND usu_usuario = '$usu'"; 
		}
		$sql.= " ORDER BY usu_tipo ASC, usu_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function count_usuario($id,$nom = '',$mail = '',$tipo = '',$band = '',$sit = '',$usu = '') {
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM seg_usuarios";
		$sql.= " WHERE 1 = 1";
		if(strlen($id)>0) { 
			  $sql.= " AND usu_id = $id"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND usu_nombre like '%$nom%'"; 
		}
		if(strlen($mail)>0) { 
			  $sql.= " AND usu_mail = '$mail'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND usu_tipo = $tipo"; 
		}
		if(strlen($band)>0) { 
			  $sql.= " AND usu_avilita = $band"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND usu_situacion = $sit"; 
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND usu_usuario = '$usu'"; 
		}
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$cont = $row["total"];
		}
		//echo $sql;
		return $cont;
	}
	
	function get_usuario_tipo_codigo($tipo = '',$tipo_codigo = '') {
		
		$sql= "SELECT *, ";
		$sql.= " (SELECT fot_string FROM app_foto_usuario WHERE fot_usuario = usu_id) as usu_foto";
		$sql.= " FROM seg_usuarios";
		$sql.= " WHERE usu_situacion != 0";
		if(strlen($tipo)>0) { 
			  $sql.= " AND usu_tipo IN($tipo)"; 
		}
		if(strlen($tipo_codigo)>0) { 
			  $sql.= " AND usu_tipo_codigo = '$tipo_codigo'"; 
		}
		$sql.= " ORDER BY usu_tipo ASC, usu_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function comprueba_nusuario($id,$usu) {
		
		$sql= "SELECT COUNT(*) as comprueba";
		$sql.= " FROM seg_usuarios";
		$sql.= " WHERE usu_usuario = '$usu'";
		$sql.= " AND usu_id != $id";  	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$cont = $row["comprueba"];
		}
		//echo $sql;
		return $cont;
	}
	
	function get_tipo_codigo($id){
	    $sql = "SELECT usu_tipo_codigo as cui ";
		$sql.= " FROM seg_usuarios";
		$sql.= " WHERE usu_id = $id";
		
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$cui = $row["cui"];
			}
		}
		//echo $sql;
		return $cui;
	}		
	
		
	function insert_usuario($id,$nom,$nom2,$mail,$tel,$tipo,$tipocod,$usu,$pass,$cambio){
		$mail = strtolower($mail);
		$fec = date("Y-m-d");
		$pass = $this->encrypt($pass, $usu); //encrypta el pasword
		
		$sql = "INSERT INTO seg_usuarios";
		$sql.= " VALUES($id,'','$nom','$nom2','$mail','$tel','$tipo','$tipocod','$usu','$pass','','',0,0,'$fec',$cambio,1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_usuario($id,$nom,$tipo,$mail,$tel,$usu,$pass,$avi,$seg,$cambio){
		$mail = strtolower($mail);
		
		$sql = "UPDATE seg_usuarios SET ";
		$sql.= "usu_nombre = '$nom',"; 
		$sql.= "usu_tipo = '$tipo',"; 
		$sql.= "usu_mail = '$mail',"; 
		$sql.= "usu_telefono = '$tel',"; 
		$sql.= "usu_seguridad = $seg,";
		$sql.= "usu_avilita = $avi,";
		$sql.= "usu_cambio = $cambio";
		if($usu != ""){
		$sql.= ",usu_usuario = '$usu'";
		}
		if($pass != ""){
		$pass = $this->encrypt($pass, $usu); //encrypta el pasword
		$sql.= ",usu_pass = '$pass'";
		}
		$sql.= " WHERE usu_id = $id; ";
		//echo $sql;
		return $sql;
	}
	
	function cambia_foto($usu,$string){
		$freg = date("Y-m-d H:i:s");
		$usureg = $_SESSION["codigo"];
		
		$sql.= "INSERT INTO app_foto_usuario (fot_usuario, fot_string , fot_fecha_registro, fot_usuario_registro)";
		$sql.= " VALUES('$usu','$string','$freg','$usureg')";
		$sql.= " ON DUPLICATE KEY UPDATE";
		$sql.= " fot_string = '$string',";
		$sql.= " fot_fecha_registro = '$freg',";
		$sql.= " fot_usuario_registro = '$usureg';";
		
		return $sql;
	}
	
	
	function modificar_campo($usuario,$campo,$valor){
		$valor = trim($valor);
		
		$sql = "UPDATE seg_usuarios SET ";
		$sql.= "$campo = '$valor'"; 
	
		$sql.= " WHERE usu_id = '$usuario'; "; 	
		
		return $sql;
	}
	
	
	function max_usuario(){
	    $sql = "SELECT max(usu_id) as max ";
		$sql.= " FROM seg_usuarios";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	function last_foto_usuario($usu){
	    $sql = "SELECT fot_string as last ";
		$sql.= " FROM app_foto_usuario";
		$sql.= " WHERE fot_usuario = '$usu'"; 	
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$last = $row["last"];
			}
		}
		//echo $sql;
		return $last;
	}
	
	
	function cambia_sit_usuario($id,$sit){
		
		$sql = "UPDATE seg_usuarios SET ";
		$sql.= "usu_situacion = $sit"; 
				
		$sql.= " WHERE usu_id = $id;"; 	
		
		return $sql;
	}
	
	
	function cambia_usu_avilita($id,$avi){
		
		$sql = "UPDATE seg_usuarios SET ";
		$sql.= "usu_avilita = $avi"; 
		$sql.= " WHERE usu_id = $id; "; 	
		
		return $sql;
	}
	
	function cambia_pregunta($id,$usu,$preg,$clave){
		$preg = trim($preg);
		$clave = trim($clave);
		$clave = $this->encrypt($clave, $usu); //encrypta la respuesta
		
		$sql = "UPDATE seg_usuarios SET ";
		$sql.= "usu_pregunta = '$preg',";
		$sql.= "usu_respuesta = '$clave'"; 
		$sql.= " WHERE usu_id = $id; "; 	
		
		return $sql;
	}
	
	function modifica_perfil($id,$nom2,$mail,$tel){
		$sql = "UPDATE seg_usuarios SET ";
		$sql.= " usu_nombre_pantalla = '$nom2',";
		$sql.= " usu_mail = '$mail',";
		$sql.= " usu_telefono = '$tel'"; 
		$sql.= " WHERE usu_id = $id; "; 	
		
		return $sql;
	}
	
	function modifica_pass($id,$usu,$pass){
	    // ejecuta el cambio de usuario y contraseña, asi como la proxima fecha de cambio
		$pass = $this->encrypt($pass, $usu); //encrypta el pasword
		$sql = "UPDATE seg_usuarios SET ";
		$sql.= " usu_usuario = '$usu',";
		$sql.= " usu_pass = '$pass'";
		$sql.= " WHERE usu_id = $id; "; 
		//echo $sql;
		return $sql;
	}
	
	function modifica_pass_perfil($id,$usu,$pass){
	    // ejecuta el cambio de usuario y contraseña, asi como la proxima fecha de cambio
		$pass = $this->encrypt($pass, $usu); //encrypta el pasword
		$sql = "UPDATE seg_usuarios SET ";
		$sql.= " usu_usuario = '$usu',";
		$sql.= " usu_pass = '$pass'";
		$sql.= " WHERE usu_id = $id; "; 	
		//echo $sql;
		return $sql;
	}
	
	function modifica_mail_usuario($id,$mail){
	    
		$sql = "UPDATE seg_usuarios SET ";
		$sql.= " usu_usuario = '$mail',";
		$sql.= " usu_mail = '$mail'";
		$sql.= " WHERE usu_id = $id; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_usu_seguridad($usu,$seg){
		$sql = "UPDATE seg_usuarios SET ";
		$sql.= "usu_seguridad = $seg"; 
		$sql.= " WHERE usu_usuario = '$usu'; "; 	
		//echo $sql;
		$result = $this->exec_sql($sql);
		return $result;
	}
	
	
	function modifica_user_chat_id($id,$user_chat_id){
		
		$sql = "UPDATE seg_usuarios SET ";
		$sql.= "usu_chat_id = '$user_chat_id'"; 
				
		$sql.= " WHERE usu_id = $id;"; 	
		
		return $sql;
	}
	
	
}	
?>
