<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$codigo = $_REQUEST["codigo"];
	
	$ClsInfo = new ClsInformacion();
	$result = $ClsInfo->get_informacion($codigo);
	
	if(is_array($result)){
		foreach($result as $row){
			$tipo = $row["inf_tipo_target"];
			$target = $row["inf_target"];
			$target_desc = ($target == "SELECT")?"Actividad para grupos especificos":"Actividad para todos";
			$nombre = utf8_decode($row["inf_nombre"]);
			$desc =  utf8_decode($row["inf_descripcion"]);
			$desc = nl2br($desc);
			$desde = cambia_fechaHora($row["inf_fecha_inicio"]);
			$hasta = cambia_fechaHora($row["inf_fecha_fin"]);
			$imagen =  trim($row["inf_imagen"]);
		}
		
	}	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
</head>
<body>	

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-calendar"></i>
		Informaci&oacute;n de la Actividad
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">	
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1 text-left">
				<label>Nombre: </label><br>
				<span class="form-info"><?php echo $nombre; ?></span>
			</div>
			<div class="col-xs-5 text-left">
				<label>Target: </label><br>
				<span class="form-info"><?php echo $target_desc; ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Descripci&oacute;n:  </label><br>
				<p class="text-primary text-justify"><?php echo $desc; ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1 text-left">
				<label>Desde: </label> <br>
				<span class="form-info"><?php echo $desde; ?></span>
			</div>
			<div class="col-xs-5 text-left">
				<label>Hasta: </label> <br>
				<span class="form-info"><?php echo $hasta; ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<a href="#" class="thumbnail">
					<img src="../../CONFIG/Actividades/<?php echo $imagen; ?>" width=" 60%" alt = "Actividad" title="<?php echo $nombre; ?>" />
				</a>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<h5 class="alert alert-info text-center">Participantes</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
			<?php if($target == "SELECT"){ ?>
				<table class="table table-striped table-bordered table-hover" >
					<thead>
						<tr>
							<th class = 'text-center'>No. </th>
							<th class = 'text-center'>Grupos</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if($target == "SELECT"){
							if($tipo == 1){
								$result = $ClsInfo->get_lista_detalle_informacion_secciones($codigo,'','','','');
							}else if($tipo == 2){
								$result = $ClsInfo->get_lista_detalle_informacion_grupos($codigo,'');
							}
						}else{
							
						}
						
						if(is_array($result)){
							$i = 1;
							foreach($result as $row){
								$tipo = $row["inf_tipo_target"];
								if($tipo == 1){
									$nivel = utf8_decode($row["niv_descripcion"]);
									$grado = utf8_decode($row["gra_descripcion"]);
									$seccion = utf8_decode($row["sec_descripcion"]);
									$nombre = "Secci&oacute;n $seccion de $grado de $nivel.";
								}else if($tipo == 2){
									$area = utf8_decode($row["are_nombre"]);
									$grupo = utf8_decode($row["gru_nombre"]);
									$nombre = "$grupo de &aacute;rea $area.";
								}
								echo "<tr><td class = 'text-center' >".$i.". </td> <td class = 'text-left'>".$nombre."</td></tr>";
								
								$i++;
							}
							
						}
					?>	
						
					</tbody>
				</table>
			<?php }else if($target == "TODOS"){ ?>
				<div class="alert alert-success" role="alert"> Asisten Todos </div>
			<?php } ?>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-success" id = "limp" onclick = "cerrarModal();"> &nbsp;&nbsp;&nbsp; <span class="fa fa-check"></span> Ok &nbsp;&nbsp;&nbsp; </button>
			</div>
        </div>
	</div>
</div>
</body>
</html>
