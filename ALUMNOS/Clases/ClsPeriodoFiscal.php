<?php
require_once ("ClsConex.php");

class ClsPeriodoFiscal extends ClsConex{
    var $anio;
	var $periodo;
	
	function __construct(){
		
		if ($_SESSION["periodo"] == "") {
            $codigo = $this->get_periodo_activo();
            $this->periodo = $codigo;
            $this->anio = $this->get_anio_periodo($codigo);
        }else{
            $this->periodo = $_SESSION["periodo"];
        }
	}	
   
//---------- PENSUM ---------//
    function get_periodo($codigo,$anio = '',$sit = ''){
		$anio = trim($anio);
		
        $sql= "SELECT *, CONCAT(per_descripcion,' - ',per_anio) as per_descripcion_completa";
		$sql.= " FROM fin_periodo_fiscal";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			$sql.= " AND per_codigo = $codigo"; 
		}
		if(strlen($anio)>0) { 
			$sql.= " AND per_anio = $anio"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND per_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY per_anio ASC, per_codigo ASC, per_situacion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_periodo($codigo,$anio = '',$sit = ''){
		$anio = trim($anio);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM fin_periodo_fiscal";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			$sql.= " AND per_codigo = $codigo"; 
		}
		if(strlen($anio)>0) { 
			$sql.= " AND per_anio = $anio"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND per_situacion IN($sit)";  
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_periodo($codigo,$descripcion,$anio){
		$descripcion = trim($descripcion);
		
		$sql = "INSERT INTO fin_periodo_fiscal ";
		$sql.= " VALUES ($codigo,'$descripcion',$anio,0,1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_periodo($codigo,$descripcion,$anio){
		$descripcion = trim($descripcion);
		
		$sql = "UPDATE fin_periodo_fiscal SET ";
		$sql.= "per_descripcion = '$descripcion',"; 
		$sql.= "per_anio = $anio"; 
		
		$sql.= " WHERE per_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_periodo($codigo,$sit){
		
		$sql = "UPDATE fin_periodo_fiscal SET ";
		$sql.= "per_situacion = $sit"; 		
		$sql.= " WHERE per_codigo = $codigo;"; 	
		
		return $sql;
	}
	
	
	function cambia_periodo_activo($codigo){
		//--inactiva a todos
		$sql = "UPDATE fin_periodo_fiscal SET ";
		$sql.= "per_activo = 0"; 
		$sql.= " WHERE 1 = 1;"; 
		//--activa al elegido
		$sql.= "UPDATE fin_periodo_fiscal SET ";
		$sql.= "per_activo = 1"; 
		$sql.= " WHERE per_codigo = $codigo;"; 	
		
		return $sql;
	}

	
	function max_periodo() {
		
        $sql = "SELECT max(per_codigo) as max ";
		$sql.= " FROM fin_periodo_fiscal";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	function get_periodo_activo() {
		
        $sql = "SELECT per_codigo ";
		$sql.= " FROM fin_periodo_fiscal";
		$sql.= " WHERE per_activo = 1";
		$sql.= " LIMIT 0,1";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$activo = $row["per_codigo"];
			}
		}else{
			$activo = 0;
		}
		//echo $sql;
		return $activo;
	}
	
	function get_anio_periodo($codigo) {
		
        $sql = "SELECT per_anio ";
		$sql.= " FROM fin_periodo_fiscal";
		$sql.= " WHERE per_codigo = $codigo"; 
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$anio = $row["per_anio"];
			}
		}
		//echo $sql;
		return $anio;
	}
    
    function get_periodo_anio($anio) {
		
        $sql = "SELECT per_codigo ";
		$sql.= " FROM fin_periodo_fiscal";
		$sql.= " WHERE per_anio = $anio";
        $sql.= " AND per_situacion = 1";
		$sql.= " LIMIT 0,1";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$periodo = $row["per_codigo"];
			}
		}
		//echo $sql;
		return $periodo;
	}
    
    
    function get_periodo_pensum($pensum) {
		
        $sql = "SELECT per_codigo ";
		$sql.= " FROM fin_periodo_fiscal, academ_pensum";
		$sql.= " WHERE per_anio = pen_anio";
        $sql.= " AND pen_codigo = $pensum";
        $sql.= " AND per_situacion = 1";
		$sql.= " LIMIT 0,1";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$periodo = $row["per_codigo"];
			}
		}
		//echo $sql."<br>";
		return $periodo;
	}
    
    function get_pensum_periodo($codigo) {
		
        $sql = "SELECT pen_codigo ";
		$sql.= " FROM fin_periodo_fiscal, academ_pensum";
		$sql.= " WHERE per_anio = pen_anio";
        $sql.= " AND per_codigo = $codigo";
        $sql.= " AND pen_situacion = 1";
		$sql.= " LIMIT 0,1";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$pensum = $row["pen_codigo"];
			}
		}
		//echo $sql."<br>";
		return $pensum;
	}

}	
?>