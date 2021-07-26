<?php 
include_once('../html_fns.php');
//Push Notifications
include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');

//////////////////---- Otros Alumnos -----/////////////////////////////////////////////
function tabla_circular($cod,$target,$tipo){
	$ClsCir = new ClsCircular();
    $result = $ClsCir->get_circular($cod,$target,$tipo);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "40px"><span class="fa fa-cog"></span></th>';
		$salida.= '<th class = "text-center" width = "150px">T&Iacute;TULO</th>';
		$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N U OBSERVACIONES</th>';
		$salida.= '<th class = "text-center" width = "50px">FECHA PUBLICACI&Oacute;N</td>';
		$salida.= '<th class = "text-center" width = "40px"><span class="fa fa-cogs"></span></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["cir_codigo"];
            $salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group" data-toggle="buttons">';
					$salida.= '<button type="button" class="btn btn-default" onclick="abrir();xajax_Buscar_Circular('.$codigo.');" title = "Seleccionar Circular" ><i class="fa fa-edit"></i></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick="ConfirmEliminar('.$codigo.');" title = "Eliminar Circular" ><i class="fa fa-trash"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//titulo
			$titulo = trim(utf8_decode($row["cir_titulo"]));
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//desc
			$desc = trim(utf8_decode($row["cir_descripcion"]));
			$desc = nl2br($desc);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//fecha inicia
			$publicacion = trim($row["cir_fecha_publicacion"]);
			$publicacion = cambia_fechaHora($publicacion);
			$salida.= '<td class = "text-center">'.$publicacion.'</td>';
			//--
			$codigo = $row["cir_codigo"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsCir->encrypt($codigo, $usu);
			$documento = trim($row["cir_documento"]);
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group" data-toggle="buttons">';
					$salida.= '<button type="button" class="btn btn-default" onclick="window.location=\'FRMmodtarget.php?hashkey='.$hashkey.'\'" title = "Editar Participantes" ><i class="fa fa-group"></i></button> ';
					$salida.= '<button type="button" class="btn btn-primary" onclick="verDocumento(\''.$documento.'\');" title = "ver Circular" ><i class="fa fa-search"></i></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			//--	
			$salida.= '</tr>';
			$i++;
		}
		$i--;
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_circular_autorizacion($cod,$target,$tipo){
	$ClsCir = new ClsCircular();
    $result = $ClsCir->get_circular($cod,$target,$tipo,'',1);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cog"></span></th>';
		$salida.= '<th class = "text-center" width = "150px">T&Iacute;TULO</th>';
		$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N U OBSERVACIONES</th>';
		$salida.= '<th class = "text-center" width = "50px">FECHA PUBLICACI&Oacute;N</td>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//nombre
			$titulo = trim(utf8_decode($row["cir_titulo"]));
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//desc
			$desc = trim(utf8_decode($row["cir_descripcion"]));
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//fecha inicia
			$publicacion = trim($row["cir_fecha_publicacion"]);
			$publicacion = cambia_fechaHora($publicacion);
			$salida.= '<td class = "text-center">'.$publicacion.'</td>';
			//--
			$cod = $row["cir_codigo"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsCir->encrypt($cod, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-primary" href="FRMautorizaciones.php?hashkey='.$hashkey.'" title = "Revisar autorizaciones o confirmaciones de padres y encargados" ><span class="fa fa-group"></span></a> ';
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



function tabla_grados_secciones(){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsAul = new ClsAula();
	$pensum = $ClsPen->get_pensum_activo();
	
	$salida .= '<div class="list-group">';
	$salida .= '<span class="list-group-item active"> Niveles, Grados y Secciones </span>';
	$salida .= '<div class="list-group-item">';
	
	$result_nivel = $ClsPen->get_nivel($pensum,"",$sit);
	$count_secciones = 1;
	if(is_array($result_nivel)){
		$salida.= '<ul class="treeview">';
		$i=1;	
		foreach($result_nivel as $row){
			$salida.= '<li>';
			//No.
			$nivel = $row["niv_codigo"];
			$desc = utf8_decode($row["niv_descripcion"]);
			//$salida .= '<input type = "checkbox" name="NIV'.$i.'" id="NIV'.$i.'" value="'.$nivel.'" />';
			$salida .= ' NIVEL: '.$desc.' ';
			
				$salida.= '<ul>';
					/// inician grados
					$result_grados = $ClsPen->get_grado($pensum,$nivel);
					if(is_array($result_grados)){
						$j=1;	
						foreach($result_grados as $row_grado){
							$salida.= '<li>';
							//No.
							$grado = $row_grado["gra_codigo"];
							$desc = utf8_decode($row_grado["gra_descripcion"]);
							//$salida .= '<input type = "checkbox" name="GRA'.$j.'" id="GRA'.$j.'" value="'.$grado.'" onclick = "check_lista_multiple(\'GRA\');" />';
							$salida .= ' GRADO: '.$desc.' ';
							
										///inician Secciones
										$salida.= '<ul>';
											$result_secciones = $ClsPen->get_seccion($pensum,$nivel,$grado,'','',1);
											if(is_array($result_secciones)){
												$k=1;	
												foreach($result_secciones as $row_seccion){
													$salida.= '<li>';
													//descripcion
													$seccion = utf8_decode($row_seccion["sec_codigo"]);
													$desc = utf8_decode($row_seccion["sec_descripcion"]);
													$salida .= '<input type = "checkbox" name="grupos'.$count_secciones.'" id="grupos'.$count_secciones.'" value="'.$pensum.'.'.$nivel.'.'.$grado.'.'.$seccion.'" />';
													$salida .= ' SECCI&Oacute;N: '.$desc.' ';
													$salida.= '</li>';
													$k++;
													$count_secciones++;
												}
												$k--;
												$salida .= '<input type = "hidden" name="SECrows" id="SECrows" value="'.$k.'" />';
											}
										$salida.= '</ul>';
									///finalizan Secciones
								
							$salida.= '</li>'; ///finalizan Grado
							$j++;
						}
						$j--;
						$salida .= '<input type = "hidden" name="GRArows" id="GRArows" value="'.$j.'" />';
					}
				
				$salida.= '</ul>';
			$salida.= '</li>'; ///finalizan Nivel
			$i++;
		}
		$i--;
		$salida .= '<input type = "hidden" name="NIVrows" id="NIVrows" value="'.$i.'" />';
		$salida.= '</ul>';
		///finalizan Principal
	}
	
	$count_secciones--;//le quita la vuelta inicial
	$salida .= '<input type = "hidden" name="gruposrows" id="gruposrows" value="'.$count_secciones.'" />';
	$salida .= '</div>';
	$salida .= '</div>';
	
	return $salida;
}






function tabla_alumnos_autorizaciones($circular){
	$ClsCir = new ClsCircular();
	$result = $ClsCir->get_autorizacion_alumno($circular);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "150px">ALUMNO</td>';
			$salida.= '<th class = "text-center" width = "100px">Grado y Secci&oacute;n</td>';
			$salida.= '<th class = "text-center" width = "50px">AUTORIZACION</td>';
			$salida.= '<th class = "text-center" width = "50px">FECHA/REGISTRO</td>';
			$salida.= '<th class = "text-center" width = "150px">PADRE O ENCARGADO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//ID
			$id = utf8_decode($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$id.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//grado
			$grado_desc = utf8_decode($row["alu_grado"]);
			$seccion_desc = utf8_decode($row["alu_seccion"]);
			$salida.= '<td class = "text-left">'.$grado_desc.' Secci&oacute;n '.$seccion_desc.'</td>';
			//ape
			$aut = utf8_decode($row["aut_autoriza"]);
			$aut = ($aut == 1)?'<span class = "text-success">Autorizado</span>':'<span class = "text-danger">Denegado</span>';
			$salida.= '<td class = "text-center">'.$aut.'</td>';
			//fecha inicia
			$fecha = trim($row["aut_fecha_registro"]);
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//padre o encargado
			$padnom = utf8_decode($row["pad_nombre"]);
			$padape = utf8_decode($row["pad_apellido"]);
			$salida.= '<td class = "text-left">'.$padnom.' '.$padape.'</td>';
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



/////////////////////////////// CONFIRMACIONES DE LECTURA ///////////////////////////////////////////////

function tabla_circular_confirmacion(){
	$ClsCir = new ClsCircular();
    $result = $ClsCir->get_circular($cod,$target,$tipo,'');
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cog"></span></th>';
		$salida.= '<th class = "text-center" width = "150px">T&Iacute;TULO</th>';
		$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N U OBSERVACIONES</th>';
		$salida.= '<th class = "text-center" width = "50px">FECHA PUBLICACI&Oacute;N</td>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//nombre
			$titulo = trim(utf8_decode($row["cir_titulo"]));
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//desc
			$desc = trim(utf8_decode($row["cir_descripcion"]));
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//fecha inicia
			$publicacion = trim($row["cir_fecha_publicacion"]);
			$publicacion = cambia_fechaHora($publicacion);
			$salida.= '<td class = "text-center">'.$publicacion.'</td>';
			//--
			$cod = $row["cir_codigo"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsCir->encrypt($cod, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-success" href="FRMleidos.php?hashkey='.$hashkey.'" title = "Listado de Usuarios y su lectura" ><i class="fa fa-group"></i> <i class="fa fa-eye"></i></a> ';
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


function tabla_lectura($push_type,$type_id){
	$ClsPush = new ClsPushup();
	$result = $ClsPush->get_notification_status($push_type,$type_id);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "150px">ALUMNO</td>';
			$salida.= '<th class = "text-center" width = "100px">Grado y Secci&oacute;n</td>';
			$salida.= '<th class = "text-center" width = "150px">USUARIO</td>';
			$salida.= '<th class = "text-center" width = "50px">STATUS</td>';
			$salida.= '<th class = "text-center" width = "50px">FECHA/REGISTRO</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//ID
			$id = utf8_decode($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$id.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//grado
			$grado_desc = utf8_decode($row["alu_grado"]);
			$seccion_desc = utf8_decode($row["alu_seccion"]);
			$salida.= '<td class = "text-left">'.$grado_desc.' Secci&oacute;n '.$seccion_desc.'</td>';
			//padre o encargado
			$padnom = utf8_decode($row["pad_nombre"]);
			$padape = utf8_decode($row["pad_apellido"]);
			$salida.= '<td class = "text-left">'.$padnom.' '.$padape.'</td>';
			//ape
			$sit = trim($row["status"]);
			$status = ($sit == 1)?'<span class = "text-success"><i class="fa fa-check"></i> Leido</span>':'';
			$salida.= '<td class = "text-center">'.$status.'</td>';
			//fecha inicia
			$fecha = trim($row["updated_at"]);
			$fecha = cambia_fechaHora($fecha);
			$fecha = ($sit == 1)?$fecha:'';
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
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
