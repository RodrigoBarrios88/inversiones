<?php 
include_once('../html_fns.php');
require_once("../recursos/mandrill/src/Mandrill.php"); //--correos
require_once("../../CONFIG/constructor.php");
//////////////////---- Otros Maestros -----/////////////////////////////////////////////
function tabla_usuarios($cui,$nombre,$acc){
	$ClsChat = new ClsChat();
	$result = $ClsChat->get_cm($cui,'',$nombre);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		if($acc == 1){
		$salida.= '<th class = "text-center" width = "50px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "130px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "60px">TIPO</td>';
		$salida.= '<th class = "text-center" width = "100px">T&Iacute;TULO</td>';
		$salida.= '<th class = "text-center" width = "100px">MAIL</td>';
		}else if($acc == 2){
		$salida.= '<th class = "text-center" class = "text-center" width = "30px"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th class = "text-center" width = "130px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "60px">TIPO</td>';
		$salida.= '<th class = "text-center" width = "100px">T&Iacute;TULO</td>';
		$salida.= '<th class = "text-center" width = "100px">MAIL</td>';
		}else{
		$salida.= '<th class = "text-center" width = "30px">No.</th>';
		$salida.= '<th class = "text-center" width = "130px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "60px">TIPO</td>';
		$salida.= '<th class = "text-center" width = "100px">T&Iacute;TULO</td>';
		$salida.= '<th class = "text-center" width = "100px">MAIL</td>';
		}
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >';
			if($acc == 1){
				//codigo
				$cui = $row["cm_cui"];
				$sit = $row["cm_situacion"];
				$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Buscar_Usuario(\''.$cui.'\');" title = "Editar Usuario" ><span class="glyphicon glyphicon-pencil"></span></button> ';
				if($sit == 1){
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Deshabilita_Usuario(\''.$cui.'\');" title = "inhabilitar Usuario" ><span class="fa fa-trash"></span></button> ';
				}else if($sit == 0){
				$salida.= '<button type="button" class="btn btn-success btn-outline btn-xs" onclick = "Habilita_Usuario(\''.$cui.'\');" title = "Habilitar Usuario" ><span class="fa fa-retweet"></span></button> ';
				}
			}else if($acc == 2){
				//codigo
				$cui = $row["cm_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsChat->encrypt($cui, $usu);
				$salida.= '<a class="btn btn-primary btn-xs" href="FRMasignacion.php?hashkey='.$hashkey.'" title = "Seleccionar Usuario" ><span class="fa fa-link"></span></a>';
			}else{
				$salida.= '<label>'.$i.'.</label>';
			}
			$salida.= '</td>';
			//CUI
			$cui = $row["cm_cui"];
			//$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nombre = utf8_decode($row["cm_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//Tipo
			$tipo = $row["usu_tipo"];
			$tipo = ($tipo == 1)?"Autoridad":"Maestro";
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//titulo
			$titulo = utf8_decode($row["cm_titulo"]);
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//correo
			$mail = $row["cm_mail"];
			$salida.= '<td class = "text-left">'.$mail.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
		$i--;
		$salida.= '</table>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}

?>