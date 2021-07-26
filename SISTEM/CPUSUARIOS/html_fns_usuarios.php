<?php
include_once('../html_fns.php');
require_once("../recursos/mandrill/src/Mandrill.php"); //--correos
include_once("FRMresponse_pass_constructor.php");
require_once("../../CONFIG/constructor.php");

function tabla_usuarios($cod,$tipo,$nom,$niv,$sit){
	$ClsUsu = new ClsUsuario();
	$result = $ClsUsu->get_usuario($cod,$tipo,$nom,$mail,$nivel,$band,$sit);
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "60px" class = "text-center"><span class="glyphicon glyphicon-cog"></span></td>';
			$salida.= '<th width = "200px" class = "text-center">NOMBRE DEL USUARIO</td>';
			$salida.= '<th width = "200px" class = "text-center">TIPO</td>';
			$salida.= '<th width = "100px" class = "text-center">E-MAIL</td>';
			$salida.= '<th width = "100px" class = "text-center">TEL.</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["usu_id"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Usuario('.$cod.')" title = "Editar Usuario" ><span class="glyphicon glyphicon-pencil"></span></button>';
			$salida.= '</td>';
			//nombre
			$nom = utf8_decode($row["usu_nombre"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			//empresa
			$tipo = $row["usu_tipo"];
			switch($tipo){
				case 5: $tipo = "ADMINISTRADOR"; break;
				case 1: $tipo = "DIRECTOR O AUTORIDAD"; break;
				case 2: $tipo = "DOCENTE O MAESTRO"; break;
				case 3: $tipo = "PADRE DE FAMILIA"; break;
				case 10: $tipo = "ALUMNO"; break;
				case 6: $tipo = "USUARIO ADMINISTRATIVO"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//usuario
			$mail = $row["usu_mail"];
			$salida.= '<td class = "text-center">'.$mail.'</td>';
			$tel = $row["usu_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_busca_usuarios($tipo,$nom,$usu,$sit,$acc){
	$ClsUsu = new ClsUsuario();
	switch($acc){
		case 1: 
			$titulo = "Listado de Usuarios para Asignaci&oacute;n de Roles"; 
			$img = "edit"; 
			$title = "Ver Info. de Usuario"; 
			break;
		case 2: 
			$titulo = "Visualizaci&oacute;n de Informaci&oacute;n de Usuarios"; 
			$img = "eye-open"; 
			$title = "Ver Info. de Usuario"; 
			break;
		case 3: 
			$titulo = "Listado de Usuarios para Cambio de Situaci&oacute;n"; 
			$img = "pencil"; 
			$title = "Seleccionar Usuario"; 
			break;
		case 4: 
			$titulo = "Visualizaci&oacute;n de Permisos de Usuarios"; 
			$img = "eye-open"; 
			$title = "Ver Info. de Usuario"; 
			break;
		case 5: 
			$titulo = "Visualizaci&oacute;n de Historial de Permisos de Usuarios"; 
			$img = "eye-open"; 
			$title = "Ver Info. de Usuario"; 
			break;
	}

	$result = $ClsUsu->get_usuario('',$nom,'',$tipo,'',$sit,$usu);
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
                        $salida.= '<h4 class="encabezado"> &nbsp;'.$titulo.' </h4>';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "60px" height = "30px"></td>';
			$salida.= '<th width = "200px">NOMBRE DEL USUARIO</td>';
			$salida.= '<th width = "200px">TIPO</td>';
			$salida.= '<th width = "250px">ROL</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$sit = $row["usu_situacion"];
			$class = ($sit == 1)?"info":"danger";
			$salida.= '<tr class = "'.$class.'">';
			//codigo
			$cod = $row["usu_id"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "Seleccionar_UsuarioJs('.$cod.','.$acc.','.$i.')" title = "Editar Usuario" ><span class="glyphicon glyphicon-'.$img.'"></span></button>';
			$salida.= '</td>';
			//nombre
			$nom = utf8_decode($row["usu_nombre"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			//empresa
			$tipo = $row["usu_tipo"];
			switch($tipo){
				case 5: $tipo = "ADMINISTRADOR"; break;
				case 1: $tipo = "DIRECTOR O AUTORIDAD"; break;
				case 2: $tipo = "DOCENTE O MAESTRO"; break;
				case 3: $tipo = "PADRE DE FAMILIA"; break;
				case 10: $tipo = "ALUMNO"; break;
				case 6: $tipo = "USUARIO ADMINISTRATIVO"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//nivel
			$niv = $row["roll_nombre"];
			$salida.= '<td class = "text-center">'.$niv.'</td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td colspan = "4"><div id = "idusu'.$i.'" class = "text-center"></div></td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '<tr>';
			$salida.= '<td colspan = "4" class = "text-center" >';
			$salida.= '<br>';
			$salida.= '<button type="button" class="btn btn-primary" onclick = "Limpiar()" title = "Limpiar" ><span class="glyphicon glyphicon-refresh"></span></button>';
			$salida.= '<br>';
			$salida.= '</td>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
			$salida.= '</form>';
	}
	
	return $salida;
}


function tabla_info_usuarios($cod,$fila){
	$ClsUsu = new ClsUsuario();
	$result = $ClsUsu->get_usuario($cod,$nom,$mail,$tipo,$band,$sit);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$grup1 = '';
		foreach($result as $row){
			$salida.= '<tr>';
			//mail
			$mail = $row["usu_mail"];
			$salida.= '<td class = "text-center" width = "200px" ><em>e-mail:</em><br>'.$mail.'</td>';
			//telefono
			$tel = $row["usu_telefono"];
			$salida.= '<td class = "text-center" width = "200px" ><em>Telefono:</em><br>'.$tel.'</td>';
			//situacion
			$sit = $row["usu_situacion"];
			$sit = ($sit == 1)?"ACTIVO":"INACTIVO";
			$salida.= '<td class = "text-center" width = "200px" ><em>Situaci&oacute;n:</em><br>'.$sit.'</td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			//telefono
			$fini = $row["usu_fecha_inicio"];
			$fini = $ClsUsu->cambia_fecha($fini);
			$salida.= '<td class = "text-center" width = "200px" ><em>1er. Ingreso:</em><br>'.$fini.'</td>';
			//mail
			$cpass = $row["usu_cambio"];
			$campass = ($cpass == 1)?"SI":"No";
			$salida.= '<td class = "text-center" width = "200px" ><em>Cambio de Pass. Frecuente?</em><br>'.$campass.'</td>';
			//telefono
			$diasp = $row["usu_dias_pass"];
			$diasp = ($cpass == 1)?$diasp:"-";
			$salida.= '<td class = "text-center" width = "200px" ><em>Dias para Cambiarla?</em><br>'.$diasp.' Dia(s)</td>';
			$salida.= '</tr>';
		}
			$salida.= '<tr>';
			$salida.= '<td colspan = "4" class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success" onclick = "cerrar_info('.$fila.');" title = "Click para cerrar informaci&oacute;n" ><span class="glyphicon glyphicon-triangle-top"></span></button>';
			$salida.= '</td>';
			$salida.= '</tr>';
			
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

///////////////////////PERMISOS//////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
function tabla_permisos_libre(){
	$ClsPerm = new ClsPermiso();
	$cont = $ClsPerm->count_permisos($id,$grupo,$desc,$clv);
	
	if($cont>0){
		$result = $ClsPerm->get_permisos($id,$grupo,$desc,$clv);
			$salida.= '<form name = "f2" id = "f2" onsubmit = "return false">';
			$salida.= '<div class="panel-body">';
                        $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$grup1 = '';
		$i = 1;//cuenta permisos en general
		$j = 1;//cuenta grupos de permisos
		$k = 1;//cuenta permisos en un grupo
		foreach($result as $row){
			$grup2 = trim($row["perm_grupo"]);
			if($grup1 != $grup2){
			//-- conteo y listado de id's de chk en un solo grupo	
			$salida.= '<tr class="success">';
			$salida.= '<input type = "hidden" name = "gruplist'.($j-1).'" id = "gruplist'.($j-1).'" value = "'.($k).'-'.($i-1).'" />';
			$salida.= '</tr>';
			//--
			$salida.= '<tr class="success">';
			//grupo
			$grupo = utf8_decode($row["gperm_desc"]);
			$salida.= '<th class = "text-center" width = "70px">';
			$salida.= '<input type = "checkbox" name = "chkg'.$j.'" id = "chkg'.$j.'" onclick = "check_todo_grupo('.$j.');" title = "Click para seleccionar todo el grupo" >';
			$salida.= '</th>';
			$salida.= '<th colspan = "2" height = "20px" >'.$grupo.'</th>';
			$salida.= '</tr>';
			$grup1 = $grup2;
			$j++; //controla la cantidad de grupos
			$k = 0;
			}
			$salida.= '<tr>';
			//codigo
			$cod = $row["perm_id"];
			$grup = $row["perm_grupo"];
			$salida.= '<td class = "text-center" width = "70px">';
			$salida.= '<input type = "checkbox" name = "chk'.$i.'" id = "chk'.$i.'" title = "Click para seleccionar" >';
			$salida.= '<input type = "hidden" name = "cod'.$i.'" id = "cod'.$i.'" value = "'.$cod.'" />';
			$salida.= '<input type = "hidden" name = "gru'.$i.'" id = "gru'.$i.'" value = "'.$grup.'" />';
			$salida.= '</td>';
			//grupo
			//nombre
			$nom = utf8_decode($row["perm_desc"]);
			$salida.= '<td align = "left" width = "450px">'.$nom.'</td>';
			$salida.= '</tr>';
			$i++;
			$k++;
		}
			$i--; //le quita la ultima vuelta de mas...
			$salida.= '<tr>';
			$salida.= '<input type = "hidden" name = "gruplist'.($j-1).'" id = "gruplist'.($j-1).'" value = "'.($k).'-'.($i).'" />';
			$salida.= '<input type = "hidden" name = "cant" id = "cant" value = "'.$i.'" />';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
			$salida.= '</form>';
	}
	
	return $salida;
}


function tabla_permisos_roll($roll){
	$ClsRoll = new ClsRoll();
	$result = $ClsRoll->get_det_roll_outer_edit($roll);
	
	if(is_array($result)){
		$salida.= '<form name = "f2" id = "f2" onsubmit = "return false">';
		$salida.= '<div class="panel-body">';
                $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$grup1 = '';
		$i = 1;		
		$j = 0;	
		foreach($result as $row){
			$grup2 = trim($row["perm_grupo"]);
			if($grup1 != $grup2){
			$salida.= '<tr class="success">';
			//grupo
			$grupo = utf8_decode($row["gperm_desc"]);
			$salida.= '<th colspan = "2" height = "20px" >'.$grupo.'</th>';
			$salida.= '</tr>';
			$grup1 = $grup2;
			}
			$salida.= '<tr>';
			//codigo
			$cod = $row["perm_id"];
			$grup = $row["perm_grupo"];
			$activ = $row["activo"];
			$chk = ($activ > 0)?"checked":"";
			$j = ($activ > 0)?$j+1:$j;
			$img = ($activ > 0)? "ok" : "minus";
			$color = ($activ > 0)? "success" : "default";
			$salida.= '<td class = "text-center" width = "70px">';
			$salida.= '<button type="button" class="btn btn-'.$color.' btn-xs"><span class="glyphicon glyphicon-'.$img.'"></span></button>';
			$salida.= '<input type = "checkbox" name = "chk'.$i.'" id = "chk'.$i.'" '.$chk.' style = "display:none;" >';
			$salida.= '<input type = "hidden" name = "cod'.$i.'" id = "cod'.$i.'" value = "'.$cod.'" />';
			$salida.= '<input type = "hidden" name = "gru'.$i.'" id = "gru'.$i.'" value = "'.$grup.'" />';
			$salida.= '</td>';
			//nombre
			$nom = utf8_decode($row["perm_desc"]);
			$salida.= '<td align = "left" width = "450px">'.$nom.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--; //le quita la ultima vuelta de mas...
			$salida.= '<tr>';
			$salida.= '<input type = "hidden" name = "cant" id = "cant" value = "'.$i.'" />';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
			$salida.= '</form>';
	}
	
	return $salida;
}

function tabla_botones_asignacion(){
	
	$salida.= '<br>';
	$salida.= '<div class="row">';
	$salida.= '<div class="col-xs-12 text-center">';
	$salida.= '<button type="button" class="btn btn-default" onclick = "Limpiar();"><span class="glyphicon glyphicon-refresh"></span> Cancelar</button> ';
	$salida.= '<button type="button" class="btn btn-success" onclick = "AsignarPerm();"><span class="glyphicon glyphicon-floppy-disk"></span> Asignar</button> ';
        $salida.= '</div>';
        $salida.= '</div>';
	$salida.= '<br><br>';
	
	return $salida;
}

function tabla_encabezado_asignacion($usu){
	$ClsUsu = new ClsUsuario();
	$result = $ClsUsu->get_usuario($usu);
	if(is_array($result)){
			$salida.= '<form name = "f1" id = "f1" method="post" enctype="multipart/form-data">';
			$salida.= '<div class="panel-heading"><label> ASIGNACI&Oacute;N DE PERMISOS </label></div>';
			$salida.= '<br>';
			$salida.= '<div class="panel-body">';
                        $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["usu_id"];
			//nombre
			$nom = utf8_decode($row["usu_nombre"]);
			$salida.= '<td align = "text-left" style = "padding:5px 10px;"><label>Usuario:</label> </th>';
			$salida.= '<td class = "celda" align = "text-left" style = "padding:5px 10px;"> '.$nom;
			$salida.= '<input type = "hidden" name = "usu" id = "usu" value = "'.$cod.'" />';
			$salida.= '<input type = "hidden" name = "sql1" id = "sql1" /></td>';
			//empresa
			$tipo = utf8_decode($row["suc_nombre"]);
			$salida.= '<td align = "text-left" style = "padding:5px 10px;"><label>Empresa:</label> </th>';
			$salida.= '<td class = "celda" align = "text-left" style = "padding:5px 10px;"> '.$tipo.'</td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			//nivel
			$niv = utf8_decode($row["roll_nombre"]);
			$salida.= '<td align = "text-left" style = "padding:5px 10px;" ><label>Rol:</label> </th>';
			$salida.= '<td align = "text-left" colspan = "3"> '.Roll_html().'</td>';
			$salida.= '</tr>';
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
			$salida.= '</form>';
	}
	
	return $salida;
}


function tabla_ver_permisos_usu($fila,$usu,$roll = '',$perm = '',$grupo = '',$quien = ''){
	$ClsPerm = new ClsPermiso();
	$result = $ClsPerm->get_asi_permisos($usu,$roll,$perm,$grupo,$quien);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
                $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$grup1 = '';
		$i = 1;		
		foreach($result as $row){
			$grup2 = trim($row["perm_grupo"]);
			if($grup1 != $grup2){
			$salida.= '<tr class = "success">';
			//grupo
			$grupo = $row["gperm_desc"];
			$salida.= '<th colspan = "2" height = "20px" >'.$grupo.'</th>';
			$salida.= '</tr>';
			$grup1 = $grup2;
			}
			$salida.= '<tr>';
			//codigo
			$cod = $row["perm_id"];
			$grup = utf8_decode($row["perm_grupo"]);
			$salida.= '<td class = "text-center" width = "70px">';
			$salida.= '<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></button>';
			$salida.= '</td>';
			//nombre
			$nom = utf8_decode($row["perm_desc"]);
			$salida.= '<td align = "left" width = "450px">'.$nom.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--; //le quita la ultima vuelta de mas...
			
			$salida.= '<tr>';
			$salida.= '<td colspan = "2" class = "text-center" >';
			$salida.= '<br>';
			$salida.= '<button type="button" class="btn btn-success" onclick = "cerrar_info('.$fila.');" title = "Click para cerrar informaci&oacute;n" ><span class="glyphicon glyphicon-triangle-top"></span></button>';
			$salida.= '<br>';
			$salida.= '</td>';
			$salida.= '</tr>';
			
			
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
			$salida.= '</form>';
	}
	
	return $salida;
}


function tabla_hist_permisos_usu($fila,$usu,$roll = '',$perm = '',$grupo = '',$quienini = '',$quienfin = ''){
	$ClsPerm = new ClsPermiso();
	$result = $ClsPerm->get_hist_permisos($usu,$roll,$perm,$grupo,$quienini,$quienfin);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
                $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<th width = "200px" height = "30px">Permiso</td>';
			$salida.= '<th width = "200px">Asign&oacute;</td>';
			$salida.= '<th width = "250px">Fec. Asig.</td>';
			$salida.= '<th width = "200px">Quit&oacute;</td>';
			$salida.= '<th width = "250px">Fec. Quit&oacute;.</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$grup1 = '';
		foreach($result as $row){
			$grup2 = trim($row["perm_grupo"]);
			if($grup1 != $grup2){
			$salida.= '<tr class="success">';
			//grupo
			$grupo = $row["gperm_desc"];
			$salida.= '<th colspan = "5" height = "20px" >'.$grupo.'</th>';
			$salida.= '</tr>';
			$grup1 = $grup2;
			}
			$salida.= '<tr>';
			//nombre
			$nom = utf8_decode($row["perm_desc"]);
			$salida.= '<td align = "left" width = "400px">'.$nom.'</td>';
			//quien ini
			$qini = $row["quien_ini"];
			$salida.= '<td class = "text-center" width = "60px">'.$qini.'</td>';
			//fecha ini
			$fini = $row["hperm_fec_ini"];
			$fini = $ClsPerm->cambia_fechaHora($fini);
			$salida.= '<td class = "text-center" width = "60px">'.$fini.'</td>';
			//quien fin
			$qfin = $row["hperm_quien_fin"];
			$nqfin = ($qfin > 0)?$row["quien_fin"]:"";
			$salida.= '<td class = "text-center" width = "60px">'.$nqfin.'</td>';
			//fecha fin
			$ffinx = trim($row["hperm_fec_fin"]);
			$ffin = ($ffinx != "0000-00-00 00:00:00")?$ffinx:"";
			$ffin = $ClsPerm->cambia_fechaHora($ffin);
			$salida.= '<td class = "text-center" width = "60px">'.$ffin.'</td>';
			$salida.= '</tr>';
		}
			$i--; //le quita la ultima vuelta de mas...
			
			$salida.= '<tr>';
			$salida.= '<td colspan = "5" class = "text-center" >';
			$salida.= '<br>';
			$salida.= '<button type="button" class="btn btn-success" onclick = "cerrar_info('.$fila.');" title = "Click para cerrar informaci&oacute;n" ><span class="glyphicon glyphicon-triangle-top"></span></button>';
			$salida.= '<br>';
			$salida.= '</td>';
			$salida.= '</tr>';
			
			
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
			$salida.= '</form>';
	}
	
	return $salida;
}





function tabla_alumnos($pensum,$nivel,$grado,$seccion){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "60px">ID</td>';
		$salida.= '<th class = "text-center" width = "60px">TIPO ID</td>';
		$salida.= '<th class = "text-center" width = "120px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "120px">APELLIDO</td>';
		$salida.= '<th class = "text-center" width = "200px">PADRE O ENCARGADO</td>';
		$salida.= '<th class = "text-center" width = "100px">CORREO ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "30px"></th>';
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
			//TIPO ID
			$tipo = utf8_decode($row["alu_tipo_cui"]);
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//correo
			$pad = utf8_decode($row["alu_padre"]);
			$salida.= '<td class = "text-left">'.$pad.'</td>';
			//correo
			$mail = $row["alu_mail"];
			$salida.= '<td class = "text-left">'.$mail.'</td>';
			//codigo
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary" onclick="xajax_Grabar_Usuario_Alumno(\''.$cui.'\');" title = "Crear Usuario" ><i class="fa fa-user"></i></button> ';
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


function tabla_direcotrio_alumnos($pensum = ''){
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAlu = new ClsAlumno();
	
	if($pensum == ""){
		$pensum = $ClsPen->get_pensum_activo();
	}
	
	$result = $ClsAcad->get_seccion_alumno($pensum,'','','','','','',1);
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "60px">FECHA NAC.</td>';
		$salida.= '<th class = "text-center" width = "100px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "150px">PADRE O ENCARGADO</td>';
		$salida.= '<th class = "text-center" width = "60px">CORREO ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "30px"></td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nom.' '.$ape.'</td>';
			//FECHA NACIMIENTO
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			$salida.= '<td class = "text-center">'.$fecnac.'</td>';
			//correo
			$grado = utf8_decode($row["gra_descripcion"])." ".utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.'</td>';
			//correo
			$pad = utf8_decode($row["alu_padre"]);
			$salida.= '<td class = "text-left">'.$pad.'</td>';
			//correo
			$mail = $row["alu_mail"];
			$salida.= '<td class = "text-left">'.$mail.'</td>';
			//codigo
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary" onclick="xajax_Grabar_Usuario_Alumno(\''.$cui.'\');" title = "Crear Usuario" ><i class="fa fa-user"></i></button> ';
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



////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

function mail_pide_passw($id,$usu,$preg,$resp,$mail){
	$ClsUsu = new ClsUsuario();
	$resp = trim($resp);
	$result = $ClsUsu->get_valida_pregunta_resp($id,$usu,$preg,$resp);
	if(is_array($result)){
		foreach($result as $row){
			$nom = $row["usu_nombre"];
			$mail = $row["usu_mail"];
			$usu = $row["usu_usuario"];
			$pass = $row["usu_pass"];
			$pass = $ClsUsu->decrypt($pass, $usu); //desencripta el password
		}
		
		// Instancia el API KEY de Mandrill
		$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
		//--
		// Create the email and send the message
		$to = array(
				array(
					'email' => $mail,
					'name' => $nom,
					'type' => 'to'
				)
		);
		/////////////_________ Correo a admin
		$ClsReg = new ClsRegla();
		$result = $ClsReg->get_credenciales();
		if(is_array($result)){
			foreach($result as $row){
			   $colegio_nombre = utf8_decode($row['colegio_nombre']);
			}
		}
		$colegio_nombre = depurador_texto($colegio_nombre);
		////////////////
		//--
		$subject = "Tu Password";
		$texto = "Has recibido un nuevo mensaje desde ASMS ($colegio_nombre).<br><br> Aqui estan los detalles:<br>";
		$texto = "Nombre: <b>$nom</b><br>E-mail: <b>$mail</b><br>Usuario: <b>$usu</b><br>Password: <b>$pass</b>";
		$texto.= "<br><br>Que pases un feliz dia!!!";
	
		$html = mail_constructor($subject,$texto); 
		try{
		
			$message = array(
				'subject' => $subject,
				'html' => $html,
				'from_email' => 'noreply@inversionesd.com',
				'to' => $to
			 );
			 
			 //print_r($message);
			 //echo "<br>";
			 $result = $mandrill->messages->send($message);
			 $validacion =  1;
		} catch(Mandrill_Error $e) { 
			//echo "<br>";
			//print_r($e);
			//devuelve un mensaje de manejo de errores
			$validacion =  2;
		}         
		
		return $validacion;
	}else{
		return 0;
	}	
}

?>