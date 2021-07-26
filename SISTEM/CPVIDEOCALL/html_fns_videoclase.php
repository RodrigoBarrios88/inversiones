<?php
include_once('../html_fns.php');
//Push Notifications
include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');
include_once('../../CONFIG/videoclases/kaltura.php');

//////////////////---- Otros Alumnos -----/////////////////////////////////////////////
function tabla_videoclase($codigosIn,$target,$tipo){
	$ClsVid = new ClsVideoclase();
	$result = $ClsVid->get_videoclase($codigosIn,$target,$tipo);

	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "70px"><span class="fa fa-cog"></span></th>';
		$salida.= '<th class = "text-center" width = "150px">Videoclase</td>';
		$salida.= '<th class = "text-center" width = "100px">Plataforma</td>';
		$salida.= '<th class = "text-center" width = "100px">Inicio</td>';
		$salida.= '<th class = "text-center" width = "100px">Finaliza</td>';
		$salida.= '<th class = "text-center" width = "100px">Asignados</td>';
		$salida.= '<th class = "text-center" width = "30px"><span class="fa fa-cog"></span></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$codigo = $row["vid_codigo"];
            $usu = $_SESSION["codigo"];
            $tipoclase = $row["vid_tipoclase"];	
            $codprimario = $row["vid_codprimario"];	
			$hashkey = $ClsVid->encrypt($codigo, $usu);
			$salida.= '<td class = "text-center" >';    
			    $salida.= '<div class="btn-group">';
					//$salida.= '<button type="button" class="btn btn-primary" onclick = "Ver_Videoclase('.$codigo.')" title = "Visualizar Videoclase" ><span class="fa fa-search"></span></button>';
					$salida.= '<button type="button" class="btn btn-default" onclick = "EDITAR('.$codigo.','.$tipoclase.','.$codprimario.')" title = "Editar Videoclase" ><span class="fa fa-edit"></span></button>';
					$salida.= '<button type="button" class="btn btn-danger" onclick = "ELIMINAR('.$codigo.','.$tipoclase.','.$codprimario.')"  title = "Eliminar Videoclase" ><span class="glyphicon glyphicon-trash"></span></button>';
				$salida.= '</div>';
			$salida.= '</td>';
			
			//nombre
			$nombre = trim(utf8_decode($row["vid_nombre"]));
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//plataforma
			$plataforma = trim(utf8_decode($row["vid_plataforma"]));
			$salida.= '<td class = "text-left">'.$plataforma.'</td>';
			//fecha inicia
			$fini = trim($row["vid_fecha_inicio"]);
			$fini = cambia_fechaHora($fini);
			$salida.= '<td class = "text-center">'.$fini.'</td>';
			//fecha finaliza
			$ffin = trim($row["vid_fecha_fin"]);
			$ffin = cambia_fechaHora($ffin);
			$salida.= '<td class = "text-center">'.$ffin.'</td>';
	    	// grupos
	            $desc = '';
				$grupos = $ClsVid->get_det_videoclase_secciones($codigo,'','','','');
				if(is_array($grupos)){
					foreach($grupos as $rowGrupo){
						$seccion = utf8_decode($rowGrupo["niv_descripcion"]) . " " .utf8_decode($rowGrupo["gra_descripcion"]) . " " . utf8_decode($rowGrupo["sec_descripcion"]);
						$desc .= $seccion . "<br>";
					}
				}
				$salida.= '<td class = "text-left">'.$desc.'</td>';
			//--
			$codigo = $row["vid_codigo"];
            	$usu = $_SESSION["codigo"];
			$hashkey = $ClsVid->encrypt($codigo, $usu);
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<button type="button" class="btn btn-warning" onclick = "ConfirmRecordatorio('.$codigo.');" title = "Notificar Recordatorio" ><i class="fa fa-bell"></i></button>';
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



function tabla_grados_secciones(){
	$ClsPen = new ClsPensum();
	$ClsAcad = new ClsAcademico();
	$ClsAul = new ClsAula();
	$pensum = $ClsPen->get_pensum_activo();
	
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	$salida = '';
	$salida.= '<div class="list-group">';
	$salida.= '<span class="list-group-item active"> Niveles, Grados y Secciones </span>';
	$salida.= '<div class="list-group-item">';
	
	$tipo_usuario = $_SESSION["tipo_usuario"];
	$tipo_codigo = $_SESSION["tipo_codigo"];
	if($tipo_usuario == 2){ //// MAESTRO
		$result = $ClsAcadem->get_seccion_maestro($pensum,'','','',$tipo_codigo,'','',1);
		if(is_array($result)){
		    $salida.= '<ul class="treeview">';
		    $i = 1;
		    $j = 1;
		    $k = 1;
		    $count_secciones = 1;
		    $nivelBase = '';		    
		    $gradoBase = '';		    
		    foreach($result as $row){
		        //------ CIERRES
		        //-- grados
		        $grado = $row["gra_codigo"];
		        //echo "$gradoBase != $grado && $j > 1<br>";
		        if($gradoBase != $grado && $j > 1){
		            $salida.= '</ul>';
		            $salida.= '</li>';
		            $j++;
		        }  
				//-- Nivel
				$nivel = $row["niv_codigo"];
		        if($nivelBase != $nivel && $i > 1){
		            $salida.= '</ul>';
		            $salida.= '</li>';
		            $i++;
		        }
		        //------ APERTURA
		        $nivel = $row["niv_codigo"];
		        if($nivelBase != $nivel){
		            $gradoBase = '';
		            $nivelBase = $nivel;
		            $j = 1;
		            $salida.= '<li>';
		            $nivelDescripcion = utf8_decode($row["niv_descripcion"]);
		            $salida .= ' NIVEL: '.$nivelDescripcion.' ';
				    $salida.= '<ul>';
				    $i++;
		        }
		        //-- grados
		        $grado = $row["gra_codigo"];
		        if($gradoBase != $grado){
		            $k = 1;
		            $gradoBase = $grado;
		            $salida.= '<li>';
		            $gradoDescripcion = utf8_decode($row["gra_descripcion"]);
		            $salida .= ' GRADO: '.$gradoDescripcion.' ';
		            $salida.= '<ul>';
		            $j++;
		        }  
		        //-- seccion
		        $salida.= '<li>';
				//descripcion
				$seccion = utf8_decode($row["sec_codigo"]);
				$seccionDescipcion = utf8_decode($row["sec_descripcion"]);
				$salida .= '<input type = "checkbox" name="grupos'.$count_secciones.'" id="grupos'.$count_secciones.'" value="'.$pensum.'.'.$nivel.'.'.$grado.'.'.$seccion.'" />';
				$salida .= ' SECCI&Oacute;N: '.$seccionDescipcion.' ';
				$salida.= '</li>';
				$k++;
				$count_secciones++;
				
			}
			        $salida.= '</li>';
	                $salida.= '</ul>';
		        $salida.= '</li>';
		    $salida.= '</ul>';
		    $i--;
		    $j--;
		    $k--;
		    $salida .= '<input type = "hidden" name="SECrows" id="SECrows" value="'.$k.'" />';
		    $salida .= '<input type = "hidden" name="GRArows" id="GRArows" value="'.$j.'" />';
		    $salida .= '<input type = "hidden" name="NIVrows" id="NIVrows" value="'.$i.'" />';
		}
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
		if(is_array($result)){
		    $salida.= '<ul class="treeview">';
		    $i = 1;
		    $j = 1;
		    $k = 1;
		    $count_secciones = 1;
		    $nivelBase = '';		    
		    $gradoBase = '';		    
		    foreach($result as $row){
		        //------ CIERRES
		        //-- grados
		        $grado = $row["gra_codigo"];
		        //echo "$gradoBase != $grado && $j > 1<br>";
		        if($gradoBase != $grado && $j > 1){
		            $salida.= '</ul>';
		            $salida.= '</li>';
		            $j++;
		        }  
				//-- Nivel
				$nivel = $row["niv_codigo"];
		        if($nivelBase != $nivel && $i > 1){
		            $salida.= '</ul>';
		            $salida.= '</li>';
		            $i++;
		        }
		        //------ APERTURA
		        $nivel = $row["niv_codigo"];
		        if($nivelBase != $nivel){
		            $gradoBase = '';
		            $nivelBase = $nivel;
		            $j = 1;
		            $salida.= '<li>';
		            $nivelDescripcion = utf8_decode($row["niv_descripcion"]);
		            $salida .= ' NIVEL: '.$nivelDescripcion.' ';
				    $salida.= '<ul>';
				    $i++;
		        }
		        //-- grados
		        $grado = $row["gra_codigo"];
		        if($gradoBase != $grado){
		            $k = 1;
		            $gradoBase = $grado;
		            $salida.= '<li>';
		            $gradoDescripcion = utf8_decode($row["gra_descripcion"]);
		            $salida .= ' GRADO: '.$gradoDescripcion.' ';
		            $salida.= '<ul>';
		            $j++;
		        }  
		        //-- seccion
		        
		        $result_grados = $ClsPen->get_grado($pensum,$nivel,$grado);
				if(is_array($result_grados)){
		        $salida.= '<li>';
				//descripcion
				$seccion = utf8_decode($row["sec_codigo"]);
				$seccionDescipcion = utf8_decode($row["sec_descripcion"]);
				$salida .= '<input type = "checkbox" name="grupos'.$count_secciones.'" id="grupos'.$count_secciones.'" value="'.$pensum.'.'.$nivel.'.'.$grado.'.'.$seccion.'" />';
				$salida .= ' SECCI&Oacute;N: '.$seccionDescipcion.' ';
				$salida.= '</li>';
				$k++;
				$count_secciones++;
			    
				}
				
			}
			        $salida.= '</li>';
	                $salida.= '</ul>';
		        $salida.= '</li>';
		    $salida.= '</ul>';
		    $i--;
		    $j--;
		    $k--;
		    $salida .= '<input type = "hidden" name="SECrows" id="SECrows" value="'.$k.'" />';
		    $salida .= '<input type = "hidden" name="GRArows" id="GRArows" value="'.$j.'" />';
		    $salida .= '<input type = "hidden" name="NIVrows" id="NIVrows" value="'.$i.'" />';
		}
		$result_secciones = $ClsPen->get_seccion_IN($pensum,$nivel,$grado,'','',1);
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
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
	}else{
		$valida = "";
	}
	
	$count_secciones--;//le quita la vuelta inicial
	$salida .= '<input type = "hidden" name="gruposrows" id="gruposrows" value="'.$count_secciones.'" />';
	$salida .= '</div>';
	$salida .= '</div>';

	return $salida;
}




function historial_videoclase($desde,$hasta,$usuario){
	$ClsVid = new ClsVideoclase();
	$usuario = $_SESSION['codigo'];
	$credenciales = $ClsVid->get_credentials($usuario);
	$partnerId = $credenciales["partner"];
	$userId = $credenciales["userid"];
	$secret = $credenciales["secret"];
	if($credenciales == ''){
		$respuesta->script('swal("Alto!", "Su usuario no tiene licencia activa para este tipo de videollamadas...", "error").then((value)=>{ cerrar(); });');
		return $respuesta;
	}

	$response = kaltura_list_liveStream($partnerId,$userId,$secret, '');
	$result = (array) $response["data"]["objects"];
	//print_r($result);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-kaltura">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Videoclase</td>';
		$salida.= '<th class = "text-center" width = "100px">Fecha Inicio</td>';
		$salida.= '<th class = "text-center" width = "50px">Duraci&oacute;n</td>';
		$salida.= '<th class = "text-center" width = "60px"><i class="fa fa-cogs"></i></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$string_base = $row->name;
			$trozos = explode("-", $string_base);
			//---
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//nombre
			$nombre = trim($trozos[2]);
			$nombre = utf8_decode($nombre);
			$nombre = str_replace(".mp4", "", $nombre);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//fecha inicia
			$fini = $trozos[1];
			$salida.= '<td class = "text-center">'.$fini.'</td>';
			//duracion
			$duracion = $row->duration;
			$duracion = gmdate("H:i:s", $duracion);
			$duracion = str_replace("00:", "", $duracion);
			$salida.= '<td class = "text-center">'.$duracion.'</td>';
			////--------------
			$link = $row->dataUrl;
			$linkDownload = $row->downloadUrl;
			$salida.= '<td class = "text-center" >';
				$salida.= '<div class="btn-group">';
					$salida.= '<a class="btn btn-default" target="_blank" href = "'.$linkDownload.'" title = "Ver carpetas y archivos enlazados" ><i class="fa fa-cloud-download"></i></a>';
					$salida.= '<a class="btn btn-primary" target="_blank" href = "FRMrecorder.php?url='.$link.'" title = "Ver clase" ><i class="fa fa-angle-double-right"></i></a>';
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




function historial_videoclase_otros($desde,$hasta,$usuario){
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	///////// FILTROS DE CODIGOS /////////////
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsVid = new ClsVideoclase();
	$codigosVideo = '';
	$codigo = $ClsVid->get_codigos_videoclase_todos();
	$codigosVideo.= ($codigo != "")?$codigo.',':'';
	////////////////
	if($tipo_usuario == 2){ //// MAESTRO
		$result_clases = $ClsVid->get_videoclase('','','','','',$desde,$hasta,$usuario);
		if(is_array($result_clases)){
			foreach($result_clases as $row){
				$codigo = $row["vid_codigo"];
				$codigosVideo.= ($codigo != "")?$codigo.',':'';
			}
		}
		$codigosVideo = substr($codigosVideo, 0, -1);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$pensum = $ClsPen->get_pensum_activo();
		$director = $tipo_codigo;
		$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$director);
		if(is_array($result)){
			foreach($result as $row){
				$nivel = $row["gra_nivel"];
				$grado = $row["gra_codigo"];
				$codigo = $ClsVid->get_codigos_secciones($pensum,$nivel,$grado,'');
				$codigosVideo.= ($codigo != "")?$codigo.',':'';
			}
		}
		$codigosVideo = substr($codigosVideo, 0, -1);
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$pensum = $ClsPen->get_pensum_activo();
		$result = $ClsPen->get_grado($pensum,'','',1);
		if(is_array($result)){
			foreach($result as $row){
				$nivel = $row["gra_nivel"];
				$grado = $row["gra_codigo"];
				$codigo = $ClsVid->get_codigos_secciones($pensum,$nivel,$grado,'');
				$codigosVideo.= ($codigo != "")?$codigo.',':'';
			}
		}
		$codigosVideo = substr($codigosVideo, 0, -1);
	}else{
		$codigosVideo == "0";
	}

	$result = $ClsVid->get_videoclase($codigosVideo);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-otra">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "150px">Videoclase</td>';
		$salida.= '<th class = "text-center" width = "100px">Plataforma</td>';
		$salida.= '<th class = "text-center" width = "100px">Inici&oacute;</td>';
		$salida.= '<th class = "text-center" width = "100px">Finaliz&oacute;</td>';
		$salida.= '<th class = "text-center" width = "60px"><i class="fa fa-cogs"></i></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$plataforma = trim($row["vid_plataforma"]);
			if($plataforma != "ASMS Videoclass"){
				//fecha inicia
				$fecha_1 = trim($row["vid_fecha_inicio"]);
				$fecha_1 = strtotime($fecha_1);
				//fecha finaliza
				$fecha_2 = trim($row["vid_fecha_fin"]);
				$fecha_2 = strtotime($fecha_2);
				if(($fecha_actual > $fecha_1) && ($fecha_actual >= $fecha_2)){
					$salida.= '<tr>';
					//codigo
					$salida.= '<td class = "text-center" >'.$i.'.</td>';
					//nombre
					$nombre = trim(utf8_decode($row["vid_nombre"]));
					$salida.= '<td class = "text-left">'.$nombre.'</td>';
					//plataforma
					$plataforma = trim(utf8_decode($row["vid_plataforma"]));
					$salida.= '<td class = "text-left">'.$plataforma.'</td>';
					//fecha inicia
					$fini = trim($row["vid_fecha_inicio"]);
					$fini = cambia_fechaHora($fini);
					$salida.= '<td class = "text-center">'.$fini.'</td>';
					//fecha finaliza
					$ffin = trim($row["vid_fecha_fin"]);
					$ffin = cambia_fechaHora($ffin);
					$salida.= '<td class = "text-center">'.$ffin.'</td>';
					////--------------
					$codigo = $row["vid_codigo"];
					$plataforma = trim($row["vid_plataforma"]);
					$link = trim($row["vid_link"]);
					if($plataforma == "ASMS Videoclass"){
						$enlace = "FRMviewer.php?codigo=$codigo";
					}else{
						$enlace = $link;
					}
					$salida.= '<td class = "text-center" >';
						$salida.= '<div class="btn-group">';
							$salida.= '<a class="btn btn-primary" target="_blank" href = "'.$enlace.'" title = "Ver clase" ><i class="fa fa-angle-double-right"></i></a>';
						$salida.= '</div>';
					$salida.= '</td>';
					//--
					$salida.= '</tr>';
					$i++;
				}
			}
		}
		$i--;
		$salida.= '</table>';
		$salida.= '</div>';
	}

	return $salida;
}




