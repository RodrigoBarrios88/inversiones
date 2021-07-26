<?php 
include_once('../html_fns.php');

function tabla_armamento($filas){
	$salida.= '<br>';
	$salida.= '<table class="table table-striped table-bordered">';
		$salida.= '<tr>';
			$salida.= '<th class="text-center">No.</th>';
			$salida.= '<th class="text-center">Tipo Arma</th>';
			$salida.= '<th class="text-center">Marca</th>';
			$salida.= '<th class="text-center">Calibre</th>';
			$salida.= '<th class="text-center">No. Registro</th>';
		$salida.= '</tr>';
	if($filas > 0){	
		for($i = 1; $i <= $filas; $i++){
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">'.$i.'.</th>';
			$salida.= '<td>';
			$salida.= '<select id="tipoarma'.$i.'" name="tipoarma'.$i.'" class="form-control">';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "PISTOLA">PISTOLA</option>';
			$salida.= '<option value = "REVOLVER">REVOLVER</option>';
			$salida.= '<option value = "ESCOPETA">ESCOPETA</option>';
			$salida.= '<option value = "RIFLE">RIFLE</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="marcaarma'.$i.'" name="marcaarma'.$i.'">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<select id="calarma'.$i.'" name="calarma'.$i.'" class="form-control">';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "9MM">9mm</option>';
			$salida.= '<option value = "0.40">.40"</option>';
			$salida.= '<option value = "0.45">.45"</option>';
			$salida.= '<option value = "22">22</option>';
			$salida.= '<option value = "7.62">7.62</option>';
			$salida.= '<option value = "5.56">5.56</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="numarma'.$i.'" name="numarma'.$i.'" onkeyup = "enteros(this);">';
			$salida.= '</td>';
		$salida.= '</tr>';
		}
	}else{
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">1.</th>';
			$salida.= '<td>';
			$salida.= '<select id="tipoarma1" name="tipoarma1" class="form-control" disabled>';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "PISTOLA">PISTOLA</option>';
			$salida.= '<option value = "REVOLVER">REVOLVER</option>';
			$salida.= '<option value = "ESCOPETA">ESCOPETA</option>';
			$salida.= '<option value = "RIFLE">RIFLE</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="marcaarma1" name="marcaarma1" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<select id="calarma1" name="calarma1" class="form-control" disabled>';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "9MM">9mm</option>';
			$salida.= '<option value = "0.40">.40"</option>';
			$salida.= '<option value = "0.45">.45"</option>';
			$salida.= '<option value = "22">22</option>';
			$salida.= '<option value = "7.62">7.62</option>';
			$salida.= '<option value = "5.56">5.56</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="numarma1" name="numarma1" onkeyup = "enteros(this);" disabled>';
			$salida.= '</td>';
		$salida.= '</tr>';
	}	
	//linea divisoria
	$salida.= '</table>';
		
	return $salida;
}


