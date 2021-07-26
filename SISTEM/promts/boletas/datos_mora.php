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
		<i class="fa fa-money"></i> Datos de la Mora
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 text-center">
			<h4 class="text-primary ">Datos de la Mora</h4>
			<a class="btn btn-default" title="Imprimir Boleta" href="CPREPORTES/REPboleta_mora.php?hashkey1=<?php echo $hashkey1; ?>&hashkey2=<?php echo $hashkey2; ?>&hashkey3=<?php echo $hashkey3; ?>" target="_blank"><i class="fa fa-files-o"></i> Ver Boleta de Mora</a>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2 col-xs-offset-1"><label>No. de Boleta: </label> </div>
		<div class="col-xs-4 text-left"><span class="text-primary"># <?php echo Agrega_Ceros($codigo); ?></span></div>
		<div class="col-xs-2 text-right"><label>No. de Referencia: </label> </div>
		<div class="col-xs-3 text-left"><span class="text-primary"><?php echo $referencia; ?></span></div>
	</div>
	<div class="row">
		<div class="col-xs-2 col-xs-offset-1"><label>Fecha de Registro: </label> </div>
		<div class="col-xs-4 text-left"><span class="text-primary"><?php echo $fecha; ?></span></div>
		<div class="col-xs-2 text-right"><label>Monto: </label> </div>
		<div class="col-xs-3 text-left"><span class="text-primary"><?php echo $monto; ?></span></div>
	</div>
	<div class="row">
		<div class="col-xs-2 col-xs-offset-1"><label>Girada para: </label> </div>
		<div class="col-xs-4 text-left"><span class="text-primary"><?php echo $nombre; ?></span></div>
		<div class="col-xs-2 text-right"><label>CUI: </label> </div>
		<div class="col-xs-2 text-left"><span class="text-primary"><?php echo $cui; ?></span></div>
	</div>
	<div class="row">
		<div class="col-xs-2 col-xs-offset-1"><label>Motivo: </label> </div>
		<div class="col-xs-9 text-left"><span class="text-primary"><?php echo $motivo; ?></span></div>
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
