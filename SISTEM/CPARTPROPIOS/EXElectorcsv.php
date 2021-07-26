<?php
	include_once('xajax_funct_articulos.php');
	$usuario = $_SESSION['codigo'];
	$nombre = $_SESSION["nombre"];
	//_SISTEMA
	$ClsProv = new ClsProveedor();
	$ClsMon = new ClsMoneda();
	$margen = $_SESSION["margenutil"];
	$moneda = $_SESSION["moneda"];
	//_$POST
	$grupo = $_REQUEST["gru1"];
	$empresa = $_REQUEST["suc1"];
	$ClsEmp = new ClsEmpresa();
	$result = $ClsEmp->get_sucursal($empresa,'','','','','1');
	if(is_array($result)){
		foreach($result as $row){
			$suc_desc = $row["suc_nombre"];
		}
	}
	$ClsArt = new ClsArticuloPropio();
	$result = $ClsArt->get_grupo($grupo,"",1);
	if(is_array($result)){
		foreach($result as $row){
			$gru_desc = $row["gru_nombre"];
		}
	}
	$titulo = "LISTADO DE MOBILIARIO, MAQUINARIA, EQUIPO O VEHICULOS A CARGAR EN BLOQUE DEL GRUPO $gru_desc EN LA EMPRESA $suc_desc";
?>
<!DOCTYPE html>
<html lang="es">
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
    
    <!-- CSS Propio -->
    <link rel="stylesheet" href="../assets.3.6.2/css/hojaElectronica.css" type="text/css" media="screen"/>

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
	
<div align = "left">
	<hr>
	<div class="row">
        <div class="col-xs-8 col-xs-offset-2 text-center">
			<h5 class="alert alert-info text-center"><?php echo $titulo; ?></h5>
		</div>
	</div>
	<div class="row">
        <div class="col-xs-3 col-xs-offset-3 text-center">
			<button type="button" class="btn btn-primary" id = "grabar" onclick = "ConfirmGrabarList();"><span class="fa fa-save"></span> Guardar</button>
		</div>
		 <div class="col-xs-3 text-center">
			<a type="button" class="btn btn-default" href = "FRMcarga.php"><span class="fa fa-arrow-left"></span> Regresar</a>
		</div>
    </div>
	<div class="row">
        <div class="col-xs-12 text-center">
			<input type = "hidden" name = "gru" id = "gru" value = "<?php echo $grupo; ?>"  />
			<input type = "hidden" name = "suc" id = "suc" value = "<?php echo $empresa; ?>"  />
		</div>
    </div>
	<hr>
	<div class="row hidden" id = "diverrores">
        <div class="col-xs-8 col-xs-offset-2 text-center">
			<h5 class="alert alert-danger text-center"><i class = "fa fa-exclamation-circle text-danger"></i> Hay errores detectados en la informaci&oacute;n del archivo .csv cargado, porfavor revisesa para habilitar el boton de carga. </h5>
		</div>
	</div>
<?php
// Fecha del Sistema
	$fecha = date("d/m/Y");
// obtenemos los datos del archivo
    $tamano = $_FILES["doc"]['size'];
    $tipo = $_FILES["doc"]['type'];
    $archivo = $_FILES["doc"]['name'];
	$nombre = "masa.csv";
   
    if ($archivo != "") {
		if (strpos($archivo, ".csv")) { 
			if ($tamano < 1000000) {
				// guardamos el archivo a la carpeta files
				$destino =  "Temp/".$nombre;
				if (move_uploaded_file($_FILES['doc']['tmp_name'],$destino)) {
					$msj = "Archivo subido: <b>".$archivo."</b>"; $status = 1;
				} else {
					$msj = "Error al subir el archivo"; $status = 0;
				}
			}else {
				$msj = "Se permiten archivos de 1 Mb m�ximo. $tamano"; $status = 0;
			}
		}else {
			$msj = "El Tipo de Archivo es incorrecto, solo se aceptan Documentos .CSV provenientes de hojas de Excel.";  $status = 0;
		}
    } else {
        $msj = "Archivo vacio.";  $status = 0;
    }
	
