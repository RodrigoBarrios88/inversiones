<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$sucCodigo = $_SESSION["sucCodigo"];
	$nivel = $_SESSION["nivel"];
	//--
	$codigo = $_REQUEST["codigo"];
	
	$ClsInfo = new ClsInformacion();
	$result = $ClsInfo->get_informacion($codigo);
	if(is_array($result)){
		foreach($result as $row){
			$tipo = $row["inf_tipo_target"];
			$target = $row["inf_target"];
			$target_desc = ($target == "SELECT")?"ACTIVIDAD PARA GRUPOS ESPECIFICOS":"ACTIVIDAD PARA TODOS";
			$nombre = utf8_decode($row["inf_nombre"]);
			$desc =  utf8_decode($row["inf_descripcion"]);
			$desc = nl2br($desc);
			$desde = cambia_fechaHora($row["inf_fecha_inicio"]);
			$hasta = cambia_fechaHora($row["inf_fecha_fin"]);
			$imagen =  trim($row["inf_imagen"]);
			//--
			$tlink = trim($row["inf_link"]);
			$link = ($tlink == "#")?'javascript:void(0);':$tlink;
			$_blank = ($tlink == "#")?'':'_blank';
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
		<i class="fa fa-info-circle"></i> Informaci&oacute;n de la Actividad
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
			<div class="row">
				<div class="col-md-5 col-md-offset-1">
					<label>Nombre: </label>
					<input type="input" class="form-control" value="<?php echo $nombre; ?>" readonly />
				</div>
				<div class=" col-md-5">
					<label>Target: </label>
					<input type="input" class="form-control" value="<?php echo $target_desc; ?>" readonly />
				</div>
			</div>
			<div class="row">
				<div class=" col-md-10 col-md-offset-1">
					<label>Desde / Hasta: </label>
					<div class='input-group'>
						<input type="input" class="form-control" value="<?php echo $desde; ?>" readonly />
						<span class="input-group-addon" >&nbsp; <i class="fa fa-calendar"></i> &nbsp; </span>
						<input type="input" class="form-control" value="<?php echo $hasta; ?>" readonly />
					</div>
				</div>
            </div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<label>Enlace (link): </label>
					<a href = "<?php echo $link; ?>" target="<?php echo $_blank; ?>" class="form-control text-info"><?php echo $link; ?></a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<label>Descripci&oacute;n: </label>
					<p class="text-info text-justify"><?php echo $desc; ?></p>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-10 col-md-offset-1 text-center">
					<a href="#" class="thumbnail">
						<img src="../../CONFIG/Actividades/<?php echo $imagen; ?>" width=" 60%" alt = "Actividad" title="<?php echo $nombre; ?>" />
					</a>
				</div>
            </div>
			<hr>
			<div class="row">
				<div class="col-md-10 col-md-offset-1 text-center">
					<h3 class="text-primary">Participantes</h3>
				</div>
            </div>
			<br>
			<div class="row">
				<div class="col-md-10 col-md-offset-1 text-center">
				<?php if($target == "SELECT"){ ?>
					<table class="table table-striped table-bordered table-hover" >
						<tr>
							<td class = 'text-center'><strong>No. </strong></td>
							<td class = 'text-center'><strong>Grupos </strong></td>
						</tr>
						<?php
							if($target == "SELECT"){
								if($tipo == 1){
									$result = $ClsInfo->get_det_informacion_secciones($codigo,'','','','');
								}else if($tipo == 2){
									$result = $ClsInfo->get_det_informacion_grupos($codigo,'');
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
										$nombre = "$grado $seccion ($nivel)";
									}else if($tipo == 2){
										$area = utf8_decode($row["are_nombre"]);
										$grupo = utf8_decode($row["gru_nombre"]);
										$nombre = "$grupo ($area)";
									}
									echo "<tr><td class = 'text-center' >".$i.". </td> <td class = 'text-left'>".$nombre."</td></tr>";
									
									$i++;
								}
								
							}
						?>	
					</table>
				<?php }else if($target == "TODOS"){ ?>
					<div class="alert alert-success" role="alert"> Invitaci&oacute;n General (Todos) </div>
				<?php } ?>
				</div>
            </div>
		<br><br>
		<div class="row">
			<div class="col-md-6 col-md-offset-3 text-center">
				<button type="button" class="btn btn-success" id = "limp" onclick = "cerrarModal();"> &nbsp;&nbsp;&nbsp; <span class="fa fa-check"></span> Ok &nbsp;&nbsp;&nbsp; </button>
			</div>
        </div>
	</div>
	<br>
</div>
</body>
</html>