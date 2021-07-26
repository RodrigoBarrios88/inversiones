<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel-body">
			<div class="row">
				<?php echo tabla_lista_proveedores($nom,$contact); ?>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 text-center">
					<button type="button" class="btn btn-success" id = "limp" onclick = "cerrarModal();"><span class="fa fa-check"></span> Aceptar</button>
				</div>
			</div>
			<br>
		</div>
		<!-- Page-Level Demo Scripts - Tables - Use for reference -->
		<script>
			$(document).ready(function() {
				$('#dataTables-example2').DataTable({
					responsive: true
				});
			});
		</script>	
	</body>
</html>


<?php


function tabla_lista_proveedores($nom,$contact){
	$ClsProv = new ClsProveedor();
	$result = $ClsProv->get_proveedor('','',$nom,$contact);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example2">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "100px" height = "30px"></th>';
			$salida.= '<th class = "text-center" width = "100px">NIT</td>';
			$salida.= '<th class = "text-center" width = "200px">PROVEEDOR</td>';
			$salida.= '<th class = "text-center" width = "200px">CONTACTO</td>';
			$salida.= '<th class = "text-center" width = "30px"></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "SeleccionarProveedor('.$i.')" title = "Seleccionar Proveedor" ><span class="fa fa-check"></span></button>  &nbsp;';
			$salida.= '</td>';
			//Nit
			$cod = $row["prov_id"];
			$nit = $row["prov_nit"];
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Ppnit'.$i.'" value = "'.$nit.'" />';
			$salida.= '<input type = "hidden" id = "Ppcod'.$i.'" value = "'.$cod.'" />';
			$salida.= $nit.'</td>';
			//nombre
			$nom = utf8_decode($row["prov_nombre"]);
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Ppnom'.$i.'" value = "'.$nom.'" />';
			$salida.= $nom.'</td>';
			//contacto
			$contacto = utf8_decode($row["prov_contacto"]);
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Ppcontac'.$i.'" value = "'.$contacto.'" />';
			$salida.= $contacto.'</td>';
			//codigo
			$cod = $row["prov_id"];
			$usucod = $_SESSION["codigo"];
			$hashkey = $ClsProv->encrypt($cod, $usucod);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="text-success" target = "_blank" href = "../CPPROVEEDOR/FRMhistorial.php?hashkey='.$hashkey.'" title = "Ver Historial de Compras al Proveedor" ><span class="fa fa-history fa-2x"></span></a> ';
			$salida.= '</td>';
			//--
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



?>