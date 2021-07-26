<?php
	include_once('xajax_funct_org.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPADMON"];
	
	//--- $_post
	$suc = $_REQUEST["suc"];
	$dep = $_REQUEST["dep"];
	//----
	$ClsOrg = new ClsOrganizacion();
	$result = $ClsOrg->get_plaza($plaza,$suc,$dep,'','','','','',1);
	if(is_array($result)){
		$string = "";
		foreach($result as $row){
			$dpi = trim($row["org_personal"]);
			$nombres = utf8_decode($row["plaz_personal_nombres"]);
			$plaza = Agrega_Ceros($row["plaz_codigo"]);
			$subord = $row["plaz_subord"];
			if($subord === "0"){
				$subord = "";
			}else if($subord === "999"){
				$subord = "";
			}else{
				$subord = Agrega_Ceros($row["plaz_subord"]);
			}	
			$empleo = utf8_decode($row["plaz_desc_lg"]);
			$departamento = utf8_decode($row["dep_desc_lg"]);
			$nombres = ($nombres == "")?$empleo:$nombres;
			
			if (file_exists ('../../CONFIG/Fotos/RRHH/'.$dpi.'.jpg')){ /// valida que tenga foto registrada
				$foto = 'RRHH/'.$dpi.'.jpg';
			}else{
				$foto = 'RRHH/nofoto.png';
			}
			//$strin2.= "$plaza,$empleo,$nombres,'$subord','$departamento' | ";
			$string.= "[{v:'$plaza', f:'<img src = \'../../CONFIG/Fotos/$foto\' class = \'foto\' /><div class = \'contenedor\'> <b id = \'div$plaza\' >$empleo</b><br><small>$nombres</small></div>'}, '$subord', '$departamento'],";
		}
	}
	
	//echo $strin2;
	
if($pensum != "" && $nombre != ""){ 
?>
<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("..");
		 ?>
	<!-- CSS Bootstrap -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- google Chart -->
	<script type='text/javascript' src='https://www.google.com/jsapi'></script>
	<script type='text/javascript'>
		google.load('visualization', '1', {packages:['orgchart']});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
		  var data = new google.visualization.DataTable();
		  data.addColumn('string', 'Name');
		  data.addColumn('string', 'Manager');
		  data.addColumn('string', 'ToolTip');
		  data.addRows([ <?php echo $string; ?> ]);
		  var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
		  chart.draw(data, {allowHtml:true});
		}
	</script>
	<!-- Organigrama -->
    <link href="../assets.3.6.2/css/organigrama.css" rel="stylesheet">
	
</head>
<body>
<br><br>
<div align = "center">
	<div id='chart_div'></div>
</div>
	<div align = "center">
		<br><br>	
		<button type="button" class="btn btn-success" onclick = "window.close();"><span class="fa fa-check"></span> Aceptar</button>
	</div>
	<div>
		<input type = 'hidden' id = 'plaza'>
		<input type = 'hidden' id = 'jer'>
		<input type = 'hidden' id = 'descsub'>
	</div>
	<br><br>
	<!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/organizacion/organizacion.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
</body>
</html>

<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
