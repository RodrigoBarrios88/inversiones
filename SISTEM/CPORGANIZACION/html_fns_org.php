<?php 
include_once('../html_fns.php');

function tabla_plazas($plaza,$dct,$dlg,$suc,$dep){
	$ClsOrg = new ClsOrganizacion();
	$result = $ClsOrg->get_plaza($plaza,$suc,$dep,$dct,$dlg,$jer,$sub,$ind,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th class = "text-center" width = "100px">PLAZA</td>';
			$salida.= '<th class = "text-center" width = "150px">NOM. ABREVIADO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOM. COMPLETO</td>';
			$salida.= '<th class = "text-center" width = "150px">EMPRESA</td>';
			$salida.= '<th class = "text-center" width = "150px">DEPARAMENTO</td>';
			$salida.= '<th class = "text-center" width = "100px">SITUACI&Oacute;N</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["plaz_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Plazas('.$cod.');" title = "Editar Plaza" > <span class="glyphicon glyphicon-pencil"></span> </button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "EliminarPlaza('.$cod.');" title = "Eliminar Plaza" > <span class="fa fa-trash-o"></span> </button>';
			$salida.= '</td>';
			//Plaza
			$plaza = $row["plaz_codigo"];
			$plaza = Agrega_Ceros($plaza);
			$salida.= '<td class = "text-center">'.$plaza.'</td>';
			//desc corta
			$dct = utf8_decode($row["plaz_desc_ct"]);
			$salida.= '<td class = "text-center">'.$dct.'</td>';
			//desc larga
			$dlg = utf8_decode($row["plaz_desc_lg"]);
			$salida.= '<td class = "text-center">'.$dlg.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center">'.$suc.'</td>';
			//departamento
			$dep = utf8_decode($row["dep_desc_ct"]);
			$salida.= '<td class = "text-center">'.$dep.'</td>';
			//situacion
			$sit = $row["plaz_situacion"];
			$sit = ($sit == 1)?"ACTIVO":"INACTIVO";
			$salida.= '<td class = "text-center">'.$sit.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function tabla_personal($dpi,$nom = '',$ape = '',$suc = '',$gene = '',$nit = '',$pais = ''){
	$ClsPer = new ClsPersonal();
		$result = $ClsPer->get_personal($dpi,$nom,$ape,$suc,$gene,$nit,'',$pais);
			
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "40px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "15px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">DPI</th>';
			$salida.= '<th class = "text-center" width = "200px">Nombres y Apellidos</th>';
			$salida.= '<th class = "text-center" width = "50px">Genero</th>';
			$salida.= '<th class = "text-center" width = "150px">Empresa</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
	if(is_array($result)){
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//botones
			$dpi = $row["per_dpi"];
			$salida.= '<td  class = "text-center">';
			$salida.= '<a type="button" class="btn btn-success btn-xs" onclick = "abrir();xajax_Buscar_Personal(\''.$dpi.'\')" title = "Selecionar Personal" ><span class="fa fa-check"></span></a> ';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//DPI
			$dpi = $row["per_dpi"];
			$salida.= '<td class = "text-center">'.$dpi.'</td>';
			//nombre
			$nom = utf8_decode($row["per_nombres"])." ".utf8_decode($row["per_apellidos"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			//genero
			$gene = $row["per_genero"];
			$genero = ($gene == "M")?"MASCULINO":"FEMENINO";
			$salida.= '<td class = "text-center">'.$genero.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center">'.$suc.'</td>';
			//--
			$salida.= '</tr>';
			//linea divisoria
			$i++;
		}
	}	
			$salida.= '</table>';
			$salida.= '</div>';
	
	return $salida;
}


function seccion_organigrama($suc,$dep='',$sub='',$i='',$jer=''){
	$ClsOrg = new ClsOrganizacion();
	$i++;
	if($i == 1){ //valida si es la primera vuelta del organigrama
		$band = 1;
		$jer = $ClsOrg->max_jerarquia($suc,$dep);
	}else{ //si no es la primera vuelta usa los datos heredados de la superior
		$band = 0;
	}
	
	$result = $ClsOrg->get_plaza('',$suc,$dep,'','',$jer,$sub,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$plaza = $row["plaz_codigo"];
			$desct = utf8_decode($row["plaz_desc_ct"]);
			$cantsub = $row["plaz_cantsub"];
			$jerarq = $row["plaz_jerarquia"]; 
			$jerarq++;
			$ind = $row["plaz_independ"];
			$ind = ($ind == 1)?"depend":"independ";
			$salida.='<li class = "'.$ind.'">';
			$salida.='<dt>';
			$salida.='<a href="javascript:void(0)" onclick = "OrganigramaAction('.$plaza.')">';
			$salida.='<span id = "img'.$plaza.'"><img src = "../../CONFIG/images/organi/menos.gif"></span> '.$desct.'</a>';
			$salida.='<a href = "javascript:void(0)" onclick = "PromtInfoPlaza('.$plaza.');" style = "border:none"/><img src = "../../CONFIG/images/search.png" width = "20px" onmouseover = "this.src=\'../../CONFIG/images/search2.png\'" onmouseout = "this.src=\'../../CONFIG/images/search.png\'" title = "Desplegar Organigrama para seleccionar"></a>';
			$salida.='</dt>';
			$salida.='<dd id="'.$plaza.'">';
			$salida.='<input type = "hidden" id = "inp'.$plaza.'" value = "'.$band.'" />';
			$salida.='<ul>';
			if($cantsub > 0){
				$salida.= seccion_organigrama($suc,$dep,$plaza,$i,$jerarq);
			}
			$salida.='</ul>';
			$salida.='</dd>';
			$salida.='</li>';
		}
	}
	return $salida;
}

function seccion_organigrama_check($suc,$dep='',$sub='',$i='',$jer=''){
	$ClsOrg = new ClsOrganizacion();
	$i++;
	if($i == 1){ //valida si es la primera vuelta del organigrama
		$band = 1;
		$jer = $ClsOrg->max_jerarquia($suc,$dep);
	}else{ //si no es la primera vuelta usa los datos heredados de la superior
		$band = 0;
	}
	
	$result = $ClsOrg->get_plaza('',$suc,$dep,'','',$jer,$sub,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$plaza = $row["plaz_codigo"];
			$desct = utf8_decode($row["plaz_desc_ct"]);
			$deslg = utf8_decode($row["plaz_desc_lg"]);
			$cantsub = $row["plaz_cantsub"];
			$jerarq = $row["plaz_jerarquia"]; 
			$jerarq++;
			$ind = $row["plaz_independ"];
			$ind = ($ind == 1)?"depend":"independ";
			$salida.='<li class = "'.$ind.'">';
			$salida.='<dt><a href="javascript:void(0)" onclick = "OrganigramaAction('.$plaza.')"><span id = "img'.$plaza.'"><img src = "../../CONFIG/images/organi/menos.gif"></span> '.$desct.' <input type = "checkbox" id = "chk'.$plaza.'" value = "'.$plaza.'" onclick = "SeleccionarPlaza(this.value);"/></a></dt>';
			$salida.='<dd id="'.$plaza.'">';
			$salida.='<input type = "hidden" id = "inp'.$plaza.'" value = "'.$band.'" />';
			$salida.='<input type = "hidden" id = "plaz'.$plaza.'" value = "'.$plaza.'" />';
			$salida.='<input type = "hidden" id = "desc'.$plaza.'" value = "'.$desct.'" />';
			$salida.='<input type = "hidden" id = "jer'.$plaza.'" value = "'.$jerarq.'" />';
			$salida.='<ul>';
			if($cantsub > 0){
				$salida.= seccion_organigrama_check($suc,$dep,$plaza,$i,$jerarq);
			}
			$salida.='</ul>';
			$salida.='</dd>';
			$salida.='</li>';
		}
	}
	return $salida;
}


function Despliega_organigrama($tipo,$suc,$dep='',$sub='',$i='',$jer=''){
	$ClsOrg = new ClsOrganizacion();
	$result = $ClsOrg->get_plaza('',$suc,$dep,'','',$jer,$sub,'',1);
	if(is_array($result)){
		if($tipo == 1){
			return seccion_organigrama($suc,$dep,$sub,$i,$jer);
		}else if($tipo == 2){
			return seccion_organigrama_check($suc,$dep,$sub,$i,$jer);
		}
	}else{
		return;
	}
}


function cadena_plazas($suc,$dep){
	$ClsOrg = new ClsOrganizacion();
	$cadena = $ClsOrg->get_solo_plaza_sucursal($suc,$dep,1);
	$cadena = substr($cadena, 0, -1);
	$salida.='<input type = "hidden" id = "codigos" value = "'.$cadena.'">';
	
	return $salida;
}

?>