function tabla_vehiculos($filas){
	$salida.= '<br>';
	$salida.= '<table class="table table-striped table-bordered font-10">';
		$salida.= '<tr>';
			$salida.= '<th class="text-center">No.</th>';
			$salida.= '<th class="text-center">Tipo</th>';
			$salida.= '<th class="text-center">Marca</th>';
			$salida.= '<th class="text-center">Linea</th>';
			$salida.= '<th class="text-center">Modelo</th>';
			$salida.= '<th class="text-center">Tarjeta/Circulaci&oacute;n</th>';
			$salida.= '<th class="text-center">Color</th>';
			$salida.= '<th class="text-center">No. Chasis</th>';
			$salida.= '<th class="text-center">No. Motor</th>';
			$salida.= '<th class="text-center">No. Placas</th>';
			$salida.= '<th class="text-center">Pais/Reg.</th>';
		$salida.= '</tr>';
	if($filas > 0){	
		for($i = 1; $i <= $filas; $i++){
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">'.$i.'.</th>';
			$salida.= '<td>';
			$salida.= '<select id="tipoveh'.$i.'" name="tipoveh'.$i.'" class="form-control input-sm">';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "SEDAN">SEDAN</option>';
			$salida.= '<option value = "HATCHBACK">HATCHBACK</option>';
			$salida.= '<option value = "SUV">SUV</option>';
			$salida.= '<option value = "PICKUP">PICKUP</option>';
			$salida.= '<option value = "MICROBUS">MICROBUS</option>';
			$salida.= '<option value = "MOTO">MOTO</option>';
			$salida.= '<option value = "OTRO">OTRO</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="marcaveh'.$i.'" name="marcaveh'.$i.'" onkeyup = "texto(this);" >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="lineaveh'.$i.'" name="lineaveh'.$i.'" onkeyup = "texto(this);" >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="modeloveh'.$i.'" name="modeloveh'.$i.'" onkeyup = "enteros(this);" >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="tarjetaveh'.$i.'" name="tarjetaveh'.$i.'" onkeyup = "texto(this);" >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="colorveh'.$i.'" name="colorveh'.$i.'" onkeyup = "texto(this);" >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="chasisveh'.$i.'" name="chasisveh'.$i.'" onkeyup = "texto(this);" >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="motorveh'.$i.'" name="motorveh'.$i.'" onkeyup = "texto(this);" >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="placasveh'.$i.'" name="placasveh'.$i.'" onkeyup = "texto(this);" >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= Paises_html("paisveh$i","Pais");
			$salida.= '</td>';
		$salida.= '</tr>';
		}
	}else{
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">1.</th>';
			$salida.= '<td>';
			$salida.= '<select id="tipoveh1" name="tipoveh1" class="form-control input-sm" disabled >';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "SEDAN">SEDAN</option>';
			$salida.= '<option value = "HATCHBACK">HATCHBACK</option>';
			$salida.= '<option value = "SUV">SUV</option>';
			$salida.= '<option value = "PICKUP">PICKUP</option>';
			$salida.= '<option value = "MICROBUS">MICROBUS</option>';
			$salida.= '<option value = "MOTO">MOTO</option>';
			$salida.= '<option value = "OTRO">OTRO</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="marcaveh1" name="marcaveh1" onkeyup = "texto(this);" disabled >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="lineaveh1" name="lineaveh1" onkeyup = "texto(this);" disabled >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="modeloveh1" name="modeloveh1" onkeyup = "enteros(this);" disabled >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="tarjetaveh1" name="tarjetaveh1" onkeyup = "texto(this);" disabled >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="colorveh1" name="colorveh1" onkeyup = "texto(this);" disabled >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="chasisveh1" name="chasisveh1" onkeyup = "texto(this);" disabled >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="motorveh1" name="motorveh1" onkeyup = "texto(this);" disabled >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control input-sm" id="placasveh1" name="placasveh1" onkeyup = "texto(this);" disabled >';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<select id="paisveh1" name="paisveh1" class="form-control" disabled>';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '</select>';
			$salida.= '</td>';
		$salida.= '</tr>';
	}	
	$salida.= '</table>';
		
	return $salida;
}


