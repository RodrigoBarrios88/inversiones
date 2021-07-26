<?php 
include_once('../html_fns.php');

function tabla_grupos($cod,$desc,$clv){
	$ClsPerm = new ClsPermiso();
	$result = $ClsPerm->get_grupo($cod,$desc,$clv);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><span class="glyphicon glyphicon-cog"></span></td>';
		$salida.= '<th class = "text-center" width = "60px">CODIGO</td>';
		$salida.= '<th class = "text-center" width = "270px">NOMBRE DEL GRUPO</td>';
		$salida.= '<th class = "text-center" width = "100px">CLAVE</td>';
		$salida.= '<th class = "text-center" width = "100px">SITUACI&Oacute;N</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$gru = $row["gperm_id"];
			$sit = $row["gperm_situacion"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Grupo('.$gru.');" title = "Click para seleccionar" ><span class="glyphicon glyphicon-pencil"></span></button>';
			$salida.= '</td>';
			//codigo
			$salida.= '<td class = "text-center"> # '.$gru.'</td>';
			//nombre
			$desc = utf8_decode($row["gperm_desc"]);
			$salida.= '<td align = "left">'.$desc.'</td>';
			//clave
			$clv = $row["gperm_clave"];
			$salida.= '<td class = "text-center">'.$clv.'</td>';
			//situacion
			$sit = ($sit == 1)?"<strong style='color:green'>ACTIVO</strong>":"<strong style='color:red'>INACTIVO</strong>";
			$salida.= '<td class = "text-center" >'.$sit.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_permisos($id,$grupo,$desc,$clv){
	$ClsPerm = new ClsPermiso();
	$result = $ClsPerm->get_permisos($id,$grupo,$desc,$clv);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px"><span class="glyphicon glyphicon-cog"></span></td>';
			$salida.= '<th class = "text-center" width = "20px">No.</td>';
			$salida.= '<th class = "text-center" width = "50px">CODIGO</td>';
			$salida.= '<th class = "text-center" width = "150px">GRUPO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE DEL PERMISOS</td>';
			$salida.= '<th class = "text-center" width = "100px">CLAVE</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["perm_id"];
			$grup = $row["perm_grupo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Permiso('.$cod.','.$grup.');" title = "Click para seleccionar" ><span class="glyphicon glyphicon-pencil"></span></button>';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//codigo
			$salida.= '<td class = "text-center">'.$cod.'</td>';
			//grupo
			$grupo = utf8_decode($row["gperm_desc"]);
			$salida.= '<td class = "text-left">'.$grupo.'</td>';
			//nombre
			$nom = utf8_decode($row["perm_desc"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//clave
			$clv = $row["perm_clave"];
			$salida.= '<td class = "text-center">'.$clv.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_roles($cod,$acc){
	$ClsRoll = new ClsRoll();
	$result = $ClsRoll->get_roll($cod);
	switch($acc){
		case 'V': 
			$img = "eye-open"; 
			$color = "success"; 
			$title = "Ver Detalle del Rol"; 
			break;
		case 'M': 
			$img = "pencil";
			$color = "warning"; 
			$title = "Seleccionar Rol"; 
			break;
		case 'D': 
			$img = "trash";
			$color = "danger"; 
			$title = "Seleccionar Rol"; 
			break;
	}
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "50px"><span class="glyphicon glyphicon-cog"></span></td>';
			$salida.= '<th class = "text-center" width = "150px">NOMBRE DEL ROL</td>';
			$salida.= '<th class = "text-center" width = "400px">DESCRIPCI&Oacute;N DEL ROL</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["roll_id"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-'.$color.' btn-xs" onclick = "Rol_AccionJs('.$cod.',\''.$acc.'\');" title = "Click para seleccionar" ><span class="glyphicon glyphicon-'.$img.'"></span></button>';
			$salida.= '</td>';
			//nombre
			$nom = utf8_decode($row["roll_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//descripcion
			$desc = utf8_decode($row["roll_desc"]);
			$salida.= '<td  class = "text-justify">'.$desc.'</td>';
			$salida.= '</tr>';
			$salida.= '<tr>';
			$salida.= '<td colspan = "3"><div id = "divroll'.$cod.'" class = "text-center" ></td>';
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


function tabla_permisos_asignacion(){
	$ClsPerm = new ClsPermiso();
	$result = $ClsPerm->get_permisos($id,$grupo,$desc,$clv);
	
	if(is_array($result)){	
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
			
		$grup1 = '';
		$i = 1;//cuenta permisos en general
		$j = 1;//cuenta grupos de permisos
		$k = 1;//cuenta permisos en un grupo
		foreach($result as $row){
			$grup2 = trim($row["perm_grupo"]);
			if($grup1 != $grup2){
			//-- conteo y listado de id's de chk en un solo grupo	
			$salida.= '<tr>';
			$salida.= '<input type = "hidden" name = "gruplist'.($j-1).'" id = "gruplist'.($j-1).'" value = "'.($k).'-'.($i-1).'" />';
			$salida.= '</tr>';
			//--
			$salida.= '<tr class="success">';
			//grupo
			$grupo = utf8_decode($row["gperm_desc"]);
			$salida.= '<th class = "text-center" width = "50px">';
			$salida.= '<input type = "checkbox" name = "chkg'.$j.'" id = "chkg'.$j.'" onclick = "check_todo_grupo('.$j.');" title = "Click para seleccionar todo el grupo" >';
			$salida.= '</th>';
			$salida.= '<th class = "text-center" colspan = "2" height = "20px" >'.$grupo.'</th>';
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
	}
	
	return $salida;
}


function tabla_editar_datosroll($cod,$nom,$desc){
		$salida.= '<div class="panel-body">
		<div class="row">
		<div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label></div>
		</div>
			<div class="row">
			<div class="col-xs-3 text-right"><label>Nombre del Rol: </label> <span class="text-danger">*</span> &nbsp;</div>
			<div class="col-xs-9">
		<input type = "text" class="form-control" name = "nom" id = "nom" onkeyup = "texto(this)" value = "'.$nom.'" />
		<input type = "hidden" name = "cod" id = "cod" value = "'.$cod.'" />
		<input type = "hidden" name = "sql" id = "sql" />
		</div>
		</div>
		<br>
		<div class="row">
        <div class="col-xs-3 text-right"><label>Descripci&oacute;n del Rol: </label> <span class="text-danger">*</span> &nbsp;</div>
        <div class="col-xs-9"><textarea type = "text" class="form-control" name = "desc" id = "desc" onkeyup = "texto(this)"> '.$desc.'</textarea></div>
        </div>
        <br>
        </div>';
	
	return $salida;
}

function tabla_permisos_editar($roll){
	$ClsRoll = new ClsRoll();
	$result = $ClsRoll->get_det_roll_outer_edit($roll);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$grup1 = '';
		$i = 1;//cuenta permisos en general
		$j = 1;//cuenta grupos de permisos
		$k = 1;//cuenta permisos en un grupo
		foreach($result as $row){
			$grup2 = trim($row["perm_grupo"]);
			if($grup1 != $grup2){
			//-- conteo y listado de id's de chk en un solo grupo	
			$salida.= '<tr>';
			$salida.= '<input type = "hidden" name = "gruplist'.($j-1).'" id = "gruplist'.($j-1).'" value = "'.($k).'-'.($i-1).'" />';
			$salida.= '</tr>';
			//--
			$salida.= '<tr class = "success">';
			//grupo
			$grupo = utf8_decode($row["gperm_desc"]);
			$salida.= '<th class = "text-center" width = "70px">';
			$salida.= '<input type = "checkbox" name = "chkg'.$j.'" id = "chkg'.$j.'" onclick = "check_todo_grupo('.$j.');" title = "Click para seleccionar todo el grupo" >';
			$salida.= '</th>';
			$salida.= '<th class = "text-center" colspan = "2" height = "20px" >'.$grupo.'</th>';
			$salida.= '</tr>';
			$grup1 = $grup2;
			$j++; //controla la cantidad de grupos
			$k = 0;
			}
			$salida.= '<tr>';
			//codigo
			$cod = $row["perm_id"];
			$grup = $row["perm_grupo"];
			$activ = $row["activo"];
			$chk = ($activ > 0)?"checked":"";
			$salida.= '<td class = "text-center" width = "70px">';
			$salida.= '<input type = "checkbox" name = "chk'.$i.'" id = "chk'.$i.'" title = "Click para seleccionar" '.$chk.'>';
			$salida.= '<input type = "hidden" name = "cod'.$i.'" id = "cod'.$i.'" value = "'.$cod.'" />';
			$salida.= '<input type = "hidden" name = "gru'.$i.'" id = "gru'.$i.'" value = "'.$grup.'" />';
			$salida.= '</td>';
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
	}
	
	return $salida;
}


function tabla_botones_actualizar(){
	$salida.= '<br>';
	$salida.= '<div class="row">';
	$salida.= '<div class="col-xs-12 text-center">';
	$salida.= '<button type="button" class="btn btn-default" onclick = "Limpiar1();"><span class="glyphicon glyphicon-refresh"></span> Cancelar</button> ';
	$salida.= '<button type="button" class="btn btn-success" onclick = "Modificar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button> ';
        $salida.= '</div>';
        $salida.= '</div>';
	$salida.= '<br><br>';
	
	return $salida;
}


function tabla_visualiza_permisos($roll){
	$ClsRoll = new ClsRoll();
	$result = $ClsRoll->get_det_roll('','',$roll);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$grup1 = '';
		$i = 1;		
		foreach($result as $row){
			$grup2 = trim($row["perm_grupo"]);
			if($grup1 != $grup2){
			$salida.= '<tr class="success">';
			//grupo
			$grupo = utf8_decode($row["gperm_desc"]);
			$salida.= '<th class = "text-center" colspan = "2" height = "20px" >'.$grupo.'</th>';
			$salida.= '</tr>';
			$grup1 = $grup2;
			}
			$salida.= '<tr>';
			//codigo
			$cod = $row["perm_id"];
			$grup = $row["perm_grupo"];
			$activ = $row["activo"];
			$chk = ($activ > 0)?"checked":"";
			$salida.= '<td class = "text-center" width = "40px">'.$i.'. </td>';
			$salida.= '<input type = "hidden" name = "cod'.$i.'" id = "cod'.$i.'" value = "'.$cod.'" />';
			$salida.= '<input type = "hidden" name = "gru'.$i.'" id = "gru'.$i.'" value = "'.$grup.'" />';
			$salida.= '</td>';
			//nombre
			$nom = utf8_decode($row["perm_desc"]);
			$salida.= '<td align = "left" width = "500px">'.$nom.'</td>';
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
	}
	
	return $salida;
}


?>