<?php 
include_once('../../html_fns.php');

function tabla_cheques($cue,$ban,$fini,$ffin,$sit){
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_cheque('',$cue,$ban,'','',$fini,$ffin,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px"><span class="glyphicon glyphicon-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "30px">SITUACI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "70px"># CHEQUE</th>';
			$salida.= '<th class = "text-center" width = "90px"># CUENTA</th>';
			$salida.= '<th class = "text-center" width = "130px">BANCO</th>';
			$salida.= '<th class = "text-center" width = "80px">MONTO</th>';
			$salida.= '<th class = "text-center" width = "90px">FECHA</th>';
			$salida.= '<th class = "text-center" width = "90px">QUIEN</th>';
			$salida.= '<th class = "text-center" width = "200px">CONCEPTO</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$cod = $row["che_codigo"];
			$cue = $row["cueb_codigo"];
			$ban = $row["ban_codigo"];
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBan->encrypt($cod, $usu);
			$hashkey2 = $ClsBan->encrypt($cue, $usu);
			$hashkey3 = $ClsBan->encrypt($ban, $usu);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-default btn-xs" href = "REPcheque.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'" target = "_blank" title = "Imprimir Cheque" ><span class="fa fa-print"></span></a> ';
			$salida.= '</td>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//Situacion
			$sit = $row["che_situacion"];
			switch($sit){
				case 1: $color = "info"; $title = "En Circulaci&oacute;n"; $icon = "fa-circle-o"; break;
				case 2: $color = "success"; $title = "Cheque Pagado"; $icon = "fa-check"; break;
				case 0: $color = "danger"; $title = "Anulado"; $icon = "fa-minus"; break;
			}
			$salida.= '<td class = "text-center '.$color.'"><span class="fa '.$icon.'" title = "'.$title.'"></span></td>';
			//numero de cheque
			$numche = $row["che_ncheque"];
			$salida.= '<td class = "text-center">'.$numche.'</td>';
			//numero de cuenta
			$numcue = $row["cueb_ncuenta"];
			$salida.= '<td class = "text-center">'.$numcue.'</td>';
			//banco
			$bann = utf8_decode($row["ban_desc_ct"]);
			$salida.= '<td class = "text-center">'.$bann.'</td>';
			//monto
			$mons = $row["mon_simbolo"];
			$monto = number_format($row["che_monto"],2, '.', '');
			$salida.= '<td class = "text-center">'.$mons.'. '.$monto;
			$salida.= '</td>';
			//fecha
			$fec = $row["che_fechor"];
			$fec = $ClsBan->cambia_fechaHora($fec);
			$salida.= '<td class = "text-center">'.$fec.'</td>';
			//quien
			$quien = utf8_decode($row["che_quien"]);
			$salida.= '<td class = "text-center">'.$quien.'</td>';
			//concepto
			$concepto = utf8_decode($row["che_concepto"]);
			$salida.= '<td class = "text-center">'.$concepto;
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-info-circle"></i> No se reportan cheques con estos paramentros de busqueda...';
		$salida.= '</h5>';
	}
	
	return $salida;
}


//echo tabla_articulos($cod,$banp,$nom,$desc,$marca,$sit);

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Tablas de Reportes ///////////////////////////////////////////////


//echo tabla_movimientos(1,1,"30/05/2013","30/07/2013");

?>
