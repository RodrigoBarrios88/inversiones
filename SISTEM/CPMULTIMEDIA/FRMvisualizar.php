<?php

include_once('xajax_funct_multimedia.php');
$usuario = $_SESSION["codigo"];
$usunombre = $_SESSION["nombre"];
$usunivel = $_SESSION["nivel"];
$tipo_usuario = $_SESSION['tipo_usuario'];
$tipo_codigo = $_SESSION['tipo_codigo'];

//-- POST
$tipo = $_REQUEST["tipo"];
$categoria = $_REQUEST["categoria"];

$ClsMulti = new ClsMultimedia();
$result = $ClsMulti->get_multimedia('',$tipo,$categoria,1);
$palyers = array();
$i = 0;
$arr_videos = array();
if(is_array($result)){
   foreach($result as $row){
      $codigo = $row["multi_codigo"];
      $video = trim($row["multi_link"]);
      $videoID = trim($row["multi_link"]);
      $titulo = utf8_decode($row["multi_titulo"]);
      //--
      $arr_videos[$i]["id"] = "player$i";
      $arr_videos[$i]["height"] = "270";
      $arr_videos[$i]["width"] = "480";
      $arr_videos[$i]["videoId"] = $videoID;
      $palyers[$i] = '<div class="text-center"><div id="player'.$i.'"></div></div>';
      //--
      $i++;
   }
   $i--;
}
	
if($usunivel != "" && $usunombre != "" && $tipo_usuario != ""){	
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
	
	<!-- Bootstrap Core CSS -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
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
				 <?php echo $_SESSION["rotulos_colegio"]; ?>
			</div>
			<!-- /.navbar-header -->
			<ul class="nav navbar-top-links navbar-right">
				<li class="dropdown">
					  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="glyphicon glyphicon-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
					  </a>
					  <ul class="dropdown-menu dropdown-user">
							<li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Formulario de Perfil de Usuarios</a></li>
							<li class="divider"></li>
							<li><a href="../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a>
							</li>
					  </ul>
					  <!-- /.dropdown-user -->
				 </li>
				 <!-- /.dropdown -->
				 <li class="dropdown">
					  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="glyphicon glyphicon-question-sign fa-fw"></i>  <i class="fa fa-caret-down"></i>
					  </a>
					  <ul class="dropdown-menu dropdown-user">
							<li><a href="#"><i class="glyphicon glyphicon-question-sign fa-fw"></i> Ayuda</a></li>
					  </ul>
					  <!-- /.dropdown-user -->
				 </li>
				 <!-- /.dropdown -->
			</ul>
			<!-- /.navbar-top-links -->

			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<li>
							<a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
							<ul class="nav nav-second-level">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMgestor.php">
										<i class="fa fa-edit"></i> Gestor Multimedia
									</a>
								</li>
								<?php } ?>
								<li>
									<a href="FRMvisualizar.php">
									<i class="fa fa-film"></i> Visualizador
									</a>
								</li>
								<hr>
								<li>
									<a href="../CPMENU/MENUcomunicacion.php">
										<i class="fa fa-indent"></i> Men&uacute
									</a>
								</li>
								<li>
									<a href="../menu.php">
										<i class="glyphicon glyphicon-list"></i> Men&uacute; Principal
									</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
					</ul>
				</div>
				<!-- /.sidebar-collapse -->
			</div>
			<!-- /.navbar-static-side -->
      </nav>
      <div id="page-wrapper">
			<br>
			<div class="panel panel-default">
				<div class="panel-heading"> 
					<span class="fa fa-film" aria-hidden="true"></span>
					Visualizador de Contenido Multimedia
				</div>
				<div class="panel-body">
					<form name = "f1" id = "f1" method="get">
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Tipo:</label>
							<select class="form-control" id="tipo" name="tipo" onchange="Submit();">
								<option value ="">TODOS</option>
								<option value ="0">OTRO</option>
								<option value ="1">EDUCATIVO Y/O PEDAG&Oacute;GICO</option>
								<option value ="2">ENTRETENIMIENTO</option>
								<option value ="3">INTERESANTE</option>
							</select>
							<script>
								document.getElementById("tipo").value = '<?php echo $tipo; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<label>Categor&iacute;a:</label>
							<select class="form-control" id="categoria" name="categoria" onchange="Submit();">
								<option value ="">TODAS</option>
								<option value ="0">OTRO</option>
								<option value ="1">PARA PADRES</option>
								<option value ="2">PARA ALUMNOS</option>
								<option value ="3">ACTIVIDADES INTERNAS</option>
							</select>
							<script>
								document.getElementById("categoria").value = '<?php echo $categoria; ?>';
							</script>
						</div>
					</div>
					</form>
					<hr>
					<div class="row">
						<div class="col-lg-10 col-xs-offset-1">
							<?php
								if(is_array($palyers)){
									foreach($palyers as $player){
										echo $player;
									}
								}
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" onclick = "prevVideo();"><i class="fa fa-chevron-left"></i> Anterior</button>
							<button type="button" class="btn btn-default" onclick = "nextVideo();"><span class="fa fa-chevron-right "></span> Siguiente</button>
						</div>
					</div>
					<br>
				</div>
			</div>
			<!-- /.panel-default -->
			<div id="fab">
				<a class="open-fab-primary" href="FRMgestor.php" title="Agregar o Editar Contenido Multimedia">
					<i class="fa fa-pencil"></i>
				</a>
			</div>
			<br>
		</div>
      <!-- /#page-wrapper -->
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
	
	<!-- Clock picker -->
	<script src="../assets.3.6.2/js/plugins/clockpicker/clockpicker.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/multimedia.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    
	<script>
		var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      var playerInfoList = <?php echo json_encode($arr_videos); ?>;
      var Indice = 0;
      var Maximo = parseInt(<?php echo $i; ?>);
      // -------------
      var player = null;
		function onYouTubeIframeAPIReady() {
         //console.log( playerInfoList[Indice].id, playerInfoList[Indice].videoId );
         console.log( Indice );
         playerInner = new YT.Player(playerInfoList[Indice].id, {
            height: '360',
            width: '640',
            videoId: playerInfoList[Indice].videoId,
         });
         return player;
      }
      
      function nextVideo() {
         if(Indice < Maximo ){
            hiddeVideo();
            Indice++;
            player = onYouTubeIframeAPIReady();
            showVideo();
         }
      }
      
      function prevVideo() {
         if(Indice > 0 ){
            hiddeVideo();
            Indice--;
            onYouTubeIframeAPIReady();
            showVideo();
         }
      }
      
      function hiddeVideo(){
         document.getElementById("player"+Indice).style.display = "none";
      }
      
      function showVideo(){
         document.getElementById("player"+Indice).style.display = "inline";
      }
	
   </script>
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>