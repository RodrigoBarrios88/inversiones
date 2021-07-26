<?
include_once('html_fns_boleta.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
    
    //// fechas ///
	$mes = date("m");
	$anio = date("Y");
	$fini = "01/01/$anio";
	$ffin = "31/$mes/$anio";
	//echo "$fini - $ffin";
    
    $ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->calcula_mora($anio,$fini,$ffin);
	if(is_array($result)){
		foreach($result as $row){
			$alumno = $row["mon_simbolo"];
			$pagos_programdo= $row["pagos_programados"];
			$pagos_ejecutado = $row["pagos_ejecutados"];
            $diferencia = ($pagos_programdo - $pagos_ejecutado);
            if($diferencia <= 0){
                $diferencia = ($diferencia * -1);
                $fecha_pago = cambia_fechaHora($fecha_pago);
                $diferencia = $mons ." ".number_format($diferencia, 2);
                $solvencia = '<h6 class="alert alert-success text-center">';
                $solvencia.= 'SOLVENTE. SALDO A FAVOR: <strong>'.$diferencia.'</strong>';
                $solvencia.= '<br><hr><small>EL &Uacute;LTIMO PAGO SE REALIZ&Oacute; EL '.$fecha_pago.'</small>';
                $solvencia.= '</h6>';
            }else{
                $hoy = date("Y-m-d");
                //echo "$fecha_programdo < $hoy";
                if($fecha_programdo < $hoy){
                    $fecha_programdo = cambia_fecha($fecha_programdo);
                    $diferencia = $mons ." ".number_format($diferencia, 2);
                    $solvencia = '<h6 class="alert alert-danger text-center">';
                    $solvencia.= 'FECHA DE PAGO EXPIRADA!. SALDO PENDIENTE: <strong>'.$diferencia.'</strong>';
                    $solvencia.= '<br><hr><small>EL PAGO EXPIR&Oacute; EL '.$fecha_programdo.'</small>';
                    $solvencia.= '</h6>';
                }else{
                    $fecha_programdo = cambia_fecha($fecha_programdo);
                    $diferencia = $mons ." ".number_format($diferencia, 2);
                    $solvencia = '<h6 class="alert alert-warning text-center">';
                    $solvencia.= 'SALDO PARA ESTE MES: <strong>'.$diferencia.'</strong>';
                    $solvencia.= '<br><hr><small>EL PROXIMO PAGO EXPIRA EL '.$fecha_programdo.'</small>';
                    $solvencia.= '</h6>';
                }
            } 
        }
	}


?>