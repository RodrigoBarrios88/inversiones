<?php
require_once ("".full_url_util($_SERVER)."/CONFIG/Connex/ConURL.php");

class ClsUtil extends ConURL{
	//////////////////////////////////////////////////////////////////////////////////////// 
	/////////////////////// AUXILIAR //////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	
	////////// Manejo de Fechas ----------------
	function cambia_fecha($Fecha){ 
		if ($Fecha<>""){ 
		   $trozos=explode("-",$Fecha,3); 
		   return $trozos[2]."/".$trozos[1]."/".$trozos[0]; 
		}else{return $Fecha;} 
	} 
	
	function regresa_fecha($Fecha){ 
		if ($Fecha<>""){ 
		   $trozos=explode("/",$Fecha); 
		   return $trozos[2]."-".$trozos[1]."-".$trozos[0]; 
		}else{return $Fecha;} 
	} 
	
	function regresa_fechaHora($Fecha) { 
		if ($Fecha<>""){ 
		   $trozos=explode("/",$Fecha); 
		   $trozos2=explode(" ",$trozos[2]);
		   $fecha = $trozos2[0]."-".$trozos[1]."-".$trozos[0]; 
		   $hora = $trozos2[1];
		   return "$fecha $hora";
		}else 
		   {return $Fecha;} 
	}
	
	function cambia_fechaHora($Fecha) { 
		if ($Fecha<>""){ 
		   $trozos=explode("-",$Fecha); 
		   $trozos2=explode(" ",$trozos[2]);
		   $fecha = $trozos2[0]."/".$trozos[1]."/".$trozos[0]; 
		   $hora = $trozos2[1];
		   return "$fecha $hora";
		}else 
		   {return $Fecha;} 
	}
	
	function Fecha_suma_dias($Fecha, $dias){
		$fec = explode("/",$Fecha);
		$day = $fec[2];
		$mon = $fec[1];
		$year = $fec[0];
		
		$fecha_cambiada = mktime(0,0,0,$mon,$day+$dias,$year);
		$fecha = date("d/m/Y", $fecha_cambiada);
		return $fecha; //devuelve dd/mm/yyyy 
	}
	
	////////// Encripci�n y Desencripci�n ----------------
	
	function encrypt($string, $key) {
	   $result = '';
	   for($i=0; $i<strlen($string); $i++) {
		  $char = substr($string, $i, 1);
		  $keychar = substr($key, ($i % strlen($key))-1, 1);
		  $char = chr(ord($char)+ord($keychar));
		  $result.=$char;
	   }
	   return base64_encode($result);
	}

	function decrypt($string, $key) {
	   $result = '';
	   $string = base64_decode($string);
	   for($i=0; $i<strlen($string); $i++) {
		  $char = substr($string, $i, 1);
		  $keychar = substr($key, ($i % strlen($key))-1, 1);
		  $char = chr(ord($char)-ord($keychar));
		  $result.=$char;
	   }
	   return $result;
	}
			
}


//////////////////////////////////////////////////// 
// URL DEL SERVIDOR
//////////////////////////////////////////////////// 
function url_origin_util( $s, $use_forwarded_host = false ){
    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
    $port     = $s['SERVER_PORT'];
    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

function full_url_util( $s, $use_forwarded_host = false ){
    return url_origin_util( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
}
?>