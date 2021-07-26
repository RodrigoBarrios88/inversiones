<?php 
include_once('../html_fns.php');

//////////////////---- Otros Alumnos -----/////////////////////////////////////////////
function tabla_encuestas($cod,$target,$tipo_target,$destinatarios){
	$ClsInfo = new ClsEncuesta();
    $result = $ClsInfo->get_encuesta($cod,$target,$tipo_target,$destinatarios);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "100px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "150px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "100px">FECHA LIMITE</td>';
			$salida.= '<th class = "text-center" width = "150px">TIPO DE DESTINATATIOS</td>';
			$salida.= '<th width = "20px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["enc_codigo"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsInfo->encrypt($cod, $usu);
			$sit = $row["enc_situacion"];
			$salida.= '<td class = "text-center" >';
			if($sit == 1){
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Encuesta('.$cod.')" title = "Editar Encuesta" > <span class="fa fa-edit"></span> </button> &nbsp;&nbsp; ';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="window.location=\'FRMmodtarget.php?hashkey='.$hashkey.'\'" title = "Editar Participantes" > <span class="fa fa-group"></span> </button> &nbsp;&nbsp; ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "ConfirmEliminar('.$cod.');" title = "Eliminar Encuesta" > <span class="fa fa-trash-o"></span> </button> &nbsp;&nbsp; ';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "ConfirmCerrar('.$cod.');" title = "Cerrar Encuesta" > <span class="fa fa-lock"></span> </button>';
			}else{
			$salida.= '<button type="button" class="btn btn-default btn-xs" disabled > <span class="fa fa-edit"></span> </button> &nbsp;&nbsp; ';
			$salida.= '<button type="button" class="btn btn-default btn-xs" disabled > <span class="fa fa-group"></span> </button> &nbsp;&nbsp; ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" disabled > <span class="fa fa-trash-o"></span> </button> &nbsp;&nbsp; ';
			$salida.= '<button type="button" class="btn btn-success btn-xs" disabled > <span class="fa fa-lock"></span> </button>';
			}
			$salida.= '</td>';
			//nombre
			$titulo = trim(utf8_decode($row["enc_titulo"]));
			$salida.= '<td class = "text-center">'.$titulo.'</td>';
			//fecha inicia
			$feclimit = trim($row["enc_fecha_limite"]);
			$feclimit = cambia_fechaHora($feclimit);
			$salida.= '<td class = "text-center">'.$feclimit.'</td>';
			//fecha finaliza
			$dest = trim($row["enc_destinatarios"]);
			switch($dest){
				case 1: $destinatarios = "DIRECTORES O AUTORIDADES"; break;
				case 2: $destinatarios = "MAESTROS"; break;
				case 3: $destinatarios = "PADRES"; break;
				case 4: $destinatarios = "MONITORES"; break;
				case 5: $destinatarios = "ALUMNOS"; break;
			}
			$salida.= '<td class = "text-center">'.$destinatarios.'</td>';
			//--
			$cod = $row["enc_codigo"];
			$sit = $row["enc_situacion"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsInfo->encrypt($cod, $usu);
			$salida.= '<td class = "text-center" >';
			if($sit == 1){
				$salida.= '<a type="button" class="btn btn-primary btn-xs" href="FRMpreguntas.php?hashkey='.$hashkey.'" target = "_blank" title = "Editar Preguntas" ><span class="fa fa-plus"></span> <span class="fa fa-question"></span></a>';
			}else{
				$salida.= '<a type="button" class="btn btn-primary btn-xs" disabled ><span class="fa fa-plus"></span> <span class="fa fa-question"></span></a>';
			}
			$salida.= '</td>';
				
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






function tabla_preguntas($codigo,$encuesta){
	$ClsInfo = new ClsEncuesta();
    $result = $ClsInfo->get_pregunta($codigo,$encuesta);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "250px">PREGUNTA</td>';
			$salida.= '<th class = "text-center" width = "150px">TIPO DE RESPUESTA</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["pre_codigo"];
			$encuesta = $row["pre_encuesta"];
            $salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Pregunta('.$codigo.','.$encuesta.')" title = "Editar Pregunta" > <span class="fa fa-edit"></span> </button> &nbsp;&nbsp; ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "Eliminar_Pregunta('.$codigo.','.$encuesta.');" title = "Eliminar Pregunta" > <span class="fa fa-trash-o"></span> </button> ';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//nombre
			$desc = trim(utf8_decode($row["pre_descripcion"]));
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//tipo
			$tipo = trim($row["pre_tipo"]);
			switch($tipo){
				case 1: $tipo_pregunta = "PUNTUACI&Oacute;N (1-5)"; break;
				case 2: $tipo_pregunta = "VERDADERO Y FALSO"; break;
				case 3: $tipo_pregunta = "ABRIETA"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo_pregunta.'</td>';
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




function tabla_resultados_encuestas(){
	$ClsInfo = new ClsEncuesta();
    $result = $ClsInfo->get_encuesta($cod,$target,$tipo_target,$destinatarios);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "150px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "100px">FECHA LIMITE</td>';
			$salida.= '<th class = "text-center" width = "150px">TIPO DE DESTINATATIOS</td>';
			$salida.= '<th width = "20px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["enc_codigo"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsInfo->encrypt($cod, $usu);
			$sit = $row["enc_situacion"];
			//nombre
			$titulo = trim(utf8_decode($row["enc_titulo"]));
			$salida.= '<td class = "text-center">'.$titulo.'</td>';
			//fecha inicia
			$feclimit = trim($row["enc_fecha_limite"]);
			$feclimit = cambia_fechaHora($feclimit);
			$salida.= '<td class = "text-center">'.$feclimit.'</td>';
			//fecha finaliza
			$dest = trim($row["enc_destinatarios"]);
			switch($dest){
				case 1: $destinatarios = "DIRECTORES O AUTORIDADES"; break;
				case 2: $destinatarios = "MAESTROS"; break;
				case 3: $destinatarios = "PADRES"; break;
				case 4: $destinatarios = "MONITORES"; break;
				case 5: $destinatarios = "ALUMNOS"; break;
			}
			$salida.= '<td class = "text-center">'.$destinatarios.'</td>';
			//--
			$cod = $row["enc_codigo"];
			$sit = $row["enc_situacion"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsInfo->encrypt($cod, $usu);
			$btn = ($sit == 2)?"success":"default";
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-'.$btn.' btn-xs" href="CPREPORTES/GRAPHresultados.php?hashkey='.$hashkey.'" target = "_blank" title = "Ver Resultados de la Encuesta" ><span class="fa fa-bar-chart-o"></span></a>';
			$salida.= '</td>';
				
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