<?php 
include_once('../html_fns.php');

function tabla_caja($cod,$suc,$mon,$sit,$acc){
	$ClsCaj = new ClsCaja();
	$result = $ClsCaj->get_caja($cod,$suc,$mon,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "80px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "130px">EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "220px">DESCRIPCIÓN</th>';
			$salida.= '<th class = "text-center" width = "70px">SALDO</th>';
			$salida.= '<th class = "text-center" width = "90px">MONEDA</th>';
			$salida.= '<th class = "text-center" width = "90px">SITUACIÓN</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$caja = $row["caja_codigo"];
			$suc = $row["caja_sucursal"];
			$sit = $row["caja_situacion"];
			$sucn = utf8_decode($row["suc_nombre"]);
			$desc = utf8_decode($row["caja_descripcion"]);
			if($acc == "MOD"){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-default btn-xs" onclick="abrir();xajax_Buscar_Caja('.$caja.','.$suc.');" title = "Editar Caja" ><span class="glyphicon glyphicon-pencil"></span></button> ';
				$salida.= '<button type="button" class="btn btn-danger btn-xs" onclick="Deshabilita_Caja('.$caja.','.$suc.');" title = "Deshabilitar Caja" ><span class="glyphicon glyphicon-trash"></span></button> ';
				$salida.= '</td>';
			}else if($acc == "SALDO"){
				$salida.= '<td class = "text-center">'.$i.'. </td>';
			}else if($acc == "ACD"){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Seleccionar_Caja('.$caja.','.$suc.',\''.$sucn.'\',\'I\')" title = "Seleccionar Caja" ><span class="fa fa-check"></span></button>';
				$salida.= '</td>';
			}else if($acc == "ACR"){
				$salida.= '<td class = "text-center" >';
				$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Seleccionar_Caja('.$caja.','.$suc.',\''.$sucn.'\',\'E\')" title = "Seleccionar Caja" ><span class="fa fa-check"></span></button>';
				$salida.= '</td>';
			}else{
				$salida.= '<td class = "text-center">'.$i.'. </td>';
			}
			//empresa
			$salida.= '<td class = "text-center">'.$sucn.'</td>';
			//DESCRIPCION
			$salida.= '<td class = "text-center">'.$desc.'</td>';
			//saldo
			$mons = $row["mon_simbolo"];
			$saldo = number_format($row["caja_saldo"], 2, '.', '');
			$salida.= '<td class = "text-center">'.$mons.'. '.$saldo.'</td>';
			//moneda
			$mon = utf8_decode($row["mon_desc"]);
			$salida.= '<td class = "text-center">'.$mon.'</td>';
			//situacion
			$sit = ($sit == 1)?"<strong class='text-success'>ACTIVA</strong>":"<strong class='text-danger'>INACTIVA</strong>";
			$salida.= '<td class = "text-center" >'.$sit.'</td>';
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


function tabla_caja_movimiento($cod,$suc,$mon){
	$ClsCaj = new ClsCaja();
	$result = $ClsCaj->get_caja($cod,$suc,$mon,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "40px" height = "30px" ><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "90px"># CAJA</th>';
			$salida.= '<th class = "text-center" width = "220px">DESCRIPCIÓN</th>';
			$salida.= '<th class = "text-center" width = "130px">EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "70px">SALDO</th>';
			$salida.= '<th class = "text-center" width = "90px">MONEDA</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$suc = $row["caja_sucursal"];
			$caja = $row["caja_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick="Seleccionar_Caja_Movimientos('.$caja.')" title = "Seleccionar Caja (Ver Movimientos)" ><span class="glyphicon glyphicon-check"></span></button> ';
			$salida.= '</td>';
			//numero de cuenta
			$num = Agrega_Ceros($caja)."-".Agrega_Ceros($suc);
			$salida.= '<td class = "text-center">'.$num.'</td>';
			//descripcion
			$desc = utf8_decode($row["caja_descripcion"]);
			$salida.= '<td class = "text-center"  class = "text-justify" >'.$desc.'</td>';
			//empresa
			$sucn = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center">'.$sucn.'</td>';
			//saldo
			$mons = $row["mon_simbolo"];
			$saldo = number_format($row["caja_saldo"],2,'.','');
			$salida.= '<td class = "text-center">'.$mons.'. '.$saldo.'</td>';
			//moneda
			$mon = utf8_decode($row["mon_desc"]);
			$salida.= '<td class = "text-center">'.$mon.'</td>';
			$salida.= '</tr>';
			//--
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}



function tabla_movimientos($caja,$suc,$fini,$ffin){
	$ClsCaj = new ClsCaja();
	$result = $ClsCaj->get_mov_caja("",$caja,$suc,'','','','',$fini,$ffin,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px" >No.</th>';
			$salida.= '<th class = "text-center" width = "80px" ># TRANS.</th>';
			$salida.= '<th class = "text-center" width = "70px" >FECHA/HORA</th>';
			$salida.= '<th class = "text-center" width = "60px" >MOV.</th>';
			$salida.= '<th class = "text-center" width = "120px" >MOTIVO</th>';
			$salida.= '<th class = "text-center" width = "200px" >JUSTIFICACIÓN</th>';
			$salida.= '<th class = "text-center" width = "100px" >DOCUMENTO</th>';
			$salida.= '<th class = "text-center" width = "50px" ><b>ENTRÓ</b></th>';
			$salida.= '<th class = "text-center" width = "50px" ><b>SALIÓ</b></th>';
			$salida.= '<th class = "text-center" width = "50px" ><b>SALDO</b></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		$saldo = $ClsCaj->get_saldo_anterior($caja,$suc,$fini);	
		$Tentra = 0;
		$Tsale = 0;
		foreach($result as $row){
			if ($i == 1){ //--
			$mons = trim($row["mon_simbolo"]);	
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "7"> <b>SALDO DE OPERACIONES ANTERIORES</b></td>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.$saldo.'</b>';
			$salida.= '</tr>';
			} //--
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$cod = Agrega_Ceros($row["mcj_codigo"]);
			$caj = Agrega_Ceros($row["mcj_caja"]);
			$suc = Agrega_Ceros($row["mcj_sucursal"]);
			$codigo = $cod."-".$caj."-".$suc;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//fecha hora
			$fec = $row["mcj_fecha"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center">'.$fec.'</td>';
			//Movimiento
			$mov = $row["mcj_movimiento"];
			$mov = ($mov == "I")?"CREDITO":"DEBITO";
			$salida.= '<td class = "text-center">'.$mov.'</td>';
			//Motivo
			$mot = $row["mcj_tipo"];
			switch($mot){
				case "C": $mot = "COMPRA"; break;
				case "RT": $mot = "RETIRO"; break;
				case "TR": $mot = "TRASLADO A CUENTA"; break;
				case "RB": $mot = "REMBOLSO DE FONDOS"; break;
				case "DP": $mot = "DEPOSITO"; break;
			}
			$salida.= '<td class = "text-center">'.$mot.'</td>';
			//justificacion
			$just = utf8_decode($row["mcj_motivo"]);
			$salida.= '<td class = "text-justify">'.$just.'</td>';
			//Documento o Boucher
			$doc = utf8_decode($row["mcj_doc"]);
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			///monto
			$mons = trim($row["mon_simbolo"]);
			$mov = trim($row["mcj_movimiento"]);
			$cant = number_format($row["mcj_monto"],2,'.','');
			if($mov == "I"){
				$entra = $cant;
				$sale = "";
				$saldo += $entra;
			}else if($mov == "E"){
				$entra = "";
				$sale = $cant;
				$saldo -=  $sale;
			}
			$Tentra+= $entra;
			$Tsale += $sale;
			$salida.= '<td class = "text-center">'.$entra.'</td>';
			$salida.= '<td class = "text-center">'.$sale.'</td>';
			$salida.= '<td class = "text-center">'.$saldo.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-center" colspan = "10"><br></td>';
			$salida.= '</tr>';
			$salida.= '<tr class = "info">';
			$salida.= '<td class = "text-center" colspan = "7" align = "right"> <b>TOTAL INGRESOS</b></td>';
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.number_format($Tentra,2,'.','').'</b>';
			$salida.= '<td class = "text-center" colspan = "2" ></td>';
			$salida.= '</tr>';
			$salida.= '<tr class = "warning">';
			$salida.= '<td class = "text-center" colspan = "7" align = "right"> <b>TOTAL EGRESOS</b></td>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '<td class = "text-center"><b>'.$mons.'. '.number_format($Tsale,2,'.','').'</b>';
			$salida.= '<td class = "text-center" ></td>';
			$salida.= '</tr>';
			$salida.= '<tr class = "success">';
			$salida.= '<td class = "text-center" colspan = "7" align = "right"> <b>SALDO</b></td>';
			$salida.= '<td class = "text-center" colspan = "2" ></td>';
			$salida.= '<td class = "text-center"><b style = "color:green">'.$mons.'. '.number_format($saldo,2,'.','').'</b>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
	}else{
		$salida.= '<div class = "row">';
		$salida.= '<div class="col-xs-10 col-xs-offset-1 text-center">';
		$salida.= '<h5 class = "alert alert-info text center"><i class = "fa fa-info-circle"></i> No hay movimientos registradas con estos criterios de busqueda, revise la fecha u otro criterio para concretar....</h5>';
		$salida.= '</div>';
		$salida.= '</div>';
	}
	
	return $salida;
}


//echo tabla_articulos($cod,$banp,$nom,$desc,$marca,$sit);

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////


//echo tabla_movimientos("",1,"30/05/2013","16/09/2013");

?>
