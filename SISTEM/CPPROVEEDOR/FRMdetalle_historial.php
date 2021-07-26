<?php
	include_once('xajax_funct_proveedores.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	
	//_$POST
	$ClsComp = new ClsCompra();
	
	$hashkey = $_REQUEST["hashkey"];
	$cod = $ClsComp->decrypt($hashkey, $id);
	
	$result = $ClsComp->get_compra($cod);
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["com_codigo"];
			$codigo = Agrega_Ceros($codigo);
			//situacion
			$sit = $row["com_situacion"];
			if($sit == 1 || $sit == 2){
				$situacion = '<i class = "fa fa-check fa-2x text-success" title = "Realizada"></i>';
			}else if($sit == 0){
				$situacion = '<i class = "fa fa-times fa-2x text-danger" title = "Anulada"></i>';
			}
			//--
			$fecha = cambia_fecha($row["com_fecha"]);
			//tipo
			$tipo = ($row["com_tipo"] == "C")?"COMPRA":"GASTO";
			//referencia
			$doc = $row["com_doc"];
			//empresa
			$suc = utf8_decode($row["suc_nombre"]);
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
					<h5><i class="fa fa-asterisk"></i> Datos de la Compra o Gasto</h5>		
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-4 col-xs-offset-1"><h4>C&oacute;digo de Importaci&oacute; de Datos:</h4></div>
						<div class="col-xs-6"><h4 class="text-success"><i class = "fa fa-qrcode"></i> <?php echo $codigo; ?>  - <label class="text-info"><?php echo $tipo; ?></label></div></h4>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<span class ="text-muted">
							* El c&oacute;digo de importaci&oacute;n de datos, sirve para listar los articulos de una compra anterior en una compra nueva,
							utilizando esta lista como referencia base. Copie este c&oacute;digo e ingreselo en la pantalla de compras donde dice "C&oacute;digo de Importaci&oacute;n de Compras o Gastos Anteriores".
							</span>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-2 col-xs-offset-1"><label>Sucrsal:</label></div>
						<div class="col-xs-3"><label class="text-info"><?php echo $suc; ?></label></div>
						<div class="col-xs-2 col-xs-offset-1"><label>Fecha:</label> <span class="text-danger">*</span></div>
						<div class="col-xs-3"><label class="text-info"><?php echo $fecha; ?></label></div>
					</div>
					<div class="row">
						<div class="col-xs-2 col-xs-offset-1"><label>Doc. Referencia:</label></div>
						<div class="col-xs-3"><label class="text-info"><?php echo $doc; ?></label></div>
						<div class="col-xs-2 col-xs-offset-1"><label>Situaci&oacute;n:</label> <span class="text-danger">*</span></div>
						<div class="col-xs-3"><label class="text-info"><?php echo $situacion; ?></label></div>
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
					<h5><i class="fa fa-shopping-cart"></i> Detalle de Compra o Gasto</h5>		
				</div>
				<div class="panel-body">
				<?php echo tabla_detalle_compra($cod); ?>
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

function tabla_detalle_compra($comp){
	$ClsComp = new ClsCompra();
	$result = $ClsComp->get_det_compra('',$comp);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<td class = "text-center"  width = "25px"><b>No.</b></td>';
			$salida.= '<td class = "text-center"  width = "60px"><b>Cant.</b></td>';
			$salida.= '<td class = "text-center"  width = "300px"><b>Descipci&oacute;n</b></td>';
			$salida.= '<td class = "text-center"  width = "60px"><b>P. Unitario</b></td>';
			$salida.= '<td class = "text-center"  width = "60px"><b>% Desc.</b></td>';
			$salida.= '<td class = "text-center"  width = "60px"><b>C * P</b></td>';
			$salida.= '<td class = "text-center"  width = "60px"><b>T/C</b></td>';
			$salida.= '<td class = "text-center"  width = "60px"><b>P. Total</b></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$Total = 0;
		$Rtotal = 0;
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Cantidad
			$cant = $row["dcom_cantidad"];
			$salida.= '<td class = "text-center" >'.$cant.'</td>';
			//Descripcion o Articulo
			$desc = utf8_decode($row["dcom_detalle"]);
			$salida.= '<td class = "text-center" align = "left">'.$desc.'</td>';
			//Precio U.
			$pre = $row["dcom_precio"];
			$mons = $row["mon_simbolo"];
			$Vmons = $row["mon_simbolo_compra"];
			$salida.= '<td class = "text-center" >'.$mons.'. '.$pre.'</td>';
			//Descuento
			$dsc = $row["dcom_descuento"];
			$salida.= '<td class = "text-center" >'.$dsc.' %</td>';
			//sub Total
			$monc = $row["dcom_tcambio"];
			$Vmonc = $row["com_tcambio"];
			$rtot = ($pre * $cant);
			$stot = $rtot - (($rtot * $dsc)/100);
			$Dcambiar = Cambio_Moneda($monc,$Vmonc,$stot);
			$Total+= $Dcambiar;
			$Rcambiar = Cambio_Moneda($monc,$Vmonc,$rtot);
			$Rtotal+= $Rcambiar;
			$stot = number_format($stot, 2, '.', '');
			$Dcambiar = number_format($Dcambiar, 2, '.', '');
			//--
			$salida.= '<td class = "text-center" >'.$mons.' '.$stot.'</td>';
			//---
			$salida.= '<td class = "text-center" >'.$monc.' x 1</td>';
			//---
			$salida.= '<td class = "text-center" >'.$Vmons.' '.$Dcambiar.'</td>';
			//---
			$salida.= '</tr>';
			$i++;
		}
			//----
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	return $salida;
}

?>