function tabla_hijos($filas){
	$salida.= '<br>';
	$salida.= '<table class="table table-striped table-bordered">';
		$salida.= '<tr>';
			$salida.= '<th class="text-center">No.</th>';
			$salida.= '<th class="text-center">Nombres</th>';
			$salida.= '<th class="text-center">Apellidos</th>';
			$salida.= '<th class="text-center">Nacionalidad</th>';
			$salida.= '<th class="text-center">Religi&oacute;n</th>';
			$salida.= '<th class="text-center">Fecha de Nacimiento</th>';
		$salida.= '</tr>';
	if($filas > 0){	
		for($i = 1; $i <= $filas; $i++){
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">'.$i.'.</th>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="nomhijo'.$i.'" name="nomhijo'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="apehijo'.$i.'" name="apehijo'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= Paises_html("paishijo$i","");
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="religionhijo'.$i.'" name="religionhijo'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<div class="input-group date" id="groupfecnachijo'.$i.'">';
			$salida.= '<input type="text" class="form-control" id = "fecnachijo'.$i.'" name="fecnachijo'.$i.'" onblur="CalculaEdad(this.value,"fecnachijo'.$i.'");" />';
			$salida.= '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
			$salida.= '<script>';
			$salida.= '$(function () { $("#fecnachijo'.$i.'").datetimepicker({ format: "DD/MM/YYYY"}); });';
			$salida.= '</script>';
			$salida.= '</div>';
			$salida.= '</td>';
		$salida.= '</tr>';
		}
	}else{
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">1.</th>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="nomhijo1" name="nomhijo1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="apehijo1" name="apehijo1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<select id="paishijo1" name="paishijo1" class="form-control" disabled>';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="religionhijo1" name="religionhijo1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<div class="input-group date">';
			$salida.= '<input type="date" class="form-control" id="fecnachijo1" name="fecnachijo1" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >';
			$salida.= '<span class="input-group-addon" style="cursor:not-allowed"><span class="glyphicon glyphicon-calendar"></span></span>';
			$salida.= '</td>';
		$salida.= '</tr>';
	}	
	$salida.= '</table>';
		
	return $salida;
}


function tabla_hermanos($filas){
	$salida.= '<br>';
	$salida.= '<table class="table table-striped table-bordered">';
		$salida.= '<tr>';
			$salida.= '<th class="text-center">No.</th>';
			$salida.= '<th class="text-center">Nombres</th>';
			$salida.= '<th class="text-center">Apellidos</th>';
			$salida.= '<th class="text-center">Nacionalidad</th>';
			$salida.= '<th class="text-center">Religi&oacute;n</th>';
			$salida.= '<th class="text-center">Fecha de Nacimiento</th>';
		$salida.= '</tr>';
	if($filas > 0){	
		for($i = 1; $i <= $filas; $i++){
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">'.$i.'.</th>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="nomhermano'.$i.'" name="nomhermano'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="apehermano'.$i.'" name="apehermano'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= Paises_html("paishermano$i","Nacionalidad");
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="religionhermano'.$i.'" name="religionhermano'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<div class="input-group date">';
			$salida.= '<input type="date" class="form-control" id="fecnachermano'.$i.'" name="fecnachermano'.$i.'" onclick="displayCalendar(this,\'dd/mm/yyyy\', this)" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >';
			$salida.= '<span class="input-group-addon" style="cursor:not-allowed"><span class="glyphicon glyphicon-calendar"></span></span>';
			$salida.= '</td>';
		$salida.= '</tr>';
		}
	}else{
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">1.</th>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="nomhermano1" name="nomhermano1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="apehermano1" name="apehermano1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<select id="paishermano1" name="paishermano1" class="form-control" disabled>';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="religionhermano1" name="religionhermano1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<div class="input-group date">';
			$salida.= '<input type="date" class="form-control" id="fecnachermano1" name="fecnachermano1" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >';
			$salida.= '<span class="input-group-addon" style="cursor:not-allowed"><span class="glyphicon glyphicon-calendar"></span></span>';
			$salida.= '</td>';
		$salida.= '</tr>';
	}			
	$salida.= '</table>';
		
	return $salida;
}


