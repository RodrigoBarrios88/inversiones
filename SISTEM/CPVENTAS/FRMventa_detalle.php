<?php
include_once('xajax_funct_ventas.php');
//$POST
$suc = $_REQUEST["suc"];
$suc = ($suc == "")?$_SESSION['empCodigo']:$suc;
$pv = $_REQUEST["pv"];
$pv = ($pv == "")?1:$pv;
$Tmon = $_REQUEST["Tmon"];
$Tmon = ($Tmon == "")?$_SESSION['moneda']:$Tmon;
$tfdsc = $_REQUEST["tfdsc"];
$fdsc = $_REQUEST["fdsc"];


///////////// MONEDA GLOBAL //////////////
$ClsMon = new ClsMoneda();
$result = $ClsMon->get_moneda($Tmon);
if(is_array($result)){
	foreach($result as $row){
		$ventMonCambio = $row["mon_cambio"];
		$ventMonSimb = $row["mon_simbolo"];
		$ventMonDesc = $row["mon_desc"];
	}
}

//$ClsVent = new ClsVenta();
//$codigo = $ClsVent->max_detalle_temporal(1,1);
//$sql = $ClsVent->insert_detalle_temporal($codigo,$pv,$suc,$tipo,$detalle,$art,$grupo,$cant,$precio,$moneda,$tcamb,$subtotal,$monto_descuento,$total);
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
   <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Libreria de Calendarios -->
	<link type="text/css" rel="stylesheet" href ="../ $('.dataTables-example').DataTable({dhtmlgoodies_calendar.css">
	<script type="text/javascript" src="../assets.3.6.2/js/dhtmlgoodies_calendar.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
		body{
			background: #fff;
		}
	</style>
</head>
<body>
	<div class="panel-body">
		<form id='detalle' name='detalle' method='get'>
		<?php
			echo tabla_filas_venta($pv,$suc,$ventMonDesc,$ventMonSimb,$ventMonCambio,$tfdsc,$fdsc);
		?>
		</form>
	</div>
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/modules/ventas/venta.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
</body>
</html>
