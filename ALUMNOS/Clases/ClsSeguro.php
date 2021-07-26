<?php
require_once ("ClsConex.php");

class ClsSeguro extends ClsConex{
   
    function get_seguro($cui){
		
        $sql ="SELECT * ";
        $sql.=" FROM app_seguro";
        $sql.=" WHERE seg_alumno = '$cui'";
        $sql.=" ORDER BY seg_alumno ASC";
        //echo $sql;
        $result = $this->exec_query($sql);
        return $result;
	}
	
	function update_seguro($cui,$sino,$poliza,$aseguradora,$plan,$asegurado,$instrucciones,$comentarios){
	    $poliza = trim($poliza);
		$aseguradora = trim($aseguradora);
		$plan = trim($plan);
		$asegurado = trim($asegurado);
		$instrucciones = trim($instrucciones);
		$comentarios = trim($comentarios);
		
        $sql = "INSERT INTO app_seguro VALUES('$cui','$sino','$poliza','$aseguradora','$plan','$asegurado','$instrucciones','$comentarios')";
	    $sql.=" ON DUPLICATE KEY UPDATE ";
	    $sql.="seg_poliza = '$poliza',";
	    $sql.="seg_tiene_seguro = '$sino',";
	    $sql.="seg_aseguradora = '$aseguradora',";
	    $sql.="seg_plan = '$plan',";
	    $sql.="seg_asegurado_principal = '$asegurado',";
	    $sql.="seg_instrucciones = '$instrucciones',";
	    $sql.="seg_comentarios = '$comentarios';";
	   
		return $sql;
	}
    
    function modificar_campo($usuario,$campo,$valor,$cui){
		$valor = trim($valor);
		$fedit = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_seguro SET ";
		$sql.= "$campo = '$valor'"; 
		$sql.= " WHERE seg_alumno = '$cui'; "; 	
		
		return $sql;
	}
	
}	
?>
