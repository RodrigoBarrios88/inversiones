<?php 
include_once('../html_fns.php');

function tabla_grupo_articulos($cod,$nom,$sit){
	$ClsArt = new ClsSuministro();
	$result = $ClsArt->get_grupo($cod,$nom,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px" class = "text-center"><span class="fa fa-cogs"></span>';
			$salida.= '<th width = "250px" class = "text-center">NOMBRE</th>';
			$salida.= '<th width = "100px" class = "text-center">SITUACI&Oacute;N</th>';
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
			$salida.= '<td>'.$grun.'</td>';
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


function tabla_articulos($cod,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,$sit,$suc){
	$ClsArt = new ClsSuministro();
	$result = $ClsArt->get_articulo($cod,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,$sit,$suc);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "60px" class = "text-center"><span class="fa fa-cogs"></span>';
			$salida.= '<th width = "120px" class = "text-center">GRUPO</th>';
			$salida.= '<th width = "150px" class = "text-center">MARCA</th>';
			$salida.= '<th width = "150px" class = "text-center">NOMBRE</th>';
			$salida.= '<th width = "200px" class = "text-center">DESCRIPCI&Oacute;N</th>';
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
			}else if($sit == 0){
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "abrir();Habilita_Articulo('.$art.','.$gru.')" title = "Habilitar Articulo" ><span class="fa fa-retweet"></span></button>';
			}
			$salida.= '</td>';
			
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td>'.$grun.'</td>';
			//marca
			$marca = utf8_decode($row["art_marca"]);
			$salida.= '<td>'.$marca.'</td>';
			//nombre
			$nom = utf8_decode($row["art_nombre"]);
			$salida.= '<td>'.$nom.'</td>';
			//desc
			$desc = utf8_decode($row["art_desc"]);
			$salida.= '<td>'.$desc.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_articulos_precio(){
	$ClsArt = new ClsSuministro();
	$result = $ClsArt->get_articulo($cod,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,$sit,$suc);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "60px" class = "text-center"><span class="fa fa-cogs"></span>';
			$salida.= '<th width = "120px" class = "text-center">GRUPO</th>';
			$salida.= '<th width = "150px" class = "text-center">MARCA</th>';
			$salida.= '<th width = "150px" class = "text-center">NOMBRE</th>';
			$salida.= '<th width = "200px" class = "text-center">DESCRIPCI&Oacute;N</th>';
			$salida.= '<th width = "70px" class = "text-center">PRECIO</th>';
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
			$salida.= '<button type="button" class="btn btn-default" onclick = "abrir();xajax_Buscar_Articulo('.$art.','.$gru.')" title = "Seleccionar Articulo" ><span class="fa fa-edit"></span></button>  &nbsp;';
			$salida.= '</td>';
			
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td>'.$grun.'</td>';
			//marca
			$marca = utf8_decode($row["art_marca"]);
			$salida.= '<td>'.$marca.'</td>';
			//nombre
			$nom = utf8_decode($row["art_nombre"]);
			$salida.= '<td>'.$nom.'</td>';
			//desc
			$desc = utf8_decode($row["art_desc"]);
			$salida.= '<td>'.$desc.'</td>';
			//precio
			$prec = $row["art_precio"];
			$salida.= '<td class = "text-center">'.$prec.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_lotes($cod,$grup,$art,$barc,$suc,$prov){
	$ClsArt = new ClsSuministro();
	$cont = $ClsArt->count_lote($cod,$grup,$art,$barc,$suc,$prov);
	
	if($cont>0){
		$result = $ClsArt->get_lote($cod,$grup,$art,$barc,$suc,$prov);
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "60px" class = "text-center"><span class="fa fa-cogs"></span>';
			$salida.= '<th width = "150px" class = "text-center">COD. LOTE</th>';
			$salida.= '<th width = "150px" class = "text-center">GRUPO</th>';
			$salida.= '<th width = "150px" class = "text-center">MARCA</th>';
			$salida.= '<th width = "150px" class = "text-center">NOMBRE</th>';
			$salida.= '<th width = "70px" class = "text-center">PREC. COMPRA</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$lot = $row["lot_codigo"];
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default" onclick = "abrir();xajax_Buscar_Lote('.$lot.','.$art.','.$gru.')" title = "Editar Articulo" ><span class="fa fa-edit"></span></button>';
			$salida.= '</td>';
			//Lote
			$lot = Agrega_Ceros($lot);
			$art = Agrega_Ceros($art);
			$gru = Agrega_Ceros($gru);
			$codigo = $lot."A".$art."A".$gru;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td>'.$grun.'</td>';
			//marca
			$marca = utf8_decode($row["art_marca"]);
			$salida.= '<td>'.$marca.'</td>';
			//nombre
			$nom = utf8_decode($row["art_nombre"]);
			$salida.= '<td>'.$nom.'</td>';
			//precio de costo
			$prec = $row["lot_precio_costo"];
			$salida.= '<td class = "text-center">Q. '.$prec.'</td>';
			
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

?>
