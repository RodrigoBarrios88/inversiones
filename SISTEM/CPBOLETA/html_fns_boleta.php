<?php 
include_once('../html_fns.php');

function tabla_alumnos($pensum,$nivel,$grado,$seccion,$acc){
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
			if($acc == "CUE"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else if($acc == "SALDO"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else if($acc == "GBOL"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else if($acc == "GPAGO"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else if($acc == "VENT"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else if($acc == "BOLEXT"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else{
			$salida.= '<th width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			if($acc == "CUE"){
				//codigo
				$cui = $row["alu_cui"];
				$sit = $row["alu_situacion"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAcad->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-primary" href="FRMcuenta.php?hashkey='.$hashkey.'" title = "Ver Estado de Cuenta" > <span class="fa fa-money"></span> </a>';
				$salida.= '</td>';
			}else if($acc == "SALDO"){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAcad->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-success" href="FRMsaldo.php?hashkey='.$hashkey.'" title = "Calcular Saldos de Pago" > <span class="fa fa-usd"></span> </a>';
				$salida.= '</td>';
			}else if($acc == "GBOL"){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAcad->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-default" href="FRMboleta.php?hashkey='.$hashkey.'" title = "Gestionar Boletas" > <span class="fa fa-edit"></span> </a>';
				$salida.= '</td>';
			}else if($acc == "GPAGO"){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAcad->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-default" href="FRMpago.php?hashkey='.$hashkey.'" title = "Gestionar Pagos" > <span class="fa fa-edit"></span> </a>';
				$salida.= '</td>';
			}else if($acc == "VENT"){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAcad->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-default" href="FRMventa.php?hashkey='.$hashkey.'" title = "Ventas con Boletas de Dep&oacute;sito" > <span class="fa fa-shopping-cart"></span> </a>';
				$salida.= '</td>';
			}else if($acc == "BOLEXT"){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAcad->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-default" href="FRMboletaextra.php?hashkey='.$hashkey.'" title = "Ventas con Boletas de Dep&oacute;sito" > <span class="fa fa-shopping-cart"></span> </a>';
				$salida.= '</td>';
			}else{
				$salida.= '<td class = "text-center">'.$i.'.</td>';
			}
			//cui
			$cui = utf8_decode($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//codigo interno
			$codigo = utf8_decode($row["alu_codigo_interno"]);
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//correo
			$pad = utf8_decode($row["alu_padre"]);
			$salida.= '<td class = "text-left">'.$pad.'</td>';
			//telefono1
			$tel = $row["alu_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
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


function tabla_direcotrio_alumnos($acc,$pensum){
	$ClsAlu = new ClsAlumno();
	$result = $ClsAlu->get_alumno($cui,'','',1);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
			if($acc == "CUE"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else if($acc == "SALDO"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else if($acc == "GBOL"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else if($acc == "GPAGO"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else if($acc == "VENT"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else if($acc == "BOLEXT"){
			$salida.= '<th width = "20px"><i class="fa fa-cogs"></i></th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}else{
			$salida.= '<th width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "40px">CUI</td>';
			$salida.= '<th class = "text-center" width = "40px">C&Oacute;DIGO</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">APELLIDO</td>';
			$salida.= '<th class = "text-center" width = "250px">PADRE O ENCARGADO</td>';
			$salida.= '<th class = "text-center" width = "150px">TELEFONO</td>';
			}
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			if($acc == "CUE"){
				//codigo
				$cui = $row["alu_cui"];
				$sit = $row["alu_situacion"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAlu->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-primary" href="FRMcuenta.php?hashkey='.$hashkey.'&pensum='.$pensum.'" title = "Ver Estado de Cuenta" > <span class="fa fa-money"></span> </a>';
				$salida.= '</td>';
			}else if($acc == "SALDO"){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAlu->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-success" href="FRMsaldo.php?hashkey='.$hashkey.'&pensum='.$pensum.'" title = "Calcular Saldos de Pago" > <span class="fa fa-usd"></span> </a>';
				$salida.= '</td>';
			}else if($acc == "GBOL"){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAlu->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-default" href="FRMboleta.php?hashkey='.$hashkey.'&pensum='.$pensum.'" title = "Gestionar Boletas" > <span class="fa fa-edit"></span> </a>';
				$salida.= '</td>';
			}else if($acc == "GPAGO"){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAlu->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-default" href="FRMpago.php?hashkey='.$hashkey.'&pensum='.$pensum.'" title = "Gestionar Pagos" > <span class="fa fa-edit"></span> </a>';
				$salida.= '</td>';
			}else if($acc == "VENT"){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAlu->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-default" href="FRMventa.php?hashkey='.$hashkey.'&pensum='.$pensum.'" title = "Ventas con Boletas de Dep&oacute;sito" > <span class="fa fa-shopping-cart"></span> </a>';
				$salida.= '</td>';
			}else if($acc == "BOLEXT"){
				//codigo
				$cui = $row["alu_cui"];
				$usu = $_SESSION["codigo"];
				$hashkey = $ClsAlu->encrypt($cui, $usu);
				$salida.= '<td class = "text-center" >';
				$salida.= '<a class="btn btn-default" href="FRMboletaextra.php?hashkey='.$hashkey.'" title = "Ventas con Boletas de Dep&oacute;sito" > <span class="fa fa-shopping-cart"></span> </a>';
				$salida.= '</td>';
			}else{
				$salida.= '<td class = "text-center">'.$i.'.</td>';
			}
			//cui
			$cui = utf8_decode($row["alu_cui"]);
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//codigo interno
			$codigo = utf8_decode($row["alu_codigo_interno"]);
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-left">'.$nom.'</td>';
			//ape
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$ape.'</td>';
			//correo
			$pad = utf8_decode($row["alu_padre"]);
			$salida.= '<td class = "text-left">'.$pad.'</td>';
			//telefono1
			$tel = $row["alu_telefono"];
			$salida.= '<td class = "text-center">'.$tel.'</td>';
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


////////////// BOLETAS DE COBRO ///////////////////////
function tabla_lista_boletas_cobro($codigo,$cue,$ban,$alumno,$referencia,$periodo){
	$ClsPer = new ClsPeriodoFiscal();
	$ClsBol = new ClsBoletaCobro();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	$result = $ClsBol->get_boleta_cobro_independiente($codigo,$cue,$ban,$alumno,$referencia,$periodo,$usuario,$fini,$ffin,1);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "100px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "80px"># CUENTA</th>';
		$salida.= '<th class = "text-center" width = "60px">BANCO</th>';
		$salida.= '<th class = "text-center" width = "50px"># BOLETA</th>';
		$salida.= '<th class = "text-center" width = "50px"># REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "70px">FECHA/PAGO</th>';
		$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "200px">MOTIVO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$ban = $row["ban_codigo"];
			$cue = $row["cueb_codigo"];
			$cod = $row["bol_codigo"];
			//--
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($cod, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-default btn-xs" title="Imprimir Boleta Original (boleta f&iacute;sica)" href = "../../CONFIG/BOLETAS/REPboleta.php?hashkey='.$hashkey.'" target = "_blank" ><span class="fa fa-print"></span></a> ';
			$salida.= '</td>';
			//numero de cuenta
			$num = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center">'.$num.'</td>';
			//banco
			$bann = $row["ban_desc_ct"];
			$salida.= '<td class = "text-center">'.$bann.'</td>';
			//Boleta
			$boleta = Agrega_Ceros($row["bol_codigo"]);
			$salida.= '<td class = "text-center">'.$boleta.'</td>';
			//Referencia
			$doc = $row["bol_referencia"];
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			//Alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left">'.$alumno.'</td>';
			//fecha de pago
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//Monto
			$mons = $row["mon_simbolo"];
			$monto = $row["bol_monto"];
			$monto = number_format($monto, 2);
			$salida.= '<td class = "text-center">'.$mons.'. '.$monto.'</td>';
			//Motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$salida.= '<td class = "text-justify">'.$motivo.'</td>';
			$salida.= '</tr>';
			//--
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-exclamation-circle"></i> No hay boletas registradas con estos filtros de busqueda...';
		$salida.= '</h5>';
	}
	
	return $salida;
}


function tabla_boletas_cobro($codigo,$division,$grupo,$alumno,$referencia,$periodo,$button){
	$ClsPer = new ClsPeriodoFiscal();
	$ClsBol = new ClsBoletaCobro();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	$result = $ClsBol->get_boleta_cobro($codigo,$division,$grupo,$alumno,$referencia,$periodo,$usuario,$fini,$ffin,1);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "100px">';
		$salida.= '<input type = "checkbox" id = "chkg" onclick = "checkTodoGrupo();" checked title = "Click para seleccionar todo el grupo" >';
		$salida.= '</th>';
		$salida.= '<th class = "text-center" width = "100px">DIVISI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "100px">GRUPO</th>';
		$salida.= '<th class = "text-center" width = "50px"># BOLETA</th>';
		$salida.= '<th class = "text-center" width = "50px"># REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "70px">FECHA/PAGO</th>';
		$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "200px">MOTIVO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$grupo = $row["ban_codigo"];
			$division = $row["cueb_codigo"];
			$codigo = $row["bol_codigo"];
			//--
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($codigo, $usu);
			$salida.= '<td class = "text-center" >';
			//--
			$salida.= '<input type = "checkbox" id = "chk'.$i.'" title = "Click para seleccionar" checked >';
			$salida.= '<input type="hidden" id = "boleta'.$i.'" value="'.$codigo.'" /> ';
			//--
			$salida.= '<a type="button" class="btn btn-info btn-outline btn-xs" title="Imprimir Boleta Original (boleta f&iacute;sica)" href = "../../CONFIG/BOLETAS/REPboleta.php?hashkey='.$hashkey.'" target = "_blank" ><span class="fa fa-print"></span></a> ';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="xajax_Buscar_Boleta_Cobro('.$codigo.');" title = "Seleccionar Boleta" '.$button.' ><span class="fa fa-edit"></span></button> ';
			//$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Confirm_EliminarBoleta('.$codigo.');" title = "Eliminar Boleta" '.$button.' ><span class="fa fa-trash-o"></span></button>';
			$salida.= '</td>';
			//division
			$division_nombre = $row["div_nombre"];
			$salida.= '<td class = "text-left">'.$division_nombre.'</td>';
			//grupo
			$grupo_nombre = $row["gru_nombre"];
			$salida.= '<td class = "text-left">'.$grupo_nombre.'</td>';
			//Boleta
			$boleta = Agrega_Ceros($row["bol_codigo"]);
			$salida.= '<td class = "text-center">'.$boleta.'</td>';
			//Referencia
			$doc = $row["bol_referencia"];
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			//fecha de pago
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//Monto
			$mons = $row["mon_simbolo"];
			$monto = $row["bol_monto"];
			$monto = number_format($monto, 2);
			$salida.= '<td class = "text-center">'.$mons.'. '.$monto.'</td>';
			//Motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$salida.= '<td class = "text-justify">'.$motivo.'</td>';
			$salida.= '</tr>';
			//--
			$i++;
		}
		$i--;
		$salida.= '</table>';
		$salida.= '<input type="hidden" id = "filas" value="'.$i.'" />';
		$salida.= '</div>';
	}
	
	return $salida;
}




function tabla_lectora_csv($archivo,$periodo,$cuenta,$banco){
	$ClsAlu = new ClsAlumno();
	$ClsBol = new ClsBoletaCobro();
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	$fila = 1;
	if (($gestor = fopen("../../CONFIG/CARGAS/$archivo", "r")) !== FALSE) {
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "60px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "40px">FECHA</th>';
		$salida.= '<th class = "text-center" width = "40px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "40px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "40px">CUI</th>';
		$salida.= '<th class = "text-center" width = "40px">COD.INT</th>';
		$salida.= '<th class = "text-center" width = "40px">MES</th>';
		$salida.= '<th class = "text-center" width = "40px">EFECTIVO</th>';
		$salida.= '<th class = "text-center" width = "40px">CHEQUES PROP.</th>';
		$salida.= '<th class = "text-center" width = "40px">OTROS BAN.</th>';
		$salida.= '<th class = "text-center" width = "40px">ONLINE</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		$errores_boleta = 0;
		$errores_alumnos = 0;
		$errores_monto = 0;
		$referencias_pagadas = 0;
		while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
			$numero = count($datos);
			$error_garrafal = 0;
			if($numero > 0){
				////-- Comprobaciones
				$iconos = "";
				$boleta = trim($datos[1]);
				$alumno = $datos[2];
				if(!is_numeric($datos[4])){
					$datos[4] = 0;
				}
				if(!is_numeric($datos[5])){
					$datos[5] = 0;
				}
				if(!is_numeric($datos[6])){
					$datos[6] = 0;
				}
				if(!is_numeric($datos[7])){
					$datos[7] = 0;
				}
				
				//fecha
				$fecha = $datos[0];
				$fecha = ($fecha != "")? $fecha : 0; /// valida que si el dato es nulo o vacion coloca 0
				$dd = substr($fecha,0,2);
				$mm = substr($fecha,3,2);
				$yy = substr($fecha,6,4);
				if(($dd > 0 && $dd <= 31) && ($mm > 0 && $mm <= 12)  && ($yy > 1999 && $yy <= date("Y"))){
					/// valido
					$validaBoleta = $ClsBol->comprueba_boleta_cobro($boleta);
					$valida_boleta = $validaBoleta["valida"];
					$codigo_boleta = $validaBoleta["bol_codigo"];
					$valida_monto = floatval($validaBoleta["bol_monto"]);
					$valida_periodo = $validaBoleta["bol_periodo_fiscal"];
					$valida_pagado = $validaBoleta["bol_pagado"];
					$situacion_boleta = $validaBoleta["bol_situacion"];
				}else{
					$valida_boleta = false;
					$codigo_boleta =  "";
					$valida_monto = "";
					$valida_periodo = "";
					$valida_pagado = "";
					$situacion_boleta = "";
				}
				$valida_codigo_alumno = $ClsBol->comprueba_codigo_interno($alumno);
				$valida_alumno = $ClsBol->comprueba_alumno($alumno);
				$monto_total = floatval(str_replace("Q","",$datos[4])+str_replace("Q","",$datos[5])+str_replace("Q","",$datos[6])+str_replace("Q","",$datos[7]));
				$valida_periodo = ($valida_periodo == "")?$periodo:$valida_periodo;
				if($valida_boleta == false && $valida_alumno == "" && $valida_codigo_alumno == ""){
					$class = "danger";
				}else if($valida_boleta == true && $valida_monto != "" && ($valida_alumno != "" || $valida_codigo_alumno != "" ) && $valida_monto != $monto_total){
					$class = "info";
				}else if($valida_boleta == true && $valida_monto != "" && ($valida_alumno != "" || $valida_codigo_alumno != "" ) && $valida_monto == $monto_total){
					if($valida_pagado != 0){
						$class = "";
						$iconos = ' <label class = "text-muted"><i class="fa fa-money" title ="Esta boleta ya fue registrada como Pagada"></i> Ya Pagada!</label>';
					}else{
						$class = "";
						$iconos = ' <span class="fa fa-check text-success" title ="Datos Correctos"></span> ';
					}
				}else{
					$class = "warning";
				}
				//valida iconos a desplegar
				if($valida_boleta == false){
					$iconos.= ' <span class="fa fa-file-text text-danger" title ="No existe el numero de boleta"></span> ';
					$errores_boleta++;
				}
				if($valida_alumno == "" && $valida_codigo_alumno == ""){
					$iconos.= ' <span class="fa fa-user text-danger" title ="No existe el alumno"></span> ';
					$errores_alumnos++;
				}
				if($valida_boleta == true && $valida_monto != "" && ($valida_monto != $monto_total)){
					$iconos.= ' <span class="fa fa-dollar text-info" title ="El monto de la boleta no coincide con el monto depositado"></span> ';
					$errores_monto++;
				}
				if($valida_pagado == 1){
					$iconos = ' <label class = "text-muted"><span class="fa fa-money" title ="Esta boleta ya fue registrada como Pagada"></span> Ya Pagada!</label>';
					$referencias_pagadas++;
				}
				/////////////// TRAE LOS DOS DATOS DE LOS ALUMNOS
				$alumno = trim($datos[2]);
				$result = $ClsAlu->get_alumno($alumno);
				if(is_array($result)){
					foreach($result as $row){
						$cui = trim($row["alu_cui"]);
						$codint = trim($row["alu_codigo_interno"]);
					}
				}else{
					$result = $ClsAlu->get_alumno_codigo_interno($alumno);
					if(is_array($result)){
						foreach($result as $row){
							$cui = trim($row["alu_cui"]);
							$codint = trim($row["alu_codigo_interno"]);
						}
					}else{
						$cui = $datos[2];
						$codint = $datos[2];
					}
				}
				
				//--------
				$salida.= '<tr class="'.$class.'">';
				//--
				$boleta = trim($datos[1]);
				$alumno = trim($datos[2]);
				$salida.= '<td class = "text-center">';
				$salida.= '<button type="button" class="btn btn-default" title="Datos de la Boleta " onclick = "VerBoleta(\''.$alumno.'\',\''.$boleta.'\');" ><i class="fa fa-search"></i></button>'; 
				$salida.= ' &nbsp; '.$iconos.'</td>';
				$fila++;
				//fecha
				$fecha = $datos[0];
				$fecha = ($fecha != "")? $fecha : 0; /// valida que si el dato es nulo o vacion coloca 0
				$dd = substr($fecha,0,2);
				$mm = substr($fecha,3,2);
				$yy = substr($fecha,6,4);
				if(($dd > 0 && $dd <= 31) && ($mm > 0 && $mm <= 12)  && ($yy > 1999 && $yy <= date("Y"))){
					/// valido
					$fecha_label = ($valida_pagado == 1)?'<small class = "text-muted">'.$fecha.'</small>':$fecha;
				}else{
					$fecha_label = '<label class = "text-danger">'.$fecha.'</label>';
					$classfecha = "danger";
					$msj.= "Formato de Fecha Invalido! Corrobore que el formato de la fecha sea dd/mm/yyyy, donde el d&iacute;a no es mayor a 31, el mes no es mayor a 12 y el a&ntilde;o se encuentra entre el 2,000 y el ".date("Y").". ";
					$error_garrafal++;
				}
				$salida.= '<td class = "text-center" >'.$fecha_label;
				$salida.= '<input type = "hidden" id = "fecha'.$i.'" name = "fecha'.$i.'" value = "'.$fecha.'" />';
				$salida.='</td>';
				//boleta
				$boleta = $datos[1];
				$boleta = ($boleta != "")? $boleta : 0; /// valida que si el dato es nulo o vacion coloca 0
				$boleta_label = ($valida_pagado == 1)?'<small class = "text-muted">'.$boleta.'</small>':$boleta;
				$valida_pagado = ($valida_pagado == 0)?"":$valida_pagado; //indica que debe ser registrada...
				$salida.= '<td class = "text-center" >'.$boleta_label;
				$salida.= '<input type = "hidden" id = "pagado'.$i.'" name = "pagado'.$i.'" value = "'.$valida_pagado.'" />'; /// valida que no este ya pagada!
				$salida.= '<input type = "hidden" id = "codigo'.$i.'" name = "codigo'.$i.'" value = "'.$codigo_boleta.'" />';
				$salida.= '<input type = "hidden" id = "periodo'.$i.'" name = "periodo'.$i.'" value = "'.$valida_periodo.'" />';
				$salida.= '<input type = "hidden" id = "referencia'.$i.'" name = "referencia'.$i.'" value = "'.$boleta.'" />';
				$salida.='</td>';
				//referencia
				$referencia = $datos[1];
				$referencia_label = ($valida_pagado == 1)?'<small class = "text-muted">'.$referencia.'</small>':$referencia;
				$salida.= '<td class = "text-center" >'.$referencia_label.'</td>';
				//CUI
				$alumno = $cui;
				$alumno = ($alumno != "")? $alumno : 0; /// valida que si el dato es nulo o vacion coloca 0
				$alumno_label = ($valida_pagado == 1)?'<small class = "text-muted">'.$alumno.'</small>':$alumno;
				$salida.= '<td class = "text-center" >'.$alumno_label;
				$salida.= '<input type = "hidden" id = "alumno'.$i.'" name = "alumno'.$i.'" value = "'.$alumno.'" />';
				$salida.='</td>';
				//No. de Boleta Alumno
				$alumno = $codint;
				$alumno = ($alumno != "")? $alumno : 0; /// valida que si el dato es nulo o vacion coloca 0
				$alumno_label = ($valida_pagado == 1)?'<small class = "text-muted">'.$alumno.'</small>':$alumno;
				$salida.= '<td class = "text-center" >'.$alumno_label;
				$salida.= '<input type = "hidden" id = "codint'.$i.'" name = "codint'.$i.'" value = "'.$alumno.'" />';
				$salida.='</td>';
				//mes
				$mes = $datos[3];
				$mes = meses_letras_a_meses_numeros($mes); // valida que los meses no vengan en letras
				$mes = ($mes != "")? $mes : 0; /// valida que si el dato es nulo o vacion coloca 0
				if(is_numeric($mes)) {
					/// valido
					$mes_label = ($valida_pagado == 1)?'<small class = "text-muted">'.$mes.'</small>':$mes;
				}else{
					$mes_label = '<label class = "text-danger">'.$mes.'</label>';
					$classfecha = "danger";
					$msj.= "Formato de Mes Invalido! Corrobore que el formato del mes sea numerico, donde el mes no es mayor a 12. ";
					$error_garrafal++;
				}
				$salida.= '<td class = "text-center" >'.$mes_label;
				$salida.= '<input type = "hidden" id = "mes'.$i.'" name = "mes'.$i.'" value = "'.$mes.'" />';
				$salida.='</td>';
				//efectivo
				$valor = str_replace("Q","",$datos[4]);
				$valor = (trim($valor) != "")? $valor : 0; /// valida que si el dato es nulo o vacion coloca 0
				if(is_numeric($valor)) {
					/// valido
					$valor_label = ($valida_pagado == 1)?'<small class = "text-muted">'.number_format($valor, 2, '.', ',').'</small>':$valor;
				}else{
					$valor_label = '<label class = "text-danger">'.$valor.'</label>';
					$classfecha = "danger";
					$msj.= "Formato de Valor Invalido! Corrobore que el formato del valor sea numerico y no tenga simbolo de moneda. ";
					$error_garrafal++;
				}
				$salida.= '<td class = "text-center" >'.$valor_label;
				$salida.= '<input type = "hidden" id = "efectivo'.$i.'" name = "efectivo'.$i.'" value = "'.$valor.'" />';
				$salida.='</td>';
				//chequede propio banco
				$valor = str_replace("Q","",$datos[5]);
				$valor = (trim($valor) != "")? $valor : 0; /// valida que si el dato es nulo o vacion coloca 0
				if(is_numeric($valor)) {
					/// valido
					$valor_label = ($valida_pagado == 1)?'<small class = "text-muted">'.$valor.'</small>':$valor;
				}else{
					$valor_label = '<label class = "text-danger">'.$valor.'</label>';
					$classfecha = "danger";
					$msj.= "Formato de Valor Invalido! Corrobore que el formato del valor sea numerico y no tenga simbolo de moneda. ";
					$error_garrafal++;
				}
				$salida.= '<td class = "text-center" >'.$valor_label;
				$salida.= '<input type = "hidden" id = "chp'.$i.'" name = "chp'.$i.'" value = "'.$valor.'" />';
				$salida.='</td>';
				//cheque de otros bancos
				$valor = str_replace("Q","",$datos[6]);
				$valor = (trim($valor) != "")? $valor : 0; /// valida que si el dato es nulo o vacion coloca 0
				if(is_numeric($valor)) {
					/// valido
					$valor_label = ($valida_pagado == 1)?'<small class = "text-muted">'.$valor.'</small>':$valor;
				}else{
					$valor_label = '<label class = "text-danger">'.$valor.'</label>';
					$classfecha = "danger";
					$msj.= "Formato de Valor Invalido! Corrobore que el formato del valor sea numerico y no tenga simbolo de moneda. ";
					$error_garrafal++;
				}
				$salida.= '<td class = "text-center" >'.$valor_label;
				$salida.= '<input type = "hidden" id = "otb'.$i.'" name = "otb'.$i.'" value = "'.$valor.'" />';
				$salida.='</td>';
				//Pagos Online
				$valor = str_replace("Q","",$datos[7]);
				$valor = (trim($valor) != "")? $valor : 0; /// valida que si el dato es nulo o vacion coloca 0
				if(is_numeric($valor)) {
					/// valido
					$valor_label = ($valida_pagado == 1)?'<small class = "text-muted">'.$valor.'</small>':$valor;
				}else{
					$valor_label = '<label class = "text-danger">'.$valor.'</label>';
					$classfecha = "danger";
					$msj.= "Formato de Valor Invalido! Corrobore que el formato del valor sea numerico y no tenga simbolo de moneda. ";
					$error_garrafal++;
				}
				$salida.= '<td class = "text-center" >'.$valor_label;
				$salida.= '<input type = "hidden" id = "online'.$i.'" name = "online'.$i.'" value = "'.$valor.'" />';
				$salida.='</td>';
				//--
				$salida.= '</tr>';
				//--
				$i++;
				//break;
			}
			if($error_garrafal > 0){
				break;
			}
		}
		$i--; //quita la ultima fila para cuadrar cantidades
			$salida.= '</table>';
			$salida.= '<input type = "hidden" id = "filas" name = "filas" value = "'.$i.'" />';
		if($error_garrafal > 0){
			$salida.= '<div class="alert alert-danger">';
			$salida.= $msj;
			$salida.= '</div>';
			$salida.= '<input type = "hidden" id = "errorgarrafal" name = "errorgarrafal" value = "'.$error_garrafal.'" />';
		}else{
			///valida cantidad de errores para notificar
			$errores_total = ($errores_alumnos+$errores_boleta+$errores_monto);
			$alert = ($errores_total > 0)?"danger":"success";
			$salida.= '<div>';
				$salida.= '<div class="alert alert-'.$alert.' alert-dismissable">';
				$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$salida.= ' '.$errores_total.' Error(es) encontrado(s)...';
				$salida.= '</div>';
				if($errores_alumnos > 0){
					$salida.= '<div class="alert alert-warning alert-dismissable">';
					$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$salida.= ' '.$errores_alumnos.' Codigos de alumnos fueron digitados incorrectamente en este listado de carga electr&oacute;nica...';
					$salida.= '</div>';
				}
				if($errores_boleta > 0){
					$salida.= '<div class="alert alert-warning alert-dismissable">';
					$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$salida.= ' '.$errores_boleta.' No. de Boleta(s) fueron digitados incorrectamente en este listado de carga electr&oacute;nica...';
					$salida.= '</div>';
				}
				if($errores_monto > 0){
					$salida.= '<div class="alert alert-warning alert-dismissable">';
					$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$salida.= ' '.$errores_monto.' montos no coinciden con su monto original...';
					$salida.= '</div>';
				}
				if($boletas_pagadas > 0){
					$salida.= '<div class="alert alert-info alert-dismissable">';
					$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$salida.= ' '.$boletas_pagadas.' Boleta(s) ya Pagadas, estas no se registraran nuevamente con esta carga...';
					$salida.= '</div>';
				}
			$salida.= '<input type = "hidden" id = "errorgarrafal" name = "errorgarrafal" value = "0" />';
			$salida.= '</div>';
			//-- /terminan notificaciones
		}		
			$salida.= '</div>';

	}else{
		$salida.= '<h5 class="alert alert-danger text-center"> <i class = "fa fa-exclamation-circle"></i> Error de lectura del archivo .CSV</h5>';
		$salida.= '<input type = "hidden" id = "errorgarrafal" name = "errorgarrafal" value = "1000" />';
	}
	fclose($gestor);
	
	return $salida;
}


function tabla_historial_csv(){
	
	$directorio = opendir("../../CONFIG/CARGAS"); //ruta actual
	$salida.= '<div class="dataTable_wrapper">';
	$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
	$salida.= '<thead>';
	$salida.= '<tr>';
	$salida.= '<th class = "text-center" width = "10px">No.</th>';
	$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
	$salida.= '<th class = "text-center" width = "200px">ARCHIVO</th>';
	$salida.= '<th class = "text-center" width = "150px">FECHA DE CARGA</th>';
	$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
	$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
	$salida.= '</tr>';
	$salida.= '</thead>';
	$i = 1;	
	while ($archivo = readdir($directorio)){ //obtenemos un archivo y luego otro sucesivamente
		if (is_dir($archivo)){ //verificamos si es o no un directorio
			/// No lista las carpetas
		}else{
			if($archivo != "index.php"){ /////// esconde el archivo de redirección por seguridad
			//-------- Lista archivos
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<a type="button" class="btn btn-default" title="Revisar el Archivo de Carga " href="FRMlectorcsv.php?name='.$archivo.'" ><span class="fa fa-table"></span></a> ';
			$salida.= '</td>';
			//nombre
			$salida.= '<td class = "text-left font-14" >'.$archivo.'</td>';
			//fecha de Carga
			$salida.= '<td class = "text-center font-14" >'.date("d/m/Y H:i:s.", filectime("../../CONFIG/CARGAS/$archivo")).'</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<a type="button" class="btn btn-success" title="Descargar Archivo de Carga" href="FRMdescargarcsv.php?name='.$archivo.'" ><span class="fa fa-download"></span></a> ';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<input type ="hidden" id ="archivo'.$i.'" name ="archivo'.$i.'" value ="'.$archivo.'" />';
			$salida.= '<button type="button" class="btn btn-danger" title="Eliminar Archivo de Carga " onclick="ConfirmEliminarArchivoCarga('.$i.');" ><span class="fa fa-trash-o"></span></button> ';
			$salida.= '</td>';
			$salida.= '</tr>';
			//--------
			$i++;
			}
		}
	}
	$salida.= '</table>';
	$salida.= '</div>';
	
	return $salida;
}



function tabla_carga_electronica($carga){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pagos_de_carga($carga);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "60px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "40px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "40px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "40px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "40px">EFECTIVO</th>';
		$salida.= '<th class = "text-center" width = "40px">CHEQUES PROP.</th>';
		$salida.= '<th class = "text-center" width = "40px">OTROS BAN.</th>';
		$salida.= '<th class = "text-center" width = "40px">ONLINE</th>';
		//$salida.= '<th class = "text-center" width = "15px"></th>';
		$salida.= '<th class = "text-center" width = "15px"></th>';
		$salida.= '<th class = "text-center" width = "15px"></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		$errores_boleta = 0;
		$errores_alumnos = 0;
		$errores_monto = 0;
		foreach($result as $row){
			////-- Comprobaciones
				$iconos = "";
				$disabled = "";
				$boleta = $row["pag_programado"];
				$cuenta = $row["pag_cuenta"];
				$banco = $row["pag_banco"];
				$alumno = $row["pag_alumno"];
				$monto_total = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
				//--comprueba
				$comprueba_boleta = $row["bol_codigo"];
				$valida_boleta = ($comprueba_boleta == $boleta)?1:"";
				///comprueba exitencia de alumno
				if($row["alu_cui"] != ""){
					$comprueba_alumno = $row["alu_cui"];
				}else if($row["alu_inscripciones_cui"] != ""){ //comprueba existencia de alumno (en modulo de inscripciones / no activo en el sistema)
					$comprueba_alumno = $row["alu_inscripciones_cui"];
				}else{
					$valida_alumno = "";
				}
				$valida_alumno = ($comprueba_alumno == $alumno)?$alumno:"";
				$valida_monto = $row["bol_monto"];
				if($valida_boleta == false && $valida_alumno == ""){
					$class = "danger";
					$disabled2 = "";
				}else if($valida_boleta == true && $valida_alumno != "" && $valida_monto != $monto_total){
					$class = "info";
					$disabled = "";
					$disabled2 = "";
				}else if($valida_boleta == true && $valida_alumno != "" && $valida_monto == $monto_total){
					$class = "";
					$iconos = ' <span class="fa fa-check text-success" title ="Datos Correctos"></span> ';
					$disabled = "disabled";
					$disabled2 = "disabled";
				}else{
					$class = "warning";
					$disabled2 = "";
				}
				//valida iconos a desplegar
				if($valida_boleta == false){
					$iconos.= ' <span class="fa fa-file-text text-danger" title ="No existe el numero de boleta"></span> ';
					$errores_boleta++;
				}
				if($valida_alumno == ""){
					$iconos.= ' <span class="fa fa-user text-danger" title ="No existe el alumno"></span> ';
					$errores_alumnos++;
				}
				if($valida_boleta == true && ($valida_monto != $monto_total)){
					$iconos.= ' <span class="fa fa-dollar text-info" title ="El monto de la boleta no coincide con el monto depositado"></span> ';
					$errores_monto++;
				}
				//--------
				$salida.= '<tr class="'.$class.'">';
				//--
				$alumno = trim($row["pag_alumno"]);
				$boleta = trim($row["pag_programado"]);
				$salida.= '<td class = "text-center">';
				$salida.= '<button type="button" class="btn btn-default" title="Datos de la Boleta " onclick = "VerBoleta(\''.$alumno.'\',\''.$boleta.'\');" ><i class="fa fa-search"></i></button> ';
				$salida.= ' &nbsp; '.$iconos.'</td>';
				//boleta
				$boleta = Agrega_Ceros($row["pag_programado"]);
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//refernecia
				$referencia = trim($row["pag_referencia"]);
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//alumno
				$alumno = $row["pag_alumno"];
				$salida.= '<td class = "text-center" >'.$alumno.'</td>';
				//efectivo
				$valor = $row["pag_efectivo"];
				$salida.= '<td class = "text-center" >'.$valor.'</td>';
				//chequede propio banco
				$valor = $row["pag_cheques_propios"];
				$salida.= '<td class = "text-center" >'.$valor.'</td>';
				//cheque de otros bancos
				$valor = $row["pag_otros_bancos"];
				$salida.= '<td class = "text-center" >'.$valor.'</td>';
				//Pagos Online
				$valor = $row["pag_online"];
				$salida.= '<td class = "text-center" >'.$valor.'</td>';
				//--
				$codigo = $row["pag_codigo"];
				$salida.= '<td class = "text-center">';
				$salida.= '<button type="button" class="btn btn-outline btn-warning" '.$disabled.' title="Enlazar Datos del Pago con Boletas Programadas" onclick = "EnlazarBoleta('.$codigo.');" ><span class="fa fa-link"></span></button> ';
				$salida.= '</td>';
				//--
				$codigo = $row["pag_codigo"];
				$salida.= '<td class = "text-center">';
				$salida.= '<button type="button" class="btn btn-warning" '.$disabled.' title="Editar Datos del Pago" onclick = "EditBoleta('.$codigo.');" ><span class="fa fa-user"></span></button> ';
				$salida.= '</td>';
				//--
				//$salida.= '<td class = "text-center">';
				//$salida.= '<button type="button" class="btn btn-outline btn-info" '.$disabled2.' title="Intercambio de Boleta (por pagos electr&oacute;nicos)" onclick = "ChangeBoleta(\''.$alumno.'\',\''.$boleta.'\',\''.$cuenta.'\',\''.$banco.'\',\''.$codigo.'\');" ><span class="fa fa-exchange"></span></button> ';
				//$salida.= '</td>';
				//--
				$salida.= '</tr>';
				//--
				$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		$salida.= '<input type = "hidden" id = "filas" name = "filas" value = "'.$i.'" />';
		///valida cantidad de errores para notificar
		$errores_total = ($errores_alumnos+$errores_boleta+$errores_monto);
		$alert = ($errores_total > 0)?"danger":"success";
		$salida.= '<div>';
			$salida.= '<div class="alert alert-'.$alert.' alert-dismissable">';
			$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			$salida.= ' '.$errores_total.' Error(es) encontrado(s)...';
			$salida.= '</div>';
			if($errores_alumnos > 0){
				$salida.= '<div class="alert alert-warning alert-dismissable">';
				$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$salida.= ' '.$errores_alumnos.' Codigos de alumnos fueron digitados incorrectamente en este listado de carga electr&oacute;nica...';
				$salida.= '</div>';
			}
			if($errores_boleta > 0){
				$salida.= '<div class="alert alert-warning alert-dismissable">';
				$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$salida.= ' '.$errores_boleta.' No. de Boleta(s) fueron digitados incorrectamente en este listado de carga electr&oacute;nica...';
				$salida.= '</div>';
			}
			if($errores_monto > 0){
				$salida.= '<div class="alert alert-warning alert-dismissable">';
				$salida.= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$salida.= ' '.$errores_monto.' montos no coinciden con su monto original...';
				$salida.= '</div>';
			}
		$salida.= '</div>';
		//-- /terminan notificaciones
		$salida.= '</div>';
	}else{
		echo "error en la lectura";
	}
	
	return $salida;
}




function tabla_historial_cargas(){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_carga_electronica($cod,$cue,$ban,$fini,$ffin);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "10px">CODIGO</th>';
		$salida.= '<th class = "text-center" width = "50px">CUENTA</th>';
		$salida.= '<th class = "text-center" width = "50px">BANCO</th>';
		$salida.= '<th class = "text-center" width = "150px">ARCHIVO</th>';
		$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "100px">FECHA DE CARGA</th>';
		$salida.= '<th class = "text-center" width = "10px"><i class="fa fa-cogs"></i></th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			//-------- Lista archivos
			$salida.= '<tr>';
			$carga = $row["car_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($carga, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default" title="Revisar el Archivo de Carga " onclick="window.location=\'FRMdetalle_historial_pagos.php?hashkey='.$hashkey.'\'" ><span class="fa fa-table"></span></button> ';
			$salida.= '</td>';
			//codigo
			$codigo = $row["car_codigo"];
			$salida.= '<td class = "text-center" >'.$codigo.'</td>';
			//cuenta
			$cuenta = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center" >'.$cuenta.'</td>';
			//Banco
			$banco = $row["ban_desc_ct"];
			$salida.= '<td class = "text-center" >'.$banco.'</td>';
			//archivo
			$archivo = $row["car_archivo"];
			$salida.= '<td class = "text-left" >'.$archivo.'</td>';
			//descripcion
			$desc = $row["car_descripcion"];
			$salida.= '<td class = "text-left" >'.$desc.'</td>';
			//fecha de Carga
			$fecha = $row["car_fecha_registro"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//--
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger" title="Eliminar Carga Electr&oacute;nica" onclick="ConfirmEliminarCarga('.$codigo.')" ><span class="fa fa-trash-o"></span></button> ';
			$salida.= '</td>';
			$salida.= '</tr>';
			//--------
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_lista_cargas(){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_carga_electronica($cod,$cue,$ban,$fini,$ffin);
	if(is_array($result)){
		$salida = '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "30px">CODIGO</th>';
		$salida.= '<th class = "text-center" width = "150px">CUENTA</th>';
		$salida.= '<th class = "text-center" width = "150px">BANCO</th>';
		$salida.= '<th class = "text-center" width = "150px">FECHA DE CARGA</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			//-------- Lista archivos
			$salida.= '<tr>';
			$carga = $row["car_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($carga, $usu);
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default" title="Generar Facturas" onclick="window.location=\'FRMgestor_facturas.php?hashkey='.$hashkey.'\'" ><i class="fa fa-dollar text-success"></i> Factura</button> ';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default" title="Generar Recibos" onclick="window.location=\'FRMgestor_recibos.php?hashkey='.$hashkey.'\'" ><i class="fa fa-check text-info"></i> Recibo</button> ';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default" title="Generar Recibos" onclick="window.location=\'FRMvisualizador_facturas.php?hashkey='.$hashkey.'\'" ><i class="fa fa-search"></i> Visualizar</button> ';
			$salida.= '</td>';
			//codigo
			$codigo = $row["car_codigo"];
			$salida.= '<td class = "text-center" >'.$codigo.'</td>';
			//cuenta
			$cuenta = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center" >'.$cuenta.'</td>';
			//Banco
			$banco = $row["ban_desc_lg"];
			$salida.= '<td class = "text-center" >'.$banco.'</td>';
			//fecha de Carga
			$fecha = $row["car_fecha_registro"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//--
			$salida.= '</tr>';
			//--------
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_pagos_carga_electronica($carga){
	
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pagos_de_carga($carga);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "60px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "40px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "40px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "40px">EFECTIVO</th>';
		$salida.= '<th class = "text-center" width = "40px">CHEQUES PROP.</th>';
		$salida.= '<th class = "text-center" width = "40px">OTROS BAN.</th>';
		$salida.= '<th class = "text-center" width = "40px">ONLINE</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			////-- Comprobaciones
				$iconos = "";
				$referencia = $row["pag_referencia"];
				$cuenta = $row["pag_cuenta"];
				$banco = $row["pag_banco"];
				$alumno = $row["pag_alumno"];
				$monto_total = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
				$fecha = $row["pag_fechor"];
				$fecha = cambia_fechaHora($fecha);
				$fecha = substr($fecha,0,10);
				//--comprueba
				$comprueba_boleta = $row["bol_referencia"];
				$valida_boleta = ($comprueba_boleta == $referencia)?1:"";
				$comprueba_alumno = $row["comprueba_alumno"];
				
				///comprueba exitencia de alumno
				if($row["alu_cui"] != ""){
					$comprueba_alumno = $row["alu_cui"];
					$cliente = $row["alu_cliente_factura"];
				}else if($row["alu_inscripciones_cui"] != ""){ //comprueba existencia de alumno (en modulo de inscripciones / no activo en el sistema)
					$comprueba_alumno = $row["alu_inscripciones_cui"];
					$cliente = $row["alu_inscripciones_cliente_factura"];
				}else{
					$valida_alumno = "";
				}
				$valida_alumno = ($comprueba_alumno == $alumno)?$alumno:"";
				$cliente = ($cliente == "")?0:$cliente;
				if($valida_boleta == false && $valida_alumno == ""){
					$class = "danger";
				}else if($valida_boleta == true && $valida_alumno != ""){
					$class = "";
					$iconos = ' <span class="fa fa-check text-success" title ="Datos Correctos"></span> ';
				}else{
					$class = "warning";
				}
				//valida iconos a desplegar
				if($valida_boleta == false){
					$iconos.= ' <span class="fa fa-file-text text-danger" title ="No existe el numero de boleta"></span> ';
					$errores_boleta++;
				}
				if($valida_alumno == ""){
					$iconos.= ' <span class="fa fa-user text-danger" title ="No existe el alumno"></span> ';
					$errores_alumnos++;
				}
				//--------
				$salida.= '<tr class="'.$class.'">';
				//--
				$alumno = trim($row["pag_alumno"]);
				$boleta = trim($row["bol_codigo"]);
				$salida.= '<td class = "text-center">';
				$salida.= '<button type="button" class="btn btn-default" title="Datos de la Boleta " onclick = "VerBoleta(\''.$alumno.'\',\''.$boleta.'\');" ><i class="fa fa-search"></i></button> ';
				$salida.= '<input type = "hidden" name = "boleta'.$i.'" id = "boleta'.$i.'" value = "'.$boleta.'" />';
				$salida.= '<input type = "hidden" name = "referencia'.$i.'" id = "referencia'.$i.'" value = "'.$referencia.'" />';
				$salida.= '<input type = "hidden" name = "alumno'.$i.'" id = "alumno'.$i.'" value = "'.$alumno.'" />';
				$salida.= '<input type = "hidden" name = "cli'.$i.'" id = "cli'.$i.'" value = "'.$cliente.'" />';
				$salida.= '<input type = "hidden" name = "monto'.$i.'" id = "monto'.$i.'" value = "'.$monto_total.'" />';
				$salida.= '<input type = "hidden" name = "fecha'.$i.'" id = "fecha'.$i.'" value = "'.$fecha.'" />';
				$salida.= ' &nbsp; '.$iconos.'</td>';
				//boleta
				$boleta = $row["pag_programado"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//refeencia
				$referencia = $row["pag_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//efectivo
				$valor = $row["pag_efectivo"];
				$mons = $row["mon_simbolo"];
				$valor = number_format($valor, 2);
				$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
				//chequede propio banco
				$valor = $row["pag_cheques_propios"];
				$mons = $row["mon_simbolo"];
				$valor = number_format($valor, 2);
				$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
				//cheque de otros bancos
				$valor = $row["pag_otros_bancos"];
				$mons = $row["mon_simbolo"];
				$valor = number_format($valor, 2);
				$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
				//Pagos Online
				$valor = $row["pag_online"];
				$mons = $row["mon_simbolo"];
				$valor = number_format($valor, 2);
				$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
				//--
				$salida.= '</tr>';
				//--
				$i++;
		}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'" />';
		$salida.= '</div>';
	}
	
	return $salida;
}

//////////////////////////// ESTADOS DE CUENTA /////////////////////////////////

function tabla_estado_cuenta($alumno,$periodo,$cuenta,$banco){
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	
	$orderby = 3;
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_vs_pago('',$cuenta,$banco,$alumno,'',$periodo,'','','',1,$orderby);
	$result_aislado = $ClsBol->get_pago_aislado('',$cuenta,$banco, $alumno,'',$periodo,'','0','','','','');
		
	$salida.= '<table class="table table-striped table-bordered table-hover">';
	$salida.= '<thead>';
	$salida.= '<tr>';
	$salida.= '<th class = "text-center" width = "5px">No.</th>';
	$salida.= '<th class = "text-center" width = "20px"><i class="fa fa-cogs"></i></th>';
	$salida.= '<th class = "text-center" width = "150px">Descripci&oacute;n</th>';
	$salida.= '<th class = "text-center" width = "40px"># Boleta</th>';
	$salida.= '<th class = "text-center" width = "40px"># Referencia</th>';
	$salida.= '<th class = "text-center" width = "60px">Fecha Limite / Fecha Pago</th>';
	$salida.= '<th class = "text-center" width = "40px">Monto Bol/Pag</th>';
	$salida.= '<th class = "text-center" width = "40px">Descuento Bol/Pag</th>';
	$salida.= '<th class = "text-center" width = "40px">Saldo por Pagar</th>';
	$salida.= '<th class = "text-center" width = "40px">Pagado</th>';
	$salida.= '</tr>';
	$salida.= '</thead>';
	$i = 1;
	$referenciaX = '';
	$montoTotal = 0;
	$saldoTotal = 0;
	if(is_array($result)){
		foreach($result as $row){
			////-- Comprobaciones
			$bolcodigo = $row["bol_codigo"];
			if($bolcodigo != $referenciaX){
				//-------------------------------------------------------------------------------------------------------------------------------------------------------
				$salida.= '<tr class="info">';
				//--
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				//--
				$boleta = trim($row["bol_codigo"]);
				$cuenta = $row["bol_cuenta"];
				$banco = $row["bol_banco"];
				$salida.= '<td class = "text-center">';
				$salida.= '<button type="button" class="btn btn-default btn-xs" title="Datos de la Boleta " onclick = "VerBoleta(\''.$alumno.'\',\''.$boleta.'\');" ><i class="fa fa-search"></i></button> ';
				$salida.= '</td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" >'.$motivo.'</td>';
				//boleta
				$boleta = Agrega_Ceros($row["bol_codigo"]);
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["bol_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//Fecha de Pago
				$fecha = $row["bol_fecha_pago"];
				$fecha = cambia_fechaHora($fecha);
				$salida.= '<td class = "text-center" >'.$fecha.'</td>';
				//monto
				$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
				$descuento = $row["bol_descuento"]; // descuento de la boleta
				$monto = ($saldo + $descuento); // monto sin descuento
				$mons = $row["bol_simbolo_moneda"];
				$valor = number_format($valor, 2);
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
				$montoTotal+= $row["bol_monto"];
				//descuento
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($descuento, 2, '.',',').'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($saldo, 2, '.',',').'</td>';
				//pagado
				$salida.= '<td class = "text-center" ></td>';
				//--
				$salida.= '</tr>';
				$referenciaX = $bolcodigo;
			}else{
				$i--;
			}
			//-------------------------------------------------------------------------------------------------------------------------------------------------------
			$pago = $row["pag_codigo"];
			if($pago != ""){
				$iconos = "";
				$boleta = trim($row["pag_programado"]);
				$cuenta = $row["pag_cuenta"];
				$banco = $row["pag_banco"];
				$monto_total = floatval($row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"]);
				/// valido
				$validaBoleta = $ClsBol->comprueba_boleta_cobro($boleta);
				$valida_boleta = $validaBoleta["valida"];
				$codigo_boleta = $validaBoleta["bol_codigo"];
				$valida_monto = trim($validaBoleta["bol_monto"]);
				$valida_pagado = $validaBoleta["bol_pagado"];
				$situacion_boleta = $validaBoleta["bol_situacion"];
				//--
				$valida_alumno = $ClsBol->comprueba_alumno($alumno);
				if($valida_boleta == false && $valida_alumno == ""){
					$class = "danger";
				}else if($valida_boleta == true && $valida_alumno != "" && ($valida_monto != $monto_total)){
					$class = "info";
				}else if($valida_boleta == true && $valida_alumno != "" && ($valida_monto == $monto_total)){
					$class = "";
					$iconos = ' <i class="fa fa-check text-success" title ="Datos Correctos"></i> ';
				}else{
					$class = "warning";
				}
				//valida iconos a desplegar
				if($valida_boleta == false){
					$iconos.= ' <i class="fa fa-file-text text-danger" title ="No existe el numero de boleta"></i> ';
					$errores_boleta++;
				}
				if($valida_alumno == ""){
					$iconos.= ' <i class="fa fa-user text-danger" title ="No existe el alumno"></i> ';
					$errores_alumnos++;
				}
				if($valida_boleta == true && ($valida_monto != $monto_total)){
					$iconos.= ' <i class="fa fa-dollar text-info" title ="El monto de la boleta no coincide con el monto depositado '.$valida_boleta.', '.$valida_monto.', '.$monto_total.'  "></i> ';
					$errores_monto++;
				}
				
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center"></td>';
				//--
				$salida.= '<td class = "text-center" >'.$iconos.'</td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" >'.$motivo.'</td>';
				//boleta
				$boleta = trim($row["pag_programado"]);
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["pag_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//fecha de pago
				$fecha = $row["pag_fechor"];
				$fecha = cambia_fechaHora($fecha);
				$salida.= '<td class = "text-center" >'.$fecha.'</td>';
				//monto
				$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
				$descuento = $row["bol_descuento"]; // descuento de la boleta
				$monto = ($saldo + $descuento); // monto sin descuento
				$mons = $row["bol_simbolo_moneda"];
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
				//descuento
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($descuento, 2, '.',',').'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($saldo, 2, '.',',').'</td>';
				//pagado
				$valor = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
				$saldo = $row["pag_total"]; /// monto registrado en la boleta, ya con descuento
				$saldoTotal+= $saldo;
				$mons = $row["pag_simbolo_moneda"];
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($valor, 2, '.',',').'</td>';
				//--
				$salida.= '</tr>';
			}else{
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center"></td>';
				//--
				$salida.= '<td class = "text-center" > - </td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$bolpago = trim($row["bol_pagado"]);
				$texto = ($bolpago == 1)?" - Abonado con otra boleta  - " : " - Pendiente de pago -";
				$salida.= '<td class = "text-left" >'.$texto.'</td>';
				//boleta
				$boleta = $row["bol_codigo"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["bol_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				//--
				$salida.= '</tr>';
			}
			//--
			$i++;
		}
	}
	if(is_array($result_aislado)){
		foreach($result_aislado as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//--
			$salida.= '<td class = "text-center" ></td>';
			//motivo
			$salida.= '<td class = "text-left" ><strong>- Pago de Boleta No Programado -</strong></td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["pag_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//fecha de pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//monto
			$descuento = 0;
			$mons = $row["mon_simbolo"];
			$monto = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
			//descuento
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format(0, 2, '.',',').'</td>';
			//saldo
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format(0, 2, '.',',').'</td>';
			//pagado
			$saldoTotal+= $monto;
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
	}
		$i--; //quita la ultima fila para cuadrar cantidades
		$salida.= '</table>';
		//$salida.= '<label> Monto: '.$montoTotal.'</label><br>';
		//$salida.= '<label> Saldo: '.$saldoTotal.'</label><br>';
	
	return $salida;
}



function tabla_estado_pagos($alumno,$periodo,$cuenta,$banco){
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	
	$orderby = 3;
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_vs_pago('',$cuenta,$banco,$alumno,'',$periodo,'','','',1,$orderby);
	$result_aislado = $ClsBol->get_pago_aislado('',$cuenta,$banco,$alumno,'',$periodo,'','0','','','','');
		
	$salida.= '<table class="table table-striped table-bordered table-hover">';
	$salida.= '<thead>';
	$salida.= '<tr>';
	$salida.= '<th class = "text-center" width = "5px">No.</th>';
	$salida.= '<th class = "text-center" width = "5px"><i class="fa fa-tag"></i></th>';
	$salida.= '<th class = "text-center" width = "50px"><i class="fa fa-cogs"></i></th>';
	$salida.= '<th class = "text-center" width = "150px">Descripci&oacute;n</th>';
	$salida.= '<th class = "text-center" width = "40px"># Boleta</th>';
	$salida.= '<th class = "text-center" width = "40px"># Referencia</th>';
	$salida.= '<th class = "text-center" width = "60px">Fecha Limite / Fecha Pago</th>';
	$salida.= '<th class = "text-center" width = "40px">Monto Bol/Pag</th>';
	$salida.= '<th class = "text-center" width = "40px">Descuento Bol/Pag</th>';
	$salida.= '<th class = "text-center" width = "40px">Saldo por Pagar</th>';
	$salida.= '<th class = "text-center" width = "40px">Pagado</th>';
	$salida.= '</tr>';
	$salida.= '</thead>';
	$i = 1;
	$referenciaX = '';
	$montoTotal = 0;
	$saldoTotal = 0;
	if(is_array($result)){
		foreach($result as $row){
			////-- Comprobaciones
			$bolcodigo = $row["bol_codigo"];
			if($bolcodigo != $referenciaX){
				//-------------------------------------------------------------------------------------------------------------------------------------------------------
				$salida.= '<tr class="info">';
				//--
				$salida.= '<td class = "text-center">'.$i.'.</td>';
				$salida.= '<td class = "text-center"></td>';
				$cuenta = $row["bol_cuenta"];
				$banco = $row["bol_banco"];
				$boleta = $row["bol_codigo"];
				$salida.= '<td class = "text-center" >';
					$salida.= '<div class="btn-group">';
						$salida.= '<button type="button" class="btn btn-default btn-xs" title="Datos de la Boleta " onclick = "VerBoleta(\''.$alumno.'\',\''.$boleta.'\');" ><i class="fa fa-search"></i></button>';
						$salida.= '<button type="button" class="btn btn-success btn-xs" title="Pagar Boleta" onclick = "abrir();xajax_Buscar_Boleta_Cobro_Para_Pago('.$boleta.');" > <i class="fa fa-dollar"></i></button>';
					$salida.= '</div>';
				$salida.= '</td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" >'.$motivo.'</td>';
				//boleta
				$boleta = $row["bol_codigo"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["bol_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//Fecha de Pago
				$fecha = $row["bol_fecha_pago"];
				$fecha = cambia_fechaHora($fecha);
				$salida.= '<td class = "text-center" >'.$fecha.'</td>';
				//monto
				$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
				$descuento = $row["bol_descuento"]; // descuento de la boleta
				$monto = ($saldo + $descuento); // monto sin descuento
				$mons = $row["bol_simbolo_moneda"];
				$valor = number_format($valor, 2);
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
				$montoTotal+= $row["bol_monto"];
				//descuento
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($descuento, 2, '.',',').'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($saldo, 2, '.',',').'</td>';
				//pagado
				$salida.= '<td class = "text-center" ></td>';
				//--
				$salida.= '</tr>';
				$referenciaX = $bolcodigo;
			}else{
				$i--;
			}
			//-------------------------------------------------------------------------------------------------------------------------------------------------------
			$pago = $row["pag_codigo"];
			if($pago != ""){
				$iconos = "";
				$boleta = $row["pag_programado"];
				$cuenta = $row["pag_cuenta"];
				$banco = $row["pag_banco"];
				$alumno = $row["pag_alumno"];
				$monto_total = floatval($row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"]);
				/// valido
				$validaBoleta = $ClsBol->comprueba_boleta_cobro($boleta);
				$valida_boleta = $validaBoleta["valida"];
				$codigo_boleta = $validaBoleta["bol_codigo"];
				$valida_monto = floatval($validaBoleta["bol_monto"]);
				$valida_pagado = $validaBoleta["bol_pagado"];
				$situacion_boleta = $validaBoleta["bol_situacion"];
				//--
				$valida_alumno = $ClsBol->comprueba_alumno($alumno);
				if($valida_boleta == false && $valida_alumno == ""){
					$class = "danger";
				}else if($valida_boleta == true && $valida_alumno != "" && ($valida_monto != $monto_total)){
					$class = "info";
				}else if($valida_boleta == true && $valida_alumno != "" && ($valida_monto == $monto_total)){
					$class = "";
					$iconos = ' <i class="fa fa-check text-success" title ="Datos Correctos"></i> ';
				}else{
					$class = "warning";
				}
				//valida iconos a desplegar
				if($valida_boleta == false){
					$iconos.= ' <i class="fa fa-file-text text-danger" title ="No existe el numero de boleta"></i> ';
					$errores_boleta++;
				}
				if($valida_alumno == ""){
					$iconos.= ' <i class="fa fa-user text-danger" title ="No existe el alumno"></i> ';
					$errores_alumnos++;
				}
				if($valida_boleta == true && ($valida_monto != $monto_total)){
					$iconos.= ' <i class="fa fa-dollar text-info" title ="El monto de la boleta no coincide con el monto depositado"></i> ';
					$errores_monto++;
				}
				
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center"></td>';
				$salida.= '<td class = "text-center">'.$iconos.'</td>';
				//--
				$codigo = trim($row["pag_codigo"]);
				$salida.= '<td class = "text-center" >';
					$salida.= '<div class="btn-group">';
						$salida.= '<button type="button" class="btn btn-default btn-xs" title="Editar Datos del Pago" onclick = "abrir();xajax_Buscar_Pago_Boleta('.$codigo.');" ><i class="fa fa-edit"></i></button>';
						$salida.= '<button type="button" class="btn btn-danger btn-xs" title="Anular Pago" onclick = "ConfirmAnularPago('.$codigo.');" ><i class="fa fa-trash"></i></button>';
					$salida.= '</div>';
				$salida.= '</td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$salida.= '<td class = "text-left" >'.$motivo.'</td>';
				//boleta
				$boleta = $row["pag_programado"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["pag_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//fecha de pago
				$fecha = $row["pag_fechor"];
				$fecha = cambia_fechaHora($fecha);
				$salida.= '<td class = "text-center" >'.$fecha.'</td>';
				//monto
				$saldo = $row["bol_monto"]; /// monto registrado en la boleta, ya con descuento
				$descuento = $row["bol_descuento"]; // descuento de la boleta
				$monto = ($saldo + $descuento); // monto sin descuento
				$mons = $row["bol_simbolo_moneda"];
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
				//descuento
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($descuento, 2, '.',',').'</td>';
				//saldo
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($saldo, 2, '.',',').'</td>';
				//pagado
				$valor = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
				$saldo = $row["pag_total"]; /// monto registrado en la boleta, ya con descuento
				$saldoTotal+= $saldo;
				$mons = $row["pag_simbolo_moneda"];
				$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($valor, 2, '.',',').'</td>';
				//--
				$salida.= '</tr>';
			}else{
				$salida.= '<tr>';
				//--
				$salida.= '<td class = "text-center"></td>';
				$salida.= '<td class = "text-center"></td>';
				//--
				$salida.= '<td class = "text-center" > - </td>';
				//motivo
				$motivo = utf8_decode($row["bol_motivo"]);
				$bolpago = trim($row["bol_pagado"]);
				$texto = ($bolpago == 1)?" - Abonado con otra boleta  - " : " - Pendiente de pago -";
				$salida.= '<td class = "text-left" >'.$texto.'</td>';
				//boleta
				$boleta = $row["bol_codigo"];
				$salida.= '<td class = "text-center" >'.$boleta.'</td>';
				//referencia
				$referencia = $row["bol_referencia"];
				$salida.= '<td class = "text-center" >'.$referencia.'</td>';
				//--
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				$salida.= '<td class = "text-center" ></td>';
				//--
				$salida.= '</tr>';
			}
			//--
			$i++;
		}
	}
	if(is_array($result_aislado)){
		foreach($result_aislado as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//--
			$salida.= '<tr>';
			//--
			$codigo = trim($row["pag_codigo"]);
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default btn-xs" title="Editar Datos del Pago" onclick = "abrir();xajax_Buscar_Pago_Boleta('.$codigo.');" ><span class="fa fa-edit"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" title="Anular Pago" onclick = "ConfirmAnularPago('.$codigo.');" ><span class="fa fa-trash"></span></button> ';
			$salida.= '</td>';
			//motivo
			$salida.= '<td class = "text-left" ><strong>- Pago de Boleta No Programado -</strong></td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["pag_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//fecha de pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center" >'.$fecha.'</td>';
			//monto
			$descuento = 0;
			$mons = $row["mon_simbolo"];
			$monto = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
			//descuento
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format(0, 2, '.',',').'</td>';
			//saldo
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format(0, 2, '.',',').'</td>';
			//pagado
			$saldoTotal+= $monto;
			$salida.= '<td class = "text-center" >'.$mons.'. '.number_format($monto, 2, '.',',').'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
	}
	$i--; //quita la ultima fila para cuadrar cantidades
	$salida.= '</table>';
	//$salida.= '<label> Monto: '.$montoTotal.'</label><br>';
	//$salida.= '<label> Saldo: '.$saldoTotal.'</label><br>';
	
	return $salida;
}


function tabla_lista_pagos($programado,$cue,$ban,$alumno,$referencia,$periodo){
	$ClsPer = new ClsPeriodoFiscal();
	$ClsBol = new ClsBoletaCobro();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	$result = $ClsBol->get_pago_boleta_cobro('',$cue,$ban,$alumno,$referencia,$periodo,'',$programado,'','','',2);
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "80px">CUENTA</th>';
		$salida.= '<th class = "text-center" width = "60px">BANCO</th>';
		$salida.= '<th class = "text-center" width = "50px">CARGA</th>';
		$salida.= '<th class = "text-center" width = "50px">BOLETA</th>';
		$salida.= '<th class = "text-center" width = "50px">REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "70px">FECHA/PAGO</th>';
		$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "200px">MOTIVO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$bolCodigo = $row["pag_programado"];
			$ban = $row["pag_banco"];
			$cue = $row["pag_cuenta"];
			//--
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($bolCodigo, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-default btn-xs" title="Imprimir Boleta Original (boleta f&iacute;sica)" href = "../../CONFIG/BOLETAS/REPboleta.php?hashkey='.$hashkey.'" target = "_blank" ><span class="fa fa-print"></span></a> ';
			$salida.= '</td>';
			//numero de cuenta
			$num = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center">'.$num.'</td>';
			//banco
			$bann = $row["ban_desc_ct"];
			$salida.= '<td class = "text-center">'.$bann.'</td>';
			//numero de carga
			$carga = $row["pag_carga"];
			$salida.= '<td class = "text-center">'.$carga.'</td>';
			//boleta
			$boleta = $row["pag_programado"];
			$salida.= '<td class = "text-center" >'.$boleta.'</td>';
			//referencia
			$referencia = $row["pag_referencia"];
			$salida.= '<td class = "text-center" >'.$referencia.'</td>';
			//Alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left">'.$alumno.'</td>';
			//fecha de pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//Monto
			$valor = $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$mons = $row["mon_simbolo"];
			$valor = number_format($valor, 2);
			$salida.= '<td class = "text-center" >'.$mons.'. '.$valor.'</td>';
			//Motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$salida.= '<td class = "text-justify">'.$motivo.'</td>';
			$salida.= '</tr>';
			//--
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-exclamation-circle"></i> No hay boletas registradas con estos filtros de busqueda...';
		$salida.= '</h5>';
	}
	
	return $salida;
}

function tabla_grupos_mora($cue,$ban,$empresa,$fini, $ffin){
	$ClsMora = new ClsMora();
	
	$result = $ClsMora->get_grupos_moras('',$cue,$ban,$empresa,'',$fini, $ffin);
	if(is_array($result)){
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "70px"></th>';
		$salida.= '<th class = "text-center" width = "50px">GRUPO</th>';
		$salida.= '<th class = "text-center" width = "100px">FECHA/REGISTRO</th>';
		$salida.= '<th class = "text-center" width = "50px">ACTIVAS/ANULADAS</th>';
		$salida.= '<th class = "text-center" width = "150px">MOTIVO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$banco = $row["ban_codigo"];
			$cuenta = $row["cueb_codigo"];
			$grupo = $row["mor_grupo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<a type="button" class="btn btn-info btn-outline btn-xs" title="Imprimir Boletas Originales (boletas f&iacute;sicas)" href = "../../CONFIG/BOLETAS/REPboletas_mora.php?grupo='.$grupo.'" target = "_blank" ><span class="fa fa-print"></span></a> ';
			$salida.= '<a type="button" class="btn btn-success btn-outline btn-xs" title="Imprimir Boletas a Colores" href = "../../CONFIG/BOLETAS/REPboletas_mora_colores.php?grupo='.$grupo.'" target = "_blank" ><span class="fa fa-print"></span></a> ';
			$salida.= '<a class="btn btn-default btn-xs" title="Editar Boletas en el Grupo" href = "FRMmora_edit.php?grupo='.$grupo.'" ><span class="fa fa-pencil"></span></a> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" title = "Eliminar Grupo de Boletas" onclick="Confirm_EliminarMora('.$grupo.');" ><span class="fa fa-trash-o"></span></button>';
			$salida.= '</td>';
			//Grupo
			$grupo = $row["mor_grupo"];
			$salida.= '<td class = "text-center"># '.$grupo.'</td>';
			//fecha de registro
			$freg = $row["mor_fecha_registro"];
			$freg = cambia_fechaHora($freg);
			$salida.= '<td class = "text-center">'.$freg.'</td>';
			//cantidad de boletas
			$cantidad = trim($row["mor_boletas"]);
			$salida.= '<td class = "text-center">'.$cantidad.'</td>';
			//motivo
			$motivo = utf8_decode($row["mor_descripcion"]);
			$salida.= '<td class = "text-left">'.$motivo.'</td>';
			//--
			$salida.= '</tr>';
			$i++;	
		}
		//--
		$salida.= '</table>';
		$salida.= '</div>';
	}
	
	return $salida;
}

function tabla_gestor_moras($cue,$ban,$empresa,$nivel,$grado,$seccion,$pagado,$grupo){
	$ClsBol = new ClsBoletaCobro();
	$ClsPer = new ClsPeriodoFiscal();
	$pensum = $_SESSION["pensum"];
	$periodo = $ClsPer->periodo;
	
	$result = $ClsBol->get_mora('',$cue,$ban,'',$nivel,$grado,$seccion,'', $periodo, $empresa, '', '', 1, '',$pagado,$grupo);
	if(is_array($result)){
        $salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "5px">No.</th>';
		$salida.= '<th class = "text-center" width = "100px"><i class="fa fa-cogs"></i></td>';
		$salida.= '<th class = "text-center" width = "30px">CUI</td>';
		$salida.= '<th class = "text-center" width = "170px">ALUMNO</td>';
		$salida.= '<th class = "text-center" width = "100px">GRADO</td>';
		$salida.= '<th class = "text-center" width = "40px">FECHA DE GENERACI&Oacute;N</td>';
		$salida.= '<th class = "text-center" width = "40px">MONTO</td>';
		$salida.= '<th class = "text-center" width = "100px">MOTIVO</td>';
		$salida.= '<th class = "text-center" width = "30px">SITUACI&Oacute;N</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//-
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//--
			$ban = $row["ban_codigo"];
			$cue = $row["cueb_codigo"];
			$cod = $row["bol_codigo"];
			//--
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($cod, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-info btn-outline btn-xs" title="Imprimir Boleta Original (boleta f&iacute;sica)" href = "../../CONFIG/BOLETAS/REPboleta.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-print"></i></a> ';
			$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="xajax_Buscar_Boleta_Cobro('.$cod.');" title = "Seleccionar Boleta" '.$button.' ><i class="fa fa-edit"></i></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Confirm_EliminarBoleta('.$cod.');" title = "Eliminar Boleta" '.$button.' ><i class="fa fa-trash-o"></i></button>';
			$salida.= '</td>';
			//cui
			$cui = $row["alu_cui"];
			$salida.= '<td class = "text-center">'.$cui.'</td>';
			//nombre
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-left">'.$nombre.' '.$apellido.'</td>';
			//grado
			$grado = utf8_decode($row["gra_descripcion"]);
			$seccion = utf8_decode($row["sec_descripcion"]);
			$salida.= '<td class = "text-left">'.$grado.' '.$seccion.'</td>';
			//fecha de registro
			$freg = $row["bol_fecha_registro"];
			$freg = cambia_fechaHora($freg);
			$salida.= '<td class = "text-center">'.$freg.'</td>';
			//Monto
			$monto = $row["bol_monto"];
			$monto = number_format($monto,2,'.',',');
			$salida.= '<td class = "text-center">Q.'.$monto.'</td>';
			//motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$salida.= '<td class = "text-left">'.$motivo.'</td>';
			//pagado
			$pagado = trim($row["bol_pagado"]);
			if($pagado == 1){
				$salida.= '<td class = "text-center"><span class="text-success">Pagado</span></td>';
			}else{
				$salida.= '<td class = "text-center"><span class="text-muted">Pendiente de Pago</span></td>';
			}
			//--
			$salida.= '</tr>';
			$i++;	
		}
		//--
		$salida.= '</table>';
		$salida.= '</div>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-ban"></i> &nbsp; No hay boletas de moras con situaci&oacute;n activa en este grupo....';
		$salida.= '</h5><br><br>';
	}
	
	return $salida;
}



function tabla_filas_venta($pv,$suc,$ventMonDesc,$ventMonSimb,$ventMonCambio,$tfdsc,$fdsc){
	
	$ClsVent = new ClsVenta();
	$result = $ClsVent->get_detalle_temporal($pv,$suc);
	//Tratamiento de la cadena de moneda
	$salida.= '<table class="table table-striped table-bordered table-hover">';
	$salida.= '<tr>';
	$salida.= '<th class = "text-center"  width = "30px">No.</td>';
	$salida.= '<th class = "text-center"  width = "75px">Cantidad</td>';
	$salida.= '<th class = "text-center"  width = "300px">Descipci&oacute;n</td>';
	$salida.= '<th class = "text-center"  width = "75px">Prec. Unitario</td>';
	$salida.= '<th class = "text-center"  width = "75px">Descuento</td>';
	$salida.= '<th class = "text-center"  width = "75px">Monto</td>';
	$salida.= '<th class = "text-center"  width = "30px"></td>';
	$salida.= '</tr>';
	$STotal = 0;
	$DescU = 0;
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Cantidad
			$cant = $row["dventemp_cantidad"];
			$tipo = $row["dventemp_tipo"];
			$salida.= '<td class = "text-center" ><span id = "spancant'.$i.'">'.$cant.'</span></td>';
			//Descripcion o Articulo
			$art = trim($row["dventemp_articulo"]);
			$grupo = trim($row["dventemp_grupo"]);
			$descripcion = utf8_decode($row["dventemp_detalle"]);
			$salida.= '<td class = "text-left">'.$descripcion.'</td>';
			//Precio U.
			$mons = trim($row["mon_simbolo"]);
			$precio = trim($row["dventemp_precio"]);
			$precio = number_format($precio, 2, '.', '');
			$salida.= '<td class = "text-center" >'.$mons.' '.$precio.'</td>';
			//Descuento
			$desc = trim($row["dventemp_descuento"]);
			$DescU+= $desc;
			$desc = number_format($desc, 2, '.', '');
			$salida.= '<td class = "text-center" >'.$mons.' '.$desc.'</td>';
			//sub Total
			$total = trim($row["dventemp_total"]);
			$tcambio = trim($row["dventemp_tcambio"]);
			$Rcambiar = Cambio_Moneda($tcambio,$ventMonCambio,$total);
			$STotal+= $Rcambiar;
			$total = number_format($total, 2, '.', '');
			$salida.= '<td class = "text-center" ><span id = "spanstot'.$i.'">'.trim($mons).' '.$total.'</span></td>';
			//---
			$cod = $row["dventemp_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick = "xajax_Quita_Fila_Venta('.$cod.','.$pv.','.$suc.');" title = "Quitar Fila" ><i class="fa fa-trash"></i></button>';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
		$i--;
	}		
			//----
			if($tfdsc == "P"){
				$descuento = ($STotal *($fdsc)/100);
			}else if($tfdsc == "M"){
			        $descuento = $fdsc;
			}
			
			$Total = $STotal - $descuento;
			$descuento = number_format($descuento, 2, '.', '');// descuento General
			$STotal = number_format($STotal, 2, '.', ''); //total sin iva
			$Total = number_format($Total, 2, '.', ''); //total sin iva
			$DescU = number_format($DescU, 2, '.', ''); //promedio de descuento
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "3" rowspan = "4">';
			$salida.= '<span id = "spannota">';
			$salida.= '<b>NOTA:</b> MONEDA PARA FACTURACI&Oacute;N: <b>'.$ventMonDesc.'</b>. TIPO DE CAMBIO '.$ventMonCambio.' x 1';
			$salida.= '</span></td>';
			$salida.= '<td class = "text-center">Desc/Unitarios</td>';
			$salida.= '<td class = "text-center" ><b><span id = "spanpromdesc">'.$ventMonSimb.' '.$DescU.'</span></b></td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" >';
			$salida.= '<input type = "hidden" name = "promdesc" id = "promdesc" value = "'.$DescU.'" /></td>';
			$salida.= '</td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">Subtotal</td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" ><b><span id = "spanstotal">'.$ventMonSimb.' '.$STotal.'</span></b>';
			$salida.= '<input type = "hidden" name = "stotal" id = "stotal" value = "'.$STotal.'" />';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">Desc/General</td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" ><b><span id = "spandscgeneral">'.$ventMonSimb.' '.$descuento.'</span></b>';
			$salida.= '<input type = "hidden" name = "tdescuento" id = "tdescuento" value = "'.$descuento.'" />';
			$salida.= '<input type = "hidden" name = "ttdescuento" id = "ttdescuento" value = "'.$tfdsc.'" />';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">TOTAL</td>';
			$salida.= '<td class = "text-center" >-</td>';
			$salida.= '<td class = "text-center" ></b><span id = "spanttotal">'.$ventMonSimb.' '.$Total.'</span></b>';
			$salida.= '<input type = "hidden" name = "ttotal" id = "ttotal" value = "'.$Total.'" />';
			$salida.= '<input type = "hidden" name = "Rtotal" id = "Rtotal" value = "'.$Rtotal.'" />';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'"/>';
			$salida.= '</td>';
			$salida.= '<td class = "text-center" colspan = "2"></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
	
	return $salida;
}



function tabla_lista_boletas_ventas($codigo,$cue,$ban,$alumno,$referencia,$periodo){
	$ClsPer = new ClsPeriodoFiscal();
	$ClsBol = new ClsBoletaCobro();
	$periodo = ($periodo == "")?$ClsPer->periodo:$periodo; //valida si el periodo fue selecciononado o si trae el activo por default
	$result = $ClsBol->get_boleta_cobro_independiente($codigo,$cue,$ban,$alumno,$referencia,$periodo,$usuario,$fini,$ffin,1,'','V');
	
	if(is_array($result)){
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "100px"><i class="fa fa-cogs"></i></th>';
		$salida.= '<th class = "text-center" width = "80px"># CUENTA</th>';
		$salida.= '<th class = "text-center" width = "60px">BANCO</th>';
		$salida.= '<th class = "text-center" width = "50px"># BOLETA</th>';
		$salida.= '<th class = "text-center" width = "50px"># REFERENCIA</th>';
		$salida.= '<th class = "text-center" width = "150px">ALUMNO</th>';
		$salida.= '<th class = "text-center" width = "70px">FECHA/PAGO</th>';
		$salida.= '<th class = "text-center" width = "50px">MONTO</th>';
		$salida.= '<th class = "text-center" width = "200px">MOTIVO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$ban = $row["ban_codigo"];
			$cue = $row["cueb_codigo"];
			$cod = $row["bol_codigo"];
			//--
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($cod, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="btn btn-default btn-xs" title="Editar detalle de la boleta" href = "REPboleta.php?hashkey='.$hashkey.'" target = "_blank" ><i class="fa fa-edit"></i></a> ';
			$salida.= '</td>';
			//numero de cuenta
			$num = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center">'.$num.'</td>';
			//banco
			$bann = $row["ban_desc_ct"];
			$salida.= '<td class = "text-center">'.$bann.'</td>';
			//Boleta
			$boleta = Agrega_Ceros($row["bol_codigo"]);
			$salida.= '<td class = "text-center">'.$boleta.'</td>';
			//Referencia
			$doc = $row["bol_referencia"];
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			//Alumno
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			$salida.= '<td class = "text-left">'.$alumno.'</td>';
			//fecha de pago
			$fecha = $row["bol_fecha_pago"];
			$fecha = cambia_fecha($fecha);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//Monto
			$mons = $row["mon_simbolo"];
			$monto = $row["bol_monto"];
			$monto = number_format($monto, 2);
			$salida.= '<td class = "text-center">'.$mons.'. '.$monto.'</td>';
			//Motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			$salida.= '<td class = "text-justify">'.$motivo.'</td>';
			$salida.= '</tr>';
			//--
			$i++;
		}
		$salida.= '</table>';
		$salida.= '</div>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-exclamation-circle"></i> No hay boletas registradas con estos filtros de busqueda...';
		$salida.= '</h5>';
	}
	
	return $salida;
}



function meses_letras_a_meses_numeros($mes){
	$mes = strtolower($mes);
	switch($mes){
		case "enero": $mes = 1; break;
		case "febrero": $mes = 2; break;
		case "marzo": $mes = 3; break;
		case "abril": $mes = 4; break;
		case "mayo": $mes = 5; break;
		case "junio": $mes = 6; break;
		case "julio": $mes = 7; break;
		case "agosto": $mes = 8; break;
		case "septiembre": $mes = 9; break;
		case "octubre": $mes = 10; break;
		case "noviembre": $mes = 11; break;
		case "diciembre": $mes = 12; break;
		default: $mes = $mes;
	}
	
	return $mes;
}


?>
