<?php
//inclu�mos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_videoclase.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// LISTA /////////
function Target_Grupos($target,$tipo){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$target,$tipo");
	if($target == "SELECT"){
		if($tipo == 1){
			$contenido = tabla_grados_secciones();
			$respuesta->assign("divgrupos","innerHTML",$contenido);
		}else if($tipo == 2){
			$contenido = grupos_lista_multiple("grupos");
			$respuesta->assign("divgrupos","innerHTML",$contenido);
		}else{
			$contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
			$respuesta->assign("divgrupos","innerHTML",$contenido);
		}
   }else{
	  $contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
	  $respuesta->assign("divgrupos","innerHTML",$contenido);
   }
   return $respuesta;
}


//////////////////---- INFORMACION -----/////////////////////////////////////////////

function Grabar_Videoclase($nombre,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$plataforma,$link,$arrgrupo,$filas,$tipoclass,$cuando){
     //instanciamos el objeto para generar la respuesta con ajax
     $respuesta = new xajaxResponse();
     $ClsVid = new ClsVideoclase();
     $ClsPush = new ClsPushup();
     //valida si es clase recurrente
     if($tipoclass !== "1"){
      if($nombre != "" && $descripcion != ""){
          $videoclase = $ClsVid->max_videoclase();
          $videoclase++; /// Maximo codigo
          $vidprimaria = $videoclase;
          $desde = "$fecdesde $hordesde";
          $hasta = "$fechasta $horhasta";
          if($plataforma === "ASMS Videoclass"){
             $sql = $ClsVid->insert_videoclase($videoclase,$nombre,$descripcion,$desde,$hasta,$target,$tipo,$plataforma,$link,'','','','',$tipoclass,$vidprimaria); /// Inserta a tabla Videoclasees
          }else{
              if( $link != ""){
                    $sql = $ClsVid->insert_videoclase($videoclase,$nombre,$descripcion,$desde,$hasta,$target,$tipo,$plataforma,$link,'','','','',$tipoclass,$vidprimaria); /// Inserta a tabla Videoclasees
                                 
                }else{
                    $respuesta->script('swal("Alto!", "Ingrese el link de la videollamada", "error").then((value)=>{ cerrar(); });');
                    return $respuesta; 
                }
          }
          if($target == "SELECT"){
               $nombre_grupo = "";
			if($tipo == 1){
				$pensum = $_SESSION["pensum"];
                    for($i = 0; $i< $filas; $i++){
                         $bloque = explode(".",$arrgrupo[$i]);
                         $nivel = $bloque[1];
                         $grado = $bloque[2];
                         $seccion = $bloque[3];
                         $nombre_grupo.= "N".$nivel."G".$grado."S".$seccion.", ";
                         $sql.= $ClsVid->insert_det_videoclase_secciones($videoclase,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
					//--
					$arrnivel.= $nivel.",";
					$arrgrado.= $grado.",";
					$arrsecc.= $seccion.",";
				}
                    $nombre_grupo.= substr($nombre_grupo, 0, -2);
			}else if($tipo == 2){
				for($i = 0; $i< $filas; $i++){
                         $grupo = $arrgrupo[$i];
                         $sql.= $ClsVid->insert_det_videoclase_grupos($videoclase,$grupo); /// Inserta detalle
                         //--
                         $nombre_grupo.= $grupo.", ";
				}
                    $nombre_grupo.= substr($nombre_grupo, 0, -2);
			}
          } else {
               $nombre_grupo = "TODOS";
          }

		$rs = $ClsVid->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
               if($plataforma == "ASMS Videoclass"){
                    $usuario = $_SESSION['codigo'];
                    $credenciales = $ClsVid->get_credentials($usuario);
                    $partnerId = $credenciales["partner"];
                    $userId = $credenciales["userid"];
                    $secret = $credenciales["secret"];
                    if($credenciales == ''){
                         $respuesta->script('swal("Alto!", "Su usuario no tiene licencia activa para este tipo de videollamadas...", "error").then((value)=>{ cerrar(); });');
                         return $respuesta;
                    }
                    $cui = $_SESSION['tipo_codigo'];
                    $organizador = $_SESSION["nombre"];
                    $desde = regresa_fechaHora($desde);
                    //$desde = strtotime ( '-2 hour' , strtotime ( $desde ) ) ;
                    $hasta = regresa_fechaHora($hasta);
                    //$hasta = strtotime ( '-2 hour' , strtotime ( $hasta ) ) ;
                    //revision de fechas programadas
                    $nuevodesde = date ( 'd/m/Y H:i' , $desde );
                    $nuevohasta = date ( 'd/m/Y H:i' , $hasta );
                    //$respuesta->alert("$nuevodesde - $nuevohasta");
                    //----
                    $arr_schedule = kaltura_add_schedule("$nombre $nombre_grupo",$descripcion, $partnerId,$userId,$secret);
                    $arr_event = kaltura_add_event($videoclase, $organizador, "$nombre $nombre_grupo", $cui, $desde, $hasta, $partnerId,$userId,$secret);
                    $schedule = $arr_schedule["data"]["id"];
                    $event = $arr_event["data"]["id"];
                    $partnerId = $arr_schedule["data"]["partnerId"];
                    //$respuesta->alert("$event, $schedule");
                    $arr_resource = kaltura_resource_event($event, $schedule, $partnerId,$userId,$secret);

                    if($arr_schedule["status"] == 1 && $arr_event["status"] == 1 && $arr_resource["status"] == 1){
                         $sql = $ClsVid->modifica_schedule_videoclase($videoclase,$schedule,$event,$partnerId); /// update datos de kaltura
                         $rs = $ClsVid->exec_sql($sql);
                         if($rs == 1){
                              $respuesta->script('swal("Excelente!", "Nueva Videoclase calendarizada con exito!", "success").then((value)=>{ window.location.reload(); });');
                         }else{
                              $sql = $ClsVid->delete_videoclase($videoclase); /// delete
                              $rs = $ClsVid->exec_sql($sql);
                              $respuesta->script('swal("Error", "Error en la actualizaci\u00F3n de parametros Kaltura", "error").then((value)=>{ cerrar(); });');
                              $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
                              $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
                         }
                    }else{
                         $sql = $ClsVid->delete_videoclase($videoclase); /// delete
                         $rs = $ClsVid->exec_sql($sql);
                         $respuesta->script('swal("Error", "Error en la transacci\u00F3n con el API de videollamadas", "error").then((value)=>{ cerrar(); });');
                         $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
                         $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
                    }
               }else{
                    $respuesta->script('swal("Excelente!", "Nueva Videoclase calendarizada con exito!", "success").then((value)=>{ window.location.reload(); });');
               }
		}else{
			$respuesta->script('swal("Error", "Error en la creaci\u00F3n del evento en BD...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
		}
        return $respuesta;
	}
     }else{
        if($nombre != "" && $descripcion != ""){
          //$respuesta->alert($target);
            $videoclase = $ClsVid->max_videoclase();
            $videoclase++; /// Maximo codigo
            $vidprimaria = $videoclase;
            $time = time();
            $fini = date("Y-m-d ", $time);
            $fin = date("Y-12-31", $time);
            $fechaInicio=strtotime("$fini");
            $fechaFin=strtotime("$fin");
            for($i2=$fechaInicio; $i2<=$fechaFin; $i2+=86400){
                $fechafinal = date("Y-m-d", $i2);
                $dia = date("N", $i2);
                 if ($dia == $cuando){
                    //$respuesta->alert($fechafinal);
                    $desde = "$fechafinal $hordesde";
                    $hasta = "$fechafinal $horhasta";
                    $desde = cambia_fechaHora($desde);
                    $hasta = cambia_fechaHora($hasta);
                    $sql = $ClsVid->insert_videoclase($videoclase,$nombre,$descripcion,$desde,$hasta,$target,$tipo,$plataforma,$link,'','','','',$tipoclass,$vidprimaria); /// Inserta a tabla Videoclase
                        if($target !== "TODOS"){
                               $nombre_grupo = "";
                			if($tipo == "1"){
                				$pensum = $_SESSION["pensum"];
                                    for($i = 0; $i< $filas; $i++){
                                         $bloque = explode(".",$arrgrupo[$i]);
                                         $nivel = $bloque[1];
                                         $grado = $bloque[2];
                                         $seccion = $bloque[3];
                                         $nombre_grupo.= "N".$nivel."G".$grado."S".$seccion.", ";
                                         $sql.= $ClsVid->insert_det_videoclase_secciones($videoclase,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
                                         //$respuesta->alert($sql);
                					$arrnivel.= $nivel.",";
                					$arrgrado.= $grado.",";
                					$arrsecc.= $seccion.",";
                				}
                                    $nombre_grupo.= substr($nombre_grupo, 0, -2);
                			}else if($tipo == 2){
                				for($i = 0; $i< $filas; $i++){
                                         $grupo = $arrgrupo[$i];
                                         $sql.= $ClsVid->insert_det_videoclase_grupos($videoclase,$grupo); /// Inserta detalle
                                         //--
                                         $nombre_grupo.= $grupo.", ";
                				}
                                    $nombre_grupo.= substr($nombre_grupo, 0, -2);
                			}
                        } else {
                            $nombre_grupo = "TODOS";
                        }
        	    $rs = $ClsVid->exec_sql($sql);
        		//$respuesta->alert($sql);
        		$videoclase++; /// Maximo codigo
        		if($rs == 1){
                       if($plataforma == "ASMS Videoclass"){
                            $usuario = $_SESSION['codigo'];
                            $credenciales = $ClsVid->get_credentials($usuario);
                            $partnerId = $credenciales["partner"];
                            $userId = $credenciales["userid"];
                            $secret = $credenciales["secret"];
                            if($credenciales == ''){
                                 $respuesta->script('swal("Alto!", "Su usuario no tiene licencia activa para este tipo de videollamadas...", "error").then((value)=>{ cerrar(); });');
                                 return $respuesta;
                            }
                            $cui = $_SESSION['tipo_codigo'];
                            $organizador = $_SESSION["nombre"];
                            $desde = regresa_fechaHora($desde);
                            //$desde = strtotime ( '-2 hour' , strtotime ( $desde ) ) ;
                            $hasta = regresa_fechaHora($hasta);
                            //$hasta = strtotime ( '-2 hour' , strtotime ( $hasta ) ) ;
                            //revision de fechas programadas
                            //$nuevodesde = date ( 'd/m/Y H:i' , $desde );
                            //$nuevohasta = date ( 'd/m/Y H:i' , $hasta );
                            //$respuesta->alert("$nuevodesde - $nuevohasta");
                            //----
                            $arr_schedule = kaltura_add_schedule("$nombre $nombre_grupo",$descripcion, $partnerId,$userId,$secret);
                            $arr_event = kaltura_add_event($videoclase, $organizador, "$nombre $nombre_grupo", $cui, $desde, $hasta, $partnerId,$userId,$secret);
                            $schedule = $arr_schedule["data"]["id"];
                            $event = $arr_event["data"]["id"];
                            $partnerId = $arr_schedule["data"]["partnerId"];
                            //$respuesta->alert("$event, $schedule");
                            $arr_resource = kaltura_resource_event($event, $schedule, $partnerId,$userId,$secret);
        
                            if($arr_schedule["status"] == 1 && $arr_event["status"] == 1 && $arr_resource["status"] == 1){
                                 $sql = $ClsVid->modifica_schedule_videoclase($videoclase,$schedule,$event,$partnerId); /// update datos de kaltura
                                 $rs = $ClsVid->exec_sql($sql);
                                 if($rs == 1){
                                      $respuesta->script('swal("Excelente!", "Nueva Videoclase calendarizada con exito!", "success").then((value)=>{ window.location.reload(); });');
                                 }else{
                                      $sql = $ClsVid->delete_videoclase($videoclase); /// delete
                                      $rs = $ClsVid->exec_sql($sql);
                                      $respuesta->script('swal("Error", "Error en la actualizaci\u00F3n de parametros Kaltura", "error").then((value)=>{ cerrar(); });');
                                      $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
                                      $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
                                 }
                            }else{
                                 $sql = $ClsVid->delete_videoclase($videoclase); /// delete
                                 $rs = $ClsVid->exec_sql($sql);
                                 $respuesta->script('swal("Error", "Error en la transacci\u00F3n con el API de videollamadas", "error").then((value)=>{ cerrar(); });');
                                 $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
                                 $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
                            }
                       }else{
                            $respuesta->script('swal("Excelente!", "Nueva Videoclase recurrente calendarizada con exito!", "success").then((value)=>{ window.location.reload(); });');
                       }
        		}else{
        			$respuesta->script('swal("Error", "Error en la creaci\u00F3n del evento en BD...", "error").then((value)=>{ cerrar(); });');
        			$respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
        			$respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
        		}
                }
            }
	    }   
     }
     return $respuesta;
}

function Modificar_Videoclase($codigo,$nombre,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$plataforma,$link,$event,$schedule,$partnerId,$arrgrupo,$filas){
     //instanciamos el objeto para generar la respuesta con ajax
     $respuesta = new xajaxResponse();
     $ClsVid = new ClsVideoclase();

     if($nombre != "" && $descripcion != ""){
          $desde = "$fecdesde $hordesde";
          $hasta = "$fechasta $horhasta";
          $sql = $ClsVid->modifica_videoclase($codigo,$nombre,$descripcion,$desde,$hasta,$plataforma,$link); /// Inserta a tabla Videoclasees
          $sql.= $ClsVid->delete_det_videoclase_grupos($codigo); //elimina detalles
          $sql.= $ClsVid->delete_det_videoclase_secciones($codigo); //elimina detalles
          $sql.= $ClsVid->modifica_target_videoclase($codigo,$target,$tipo); /// Actualiza Videoclasees
          if($target == "SELECT"){
               $nombre_grupo = "";
			if($tipo == 1){
				$pensum = $_SESSION["pensum"];
                    for($i = 0; $i< $filas; $i++){
                         $bloque = explode(".",$arrgrupo[$i]);
                         $nivel = $bloque[1];
                         $grado = $bloque[2];
                         $seccion = $bloque[3];
                         $nombre_grupo.= "N".$nivel."G".$grado."S".$seccion.", ";
                         $sql.= $ClsVid->insert_det_videoclase_secciones($codigo,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
					//--
					$arrnivel.= $nivel.",";
					$arrgrado.= $grado.",";
					$arrsecc.= $seccion.",";
				}
                    $nombre_grupo.= substr($nombre_grupo, 0, -2);
			}else if($tipo == 2){
				for($i = 0; $i< $filas; $i++){
                         $grupo = $arrgrupo[$i];
                         $sql.= $ClsVid->insert_det_videoclase_grupos($codigo,$grupo); /// Inserta detalle
                         //--
                         $nombre_grupo.= $grupo.", ";
				}
                    $nombre_grupo.= substr($nombre_grupo, 0, -2);
			}
          } else {
               $nombre_grupo = "TODOS";
          }

          $rs = $ClsVid->exec_sql($sql);
          //$respuesta->alert($sql);
          if($rs == 1){
               if($plataforma == "ASMS Videoclass"){
                    $usuario = $_SESSION['codigo'];
                    $credenciales = $ClsVid->get_credentials($usuario);
                    $partnerId = $credenciales["partner"];
                    $userId = $credenciales["userid"];
                    $secret = $credenciales["secret"];
                    if($credenciales == ''){
                         $respuesta->script('swal("Alto!", "Su usuario no tiene licencia activa para este tipo de videollamadas...", "error").then((value)=>{ cerrar(); });');
                         return $respuesta;
                    }

                    ///--- eliminacion anteriro ---///
                    kaltura_delete_schedule($schedule, $partnerId,$userId,$secret);
                    kaltura_delete_event($event, $partnerId,$userId,$secret);
                    ///--- nueva programacion ---///
                    $cui = $_SESSION['tipo_codigo'];
                    $organizador = $_SESSION["nombre"];
                    $desde = regresa_fechaHora($desde);
                    //$desde = strtotime ( '-2 hour' , strtotime ( $desde ) ) ;
                    $hasta = regresa_fechaHora($hasta);
                    //$hasta = strtotime ( '-2 hour' , strtotime ( $hasta ) ) ;
                    //revision de fechas programadas
                    $nuevodesde = date ( 'd/m/Y H:i' , $desde );
                    $nuevohasta = date ( 'd/m/Y H:i' , $hasta );
                    //$respuesta->alert("$nuevodesde - $nuevohasta");
                    //----
                    $arr_schedule = kaltura_add_schedule("$nombre $nombre_grupo",$descripcion, $partnerId,$userId,$secret);
                    $arr_event = kaltura_add_event($codigo, $organizador, "$nombre $nombre_grupo", $cui, $desde, $hasta, $partnerId,$userId,$secret);
                    $schedule = $arr_schedule["data"]["id"];
                    $event = $arr_event["data"]["id"];
                    $partnerId = $arr_schedule["data"]["partnerId"];
                    //$respuesta->alert("$event, $schedule");
                    $arr_resource = kaltura_resource_event($event, $schedule, $partnerId,$userId,$secret);
                    if($arr_schedule["status"] == 1 && $arr_event["status"] == 1 && $arr_resource["status"] == 1){
                         $sql = $ClsVid->modifica_schedule_videoclase($codigo,$schedule,$event,$partnerId); /// update datos de kaltura
                         //$respuesta->alert($sql);
                         $rs = $ClsVid->exec_sql($sql);
                         if($rs == 1){
                              $respuesta->script('swal("Excelente!", "Calendarizaci\u00F3n de Videoclase actualizada con exito!", "success").then((value)=>{ window.location.reload(); });');
                         }else{
                              $sql = $ClsVid->delete_videoclase($codigo); /// delete
                              $rs = $ClsVid->exec_sql($sql);
                              $respuesta->script('swal("Error", "Error en la actualizaci\u00F3n de parametros Kaltura", "error").then((value)=>{ cerrar(); });');
                              $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary hidden';");
                              $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary';");
                         }
                    }else{
                         $sql = $ClsVid->delete_videoclase($videoclase); /// delete
                         $rs = $ClsVid->exec_sql($sql);
                         $respuesta->script('swal("Error", "Error en la transacci\u00F3n con el API de videollamadas", "error").then((value)=>{ cerrar(); });');
                         $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary hidden';");
                         $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary';");
                    }
               }else{
                    $respuesta->script('swal("Excelente!", "Calendarizaci\u00F3n de Videoclase actualizada con exito!", "success").then((value)=>{ window.location.reload(); });');
               }
          }else{
               $respuesta->script('swal("Error", "Error en la creaci\u00F3n del evento en BD...", "error").then((value)=>{ cerrar(); });');
               $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary hidden';");
               $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary';");
          }

	}
     return $respuesta;
}

function Modificar_Videoclase_recurrente($codigo,$nombre,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$plataforma,$link,$event,$schedule,$partnerId,$arrgrupo,$filas,$tipoclass,$cuando,$codprimario){
     //instanciamos el objeto para generar la respuesta con ajax
     $respuesta = new xajaxResponse();
     $ClsVid = new ClsVideoclase();
    $result = $ClsVid-> get_videoclase_recurrente($codprimario);
        if(is_array($result)){
            foreach($result as $row){
            $codigo = $row["vid_codigo"];
            //$respuesta->alert($codigo);       
                $sql = $ClsVid->delete_videoclase($codigo); /// Inserta a tabla Videoclasees
                $sql.= $ClsVid->delete_det_videoclase_grupos($codigo); //elimina detalles
                $sql.= $ClsVid->delete_det_videoclase_secciones($codigo); //elimina detalles;
                //$respuesta->alert($sql);
            }
        }
         if($nombre != "" && $descripcion != ""){
          //$respuesta->alert($target);
            $videoclase = $ClsVid->max_videoclase();
            $videoclase++; /// Maximo codigo
            $vidprimaria = $videoclase;
            $time = time();
            $fini = date("Y-m-d ", $time);
            $fin = date("Y-12-31", $time);
            $fechaInicio=strtotime("$fini");
            $fechaFin=strtotime("$fin");
            for($i2=$fechaInicio; $i2<=$fechaFin; $i2+=86400){
                $fechafinal = date("Y-m-d", $i2);
                $dia = date("N", $i2);
                 if ($dia == $cuando){
                    //$respuesta->alert($fechafinal);
                    $desde = "$fechafinal $hordesde";
                    $hasta = "$fechafinal $horhasta";
                    $desde = cambia_fechaHora($desde);
                    $hasta = cambia_fechaHora($hasta);
                    $sql = $ClsVid->insert_videoclase($videoclase,$nombre,$descripcion,$desde,$hasta,$target,$tipo,$plataforma,$link,'','','','',$tipoclass,$vidprimaria); /// Inserta a tabla Videoclase
                        if($target !== "TODOS"){
                               $nombre_grupo = "";
                			if($tipo == "1"){
                				$pensum = $_SESSION["pensum"];
                                    for($i = 0; $i< $filas; $i++){
                                         $bloque = explode(".",$arrgrupo[$i]);
                                         $nivel = $bloque[1];
                                         $grado = $bloque[2];
                                         $seccion = $bloque[3];
                                         $nombre_grupo.= "N".$nivel."G".$grado."S".$seccion.", ";
                                         $sql.= $ClsVid->insert_det_videoclase_secciones($videoclase,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
                                         //$respuesta->alert($sql);
                					$arrnivel.= $nivel.",";
                					$arrgrado.= $grado.",";
                					$arrsecc.= $seccion.",";
                				}
                                    $nombre_grupo.= substr($nombre_grupo, 0, -2);
                			}else if($tipo == 2){
                				for($i = 0; $i< $filas; $i++){
                                         $grupo = $arrgrupo[$i];
                                         $sql.= $ClsVid->insert_det_videoclase_grupos($videoclase,$grupo); /// Inserta detalle
                                         //--
                                         $nombre_grupo.= $grupo.", ";
                				}
                                    $nombre_grupo.= substr($nombre_grupo, 0, -2);
                			}
                        } else {
                            $nombre_grupo = "TODOS";
                        }
        	    $rs = $ClsVid->exec_sql($sql);
        		//$respuesta->alert($sql);
        		$videoclase++; /// Maximo codigo
        		if($rs == 1){
                       if($plataforma == "ASMS Videoclass"){
                            $usuario = $_SESSION['codigo'];
                            $credenciales = $ClsVid->get_credentials($usuario);
                            $partnerId = $credenciales["partner"];
                            $userId = $credenciales["userid"];
                            $secret = $credenciales["secret"];
                            if($credenciales == ''){
                                 $respuesta->script('swal("Alto!", "Su usuario no tiene licencia activa para este tipo de videollamadas...", "error").then((value)=>{ cerrar(); });');
                                 return $respuesta;
                            }
                            $cui = $_SESSION['tipo_codigo'];
                            $organizador = $_SESSION["nombre"];
                            $desde = regresa_fechaHora($desde);
                            //$desde = strtotime ( '-2 hour' , strtotime ( $desde ) ) ;
                            $hasta = regresa_fechaHora($hasta);
                            //$hasta = strtotime ( '-2 hour' , strtotime ( $hasta ) ) ;
                            //revision de fechas programadas
                            //$nuevodesde = date ( 'd/m/Y H:i' , $desde );
                            //$nuevohasta = date ( 'd/m/Y H:i' , $hasta );
                            //$respuesta->alert("$nuevodesde - $nuevohasta");
                            //----
                            $arr_schedule = kaltura_add_schedule("$nombre $nombre_grupo",$descripcion, $partnerId,$userId,$secret);
                            $arr_event = kaltura_add_event($videoclase, $organizador, "$nombre $nombre_grupo", $cui, $desde, $hasta, $partnerId,$userId,$secret);
                            $schedule = $arr_schedule["data"]["id"];
                            $event = $arr_event["data"]["id"];
                            $partnerId = $arr_schedule["data"]["partnerId"];
                            //$respuesta->alert("$event, $schedule");
                            $arr_resource = kaltura_resource_event($event, $schedule, $partnerId,$userId,$secret);
        
                            if($arr_schedule["status"] == 1 && $arr_event["status"] == 1 && $arr_resource["status"] == 1){
                                 $sql = $ClsVid->modifica_schedule_videoclase($videoclase,$schedule,$event,$partnerId); /// update datos de kaltura
                                 $rs = $ClsVid->exec_sql($sql);
                                 if($rs == 1){
                                      $respuesta->script('swal("Excelente!", "Nueva Videoclase calendarizada con exito!", "success").then((value)=>{ window.location.reload(); });');
                                 }else{
                                      $sql = $ClsVid->delete_videoclase($videoclase); /// delete
                                      $rs = $ClsVid->exec_sql($sql);
                                      $respuesta->script('swal("Error", "Error en la actualizaci\u00F3n de parametros Kaltura", "error").then((value)=>{ cerrar(); });');
                                      $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
                                      $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
                                 }
                            }else{
                                 $sql = $ClsVid->delete_videoclase($videoclase); /// delete
                                 $rs = $ClsVid->exec_sql($sql);
                                 $respuesta->script('swal("Error", "Error en la transacci\u00F3n con el API de videollamadas", "error").then((value)=>{ cerrar(); });');
                                 $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
                                 $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
                            }
                       }else{
                            $respuesta->script('swal("Excelente!", "Nueva Videoclase recurrente calendarizada con exito!", "success").then((value)=>{ window.location.reload(); });');
                       }
        		}else{
        			$respuesta->script('swal("Error", "Error en la creaci\u00F3n del evento en BD...", "error").then((value)=>{ cerrar(); });');
        			$respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
        			$respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
        		}
                }
            }
	    }   
    return $respuesta; 
}

function Modificar_Videoclase_uar($codigo,$nombre,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$plataforma,$link,$event,$schedule,$partnerId,$arrgrupo,$filas,$tipoclass,$cuando,$codprimario){
     //instanciamos el objeto para generar la respuesta con ajax
     $respuesta = new xajaxResponse();
     $ClsVid = new ClsVideoclase();
     $ClsPush = new ClsPushup();
     //valida si es clase recurrente
        if($nombre != "" && $descripcion != ""){
          //$respuesta->alert($target);
            $videoclase = $ClsVid->max_videoclase();
            $videoclase++; /// Maximo codigo
            $vidprimaria = $videoclase;
            $time = time();
            $fini = date("Y-m-d ", $time);
            $fin = date("Y-12-31", $time);
            $fechaInicio=strtotime("$fini");
            $fechaFin=strtotime("$fin");
            for($i2=$fechaInicio; $i2<=$fechaFin; $i2+=86400){
                $fechafinal = date("Y-m-d", $i2);
                $dia = date("N", $i2);
                 if ($dia == $cuando){
                    //$respuesta->alert($fechafinal);
                    $desde = "$fechafinal $hordesde";
                    $hasta = "$fechafinal $horhasta";
                    $desde = cambia_fechaHora($desde);
                    $hasta = cambia_fechaHora($hasta);
                    $sql = $ClsVid->insert_videoclase($videoclase,$nombre,$descripcion,$desde,$hasta,$target,$tipo,$plataforma,$link,'','','','',$tipoclass,$vidprimaria); /// Inserta a tabla Videoclase
                        if($target !== "TODOS"){
                               $nombre_grupo = "";
                			if($tipo == "1"){
                				$pensum = $_SESSION["pensum"];
                                    for($i = 0; $i< $filas; $i++){
                                         $bloque = explode(".",$arrgrupo[$i]);
                                         $nivel = $bloque[1];
                                         $grado = $bloque[2];
                                         $seccion = $bloque[3];
                                         $nombre_grupo.= "N".$nivel."G".$grado."S".$seccion.", ";
                                         $sql.= $ClsVid->insert_det_videoclase_secciones($videoclase,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
                                         //$respuesta->alert($sql);
                					$arrnivel.= $nivel.",";
                					$arrgrado.= $grado.",";
                					$arrsecc.= $seccion.",";
                				}
                                    $nombre_grupo.= substr($nombre_grupo, 0, -2);
                			}else if($tipo == 2){
                				for($i = 0; $i< $filas; $i++){
                                         $grupo = $arrgrupo[$i];
                                         $sql.= $ClsVid->insert_det_videoclase_grupos($videoclase,$grupo); /// Inserta detalle
                                         //--
                                         $nombre_grupo.= $grupo.", ";
                				}
                                    $nombre_grupo.= substr($nombre_grupo, 0, -2);
                			}
                        } else {
                            $nombre_grupo = "TODOS";
                        }
        	    $rs = $ClsVid->exec_sql($sql);
        		//$respuesta->alert($sql);
        		$videoclase++; /// Maximo codigo
        		if($rs == 1){
                       if($plataforma == "ASMS Videoclass"){
                            $usuario = $_SESSION['codigo'];
                            $credenciales = $ClsVid->get_credentials($usuario);
                            $partnerId = $credenciales["partner"];
                            $userId = $credenciales["userid"];
                            $secret = $credenciales["secret"];
                            if($credenciales == ''){
                                 $respuesta->script('swal("Alto!", "Su usuario no tiene licencia activa para este tipo de videollamadas...", "error").then((value)=>{ cerrar(); });');
                                 return $respuesta;
                            }
                            $cui = $_SESSION['tipo_codigo'];
                            $organizador = $_SESSION["nombre"];
                            $desde = regresa_fechaHora($desde);
                            //$desde = strtotime ( '-2 hour' , strtotime ( $desde ) ) ;
                            $hasta = regresa_fechaHora($hasta);
                            //$hasta = strtotime ( '-2 hour' , strtotime ( $hasta ) ) ;
                            //revision de fechas programadas
                            //$nuevodesde = date ( 'd/m/Y H:i' , $desde );
                            //$nuevohasta = date ( 'd/m/Y H:i' , $hasta );
                            //$respuesta->alert("$nuevodesde - $nuevohasta");
                            //----
                            $arr_schedule = kaltura_add_schedule("$nombre $nombre_grupo",$descripcion, $partnerId,$userId,$secret);
                            $arr_event = kaltura_add_event($videoclase, $organizador, "$nombre $nombre_grupo", $cui, $desde, $hasta, $partnerId,$userId,$secret);
                            $schedule = $arr_schedule["data"]["id"];
                            $event = $arr_event["data"]["id"];
                            $partnerId = $arr_schedule["data"]["partnerId"];
                            //$respuesta->alert("$event, $schedule");
                            $arr_resource = kaltura_resource_event($event, $schedule, $partnerId,$userId,$secret);
        
                            if($arr_schedule["status"] == 1 && $arr_event["status"] == 1 && $arr_resource["status"] == 1){
                                 $sql = $ClsVid->modifica_schedule_videoclase($videoclase,$schedule,$event,$partnerId); /// update datos de kaltura
                                 $rs = $ClsVid->exec_sql($sql);
                                 if($rs == 1){
                                      $respuesta->script('swal("Excelente!", "Nueva Videoclase calendarizada con exito!", "success").then((value)=>{ window.location.reload(); });');
                                 }else{
                                      $sql = $ClsVid->delete_videoclase($videoclase); /// delete
                                      $rs = $ClsVid->exec_sql($sql);
                                      $respuesta->script('swal("Error", "Error en la actualizaci\u00F3n de parametros Kaltura", "error").then((value)=>{ cerrar(); });');
                                      $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
                                      $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
                                 }
                            }else{
                                 $sql = $ClsVid->delete_videoclase($videoclase); /// delete
                                 $rs = $ClsVid->exec_sql($sql);
                                 $respuesta->script('swal("Error", "Error en la transacci\u00F3n con el API de videollamadas", "error").then((value)=>{ cerrar(); });');
                                 $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
                                 $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
                            }
                       }else{
                            $respuesta->script('swal("Excelente!", "Nueva Videoclase recurrente calendarizada con exito!", "success").then((value)=>{ window.location.reload(); });');
                       }
        		}else{
        			$respuesta->script('swal("Error", "Error en la creaci\u00F3n del evento en BD...", "error").then((value)=>{ cerrar(); });');
        			$respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
        			$respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
        		}
                }
            }
	    }     
     return $respuesta;
}

function Buscar_Videoclase_recurrente($codigo,$recurrente){
     //instanciamos el objeto para generar la respuesta con ajax
     //$respuesta = new xajaxResponse('ISO-8859-1');
     $respuesta = new xajaxResponse();
     $ClsVid = new ClsVideoclase();

     //$respuesta->alert("$codigo");
     $result = $ClsVid->get_videoclase($codigo);
     if(is_array($result)){
          foreach($result as $row){
               $codigo = $row["vid_codigo"];
               $respuesta->assign("codigo","value",$codigo);
               $nombre = utf8_decode($row["vid_nombre"]);
               $respuesta->assign("nombre","value",$nombre);
               $descripcion = utf8_decode($row["vid_descripcion"]);
               $respuesta->assign("descripcion","value",$descripcion);
               $desde = $row["vid_fecha_inicio"];
               $desde = cambia_fechaHora($desde);
               $fecini = substr($desde,0,10);
               $horini = substr($desde,11,18);
               $respuesta->assign("fecini","value",$fecini);
               $respuesta->assign("horini","value",$horini);
               $hasta = $row["vid_fecha_fin"];
               $hasta = cambia_fechaHora($hasta);
               $fecfin = substr($hasta,0,10);
               $horfin = substr($hasta,11,18);
               $respuesta->assign("fecfin","value",$fecfin);
               $respuesta->assign("horfin","value",$horfin);
               $plataforma = $row["vid_plataforma"];
               $respuesta->assign("plataforma","value",$plataforma);
               $link = $row["vid_link"];
               $respuesta->assign("link","value",$link);
               //--
               $evento = $row["vid_event"];
               $respuesta->assign("evento","value",$evento);
               $schedule = $row["vid_schedule"];
               $respuesta->assign("schedule","value",$schedule);
               $partnerid = $row["vid_partnerId"];
               $respuesta->assign("partnerId","value",$partnerid);
               //--
               $target = $row["vid_target"];
               $respuesta->assign("target","value",$target);
               $tipo_target = $row["vid_tipo_target"];
               $respuesta->assign("tipotarget","value",$tipo_target);
               $tipo_clase = $row["vid_tipoclase"];
               $respuesta->assign("tipoclase","value",$tipo_clase);
               $recurrente = $row["vid_codprimario"];
               $respuesta->assign("recurrente","value",$recurrente);
            //   $dia = date("N");
            //   $dia->assign("dias","value",$dia);
               //////
               if($target == "SELECT"){
                    if($tipo_target == 1){
                         $contenido = tabla_grados_secciones();
                         $respuesta->assign("divgrupos","innerHTML",$contenido);
                    }else if($tipo_target == 2){
                         $contenido = grupos_lista_multiple("grupos");
                         $respuesta->assign("divgrupos","innerHTML",$contenido);
                    }else{
                         $contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
                         $respuesta->assign("divgrupos","innerHTML",$contenido);
                    }
                    $respuesta->script('document.getElementById("tipotarget").removeAttribute("disabled");');
               }else{
                    $respuesta->script('document.getElementById("tipotarget").setAttribute("disabled","disabled");');
                    $respuesta->script('document.getElementById("tipoclase").setAttribute("disabled","disabled");');
                    $contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
                    $respuesta->assign("divgrupos","innerHTML",$contenido);
               }

               if($plataforma != "ASMS Videoclass"){
                    $respuesta->script('document.getElementById("link").removeAttribute("disabled");');
               }else{
                    $respuesta->script('document.getElementById("link").setAttribute("disabled","disabled");');
               }
          }
          //--
          $respuesta->script("document.getElementById('dia').className = '';");
          $contenido = tabla_videoclase($codigo,'','');
          $respuesta->assign("result","innerHTML",$contenido);
          //abilita y desabilita botones
          $respuesta->script("document.getElementById('btn-modificar2').className = 'btn btn-primary';");
          $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
          $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary hidden';");
          $respuesta->script('document.getElementById("nombre").focus();');
          $respuesta->script("cerrar();");
     }
     return $respuesta;
}

function Buscar_Videoclase($codigo){
     //instanciamos el objeto para generar la respuesta con ajax
     //$respuesta = new xajaxResponse('ISO-8859-1');
     $respuesta = new xajaxResponse();
     $ClsVid = new ClsVideoclase();

     //$respuesta->alert("$codigo");
     $result = $ClsVid->get_videoclase($codigo);
     if(is_array($result)){
          foreach($result as $row){
               $codigo = $row["vid_codigo"];
               $respuesta->assign("codigo","value",$codigo);
               $nombre = utf8_decode($row["vid_nombre"]);
               $respuesta->assign("nombre","value",$nombre);
               $descripcion = utf8_decode($row["vid_descripcion"]);
               $respuesta->assign("descripcion","value",$descripcion);
               $desde = $row["vid_fecha_inicio"];
               $desde = cambia_fechaHora($desde);
               $fecini = substr($desde,0,10);
               $horini = substr($desde,11,18);
               $respuesta->assign("fecini","value",$fecini);
               $respuesta->assign("horini","value",$horini);
               $hasta = $row["vid_fecha_fin"];
               $hasta = cambia_fechaHora($hasta);
               $fecfin = substr($hasta,0,10);
               $horfin = substr($hasta,11,18);
               $respuesta->assign("fecfin","value",$fecfin);
               $respuesta->assign("horfin","value",$horfin);
               $plataforma = $row["vid_plataforma"];
               $respuesta->assign("plataforma","value",$plataforma);
               $link = $row["vid_link"];
               $respuesta->assign("link","value",$link);
               //--
               $evento = $row["vid_event"];
               $respuesta->assign("evento","value",$evento);
               $schedule = $row["vid_schedule"];
               $respuesta->assign("schedule","value",$schedule);
               $partnerid = $row["vid_partnerId"];
               $respuesta->assign("partnerId","value",$partnerid);
               //--
               $target = $row["vid_target"];
               $respuesta->assign("target","value",$target);
               $tipo_target = $row["vid_tipo_target"];
               $respuesta->assign("tipotarget","value",$tipo_target);
               $tipo_clase = 2;
               $respuesta->assign("tipoclase","value",$tipo_clase);
               //////
               if($target == "SELECT"){
                    if($tipo_target == 1){
                         $contenido = tabla_grados_secciones();
                         $respuesta->assign("divgrupos","innerHTML",$contenido);
                    }else if($tipo_target == 2){
                         $contenido = grupos_lista_multiple("grupos");
                         $respuesta->assign("divgrupos","innerHTML",$contenido);
                    }else{
                         $contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
                         $respuesta->assign("divgrupos","innerHTML",$contenido);
                    }
                    $respuesta->script('document.getElementById("tipotarget").removeAttribute("disabled");');
               }else{
                    $respuesta->script('document.getElementById("tipotarget").setAttribute("disabled","disabled");');
                    $contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
                    $respuesta->assign("divgrupos","innerHTML",$contenido);
               }

                if($plataforma != "ASMS Videoclass"){
                    $respuesta->script('document.getElementById("link").removeAttribute("disabled");');
                }else{
                    $respuesta->script('document.getElementById("link").setAttribute("disabled","disabled");');
                }
               
                $respuesta->script('document.getElementById("simpleini").className="";');
                $respuesta->script('document.getElementById("simplefin").className=""');
          }
          //--
          $contenido = tabla_videoclase($codigo,'','');
          $respuesta->assign("result","innerHTML",$contenido);
          //abilita y desabilita botones
          $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary';");
          $respuesta->script("document.getElementById('btn-modificar2').className = 'hidden';");
          $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary hidden';");
          $respuesta->script('document.getElementById("nombre").focus();');
          $respuesta->script("cerrar();");
     }
     return $respuesta;
}

function Situacion_Videoclase($codigo){
 $respuesta = new xajaxResponse();
 $ClsVid = new ClsVideoclase();

 //$respuesta->alert("$codigo");
 if($codigo != ""){
      $ClsVid = new ClsVideoclase();
      $result = $ClsVid->get_videoclase($codigo);
      if(is_array($result)){
           foreach($result as $row){
                $plataforma = trim($row["vid_plataforma"]);
                $eventId = $row["vid_link"];
                $schedule = $row["vid_schedule"];
                $partnerid = $row["vid_partnerId"];
           }
      }
      if($plataforma == "ASMS Videoclass"){
           $usuario = $_SESSION['codigo'];
           $credenciales = $ClsVid->get_credentials($usuario);
           $partnerId = $credenciales["partner"];
           $userId = $credenciales["userid"];
           $secret = $credenciales["secret"];
           if($credenciales == ''){
                $respuesta->script('swal("Alto!", "Su usuario no tiene licencia activa para este tipo de videollamadas...", "error").then((value)=>{ cerrar(); });');
                return $respuesta;
           }
           ///--- eliminacion anteriro ---///
           kaltura_delete_schedule($schedule, $partnerId,$userId,$secret);
           kaltura_delete_event($event, $partnerId,$userId,$secret);
      }
      $sql = $ClsVid->cambia_sit_videoclase($codigo,0);
      $rs = $ClsVid->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
           $respuesta->script('swal("Ok", "Videoclase eliminada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
           $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
 }

 return $respuesta;
}
    
function Situacion_Videoclase_recurrente($codigo,$codprimario){
    $respuesta = new xajaxResponse();
    $ClsVid = new ClsVideoclase();
    $result = $ClsVid-> get_videoclase_recurrente($codprimario);
        if(is_array($result)){
            foreach($result as $row){
            $codigo = $row["vid_codigo"];
            //$respuesta->alert($codigo); 
              $result = $ClsVid->get_videoclase($codigo);
              if(is_array($result)){
                   foreach($result as $row){
                        $plataforma = trim($row["vid_plataforma"]);
                        $eventId = $row["vid_link"];
                        $schedule = $row["vid_schedule"];
                        $partnerid = $row["vid_partnerId"];
                   }
              }
              if($plataforma == "ASMS Videoclass"){
                   $usuario = $_SESSION['codigo'];
                   $credenciales = $ClsVid->get_credentials($usuario);
                   $partnerId = $credenciales["partner"];
                   $userId = $credenciales["userid"];
                   $secret = $credenciales["secret"];
                   if($credenciales == ''){
                        $respuesta->script('swal("Alto!", "Su usuario no tiene licencia activa para este tipo de videollamadas...", "error").then((value)=>{ cerrar(); });');
                        return $respuesta;
                   }
                   ///--- eliminacion anteriro ---///
                   kaltura_delete_schedule($schedule, $partnerId,$userId,$secret);
                   kaltura_delete_event($event, $partnerId,$userId,$secret);
              }
              $sql = $ClsVid->cambia_sit_videoclase($codigo,0);
              $rs = $ClsVid->exec_sql($sql);
              //$respuesta->alert("$sql");
              if($rs == 1){
                   $respuesta->script('swal("Ok", "Videoclase eliminada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
              }else{
                   $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
              }
        }
    }

 return $respuesta;
}
//////////////////---- RECORDATORIO -----/////////////////////////////////////////////

function Recordatorio($codigo){
     $respuesta = new xajaxResponse();
     $ClsVid = new ClsVideoclase();
     $ClsPush = new ClsPushup();

     if($codigo != ""){
          $result = $ClsVid->get_videoclase($codigo);
          //$respuesta->alert("$result");
		if(is_array($result)){
               foreach($result as $row){
                    $codigo = $row["vid_codigo"];
                    $titulo = trim($row["vid_nombre"]);
                    //--
                    $desde = $row["vid_fecha_inicio"];
                    $desde = cambia_fechaHora($desde);
                    $fecini = substr($desde,0,10);
                    $horini = substr($desde,11,18);
                    //--
                    $hasta = $row["vid_fecha_fin"];
                    $hasta = cambia_fechaHora($hasta);
                    $fecfin = substr($hasta,0,10);
                    $horfin = substr($hasta,11,18);
                    //
                    $target = trim($row["vid_target"]);
                    $tipo_target = trim($row["vid_tipo_target"]);
               }
		}

		if($target == "SELECT"){
               if($tipo_target == 1){
                    $pensum = $_SESSION["pensum"];
                    $result = $ClsVid->get_det_videoclase_secciones($codigo,'','','','');
                    if(is_array($result)){
                         foreach($result as $row){
                              $pensum = $row["niv_pensum"];
                              $nivel = $row["niv_codigo"];
                              $grado = $row["gra_codigo"];
                              $seccion = $row["sec_codigo"];
                              $arrnivel.= ($nivel == 0)?"":$nivel.",";
                              $arrgrado.= ($grado == 0)?"":$grado.",";
                              $arrseccion.= ($seccion == 0)?"":$seccion.",";
                         }
                    }
                    $arrnivel = substr($arrnivel,0,-1);
                    $arrgrado = substr($arrgrado,0,-1);
                    $arrseccion = substr($arrseccion,0,-1);
                    $result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,$arrnivel,$arrgrado,$arrseccion);
			}else if($tipo_target == 2){
                    $result = $ClsVid->get_det_videoclase_grupos($codigo,'');
                    if(is_array($result)){
                         foreach($result as $row){
                              $grupo = $row["det_grupo"];
                              $arrgrupo.= $grupo.",";
                         }
                    }
                    $arrgrupo = substr($arrgrupo,0,-1);
                    $result_push = $ClsPush->get_grupos_users($arrgrupo);
			}
		}else{
			$pensum = $_SESSION["pensum"];
			$result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,'','','');
		}

          //$respuesta->alert("$result_push");
          /// registra la notificacion //
		if(is_array($result_push)) {
               $title = 'Recordatorio';
               $message = "Recordatorio: $titulo ($fecini $horini)";
               $message = depurador_texto($message);
               $push_tipo = 13;
               $item_id = $codigo;
               $cert_path = '../../CONFIG/push/ck_prod.pem';
               //--
               foreach ($result_push as $row){
                    $user_id = $row["user_id"];
                    $sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
               }
		}

		$rs = $ClsVid->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
               ///// Ejecuta notificaciones push
               if(is_array($result_push)) {
                    foreach ($result_push as $row){
                         $user_id = $row["user_id"];
                         $device_type = $row["device_type"];
                         $device_token = $row["device_token"];
                         $certificate_type = $row["certificate_type"];
                         //cuenta las notificaciones pendientes
                         $pendientes = intval($ClsPush->count_pendientes_leer($user_id));
                         //--
                         $data = array(
                              'landing_page'=> 'videollamadas',
                              'codigo' => $item_id
                         );
                         //envia la push
                         if($device_type == 'android') {
                              SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // Android
                         }else if($device_type == 'ios') {
                              SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
                         }
                    }
               }
               ////
               $respuesta->script('swal("Ok", "Recordatorio notificado con exito!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ window.location.reload(); });');
		}
     }

     return $respuesta;
}


//////////////////---- COMBOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Target_Grupos");
//////////////////---- ALUMNOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Videoclase");
$xajax->register(XAJAX_FUNCTION, "Modificar_Videoclase");
$xajax->register(XAJAX_FUNCTION, "Modificar_Videoclase_recurrente");
$xajax->register(XAJAX_FUNCTION, "Modificar_Videoclase_uar");
$xajax->register(XAJAX_FUNCTION, "Buscar_Videoclase");
$xajax->register(XAJAX_FUNCTION, "Buscar_Videoclase_recurrente");
$xajax->register(XAJAX_FUNCTION, "Situacion_Videoclase");
$xajax->register(XAJAX_FUNCTION, "Situacion_Videoclase_recurrente");
//////////////////---- RECORDATORIO -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Recordatorio");
//El objeto xajax tiene que procesar cualquier petici�n
$xajax->processRequest();

?>
