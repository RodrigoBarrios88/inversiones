<?php
require_once ("ClsConex.php");

class ClsPlanillaAsignaciones extends ClsConex{
   
//---------- HORAS LABORADAS ---------//
	//---------- Configuracion Horas Laboradas ---------//
    function get_configuracion_horas($persona) {
		
      $sql= "SELECT * ";
      $sql.= " FROM rrhh_personal, sal_configuracion_horas, fin_moneda";
      $sql.= " WHERE conf_moneda = mon_id";
      $sql.= " AND conf_personal = per_dpi"; 
      if(strlen($persona)>0) { 
         $sql.= " AND conf_personal = $persona"; 
      }
      $sql.= " ORDER BY conf_personal ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_configuracion_horas($persona) {
		
	    $sql= "SELECT COUNT(conf_personal) as total ";
		$sql.= " FROM sal_configuracion_horas, fin_moneda";
		$sql.= " WHERE conf_moneda = mon_id"; 
		if(strlen($persona)>0) { 
			$sql.= " AND conf_personal = $persona"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
    
    function get_personal_configuracion_horas($personal,$tipo) {
		
	    $sql= "SELECT * ";
        $sql.= " FROM sal_personal_tipo_nomina,sal_tipo_nomina,rrhh_personal,sal_configuracion_horas,fin_moneda";
		$sql.= " WHERE ptn_personal = per_dpi";
		$sql.= " AND ptn_tipo_nomina = tip_codigo";
        $sql.= " AND conf_personal = per_dpi"; 
        $sql.= " AND conf_moneda = mon_id"; 
		if(strlen($personal)>0) { 
			  $sql.= " AND ptn_personal = '$personal'";
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND ptn_tipo_nomina = '$tipo'";
		}
		$sql.= " ORDER BY per_nombres ASC, per_apellidos ASC, per_dpi ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
			
	function insert_configuracion_horas($persona,$cant_regulares,$monto_regulares,$cant_extras,$monto_extras,$moneda) {
	    //-- UPPERCASE
			$desc = trim($desc);
		//--
		$sql = "INSERT INTO sal_configuracion_horas ";
		$sql.= "VALUES ($persona,'$cant_regulares','$monto_regulares','$cant_extras','$monto_extras','$moneda') ";
        $sql.= " ON DUPLICATE KEY UPDATE";
		$sql.= " conf_cantidad_regulares = '$cant_regulares',";
		$sql.= " conf_monto_regulares = '$monto_regulares',";
		$sql.= " conf_cantidad_extras = '$cant_extras',";
		$sql.= " conf_monto_extras = '$monto_extras',";
		$sql.= " conf_moneda = '$moneda'; ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_configuracion_horas($persona) {
		
        $sql = "DELETE FROM sal_configuracion_horas";
        $sql.= " WHERE conf_personal = '$persona'; ";
		//echo $sql;
		return $max;
	}	
		
    
	//---------- Horas Laboradas ---------//
   function get_horas_laboradas($nomina,$persona) {
		
	   $sql= "SELECT * ";
		$sql.= " FROM rrhh_personal, sal_horas_laboradas, fin_moneda";
		$sql.= " WHERE hor_moneda = mon_id";
      $sql.= " AND hor_personal = per_dpi";
      if(strlen($nomina)>0) { 
			$sql.= " AND hor_nomina = $nomina"; 
		}
		if(strlen($persona)>0) { 
			$sql.= " AND hor_personal = $persona"; 
		}
		$sql.= " ORDER BY hor_nomina ASC, per_apellidos ASC, per_nombres ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_horas_laboradas($nomina,$persona) {
		
	   $sql= "SELECT COUNT(*) as total ";
		$sql.= " FROM rrhh_personal, sal_horas_laboradas, fin_moneda";
		$sql.= " WHERE hor_moneda = mon_id";
      $sql.= " AND hor_personal = per_dpi";
      if(strlen($nomina)>0) { 
			$sql.= " AND hor_nomina = $nomina"; 
		}
		if(strlen($persona)>0) { 
			$sql.= " AND hor_personal = $persona"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_horas_laboradas($nomina,$persona,$cant_regulares,$monto_regulares,$cant_extras,$monto_extras,$moneda,$tcambio) {
	   //-- UPPERCASE
			$desc = trim($desc);
		//--
		$sql = "INSERT INTO sal_horas_laboradas ";
		$sql.= "VALUES ('$nomina','$persona','$cant_regulares','$monto_regulares','$cant_extras','$monto_extras','$moneda','$tcambio') ";
      $sql.= " ON DUPLICATE KEY UPDATE";
		$sql.= " hor_cantidad_regulares = '$cant_regulares',";
		$sql.= " hor_monto_regulares = '$monto_regulares',";
		$sql.= " hor_cantidad_extras = '$cant_extras',";
		$sql.= " hor_monto_extras = '$monto_extras',";
		$sql.= " hor_moneda = '$moneda', ";
      $sql.= " hor_cambio = '$tcambio'; ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_horas_laboradas($nomina,$persona) {
		
      $sql = "DELETE FROM sal_horas_laboradas ";
      $sql.= " WHERE hor_nomina = '$nomina' ";
		$sql.= " AND hor_personal = '$persona'; ";
		//echo $sql;
		return $sql;
	}	
		
	
//---------- BONIFICACIONES ---------//
	//---------- Base de Bonificaciones generales ---------//
    function get_base_bonificaciones($codigo,$cui,$sit) {
		
	   $sql= "SELECT * ";
		$sql.= " FROM sal_base_bonificaciones, fin_moneda";
		$sql.= " WHERE  bas_moneda = mon_id"; 
		if(strlen($codigo)>0) { 
			$sql.= " AND bas_codigo = $codigo"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND bas_personal = '$cui'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND bas_situacion = $sit"; 
		}
		$sql.= " ORDER BY bas_personal ASC, bas_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_base_bonificaciones($codigo,$cui,$sit) {
		
	    $sql= "SELECT COUNT(bas_codigo) as total ";
		$sql.= " FROM sal_base_bonificaciones, fin_moneda";
		$sql.= " WHERE  bas_moneda = mon_id"; 
		if(strlen($codigo)>0) { 
			$sql.= " AND bas_codigo = $codigo"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND bas_personal = '$cui'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND bas_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_base_bonificaciones($codigo,$cui,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "INSERT INTO sal_base_bonificaciones ";
		$sql.= "VALUES ($codigo,'$cui','$monto','$moneda','$tcambio','$desc',1); ";
		//echo $sql;
		return $sql;
	}
	
	function update_base_bonificaciones($codigo,$cui,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "UPDATE sal_base_bonificaciones SET";
		$sql.= " bas_monto = '$monto',";
		$sql.= " bas_moneda = '$moneda',";
		$sql.= " bas_tipo_cambio = '$tcambio',";
		$sql.= " bas_descripcion = '$desc'";
		
		$sql.= " WHERE bas_codigo = '$codigo' ";
		$sql.= " AND bas_personal = '$cui'; ";
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_base_bonificaciones($codigo,$cui) {
		
        $sql = "UPDATE sal_base_bonificaciones SET bas_situacion = 0 ";
        $sql.= " WHERE bas_codigo = '$codigo' ";
		$sql.= " AND bas_personal = '$cui'; ";
		//echo $sql;
		return $sql;
	}	
		
	function max_base_bonificaciones($cui) {
		
        $sql = "SELECT max(bas_codigo) as max ";
		$sql.= " FROM sal_base_bonificaciones";
        $sql.= " WHERE bas_personal = '$cui'; ";
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	//---------- Bonificaciones generales ---------//
    function get_bonificaciones_generales($nomina,$cui,$codigo) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM sal_bonificaciones_generales, fin_moneda";
		$sql.= " WHERE  bon_moneda = mon_id"; 
		if(strlen($nomina)>0) { 
			$sql.= " AND bon_nomina = $nomina"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND bon_personal = '$cui'"; 
		}
		if(strlen($codigo)>0) { 
			$sql.= " AND bon_codigo = $codigo"; 
		}
		$sql.= " ORDER BY bon_nomina, bon_personal ASC, bon_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_bonificaciones_generales($nomina,$cui,$codigo) {
		
	    $sql= "SELECT COUNT(bon_codigo) as total ";
		$sql.= " FROM sal_bonificaciones_generales";
		$sql.= " WHERE  1 = 1"; 
		if(strlen($nomina)>0) { 
			$sql.= " AND bon_nomina = $nomina"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND bon_personal = '$cui'"; 
		}
		if(strlen($codigo)>0) { 
			$sql.= " AND bon_codigo = $codigo"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_bonificaciones_generales($nomina,$cui,$codigo,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "INSERT INTO sal_bonificaciones_generales ";
		$sql.= "VALUES ($nomina,'$cui','$codigo','$monto','$moneda','$tcambio','$desc'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_bonificaciones_generales($nomina,$cui,$codigo,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "UPDATE sal_bonificaciones_generales SET";
		$sql.= " bon_monto = '$monto',";
		$sql.= " bon_moneda = '$moneda',";
		$sql.= " bon_tipo_cambio = '$tcambio',";
		$sql.= " bon_descripcion = '$desc'";
		
		$sql.= " WHERE bon_codigo = '$codigo' ";
		$sql.= " AND bon_personal = '$cui' ";
		$sql.= " AND bon_nomina = '$nomina'; ";
		//echo $sql;
		return $sql;
	}
	
	function delete_bonificaciones_generales($nomina,$cui,$codigo) {
		
        $sql = "DELETE FROM sal_bonificaciones_generales ";
        $sql.= " WHERE bon_codigo = '$codigo' ";
		$sql.= " AND bon_personal = '$cui' ";
		$sql.= " AND bon_nomina = '$nomina'; ";
		//echo $sql;
		return $sql;
	}	
		
	function max_bonificaciones_generales($nomina,$cui) {
		
        $sql = "SELECT max(bon_codigo) as max ";
		$sql.= " FROM sal_bonificaciones_generales";
        $sql.= " WHERE bon_personal = '$cui' ";
		$sql.= " AND bon_nomina = '$nomina'; ";
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
	//---------- Bonificaciones Emergentes ---------//
    function get_bonificaciones_emeregentes($nomina,$cui,$codigo) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM sal_bonificaciones_emeregentes, fin_moneda";
		$sql.= " WHERE  bon_moneda = mon_id"; 
		if(strlen($nomina)>0) { 
			$sql.= " AND bon_nomina = '$nomina'"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND bon_personal = '$cui'"; 
		}
		if(strlen($codigo)>0) {
			$sql.= " AND bon_codigo = '$codigo'"; 
		}
		$sql.= " ORDER BY bon_nomina, bon_personal ASC, bon_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_bonificaciones_emeregentes($nomina,$cui,$codigo) {
		
	    $sql= "SELECT COUNT(bon_codigo) as total ";
		$sql.= " FROM sal_bonificaciones_emeregentes, fin_moneda";
		$sql.= " WHERE bon_moneda = mon_id"; 
		if(strlen($nomina)>0) { 
			$sql.= " AND bon_nomina = '$nomina'"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND bon_personal = '$cui'"; 
		}
		if(strlen($codigo)>0) { 
			$sql.= " AND bon_codigo = '$codigo'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_bonificaciones_emeregentes($nomina,$cui,$codigo,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "INSERT INTO sal_bonificaciones_emeregentes ";
		$sql.= "VALUES ($nomina,'$cui','$codigo','$monto','$moneda','$tcambio','$desc'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_bonificaciones_emeregentes($nomina,$cui,$codigo,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "UPDATE sal_bonificaciones_emeregentes SET";
		$sql.= " bon_monto = '$monto',";
		$sql.= " bon_moneda = '$moneda',";
		$sql.= " bon_tipo_cambio = '$tcambio',";
		$sql.= " bon_descripcion = '$desc'";
		
		$sql.= " WHERE bon_codigo = '$codigo' ";
		$sql.= " AND bon_personal = '$cui' ";
		$sql.= " AND bon_nomina = '$nomina'; ";
		//echo $sql;
		return $sql;
	}
	
	function delete_bonificaciones_emeregentes($nomina,$cui,$codigo) {
		
        $sql = "DELETE FROM sal_bonificaciones_emeregentes ";
        $sql.= " WHERE bon_codigo = '$codigo' ";
		$sql.= " AND bon_personal = '$cui' ";
		$sql.= " AND bon_nomina = '$nomina'; ";
		//echo $sql;
		return $sql;
	}	
		
	function max_bonificaciones_emeregentes($nomina,$cui) {
		
        $sql = "SELECT max(bon_codigo) as max ";
		$sql.= " FROM sal_bonificaciones_emeregentes";
        $sql.= " WHERE bon_personal = '$cui' ";
		$sql.= " AND bon_nomina = '$nomina'; ";
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
//---------- COMISIONES ---------//
	//---------- Comisiones ---------//
    function get_comisiones($nomina,$cui,$codigo) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM sal_comisiones, fin_moneda";
		$sql.= " WHERE  com_moneda = mon_id"; 
		if(strlen($nomina)>0) { 
			$sql.= " AND com_nomina = $nomina"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND com_personal = '$cui'"; 
		}
		if(strlen($codigo)>0) { 
			$sql.= " AND com_codigo = $codigo"; 
		}
		$sql.= " ORDER BY com_nomina, com_personal ASC, com_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_comisiones($nomina,$cui,$codigo) {
		
	    $sql= "SELECT COUNT(com_codigo) as total ";
		$sql.= " FROM sal_comisiones, fin_moneda";
		$sql.= " WHERE  com_moneda = mon_id"; 
		if(strlen($nomina)>0) { 
			$sql.= " AND com_nomina = $nomina"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND com_personal = '$cui'"; 
		}
		if(strlen($codigo)>0) { 
			$sql.= " AND com_codigo = $codigo"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_comisiones($nomina,$cui,$codigo,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "INSERT INTO sal_comisiones ";
		$sql.= "VALUES ($nomina,'$cui','$codigo','$monto','$moneda','$tcambio','$desc'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_comisiones($nomina,$cui,$codigo,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "UPDATE sal_comisiones SET";
		$sql.= " com_monto = '$monto',";
		$sql.= " com_moneda = '$moneda',";
		$sql.= " com_tipo_cambio = '$tcambio',";
		$sql.= " com_descripcion = '$desc'";
		
		$sql.= " WHERE com_codigo = '$codigo' ";
		$sql.= " AND com_personal = '$cui' ";
		$sql.= " AND com_nomina = '$nomina'; ";
		//echo $sql;
		return $sql;
	}
	
	function delete_comisiones($nomina,$cui,$codigo) {
		
        $sql = "DELETE FROM sal_comisiones ";
        $sql.= " WHERE com_codigo = '$codigo' ";
		$sql.= " AND com_personal = '$cui' ";
		$sql.= " AND com_nomina = '$nomina'; ";
		//echo $sql;
		return $sql;
	}	
		
	function max_comisiones($nomina,$cui) {
		
        $sql = "SELECT max(com_codigo) as max ";
		$sql.= " FROM sal_comisiones";
        $sql.= " WHERE com_personal = '$cui' ";
		$sql.= " AND com_nomina = '$nomina'; ";
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	


//---------- DESCUENTOS ---------//
	//---------- Base de Descuentos ---------//
    function get_base_descuentos($codigo,$cui,$sit) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM sal_base_descuentos, fin_moneda";
		$sql.= " WHERE  bas_moneda = mon_id"; 
		if(strlen($codigo)>0) { 
			$sql.= " AND bas_codigo = $codigo"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND bas_personal = '$cui'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND bas_situacion = $sit"; 
		}
		$sql.= " ORDER BY bas_personal ASC, bas_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_base_descuentos($codigo,$cui,$sit) {
		
	    $sql= "SELECT COUNT(bas_codigo) as total ";
		$sql.= " FROM sal_base_descuentos, fin_moneda";
		$sql.= " WHERE  bas_moneda = mon_id"; 
		if(strlen($codigo)>0) { 
			$sql.= " AND bas_codigo = $codigo"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND bas_personal = '$cui'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND bas_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_base_descuentos($codigo,$cui,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "INSERT INTO sal_base_descuentos ";
		$sql.= "VALUES ($codigo,'$cui','$monto','$moneda','$tcambio','$desc',1); ";
		//echo $sql;
		return $sql;
	}
	
	function update_base_descuentos($codigo,$cui,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "UPDATE sal_base_descuentos SET";
		$sql.= " bas_monto = '$monto',";
		$sql.= " bas_moneda = '$moneda',";
		$sql.= " bas_tipo_cambio = '$tcambio',";
		$sql.= " bas_descripcion = '$desc'";
		
		$sql.= " WHERE bas_codigo = '$codigo' ";
		$sql.= " AND bas_personal = '$cui'; ";
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_base_descuentos($codigo,$cui) {
		
        $sql = "UPDATE sal_base_descuentos SET bas_situacion = 0 ";
        $sql.= " WHERE bas_codigo = '$codigo' ";
		$sql.= " AND bas_personal = '$cui'; ";
		//echo $sql;
		return $sql;
	}	
		
	function max_base_descuentos($cui) {
		
        $sql = "SELECT max(bas_codigo) as max ";
		$sql.= " FROM sal_base_descuentos";
        $sql.= " WHERE bas_personal = '$cui'; ";
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
    }

	//---------- Descuentos ---------//
    function get_descuentos($nomina,$cui,$codigo) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM sal_descuentos, fin_moneda";
		$sql.= " WHERE  des_moneda = mon_id"; 
		if(strlen($nomina)>0) { 
			$sql.= " AND des_nomina = $nomina"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND des_personal = $cui"; 
		}
		if(strlen($codigo)>0) { 
			$sql.= " AND des_codigo = $codigo"; 
		}
		$sql.= " ORDER BY des_nomina, des_personal ASC, des_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_descuentos($nomina,$cui,$codigo) {
		
	    $sql= "SELECT COUNT(des_codigo) as total ";
		$sql.= " FROM sal_descuentos, fin_moneda";
		$sql.= " WHERE  des_moneda = mon_id"; 
		if(strlen($nomina)>0) { 
			$sql.= " AND des_nomina = $nomina"; 
		}
		if(strlen($cui)>0) { 
			$sql.= " AND des_personal = $cui"; 
		}
		if(strlen($codigo)>0) { 
			$sql.= " AND des_codigo = $codigo"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_descuentos($nomina,$cui,$codigo,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "INSERT INTO sal_descuentos ";
		$sql.= "VALUES ($nomina,'$cui','$codigo','$monto','$moneda','$tcambio','$desc'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_descuentos($nomina,$cui,$codigo,$monto,$moneda,$tcambio,$desc) {
	    //-- UPPERCASE
		$desc = trim($desc);
		//--
		$sql = "UPDATE sal_descuentos SET";
		$sql.= " des_monto = '$monto',";
		$sql.= " des_moneda = '$moneda',";
		$sql.= " des_tipo_cambio = '$tcambio',";
		$sql.= " des_descripcion = '$desc'";
		
		$sql.= " WHERE des_codigo = '$codigo' ";
		$sql.= " AND des_personal = '$cui' ";
		$sql.= " AND des_nomina = '$nomina'; ";
		//echo $sql;
		return $sql;
	}
	
	function delete_descuentos($nomina,$cui,$codigo) {
		
        $sql = "DELETE FROM sal_descuentos ";
        $sql.= " WHERE des_codigo = '$codigo' ";
		$sql.= " AND des_personal = '$cui' ";
		$sql.= " AND des_nomina = '$nomina'; ";
		//echo $sql;
		return $sql;
	}	
		
	function max_descuentos($nomina,$cui) {
		
        $sql = "SELECT max(des_codigo) as max ";
		$sql.= " FROM sal_descuentos";
        $sql.= " WHERE des_personal = '$cui' ";
		$sql.= " AND des_nomina = '$nomina'; ";
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	


	
}	
?>
