<?php 
include_once('../../PADRES/html_fns.php');

function Montos_Contratos($nivel){
	
	switch($nivel){
		case 1:
			$Montos = array(
				"INSCRIPCION" => "460",
				"COLEGIATURA" => "910.00",
				"COMPLEMENTARIO" => "0"
			); break;
		case 2:
			$Montos = array(
				"INSCRIPCION" => "575",
				"COLEGIATURA" => "1165.00",
				"COMPLEMENTARIO" => "0"
			); break;
		case 3:
			$Montos = array(
				"INSCRIPCION" => "661",
				"COLEGIATURA" => "1368.00",
				"COMPLEMENTARIO" => "0"
			); break;
		case 4:
			$Montos = array(
				"INSCRIPCION" => "675",
				"COLEGIATURA" => "1408.00",
				"COMPLEMENTARIO" => "0"
			); break;
	}
	
	return $Montos;
}



function Montos_Libros($nivel,$grado){
	///////////////// NOTA ////////////////
	// Las cantidades deben de estar entre "" para que se interpreten como string a la hora de partir enteros y decimales ///
	// esto ayuda a leer los decimales exactos y no simplificados al convertir en letras. Ejemplo ".80" se leera OCHENTA y no OCHO //
	
	if($nivel == 1){
		switch($grado){
			case 1:
				$Montos = array(
					1 => "337.00",
					2 => "337.00",
					3 => "336.00"
				); break;
			case 2:
				$Montos = array(
					1 => "317.00",
					2 => "317.00",
					3 => "317.00"
				); break;
			case 3:
				$Montos = array(
					1 => "273.00",
					2 => "273.00",
					3 => "273.00"
				); break;
			case 4:
				$Montos = array(
					1 => "310.00",
					2 => "310.00",
					3 => "310.00"
				); break;
		}
	}else if($nivel == 2){
		switch($grado){
			case 1:
				$Montos = array(
					1 => "227.00",
					2 => "227.00",
					3 => "227.00"
				); break;
			case 2:
				$Montos = array(
					1 => "227.00",
					2 => "227.00",
					3 => "227.00"
				); break;
			case 3:
				$Montos = array(
					1 => "227.00",
					2 => "227.00",
					3 => "227.00"
				); break;
			case 4:
				$Montos = array(
					1 => "203.00",
					2 => "203.00",
					3 => "203.00"
				); break;
			case 5:
				$Montos = array(
					1 => "203.00",
					2 => "203.00",
					3 => "203.00"
				); break;
		}
	}else if($nivel == 3){
		switch($grado){
			case 1:
				$Montos = array(
					1 => "203.00",
					2 => "203.00",
					3 => "203.00"
				); break;
			case 2:
				$Montos = array(
					1 => "203.00",
					2 => "203.00",
					3 => "203.00"
				); break;
			case 3:
				$Montos = array(
					1 => "203.00",
					2 => "203.00",
					3 => "203.00"
				); break;
		}
	}else if($nivel == 4){
		switch($grado){
			case 1:
				$Montos = array(
					1 => "203.00",
					2 => "203.00",
					3 => "203.00"
				); break;
			case 2:
				$Montos = array(
					1 => "203.00",
					2 => "203.00",
					3 => "203.00"
				); break;
			case 3:
				$Montos = array(
					1 => "203.00",
					2 => "203.00",
					3 => "203.00"
				); break;
		}
	}
	
	return $Montos;
}




?>