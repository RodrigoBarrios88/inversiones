<?php
require_once ("ClsConex.php");

class ClsEconomica extends ClsConex{
   
//---------- Laboral Anterior ---------//
    function get_economica($personal) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM rrhh_economica";
		$sql.= " WHERE eco_personal = $personal"; 
		$sql.= " ORDER BY eco_personal ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
			
	function insert_economica($eco_personal,$eco_trabaja_conyugue,$eco_sueldo_conyugue,$eco_lugar_trabajo_conyuge,$eco_cargas_familiares,$eco_vivienda,$eco_pago_vivienda,
			$eco_cuenta_banco,$eco_banco,$eco_tarjeta,$eco_operador_tarjeta,$eco_otros_ingresos,$eco_monto_otros,$eco_sueldo,$eco_descuentos,$eco_prestamos,$eco_saldo_prestamos) {
	     //-- UPPERCASE
			$eco_trabaja_conyugue = trim($eco_trabaja_conyugue);
			$eco_lugar_trabajo_conyuge = trim($eco_lugar_trabajo_conyuge);
			$eco_vivienda = trim($eco_vivienda);
			$eco_cuenta_banco = trim($eco_cuenta_banco);
			$eco_banco = trim($eco_banco);
			$eco_tarjeta = trim($eco_tarjeta);
			$eco_operador_tarjeta = trim($eco_operador_tarjeta);
			$eco_otros_ingresos = trim($eco_otros_ingresos);
			$eco_prestamos = trim($eco_prestamos);
		//--
		$sql = "INSERT INTO rrhh_economica ";
		$sql.= "VALUES ('$eco_personal','$eco_trabaja_conyugue','$eco_sueldo_conyugue','$eco_lugar_trabajo_conyuge','$eco_cargas_familiares','$eco_vivienda','$eco_pago_vivienda','$eco_cuenta_banco','$eco_banco','$eco_tarjeta','$eco_operador_tarjeta','$eco_otros_ingresos','$eco_monto_otros','$eco_sueldo','$eco_descuentos','$eco_prestamos','$eco_saldo_prestamos'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_economica($eco_personal,$eco_trabaja_conyugue,$eco_sueldo_conyugue,$eco_lugar_trabajo_conyuge,$eco_cargas_familiares,$eco_vivienda,$eco_pago_vivienda,
			$eco_cuenta_banco,$eco_banco,$eco_tarjeta,$eco_operador_tarjeta,$eco_otros_ingresos,$eco_monto_otros,$eco_sueldo,$eco_descuentos,$eco_prestamos,$eco_saldo_prestamos) {
	        //-- UPPERCASE
			$eco_trabaja_conyugue = trim($eco_trabaja_conyugue);
			$eco_lugar_trabajo_conyuge = trim($eco_lugar_trabajo_conyuge);
			$eco_vivienda = trim($eco_vivienda);
			$eco_cuenta_banco = trim($eco_cuenta_banco);
			$eco_banco = trim($eco_banco);
			$eco_tarjeta = trim($eco_tarjeta);
			$eco_operador_tarjeta = trim($eco_operador_tarjeta);
			$eco_otros_ingresos = trim($eco_otros_ingresos);
			$eco_prestamos = trim($eco_prestamos);
		//--
		$sql = "UPDATE rrhh_economica SET";
		$sql.= " eco_trabaja_conyugue = '$eco_trabaja_conyugue',";
		$sql.= " eco_sueldo_conyugue = '$eco_sueldo_conyugue',";
		$sql.= " eco_lugar_trabajo_conyuge = '$eco_lugar_trabajo_conyuge',";
		$sql.= " eco_cargas_familiares = '$eco_cargas_familiares',";
		$sql.= " eco_vivienda = '$eco_vivienda',";
		$sql.= " eco_pago_vivienda = '$eco_pago_vivienda',";
		$sql.= " eco_cuenta_banco = '$eco_cuenta_banco',";
		$sql.= " eco_banco = '$eco_banco',";
		$sql.= " eco_tarjeta = '$eco_tarjeta',";
		$sql.= " eco_operador_tarjeta = '$eco_operador_tarjeta',";
		$sql.= " eco_otros_ingresos = '$eco_otros_ingresos',";
		$sql.= " eco_monto_otros = '$eco_monto_otros',";
		$sql.= " eco_sueldo = '$eco_sueldo',";
		$sql.= " eco_descuentos = '$eco_descuentos',";
		$sql.= " eco_prestamos = '$eco_prestamos',";
		$sql.= " eco_saldo_prestamos = '$eco_saldo_prestamos' ";
		
		$sql.= "WHERE eco_personal = '$eco_personal'; ";

		//echo $sql;
		return $sql;
	}
	
	function delete_economica($personal){
		$sql = "DELETE FROM rrhh_economica  ";
		$sql.= " WHERE eco_personal = $personal; "; 	
		return $sql;
	}
	
}	
?>
