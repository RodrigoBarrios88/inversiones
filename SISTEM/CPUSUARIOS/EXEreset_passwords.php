<?php
	include_once('xajax_funct_usuarios.php');
	$nombre = $_SESSION["nombre"];
	$nombre_pantalla = $_SESSION["nombre_pantalla"];
	$tipo = $_SESSION["nivel"];
	$valida = $_SESSION["GRP_GPADMIN"];
	
if($tipo != "" && $nombre != ""){	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	<!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
	<!-- jQuery --> 
    <script type="text/javascript" src=" https://code.jquery.com/jquery-1.12.3.js"></script>
    <script type="text/javascript" src=" https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src=" https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src=" https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src=" https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

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
	
<?php
// Fecha del Sistema
	$fecha = date("Y-m-d H:i:s");
	//-
	$ClsPad = new ClsPadre();
	$ClsMae = new ClsMaestro();
	$ClsOtroUsu = new ClsOtrosUsu();
	$ClsUsu = new ClsUsuario();
	// ID del Ultimo Usuario
	echo "<h3>PADRES</h3><br>";
	$result = $ClsUsu->get_usuario('','','','3','',1,'');
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			$id = trim($row["usu_id"]);
			$usu = trim($row["usu_usuario"]);
			$pass = "123456";
			if($usu != "" && $usu != "pendiente"){
				$sql.= $ClsUsu->modifica_pass($id,$usu,$pass);
				//echo $ClsUsu->modifica_pass($id,$usu,$pass);
				//echo "<br>";
			}
			$i++;
		}
		echo tabla_paswords_usuarios(3);
		echo "<br>";
		$i--;
		echo "<h5>Total de Padres: $i.</h5><br>";
	}
	
	echo "<h3>MAESTROS</h3><br>";
	$result = $ClsUsu->get_usuario('','','','2','',1,'');
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			$id = trim($row["usu_id"]);
			$usu = trim($row["usu_usuario"]);
			$pass = "123456";
			if($usu != "" && $usu != "pendiente"){
				$sql.= $ClsUsu->modifica_pass($id,$usu,$pass);
				//echo $ClsUsu->modifica_pass($id,$usu,$pass);
				//echo "<br>";
			}
			$i++;
		}
		echo tabla_paswords_usuarios(2);
		echo "<br>";
		$i--;
		echo "<h5>Total de Maestros: $i.</h5><br>";
	}
	
	echo "<h3>AUTORIDADES</h3><br>";
	$result = $ClsUsu->get_usuario('','','','1','',1,'');
	if(is_array($result)){
		$i = 1;
		foreach($result as $row){
			$id = trim($row["usu_id"]);
			$usu = trim($row["usu_usuario"]);
			$pass = "123456";
			if($usu != "" && $usu != "pendiente"){
				$sql.= $ClsUsu->modifica_pass($id,$usu,$pass);
				//echo $ClsUsu->modifica_pass($id,$usu,$pass);
				//echo "<br>";
			}
			$i++;
		}
		echo tabla_paswords_usuarios(1);
		echo "<br>";
		$i--;
		echo "<h3>Total de Usuarios Autoridades: $i.</h3><br>";
	}
	
	//echo $sql;
	$rs = $ClsUsu->exec_sql($sql);
	if ($rs == 1) {	
		$msj = "Usuarios Actualizados satisfactoriamente!!!";
	} else {
		$msj = "Error de Conexi&oacute;n...";
	}
	//echo $Ssql;
	
?>
    
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<br>
		<label align ="center"><?php echo $msj; ?></label>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" onclick = "window.location='FRMusuarios.php';" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>
		</div>
	      </div>
	      <div class="modal-body" id= "Pcontainer">
		
	      </div>
	    </div>
	  </div>
	</div>
    <!-- Modal -->
    <script type='text/javascript' >
	//window.setTimeout('abrir();',1000);
	</script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/seguridad/usuario.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-padre').DataTable({
				pageLength: 100,
				responsive: true,
				dom: '<"html5buttons"B>lTfgitp',
				buttons: [
					'copyHtml5',
					'csvHtml5',
					 {extend: 'pdf', title: 'Listado de Usuarios Padres'},
					 {extend: 'excel', title: 'Listado de Usuarios Padres'}
				]
			} );
		} );
		
		$(document).ready(function() {
			$('#dataTables-maestro').DataTable({
				pageLength: 100,
				responsive: true,
				dom: '<"html5buttons"B>lTfgitp',
				buttons: [
					'copyHtml5',
					'csvHtml5',
					 {extend: 'pdf', title: 'Listado de Usuarios Maestros'},
					 {extend: 'excel', title: 'Listado de Usuarios Maestros'}
				]
			} );
		} );
		
		$(document).ready(function() {
			$('#dataTables-autoridad').DataTable({
				pageLength: 100,
				responsive: true,
				dom: '<"html5buttons"B>lTfgitp',
				buttons: [
					'copyHtml5',
					'csvHtml5',
					 {extend: 'pdf', title: 'Listado de Usuarios Autoridades'},
					 {extend: 'excel', title: 'Listado de Usuarios Autoridades'}
				]
			} );
		} );
    </script>	
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}


function tabla_paswords_usuarios($tipo){
	$ClsUsu = new ClsUsuario();
	$result = $ClsUsu->get_usuario('','','',$tipo,'',1);
	
	switch($tipo){
		case 1: $tabla = "autoridad"; break;
		case 2: $tabla = "maestro"; break;
		case 3: $tabla = "padre"; break;
	}
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-'.$tabla.'">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "60px" class = "text-center"><span class="glyphicon glyphicon-cog"></span></td>';
			$salida.= '<th width = "200px" class = "text-center">NOMBRE DEL USUARIO</td>';
			$salida.= '<th width = "200px" class = "text-center">TIPO</td>';
			$salida.= '<th width = "100px" class = "text-center">USUARIO</td>';
			$salida.= '<th width = "100px" class = "text-center">CONTRASE&Ntilde;A</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//nombre
			$nom = utf8_decode($row["usu_nombre"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			//tipo
			$tipo = $row["usu_tipo"];
			switch($tipo){
				case 1: $tipo = "DIRECTOR O AUTORIDAD"; break;
				case 2: $tipo = "DOCENTE O MAESTRO"; break;
				case 3: $tipo = "PADRE DE FAMILIA"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//usuario
			$usu = $row["usu_usuario"];
			$salida.= '<td class = "text-center">'.$usu.'</td>';
			//pass
			$pass = $row["usu_pass"];
			if($usu != "" && $usu != "pendiente"){
				$pass = $ClsUsu->decrypt($pass,$usu);
			}else{
				$pass = "";
			}
			$salida.= '<td class = "text-center">'.$pass.'</td>';
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




?>