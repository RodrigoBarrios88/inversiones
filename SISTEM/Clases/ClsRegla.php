<?php
require_once ("ClsConex.php");

class ClsRegla extends ClsConex{
    
    ////////////////////////// CREDENCIALES //////////////////////////
    function get_credenciales() {
				
        $sql= "SELECT * ";
		$sql.= " FROM conf_credenciales";
				
		$result = $this->exec_query($sql);
		
		return $result;
	}
    
    function update_credenciales($nombre,$rotulo,$rotulo_sub,$nombre_reporte,$direccion1,$direccion2,$departamento,$municipio,$telefono,$correo,$website,$nivel,$ciclo,$modalidad,$jornada,$sector,$area) {
		
		$sql = "UPDATE conf_credenciales SET ";
		$sql.= "colegio_nombre = '$nombre',";
		$sql.= "colegio_rotulo = '$rotulo',";
		$sql.= "colegio_rotulo_subpantalla = '$rotulo_sub',";
		$sql.= "colegio_nombre_reporte = '$nombre_reporte',";
		$sql.= "colegio_direccion1 = '$direccion1',";
		$sql.= "colegio_direccion2 = '$direccion2',";
		$sql.= "colegio_departamento = '$departamento',";
		$sql.= "colegio_municipio = '$municipio',";
		$sql.= "colegio_telefono = '$telefono',";
		$sql.= "colegio_correo = '$correo',";
		$sql.= "colegio_website  = '$website',";
		$sql.= "mineduc_nivel = '$nivel',";
		$sql.= "mineduc_cliclo = '$ciclo',";
		$sql.= "mineduc_modalidad = '$modalidad',";
		$sql.= "mineduc_jornada = '$jornada',";
		$sql.= "mineduc_sector = '$sector',";
		$sql.= "mineduc_area = '$area'";
		
		$sql.= "WHERE colegio_codigo = 1;";
	
		return $sql;
	}
    
    ////////////////////////// REGLAS //////////////////////////
    function get_reglas() {
				
        $sql= "SELECT * ";
		$sql.= " FROM conf_reglas";
				
		$result = $this->exec_query($sql);
		
		return $result;
	}
	
	function get_mail_admin() {
				
        $sql= "SELECT reg_correo_admin ";
		$sql.= " FROM conf_reglas";
				
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$mail = $row['reg_correo_admin'];
			}
		}
		return $mail;
	}
	
	function get_regla_moneda() {
				
        $sql= "SELECT reg_moneda ";
		$sql.= " FROM conf_reglas";
				
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$mon = $row['reg_moneda'];
			}
		}
		return $mon;
	}
	
	function update_mail_admin($mail) {
		$sql = "UPDATE conf_reglas SET reg_correo_admin = '$mail';";
				
		$result = $this->exec_sql($sql);
		
		return $result;
	}
	
	function update_reglas($mail,$mon,$pais,$dep,$mun,$regimen,$iva,$isr,$fac,$ser,$margen,$minimo,$desc,$carg,$igssemp,$igsspat,$irtra,$intecap) {
		$mail = strtolower($mail);
		
		$sql = "UPDATE conf_reglas SET ";
		$sql.= "reg_correo_admin = '$mail',";
		$sql.= "reg_moneda = $mon,";
		$sql.= "reg_pais = $pais,";
		$sql.= "reg_departamento = $dep,";
		$sql.= "reg_municipio = $mun,";
		$sql.= "reg_regimen_tributario = $regimen,";
		$sql.= "reg_iva = $iva,";
		$sql.= "reg_isr = $isr,";
		$sql.= "reg_factura = $fac,";
		$sql.= "reg_serie = $ser,";
		$sql.= "reg_margen = $margen,";
		$sql.= "reg_minimo_producto = $minimo,";
		$sql.= "reg_descarga = $desc,";
		$sql.= "reg_carga = $carg,";
		$sql.= "reg_igss_empleado  = $igssemp,";
		$sql.= "reg_igss_patrono  = $igsspat,";
		$sql.= "reg_irtra  = $irtra,";
		$sql.= "reg_intecap = $intecap ";
		
		$sql.= "WHERE reg_codigo = 1;";
	
		return $sql;
	}
    
    
    ////////////////////////// MODULOS //////////////////////////
    
    function get_modulos() {
				
        $sql= "SELECT * ";
		$sql.= " FROM conf_modulos";
        $sql.= " WHERE 1 = 1";
				
		$result = $this->exec_query($sql);
		
		return $result;
	}
    
    function update_situacion_modulos($codigo,$situacion) {
		$sql = "UPDATE conf_modulos SET mod_situacion = '$situacion' WHERE mod_codigo = $codigo;";
		return $sql;
	}
		
}

?>