function tabla_faminst($filas){
	$salida.= '<br>';
	$salida.= '<table class="table table-striped table-bordered">';
		$salida.= '<tr>';
			$salida.= '<th class="text-center">No.</th>';
			$salida.= '<th class="text-center">Nombre</th>';
			$salida.= '<th class="text-center">Parentesco</th>';
			$salida.= '<th class="text-center">Puesto</th>';
			$salida.= '<th class="text-center">A&ntilde;o</th>';
		$salida.= '</tr>';
	if($filas > 0){	
		for($i = 1; $i <= $filas; $i++){
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">'.$i.'.</th>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="nomfaminst'.$i.'" name="nomfaminst'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="parenfaminst'.$i.'" name="parenfaminst'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="puestofaminst'.$i.'" name="puestofaminst'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="aniofaminst'.$i.'" name="aniofaminst'.$i.'" onkeyup = "enteros(this);" maxlength="4">';
			$salida.= '</td>';
		$salida.= '</tr>';
		}
	}else{
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">1.</th>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="nomfaminst1" name="nomfaminst1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="parenfaminst1" name="parenfaminst1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="puestofaminst1" name="puestofaminst1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="aniofaminst1" name="aniofaminst1" onkeyup = "enteros(this);" maxlength="4" disabled>';
			$salida.= '</td>';
		$salida.= '</tr>';	
	}	
	$salida.= '</table>';
		
	return $salida;
}

function tabla_refsocial($filas){
	$salida.= '<br>';
	$salida.= '<table class="table table-striped table-bordered">';
		$salida.= '<tr>';
			$salida.= '<th class="text-center">No.</th>';
			$salida.= '<th class="text-center">Nombre</th>';
			$salida.= '<th class="text-center">Direcci&oacute;n</th>';
			$salida.= '<th class="text-center">Tel&eacute;fono</th>';
			$salida.= '<th class="text-center">Lugar de Trabajo</th>';
			$salida.= '<th class="text-center">Cargo</th>';
		$salida.= '</tr>';
	if($filas > 0){
		for($i = 1; $i <= $filas; $i++){
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">'.$i.'.</th>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="nomsocial'.$i.'" name="nomsocial'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="dirsocial'.$i.'" name="dirsocial'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="telsocial'.$i.'" name="telsocial'.$i.'" onkeyup = "enteros(this);" maxlength="12">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="trabajosocial'.$i.'" name="trabajosocial'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="cargosocial'.$i.'" name="cargosocial'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
		$salida.= '</tr>';
		}
	}else{
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">1.</th>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="nomsocial1" name="nomsocial1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="dirsocial1" name="dirsocial1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="telsocial1" name="telsocial1" onkeyup = "enteros(this);" maxlength="12" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="trabajosocial1" name="trabajosocial1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="cargosocial1" name="cargosocial1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
		$salida.= '</tr>';
	}	
	$salida.= '</table>';
		
	return $salida;
}