/////////////////////////////// CONFIRMACIONES DE LECTURA ///////////////////////////////////////////////

function tabla_info_confirmacion(){
	$ClsVid = new ClsVideoclase();
    $result = $ClsVid->get_videoclase($codigo,$target,$tipo);
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cog"></span></th>';
		$salida.= '<th class = "text-center" width = "150px">T&Iacute;TULO</th>';
		$salida.= '<th class = "text-center" width = "200px">DESCRIPCI&Oacute;N O OBSERVACIONES</th>';
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
			$titulo = trim(utf8_decode($row["vid_nombre"]));
			$salida.= '<td class = "text-left">'.$titulo.'</td>';
			//desc
			$desc = trim(utf8_decode($row["vid_descripcion"]));
			$desc = (strlen($desc) > 128)?substr($desc,0,120)."...":$desc;
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
			//fecha inicia
			$publicacion = trim($row["vid_fecha_registro"]);
			$publicacion = cambia_fechaHora($publicacion);
			$salida.= '<td class = "text-center">'.$publicacion.'</td>';
			//--
			$codigo = $row["vid_codigo"];
            $usu = $_SESSION["codigo"];
			$hashkey = $ClsVid->encrypt($codigo, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-success btn-xs" href="FRMleidos.php?hashkey='.$hashkey.'" title = "Listado de Usuarios y su lectura" ><i class="fa fa-group"></i> <i class="fa fa-eye"></i></a> ';
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
			$salida.= '<th class = "text-center" width = "50px">STUATUS</td>';
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


//echo tabla_grados_secciones();

?>
