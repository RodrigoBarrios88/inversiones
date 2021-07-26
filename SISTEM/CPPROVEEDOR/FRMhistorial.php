<?php
	include_once('xajax_funct_proveedores.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	
	//_$POST
	$ClsProv = new ClsProveedor();
	
	$hashkey = $_REQUEST["hashkey"];
	$proveedor = $ClsProv->decrypt($hashkey, $id);
	
	$result = $ClsProv->get_proveedor($proveedor);
	if(is_array($result)){
		foreach($result as $row){
			//NIT
			$nit = $row["prov_nit"];
			//nombre
			$nom = utf8_decode($row["prov_nombre"]);
			//telefono
			$tel = $row["prov_tel1"];
			//contacto
			$contacto = utf8_decode($row["prov_contacto"]);
		}	
	}	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("..");
		 ?>
    <!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
	 <!-- Estilos Utilitarios -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
    
	<!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
   <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
	<br>
	<div class="row">
		<div class="col-xs-12 text-center">
			<button type="button" class="btn btn-default" id = "print" onclick="pageprint();"><i class="fa fa-print fa-2x"></i></button>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h5><i class="fa fa-user"></i> Datos del Proveedor</h5>		
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>NIT:</label></div>
						<div class="col-xs-5"><label>Nombre:</label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $nit; ?></label></div>
						<div class="col-xs-5"><label class="text-info"><?php echo $nom; ?></label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Tel&eacute;fono:</label></div>
						<div class="col-xs-5"><label>Contacto:</label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label class="text-info"><?php echo $tel; ?></label></div>
						<div class="col-xs-5"><label class="text-info"><?php echo $contacto; ?></label></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
    <div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h5><i class="fa fa-history"></i> Historial de Compras del Proveedor</h5>		
				</div>
				<div class="panel-body">
				<?php echo tabla_historial_compra($proveedor); ?>
				</div>
			</div>
		</div>
	</div>
	<!-- /.jumbotron -->
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div id = "ModalDialog" class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
					<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?> ASMS</h4>
			  </div>
			  <div class="modal-body text-center" id= "lblparrafo">
					<img src="../../CONFIG/images/img-loader.gif"/><br>
					<label align ="center">Transaccion en Proceso...</label>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
					</div>
			  </div>
			  <div class="modal-body" id= "Pcontainer"></div>
			</div>
		</div>
	</div>
    <!-- Modal -->
    
	<div>
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/compras/proveedor.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 50,
				responsive: true
			});
	    });
    </script>	
    </div>
</body>

</html>
<?php

function tabla_historial_compra($proveedor){
	$ClsComp = new ClsCompra();
	$result = $ClsComp->get_compra('','',$proveedor,'','','','','','');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "20px">SIT.</th>';
			$salida.= '<th class = "text-center" width = "60px">FECHA</th>';
			$salida.= '<th class = "text-center" width = "120px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "70px">DOC. REF.</th>';
			$salida.= '<th class = "text-center" width = "100px">EMPRESA</th>';
			$salida.= '<th class = "text-center" width = "30px"></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$sit = $row["com_situacion"];
			$salida.= '<td class = "text-center" >';
			if($sit == 1 || $sit == 2){
				$salida.= '<i class = "fa fa-check fa-2x text-success" title = "Realizada"></i>';
			}else if($sit == 0){
				$salida.= '<i class = "fa fa-times fa-2x text-danger" title = "Anulada"></i>';
			}
			$salida.= '</td>';
			//--
			$fecha = cambia_fecha($row["com_fecha"]);
			$salida.= '<td class = "text-center">'.$fecha.'</td>';
			//tipo
			$tipo = ($row["com_tipo"] == "C")?"COMPRA":"GASTO";
			$salida.= '<td class = "text-center" >'.$tipo.'</td>';
			//referencia
			$ref = $row["com_doc"];
			$salida.= '<td class = "text-center" >'.$ref.'</td>';
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center" >'.$suc.'</td>';
			//codigo
			$cod = $row["com_codigo"];
			$usucod = $_SESSION["codigo"];
			$hashkey = $ClsComp->encrypt($cod, $usucod);
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="text-success" href = "../CPPROVEEDOR/FRMdetalle_historial.php?hashkey='.$hashkey.'" title = "Ver Historial de Compra" ><span class="fa fa-paste fa-2x"></span></a> ';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			//--
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