function tabla_titulos($filas){
	$salida.= '<br>';
	$salida.= '<table class="table table-striped table-bordered">';
		$salida.= '<tr>';
			$salida.= '<th class="text-center">No.</th>';
			$salida.= '<th class="text-center">Nivel</th>';
			$salida.= '<th class="text-center">T&iacute;tulo</th>';
			$salida.= '<th class="text-center">Universidad</th>';
			$salida.= '<th class="text-center">Pa&iacute;s</th>';
			$salida.= '<th class="text-center">A&ntilde;o</th>';
			$salida.= '<th class="text-center">Sem&eacute;stres</th>';
			$salida.= '<th class="text-center">Graduado?</th>';
		$salida.= '</tr>';
	if($filas > 0){
		for($i = 1; $i <= $filas; $i++){
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">'.$i.'.</th>';
			$salida.= '<td>';
			$salida.= '<select id="nivelu'.$i.'" name="nivelu'.$i.'" class="form-control">';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "PROF">PROFESORADO (Equivalente)</option>';
			$salida.= '<option value = "LIC">LICENCIATURA (Equivalente)</option>';
			$salida.= '<option value = "POST">POST-GRADO</option>';
			$salida.= '<option value = "MAST">MAESTRIA</option>';
			$salida.= '<option value = "DOC">DOCTORADO</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="titulo'.$i.'" name="titulo'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="unversidad'.$i.'" name="unversidad'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= Paises_html("paistit$i","Pa&iacute;s de Estudio");
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="aniotit'.$i.'" name="aniotit'.$i.'" onkeyup = "enteros(this);" maxlength="4">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="semtit'.$i.'" name="semtit'.$i.'" onkeyup = "enteros(this);" maxlength="2">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<select id="graduadotit'.$i.'" name="graduadotit'.$i.'" class="form-control">';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "NO">NO</option>';
			$salida.= '<option value = "SI">SI</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			
		$salida.= '</tr>';
		}
	}else{
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">1.</th>';
			$salida.= '<td>';
			$salida.= '<select id="nivelu1" name="nivelu1" class="form-control" disabled>';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "PROF">PROFESORADO (Equivalente)</option>';
			$salida.= '<option value = "LIC">LICENCIATURA (Equivalente)</option>';
			$salida.= '<option value = "POST">POST-GRADO</option>';
			$salida.= '<option value = "MAST">MAESTRIA</option>';
			$salida.= '<option value = "DOC">DOCTORADO</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="titulo1" name="titulo1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="unversidad1" name="unversidad1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<select id="paistit1" name="paistit1" class="form-control" disabled>';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="aniotit1" name="aniotit1" onkeyup = "enteros(this);" maxlength="4" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="semtit1" name="semtit1" onkeyup = "enteros(this);" maxlength="2" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<select id="graduadotit1" name="graduadotit1" class="form-control" disabled>';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "NO">NO</option>';
			$salida.= '<option value = "SI">SI</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			
		$salida.= '</tr>';	
	}	
	$salida.= '</table>';
		
	return $salida;
}

function tabla_idiomas($filas){
	$salida.= '<br>';
	$salida.= '<table class="table table-striped table-bordered">';
		$salida.= '<tr>';
			$salida.= '<th rowspan = "2" class="text-center">No.</th>';
			$salida.= '<th rowspan = "2" class="text-center">Idioma</th>';
			$salida.= '<th colspan = "3" class="text-center">Porcentaje</th>';
		$salida.= '</tr>';
		$salida.= '<tr>';
			$salida.= '<th class="text-center">% Habla</th>';
			$salida.= '<th class="text-center">% Lee</th>';
			$salida.= '<th class="text-center">% Escribe</th>';
		$salida.= '</tr>';
	if($filas > 0){	
		for($i = 1; $i <= $filas; $i++){
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">'.$i.'.</th>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="idioma'.$i.'" name="idioma'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="habla'.$i.'" name="habla'.$i.'" onkeyup = "enteros(this);" maxlength="3" placeholder = "0 %">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="lee'.$i.'" name="lee'.$i.'" onkeyup = "enteros(this);" maxlength="3" placeholder = "0 %">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="escribe'.$i.'" name="escribe'.$i.'" onkeyup = "enteros(this);" maxlength="3" placeholder = "0 %">';
			$salida.= '</td>';
		$salida.= '</tr>';
		}
	}else{
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">1.</th>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="idioma1" name="idioma1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="habla1" name="habla1" onkeyup = "enteros(this);" maxlength="3" placeholder = "0 %" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="lee1" name="lee1" onkeyup = "enteros(this);" maxlength="3" placeholder = "0 %" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="escribe1" name="escribe1" onkeyup = "enteros(this);" maxlength="3" placeholder = "0 %" disabled>';
			$salida.= '</td>';
		$salida.= '</tr>';
	}	
	$salida.= '</table>';
		
	return $salida;
}

