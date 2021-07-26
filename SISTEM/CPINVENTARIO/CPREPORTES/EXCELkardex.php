<?php
include_once("html_fns_reportes.php");
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//post
	$barc = trim($_REQUEST["barc"]);
	$suc = trim($_REQUEST["suc"]);
	$gru = trim($_REQUEST["gru"]);
	$art = trim($_REQUEST["art"]);
	
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=kardex.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	//--
			
	$ClsArt = new ClsArticulo();
	$bandera = false;
	if($barc != ""){ 
		$result = $ClsArt->get_articulo('','','','','','','',$barc);
		if(is_array($result)){
			foreach($result as $row){
				$art = $row["art_codigo"];
				$gru = $row["art_grupo"];
			}
		}
		$bandera = true;
	}else if($art != "" && $gru != ""){
		$bandera = true;
	}
	
	if($bandera == true){
	

		echo "<p><b>Movimientos:</b></p>";
			echo rep_tabla_tarjeta_a($art,$gru,$suc); 
		echo "<p><b>Existencias:</b></p>";
			echo rep_tabla_tarjeta_b($art,$gru,$suc); 

	}else{
		echo "<p><b>No existe resultado específico para este criterio de búsqueda.... </b></p>";
	}
?>