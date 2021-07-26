<?php
	include_once('html_fns_push.php');
	$user_id = $_REQUEST['user_id'];
	$device_id = $_REQUEST['device_id'];
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ASMS</title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    
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
	
	<!-- Sweet Alert -->
	<script src="../assets.3.6.2/js/plugins/sweetalert/sweetalertnew.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets.3.6.2/css/plugins/sweetalert/sweetalert.css">

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
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header"> 
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- /.navbar-header -->   
        </nav>
        <div id="page-wrapper" style="margin: 0px;">
            <br>
            <div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
					<form name = "f1" name = "f1" action = "EXEpush.php" method="get" enctype="multipart/form-data">
						<div class="panel-heading"> 
							<span class="fa fa-comments" aria-hidden="true"></span>
							Formulario Gr&aacute;fico de Notificaci&oacute;n
						</div>
						<br>
						<div class="row">
							<div class="col-lg-5 col-xs-12 col-lg-offset-1">
								<label>user_id:</label>
								<input type = "text" class = "form-control" name = "user_id" id = "user_id" value = "<?php echo $user_id; ?>" readonly />
							</div>
							<div class="col-lg-5 col-xs-12">
								<label>device_id:</label>
								<input type = "text" class = "form-control" name = "device_id" id = "device_id" value = "<?php echo $device_id; ?>" readonly />
							</div>
						</div>
						<div class="row">
							<div class="col-lg-10 col-xs-12 col-lg-offset-1">
								<label>Mensaje:</label>
								<textarea class = "form-control text-libre" name = "mensaje" id = "mensaje" onkeyup="texto(this)" rows="4" ></textarea>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-12 text-center">
								<button type="button"  class="btn btn-default" onclick = "window.close();" ><span class="fa fa-times"></span> Cerrar</button> 
								<button type="button" class="btn btn-success" onclick = "Submit();"><span class="fa fa-send"></span> Enviar</button>
							</div>
						</div>
						<br>
					</form>
					</div>
					<!-- /.panel-default -->
				</div>
			</div>
		</div>
        <!-- /#page-wrapper -->
        <!-- //////////////////////////////// -->
        <!-- .footer -->

    </div>
    <!-- /#wrapper -->
    
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
			<h4 class="modal-title text-left" id="myModalLabel"><img src = "../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src = "../../CONFIG/images/img-loader.gif" width="100px" /><br>
		<label align ="center">Transaccion en Proceso...</label>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
		</div>
	      </div>
	      <div class="modal-body" id= "Pcontainer">
		
	      </div>
	    </div>
	  </div>
	</div>
    <!-- Modal -->
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    
    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/push.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 100,
				responsive: true
			});
		});
    </script>	
    
</body>

</html>