function tabla_otros_cursos($filas){
	$salida.= '<br>';
	$salida.= '<table class="table table-striped table-bordered">';
		$salida.= '<tr>';
			$salida.= '<th class="text-center">No.</th>';
			$salida.= '<th class="text-center">Nivel</th>';
			$salida.= '<th class="text-center">Curso</th>';
			$salida.= '<th class="text-center">Instituci&oacute;n</th>';
			$salida.= '<th class="text-center">Pa&iacute;s</th>';
			$salida.= '<th class="text-center">A&ntilde;o</th>';
		$salida.= '</tr>';
	if($filas > 0){	
		for($i = 1; $i <= $filas; $i++){
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">'.$i.'.</th>';
			$salida.= '<td>';
			$salida.= '<select id="nivelciv'.$i.'" name="nivelciv'.$i.'" class="form-control">';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "TALL">TALLER</option>';
			$salida.= '<option value = "SEM">SEMINARIO</option>';
			$salida.= '<option value = "DIP">DIPLOMADO</option>';
			$salida.= '<option value = "CAP">CAPACITACI&Oacute;N</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="otrocurso'.$i.'" name="otrocurso'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="instituto'.$i.'" name="instituto'.$i.'" onkeyup = "texto(this);">';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= Paises_html("paisotrocur$i","Pa&iacute;s de Estudio");
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="aniootrocur'.$i.'" name="aniootrocur'.$i.'" onkeyup = "enteros(this);" maxlength="4">';
			$salida.= '</td>';
		$salida.= '</tr>';
		}
	}else{
		$salida.= '<tr>';
			//No.
			$salida.= '<th class="text-center">1.</th>';
			$salida.= '<td>';
			$salida.= '<select id="nivelciv1" name="nivelciv1" class="form-control" disabled>';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '<option value = "TALL">TALLER</option>';
			$salida.= '<option value = "SEM">SEMINARIO</option>';
			$salida.= '<option value = "DIP">DIPLOMADO</option>';
			$salida.= '<option value = "CAP">CAPACITACI&Oacute;N</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="otrocurso1" name="otrocurso1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="instituto1" name="instituto1" onkeyup = "texto(this);" disabled>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<select id="paisotrocur1" name="paisotrocur1" class="form-control" disabled>';
			$salida.= '<option value = "">Seleccione</option>';
			$salida.= '</select>';
			$salida.= '</td>';
			$salida.= '<td>';
			$salida.= '<input type="text" class="form-control" id="aniootrocur1" name="aniootrocur1" onkeyup = "enteros(this);" maxlength="4" disabled>';
			$salida.= '</td>';
		$salida.= '</tr>';
	}	
	//linea divisoria
	$salida.= '</table>';
		
	return $salida;
}


/////////////// Listados /////////////////////