if ($status != 1) {	
	//echo $msj;
	//ejecuta Gift cargando
	echo "<script type='text/javascript' >AlertasJs('$msj','window.location=\'FRMcarga.php\'');</script>";
	echo "<script type='text/javascript' >window.setTimeout('abrir();',1000);</script>";
} else {
    //Instancio la clase DOM que nos permitira operar con el XML
	
	//inicia el dibujo de la tabla
	$salida.= '<form name = "f1" id = "f1">';
	$salida.= '<div class="panel-body">';
	$salida.= '<table class="table table-striped table-bordered table-hover">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "100px">NOMBRE DEL PRODUCTO</th>';
		$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</th>';
		$salida.= '<th class = "text-center" width = "100px">MARCA</th>';
		$salida.= '<th class = "text-center" width = "60px">No. DE PARTE O SERIE</th>';
		$salida.= '<th class = "text-center" width = "60px">PRECIO INICIAL</th>';
		$salida.= '<th class = "text-center" width = "60px">PRECIO ACTUAL</th>';
		$salida.= '<th class = "text-center" width = "30px">MONEDA</th>';
		$salida.= '<th class = "text-center" width = "30px">T/CAMBIO</th>';
		$salida.= '</tr>';
		$salida.= '</thead>';
	
	//inicia el ciclo para filas
	$fila = 0;
	if(($gestor = fopen("Temp/masa.csv", "r")) !== FALSE) {
		$errores = 0;
		while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
			if($fila != 0){
				$numero = count($datos);
				if($numero > 0){
					$salida.= '<tr>';
					//--
					$salida.= '<td class = "text-center" >'.$fila.'. </td>';
					//Nombre
					$nombre = trim(utf8_decode($datos[1]));
					$salida.= '<td class = "text-center" >'.$nombre;
					$salida.= '<input type = "hidden" id = "nombre'.$fila.'" name = "nombre'.$fila.'" value = "'.$nombre.'" />';
					$salida.='</td>';
					//descripcion
					$desc = trim(utf8_decode($datos[2]));
					$salida.= '<td class = "text-center" >'.$desc;
					$salida.= '<input type = "hidden" id = "desc'.$fila.'" name = "desc'.$fila.'" value = "'.$desc.'" />';
					$salida.='</td>';
					//marca
					$marca = trim(utf8_decode($datos[3]));
					$salida.= '<td class = "text-center" >'.$marca;
					$salida.= '<input type = "hidden" id = "marca'.$fila.'" name = "marca'.$fila.'" value = "'.$marca.'" />';
					$salida.='</td>';
					//serie
					$serie = trim(utf8_decode($datos[4]));
					$salida.= '<td class = "text-center" >'.$marca;
					$salida.= '<input type = "hidden" id = "serie'.$fila.'" name = "serie'.$fila.'" value = "'.$serie.'" />';
					$salida.='</td>';
					//precio de Inicial
					$precio = $datos[5];
					$prec = $datos[5];
					if(!is_numeric($precio)){
						$precio = '<span class = "text-danger"><i class = "fa fa-exclamation-circle text-danger"></i> ('.$precio.') CONTIENE CARACTERES NO NUMERICOS!</span>';
						$errores++;
					}
					$salida.= '<td class = "text-center" >'.$precio;
					$salida.= '<input type = "hidden" id = "preini'.$fila.'" name = "preini'.$fila.'" value = "'.$prec.'" />';
					$salida.='</td>';
					//precio de Actual
					$precio = $datos[6];
					$prec = $datos[6];
					if(!is_numeric($precio)){
						$precio = '<span class = "text-danger"><i class = "fa fa-exclamation-circle text-danger"></i> ('.$precio.') CONTIENE CARACTERES NO NUMERICOS!</span>';
						$errores++;
					}
					$salida.= '<td class = "text-center" >'.$precio;
					$salida.= '<input type = "hidden" id = "preact'.$fila.'" name = "preact'.$fila.'" value = "'.$prec.'" />';
					$salida.='</td>';
					//moneda
					$mon = utf8_decode($datos[7]);
					if($mon != ""){
						$result = $ClsMon->get_moneda($mon);
						if(is_array($result)){
							foreach($result as $row){
								$mon = trim($row["mon_id"]);
								$moneda = utf8_decode($row["mon_desc"]);
							}
						}else{
							$mon = 1;
							$moneda = '<span class = "text-danger"><i class = "fa fa-exclamation-circle text-danger"></i> MONEDA DESCONOCIDA</span>';
							$errores++;
						}
					}else{
						$mon = 1;
						$moneda = '<span class = "text-danger"><i class = "fa fa-exclamation-circle text-danger"></i> CASILLA VACIA</span>';
						$errores++;
					}
					$salida.= '<td class = "text-center" >'.$moneda;
					$salida.= '<input type = "hidden" id = "mon'.$fila.'" name = "mon'.$fila.'" value = "'.$mon.'" />';
					$salida.='</td>';
					//tipo de Cambio
					$tcambio = $datos[8];
					$tcam = $datos[8];
					if(!is_numeric($tcambio)){
						$tcambio = '<span class = "text-danger"><i class = "fa fa-exclamation-circle text-danger"></i> ('.$tcambio.') CONTIENE CARACTERES NO NUMERICOS!</span>';
						$errores++;
					}
					$salida.= '<td class = "text-center" >'.$tcambio;
					$salida.= '<input type = "hidden" id = "tcambio'.$fila.'" name = "tcambio'.$fila.'" value = "'.$tcam.'" />';
					$salida.='</td>';
					//--
					$salida.= '</tr>';
					$fila++;
				}
			}else{
				$fila++; // elimina el encabezado del archivo
			}
		}
		$fila--;
	}else{
		$salida.= '<tr>';
		$salida.= '<td colspan = "10"><h5 class="alert alert-danger > <span class = "fa fa-exclamation-circle"></span> Error de Lectura...</h5></td>';
		$salida.= '</tr>';
		$errores++;
	}
	fclose($gestor);
	$salida.= '</table>';
	$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$fila.'" >';
	$salida.= '</div>';
	$salida.= '</form>';
	echo $salida;
	//elimina la hija que se subio al servidor
	//unlink($destino);
} 

?>
<!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?> ASMS</h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<br>
		<label align ="center"><?php echo $msj; ?></label>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" onclick = "window.location='FRMcarga.php';" data-dismiss="modal"><span class="fa fa-check"></span> Aceptar</button>
		</div>
	      </div>
	      <div class="modal-body" id= "Pcontainer">
		
	      </div>
	    </div>
	  </div>
	</div>
    <!-- Modal -->
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/inventario/articulopropio.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
	<script>
		var errores = parseInt(<?php echo $errores; ?>);
		if(errores > 0){
			document.getElementById("grabar").setAttribute("disabled","disabled");
			document.getElementById("diverrores").className = "row";
		}else{
			document.getElementById("grabar").disabled = false;
			document.getElementById("diverrores").className = "row hidden";
		}
    </script>
    
</body>

</html>
