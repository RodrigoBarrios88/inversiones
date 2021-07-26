<?php 
include_once('../html_fns.php');

function tabla_grupo_articulos($cod,$nom,$sit){
	$ClsArt = new ClsArticuloPropio();
	$result = $ClsArt->get_grupo($cod,$nom,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th width = "250px">NOMBRE</th>';
			$salida.= '<th width = "100px">DEPRECIACION</th>';
			$salida.= '<th width = "100px">SITUACIÓN</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$gru = $row["gru_codigo"];
			$sit = $row["gru_situacion"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Grupo_Articulo('.$gru.')" title = "Seleccionar Grupo" ><span class="fa fa-edit"></span></button> &nbsp;';
			if($sit == 1){
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "abrir();Deshabilita_Grupo('.$gru.')" title = "Deshabilitar Grupo" ><span class="fa fa-trash-o"></span></button>';
			}else if($sit == 0){
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "abrir();Habilita_Grupo('.$gru.')" title = "Habilitar Grupo" ><span class="fa fa-retweet"></span></button>';
			}
			$salida.= '</td>';
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td class = "text-justify">'.$grun.'</td>';
			//grupo
			$porcent = utf8_decode($row["gru_depreciacion"]);
			$salida.= '<td class = "text-center">'.$porcent.' %</td>';
			//situacion
			$sit = ($sit == 1)?"<strong class='text-success'>ACTIVO</strong>":"<strong class='text-danger'>INACTIVO</strong>";
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


function tabla_articulos($cod,$grup,$nom,$cumed,$umed,$sit){
	$ClsArt = new ClsArticuloPropio();
	$result = $ClsArt->get_articulo($cod,$grup,$nom,$cumed,$umed,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th width = "150px">GRUPO</th>';
			$salida.= '<th width = "120px">NOMBRE</th>';
			$salida.= '<th width = "120px">MARCA</th>';
			$salida.= '<th width = "50px">CANTIDAD</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$sit = $row["art_situacion"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Articulo('.$art.','.$gru.')" title = "Seleccionar Articulo" ><span class="fa fa-edit"></span></button>  &nbsp;';
			if($sit == 1){
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "abrir();Deshabilita_Articulo('.$art.','.$gru.')" title = "Deshabilitar Articulo" ><span class="fa fa-trash-o"></span></button>';
			}
			$salida.= '</td>';
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td >'.$grun.'</td>';
			//nombre
			$nom = utf8_decode($row["art_nombre"]);
			$salida.= '<td >'.$nom.'</td>';
			//marca
			$nom = utf8_decode($row["art_marca"]);
			$salida.= '<td >'.$nom.'</td>';
			//cantidad
			$cant = $row["art_cant_suc"];
			$cant = (trim($cant) == "")?0:$cant;
			$salida.= '<td class = "text-center">'.$cant.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

//////----------- Inventario -------------------//////////////

function tabla_articulos_inventario($art,$grup,$nom,$desc,$marca,$suc,$sit){
	$ClsArt = new ClsArticuloPropio();
	$result = $ClsArt->get_inventario($cod,$grup,$art,$nom,$desc,$marca,$suc,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th class = "text-center" width = "120px">GRUPO</th>';
			$salida.= '<th class = "text-center" width = "120px">DESCRIPCI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "100px">MARCA</th>';
			$salida.= '<th class = "text-center" width = "70px">No. DE PARTE</th>';
			$salida.= '<th class = "text-center" width = "70px">PRECIO INICIAL</th>';
			$salida.= '<th class = "text-center" width = "70px">PRECIO ACTUAL</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$cod = $row["inv_codigo"];
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$sit = $row["inv_situacion"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "abrir();xajax_Buscar_Inventario('.$cod.','.$gru.','.$art.')" title = "Seleccionar Inventario" ><span class="fa fa-edit"></span></button>  &nbsp;';
			if($sit == 1){
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "abrir();Deshabilita_Inventario('.$cod.','.$gru.','.$art.')" title = "Deshabilitar Inventario" ><span class="fa fa-trash-o"></span></button>';
			}
			$salida.= '</td>';
			//nombre
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td class = "text-center">'.$grun.'</td>';
			//desc
			$desc = utf8_decode($row["art_desc"]);
			$salida.= '<td class = "text-justify" >'.$desc.'</td>';
			//marca
			$marca = utf8_decode($row["art_marca"]);
			$salida.= '<td class = "text-center">'.$marca.'</td>';
			//numero
			$num = $row["inv_numero"];
			$salida.= '<td class = "text-center">'.$num.'</td>';
			//precio
			$mon = $row["mon_simbolo"];
			$prec = $row["inv_precio_inicial"];
			$salida.= '<td class = "text-center">'.$mon.'. '.$prec.'</td>';
			//precio
			$mon = $row["mon_simbolo"];
			$prec = $row["inv_precio_actual"];
			$salida.= '<td class = "text-center">'.$mon.'. '.$prec.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

function tabla_inicio_carga($filas){
			$salida = '<br>';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px" height = "30px">No.</td>';
			$salida.= '<th class = "text-center" width = "200px">No. de Parte</td>';
			$salida.= '<th class = "text-center" width = "100px">Precio Inicial</td>';
			$salida.= '<th class = "text-center" width = "100px">Precio Actual</td>';
			$salida.= '<th class = "text-center" width = "100px">Moneda</td>';
			$salida.= '<th class = "text-center" width = "20px"></td>';
			$salida.= '</tr>';
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//numero
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "text" class = "form-control" name = "num'.$i.'" id = "num'.$i.'" onkeyup = "texto(this);" />';
			$salida.= '</td>';
			//precio inicial
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "text" class = "form-control" name = "preini'.$i.'" id = "preini'.$i.'" onkeyup = "decimales(this);" />';
			$salida.= '</td>';
			//precio final
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "text" class = "form-control" name = "prefin'.$i.'" id = "prefin'.$i.'" onkeyup = "decimales(this);" />';
			$salida.= '</td>';
			//Moneda
			$salida.= '<td class = "text-center">';
			$salida.= moneda_html("mon$i");
			$salida.= '</td>';
			//---
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger" onclick = "QuitarFilaCarga('.$i.');" title = "Quitar Fila" ><span class="fa fa-times"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '</tr>';
		}
		$i--;
	}		
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "7"> '.$i.' Registro(s).';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	
	return $salida;
}


function tabla_filas_carga($filas,$num,$preini,$prefin,$mon){
	
	//convierte strig plano en array
		$desc = explode("|", $desc);
		$num = explode("|", $num);
		$preini = explode("|", $preini);
		$prefin = explode("|", $prefin);
			$salida = '<br>';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px" height = "30px">No.</td>';
			$salida.= '<th class = "text-center" width = "200px">No. de Parte</td>';
			$salida.= '<th class = "text-center" width = "100px">Precio Inicial</td>';
			$salida.= '<th class = "text-center" width = "100px">Precio Actual</td>';
			$salida.= '<th class = "text-center" width = "100px">Moneda</td>';
			$salida.= '<th class = "text-center" width = "20px"></td>';
			$salida.= '</tr>';
	
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//descripcion
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "text" class = "form-control" name = "num'.$i.'" id = "num'.$i.'" value = "'.utf8_decode($num[$i]).'" onkeyup = "texto(this);" />';
			$salida.= '</td>';
			//marca
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "text" class = "form-control" name = "preini'.$i.'" id = "preini'.$i.'" value = "'.utf8_decode($preini[$i]).'" onkeyup = "decimales(this);" />';
			$salida.= '</td>';
			//numero de parte
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "text" class = "form-control" name = "prefin'.$i.'" id = "prefin'.$i.'" value = "'.$prefin[$i].'" onkeyup = "decimales(this);" />';
			$salida.= '</td>';
			//Moneda
			$salida.= '<td class = "text-center">';
			$salida.= moneda_html("mon$i");
			$salida.= '<script>';
			$salida.= '<document.getElementById("mon'.$i.'").value = '.$mon[$i].'>';
			$salida.= '</script>';
			$salida.= '</td>';
			//---
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger" onclick = "QuitarFilaCarga('.$i.');" title = "Quitar Fila" ><span class="fa fa-times"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '</tr>';
		}
		$i--;
	}		
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "7"> '.$i.' Registro(s).';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	
	return $salida;
}

//echo tabla_articulos_inventario(1,1,$nom,$desc,$marca,$suc,$sit);

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////

?>