function tabla_personal($dpi,$nom = '',$ape = '',$suc = '',$gene = '',$nit = '',$pais = ''){
	$ClsPer = new ClsPersonal();
		$result = $ClsPer->get_personal($dpi,$nom,$ape,$suc,$gene,$nit,'',$pais);
			
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "15px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">DPI</th>';
			$salida.= '<th class = "text-center" width = "200px">Nombres y Apellidos</th>';
			$salida.= '<th class = "text-center" width = "50px">Genero</th>';
			$salida.= '<th class = "text-center" width = "150px">Organizaci&oacute;n</th>';
			$salida.= '<th class = "text-center" width = "80px"><span class="fa fa-cogs"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
	if(is_array($result)){
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//DPI
			$dpi = $row["per_dpi"];
			$salida.= '<td class = "text-center">'.$dpi.'</td>';
			//nombre
			$nom = utf8_decode($row["per_nombres"])." ".utf8_decode($row["per_apellidos"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//genero
			$gene = $row["per_genero"];
			$genero = ($gene == "M")?"MASCULINO":"FEMENINO";
			$salida.= '<td class = "text-center">'.$genero.'</td>';
			//organizacion
			$plaza = utf8_decode($row["plaz_desc_ct"]);
			$dep = utf8_decode($row["dep_desc_ct"]);
			$suc = utf8_decode($row["suc_nombre"]);
			$puesto = ($plaza != "")?"$plaza ($dep)":$suc;
			$salida.= '<td class = "text-center">'.$puesto.'</td>';
			//botones
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsPer->encrypt($dpi, $usu);
		
			$salida.= '<td  class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default" onclick="window.location=\'FRMmodformulario.php?hashkey='.$hashkey.'\'" title = "Editar Datos" ><span class="glyphicon glyphicon-pencil"></span></button> ';
			$salida.= '<button type="button" class="btn btn-default" onclick="window.location=\'FRMfoto.php?hashkey='.$hashkey.'\'" title = "Re-Capturar Fotograf&iacute;a" ><span class="fa fa-camera-retro"></span></button> ';
			$salida.= '<a type="button" class="btn btn-default" href="CPREPORTES/REPformulario.php?hashkey='.$hashkey.'" target = "_blank" title = "Imprimir Formulario" ><span class="fa fa-print"></span></a> ';
			$salida.= '</td>';
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


function tabla_personal_carne($dpi,$nom = '',$ape = '',$suc = '',$gene = '',$nit = '',$pais = ''){
	$ClsPer = new ClsPersonal();
	$result = $ClsPer->get_personal($dpi,$nom,$ape,$suc,$gene,$nit,'',$pais);
			
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "15px">No.</th>';
			$salida.= '<th class = "text-center" width = "50px">DPI</th>';
			$salida.= '<th class = "text-center" width = "200px">Nombres y Apellidos</th>';
			$salida.= '<th class = "text-center" width = "50px">Genero</th>';
			$salida.= '<th class = "text-center" width = "150px">Organizaci&oacute;n</th>';
			$salida.= '<th class = "text-center" width = "40px"><span class="fa fa-cogs"></span></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
	if(is_array($result)){
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
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
			//organizacion
			$plaza = utf8_decode($row["plaz_desc_ct"]);
			$dep = utf8_decode($row["dep_desc_ct"]);
			$suc = utf8_decode($row["suc_nombre"]);
			$puesto = ($plaza != "")?"$plaza ($dep)":$suc;
			$salida.= '<td class = "text-center">'.$puesto.'</td>';
			//botones
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsPer->encrypt($dpi, $usu);
		
			$salida.= '<td  class = "text-center">';
			$salida.= '<a type="button" class="btn btn-default" href="CPREPORTES/REPcarne.php?hashkey='.$hashkey.'" target = "_blank" title = "Imprimir Carn&eacute;" ><span class="fa fa-credit-card"></span></a> ';
			$salida.= '</td>';
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



function tabla_plazas(){
	$ClsOrg = new ClsOrganizacion();
	$result = $ClsOrg->get_plaza($plaza,$suc,$dep,$dct,$dlg,$jer,$sub,$ind,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px"><span class="fa fa-cogs"></span></td>';
			$salida.= '<th class = "text-center" width = "50px">PLAZA No.</td>';
			$salida.= '<th class = "text-center" width = "200px">NOM. COMPLETO</td>';
			$salida.= '<th class = "text-center" width = "200px">EMPRESA</td>';
			$salida.= '<th class = "text-center" width = "150px">DEPARAMENTO</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$plaza = $row["plaz_codigo"];
			//botones
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsOrg->encrypt($plaza, $usu);
			$salida.= '<td  class = "text-center">';
			$salida.= '<a type="button" class="btn btn-default" href="FRMtarjeta.php?hashkey='.$hashkey.'" target = "_blank" title = "Gestor de Tarjeta de Responsabilidad" ><span class="fa fa-file-text-o"></span></a> ';
			$salida.= '</td>';
			//Plaza
			$plaza = $row["plaz_codigo"];
			$plaza = Agrega_Ceros($plaza);
			$salida.= '<td class = "text-center">'.$plaza.'</td>';
			//desc larga
			$dlg = utf8_decode($row["plaz_desc_lg"]);
			$salida.= '<td class = "text-center">'.$dlg.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center">'.$suc.'</td>';
			//departamento
			$dep = utf8_decode($row["dep_desc_ct"]);
			$salida.= '<td class = "text-center">'.$dep.'</td>';
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



//echo tabla_info_merito(1214);

?>
