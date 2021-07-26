<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$codigo = $_REQUEST["cod"];
	$cuenta = $_REQUEST["cue"];
	$banco = $_REQUEST["ban"];
	
	$ClsMora = new ClsMora();
	$result = $ClsMora->get_mora($codigo,$cuenta,$banco);
	
	if(is_array($result)){
		foreach($result as $row){
			$alumno = $row["mor_alumno"];
			$referencia = $row["mor_boleta"];
			$fecha = $row["mor_fecha_registro"];
			$fecha = cambia_fechaHora($fecha);
			$motivo = $row["mor_motivo"];
			$monto = $row["mor_monto"];
			$mons = $row["mon_simbolo"];
			$monto = $mons." ".number_format($monto, 2);
			//--
			$nombre = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
			$cui = $row["alu_cui"];
		}
	}
	//--
	$usuario = $_SESSION["codigo"];
	$hashkey1 = $ClsMora->encrypt($codigo, $usuario);
	$hashkey2 = $ClsMora->encrypt($cuenta, $usuario);
	$hashkey3 = $ClsMora->encrypt($banco, $usuario);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
    </head>
<body>	

<div class="panel panel-default">
	<div class="panel-heading">
		<label>Datos de la Mora</label>
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="row">
		<div class="col-xs-12 text-center">
			<h4 class="text-primary ">Datos de la Mora</h4>
			<a class="btn btn-primary btn-outline" title="Imprimir Boleta" href="CPREPORTES/REPboleta_mora.php?codigo=<?php echo $codigo; ?>&cuenta=<?php echo $cuenta; ?>&banco=<?php echo $banco; ?>" target="_blank"><i class="fa fa-files-o"></i> Ver Boleta de Mora</a>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-xs-1"></div>
		<div class="col-xs-5 text-left">
			<label>No. de Boleta: </label><br>
			<span class="form-control"># <?php echo Agrega_Ceros($codigo); ?></span>
		</div>
		<div class="col-xs-5">
			<label>No. de Referencia: </label><br>
			<span class="form-control"><?php echo $referencia; ?></span>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-1"></div>
		<div class="col-xs-5">
			<label>Fecha de Registro: </label><br>
			<span class="form-control"><?php echo $fecha; ?></span>
		</div>
		<div class="col-xs-5">
			<label>Monto: </label><br>
			<span class="form-control"><?php echo $monto; ?></span>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-1"></div>
		<div class="col-xs-5">
			<label>Girada para: </label><br>
			<span class="form-control"><?php echo $nombre; ?></span>
		</div>
		<div class="col-xs-5">
			<label>CUI: </label><br>
			<span class="form-control"><?php echo $cui; ?></span>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-1"></div>
		<div class="col-xs-10">
			<label>Motivo: </label><br>
			<span class="form-control"><?php echo $motivo; ?></span>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-xs-12 text-center">
			<button type="button" class="btn btn-success" id = "limp" onclick = "cerrarModal();"> &nbsp;&nbsp;&nbsp; <span class="fa fa-check"></span> Ok &nbsp;&nbsp;&nbsp; </button>
		</div>
	</div>
	<br>
</div>
</body>
</html>
