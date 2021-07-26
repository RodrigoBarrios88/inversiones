<?php
require_once ("ClsConex.php");

class ClsPenal extends ClsConex{
   
//---------- Laboral Anterior ---------//
    function get_penal($personal) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM rrhh_penal";
		$sql.= " WHERE pen_personal = $personal"; 
		$sql.= " ORDER BY pen_personal ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
			
	function insert_penal($pen_personal,$pen_detenido,$pen_motivo_detenido,$pen_donde_detenido,$pen_cuando_detenido,$pen_porque_detenido,$pen_fec_libertad,$pen_arraigado,$pen_motivo_arraigo,$pen_donde_arraigo,$pen_cuando_arraigo) {
	     //-- UPPERCASE
			$pen_detenido = trim($pen_detenido);
			$pen_motivo_detenido = trim($pen_motivo_detenido);
			$pen_donde_detenido = trim($pen_donde_detenido);
			$pen_cuando_detenido = trim($pen_cuando_detenido);
			$pen_porque_detenido = trim($pen_porque_detenido);
			$pen_arraigado = trim($pen_arraigado);
			$pen_motivo_arraigo = trim($pen_motivo_arraigo);
			$pen_donde_arraigo = trim($pen_donde_arraigo);
			$pen_cuando_arraigo = trim($pen_cuando_arraigo);
		//--
		$sql = "INSERT INTO rrhh_penal ";
		$sql.= "VALUES ('$pen_personal','$pen_detenido','$pen_motivo_detenido','$pen_donde_detenido','$pen_cuando_detenido','$pen_porque_detenido','$pen_fec_libertad','$pen_arraigado','$pen_motivo_arraigo','$pen_donde_arraigo','$pen_cuando_arraigo'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_penal($pen_personal,$pen_detenido,$pen_motivo_detenido,$pen_donde_detenido,$pen_cuando_detenido,$pen_porque_detenido,$pen_fec_libertad,$pen_arraigado,$pen_motivo_arraigo,$pen_donde_arraigo,$pen_cuando_arraigo) {
	     //-- UPPERCASE
			$pen_detenido = trim($pen_detenido);
			$pen_motivo_detenido = trim($pen_motivo_detenido);
			$pen_donde_detenido = trim($pen_donde_detenido);
			$pen_cuando_detenido = trim($pen_cuando_detenido);
			$pen_porque_detenido = trim($pen_porque_detenido);
			$pen_arraigado = trim($pen_arraigado);
			$pen_motivo_arraigo = trim($pen_motivo_arraigo);
			$pen_donde_arraigo = trim($pen_donde_arraigo);
			$pen_cuando_arraigo = trim($pen_cuando_arraigo);
		//--
		$sql = "UPDATE rrhh_penal SET";
		$sql.= " pen_detenido = '$pen_detenido',";
		$sql.= " pen_motivo_detenido = '$pen_motivo_detenido',";
		$sql.= " pen_donde_detenido = '$pen_donde_detenido',";
		$sql.= " pen_cuando_detenido = '$pen_cuando_detenido',";
		$sql.= " pen_porque_detenido = '$pen_porque_detenido',";
		$sql.= " pen_fec_libertad = '$pen_fec_libertad',";
		$sql.= " pen_arraigado = '$pen_arraigado',";
		$sql.= " pen_motivo_arraigo = '$pen_motivo_arraigo',";
		$sql.= " pen_donde_arraigo = '$pen_donde_arraigo',";
		$sql.= " pen_cuando_arraigo = '$pen_cuando_arraigo' ";
		
		$sql.= "WHERE pen_personal = '$pen_personal'; ";
		//echo $sql;
		return $sql;
	}
	
	function delete_penal($personal){
		$sql = "DELETE FROM rrhh_penal  ";
		$sql.= " WHERE pen_personal = $personal; "; 	
		return $sql;
	}
	
}	
?>
