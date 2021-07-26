<?php
require_once("Clases/ClsUsuario.php");
require_once("Clases/ClsPermiso.php");
require_once ("Clases/ClsRegla.php");
require_once ("Clases/ClsPensum.php");
include_once('user_auth_fns.php');

function consulta_log(){
$ClsUsu = new ClsUsuario();
$ClsReg = new ClsRegla();
$ClsPerm = new ClsPermiso();
$ClsPen = new ClsPensum();
//esta funcion verifica con que tipo de navegador pretende utilizar el sistema el Usuario
  check_Nav();

$usu = $_SESSION['usu'];
$pass = $_SESSION['pass'];
//////////////////////// CREDENCIALES DE COLEGIO
$ClsReg = new ClsRegla();
$result = $ClsReg->get_credenciales();
if(is_array($result)){
	foreach($result as $row){
		$nombre = utf8_decode($row['colegio_nombre']);
		$rotulo = utf8_decode($row['colegio_rotulo']);
		$rotulo_sub = utf8_decode($row['colegio_rotulo_subpantalla']);
		$nombre_reporte = utf8_decode($row['colegio_nombre_reporte']);
		$direccion1 = utf8_decode($row['colegio_direccion1']);
		$direccion2 = utf8_decode($row['colegio_direccion2']);
		$departamento = utf8_decode($row['colegio_departamento']);
		$municipio = utf8_decode($row['colegio_municipio']);
		$telefono = utf8_decode($row['colegio_telefono']);
		$correo = utf8_decode($row['colegio_correo']);
		$website = utf8_decode($row['colegio_website']);
		$nivel = utf8_decode($row['mineduc_nivel']);
		$ciclo = utf8_decode($row['mineduc_cliclo']);
		$modalidad = utf8_decode($row['mineduc_modalidad']);
		$jornada = utf8_decode($row['mineduc_jornada']);
		$sector = utf8_decode($row['mineduc_sector']);
		$area = utf8_decode($row['mineduc_area']);
	}
}
//////////////////////////- SETEA CREDENCIALES DE COLEGIO !
$_SESSION["nombre_colegio"] = $nombre;
$_SESSION["rotulos_colegio"] = $rotulo;
$_SESSION["rotulos_colegio_subpantalla"] = $rotulo_sub;
$_SESSION["colegio_nombre_reporte"] = $nombre_reporte;
$_SESSION["colegio_direccion"] = $direccion1." ".$direccion2;
$_SESSION["colegio_departamento"] = $departamento;
$_SESSION["colegio_municipio"] = $municipio;
$_SESSION["mineduc_nivel"] = $nivel;
$_SESSION["mineduc_cliclo"] = $ciclo;
$_SESSION["mineduc_modalidad"] = $modalidad;
$_SESSION["mineduc_jornada"] = $jornada;
$_SESSION["mineduc_sector"] = $sector;
$_SESSION["mineduc_area"] = $area;
//////////////////////////- CREDENCIALES DE COLEGIO !

//////////////////////////- MODULOS HABILITADOS
$ClsReg = new ClsRegla();
$result = $ClsReg->get_modulos();
if(is_array($result)){
	foreach($result as $row){
		$codigo = $row["mod_codigo"];
		$nombre = $row["mod_nombre"];
		$modclave = $row["mod_clave"];
		$situacion = $row["mod_situacion"];
		if($situacion == 1){
			$_SESSION["MOD_$modclave"] = 1;
		}else{
			$_SESSION["MOD_$modclave"] = "";
		}
	}
}
//////////////////////////- MODULOS HABILITADOS

// VERSION //
if($software_version == "FULL"){
	$_SESSION["VFULL"] = 1;
}else if($software_version == "BASIC"){
	$_SESSION["VBASIC"] = 1;
}

	
	$result = $ClsUsu->get_login($usu,$pass);
	if (is_array($result)) {
		foreach ($result as $row){
			$codigo = $row['usu_id'];
			$nombre = utf8_decode($row['usu_nombre']);
			$nivel = $row['usu_nivel'];
			$band = $row['usu_avilita'];
			$tipo = $row['usu_tipo'];
			$tipo_codigo = $row['usu_tipo_codigo'];
		}
			
		$result2 = $ClsReg->get_reglas();
		if (is_array($result2)) {
			foreach ($result2 as $row2){
				$mon = $row2['reg_moneda'];
				$pai = $row2['reg_pais'];
				$dep = $row2['reg_departamento'];
				$mun = $row2['reg_municipio'];
				$timp = trim($row2['reg_timpuesto']);
				$iva = trim($row2['reg_iva']);
				$isr = trim($row2['reg_isr']);
				$fac = trim($row2['reg_factura']);
				$ser = trim($row2['reg_serie']);
				$marg = $row2['reg_margen'];
				$desc = $row2['reg_descarga'];
				$carg = $row2['reg_carga'];
				$igss = $row2['reg_igss'];
				$irtra = $row2['reg_irtra'];
				$intecap = $row2['reg_intecap'];
			}
		}
		/// PENSUM ////
		
		$pensum = $ClsPen->get_pensum_activo();
		
		//// PERMISOS
		$result = $ClsPerm->get_asi_permisos($codigo);
		if (is_array($result)) {
			if($tipo == 5){
				$gpcod1 = "";
				$gpcod2 = "";
				foreach ($result as $row){
					$gpclave = trim($row['gperm_clave']); //Clave de grupo
					$clave = trim($row['perm_clave']); //clave de permiso
					$nivel = $row['roll_nombre']; //nombre del rol
					$_SESSION["GRP_$gpclave"] = 1;
					$_SESSION["$clave"] = 1;
				}
				
				/// USUARIO
				$_SESSION['codigo'] = $codigo;
				$_SESSION['nombre'] = $nombre;
				$_SESSION['sucursal'] = "CENTRAL";
				$_SESSION['sucCodigo'] = 1;
				$_SESSION['nivel'] = $nivel;
					
				/// CONFIGURACIÓN
				$_SESSION['title'] = "ASMS";
				$_SESSION['moneda'] = $mon;
				$_SESSION['pais'] = $pai;
            $_SESSION['departamento'] = $dep;
            $_SESSION['municipio'] = $mun;
				$_SESSION['timpuesto'] = $timp;
				$_SESSION['iva'] = $iva;
				$_SESSION['isr'] = $isr;
				$_SESSION['facturar'] = $fac;
				$_SESSION['seriexdefecto'] = $ser;
				$_SESSION['margenutil'] = $marg;
				$_SESSION['descargarinv'] = $desc;
				$_SESSION['cargarinv'] = $carg;
				$_SESSION['igss'] = $igss;
				$_SESSION['irtra'] = $irtra;
				$_SESSION['intecap'] = $intecap;
				
				///// ASMS /////
				$_SESSION['pensum'] = $pensum;
				$_SESSION['tipo_usuario'] = $tipo;
				$_SESSION['tipo_codigo'] = $tipo_codigo;
				if($tipo == 2){
					$_SESSION['maestro'] = $tipo_codigo;
				}else if($tipo == 3){
					$_SESSION['padre'] = $tipo_codigo;
				}else if($tipo == 4){
					$_SESSION['monitor'] = $tipo_codigo;
				}
				
				
				//echo $band;
				if($band != 1){
					//Header('Location: FRMcambia_pass.php');
					redirect('CPUSUARIOS/FRMcambia_pass.php',0);
				}else{
					//Header('Location: menu.php');
					redirect('menu.php',0);
					//echo "voy para el menu";	
				}
			}else{
				////// USUARIO ASMINISTRATIVO SIN PERMISOS PARA EL PORTAL DE PADRES
				$_SESSION['usu'] = "";	
				unset($_SESSION['usu']);
				$_SESSION['pass'] = "";	
				unset($_SESSION['pass']);
				session_destroy();
				//redirecciona por medio de $_post
				echo "<form id='f1' name='f1' action='index.php' method='post'>";
				echo "<input type='hidden' name='invalid' value='3' />";
				echo "<input type='hidden' name='seg' value='0' />";
				//echo "<script>document.f1.submit();</script>";
				echo "</form>";
			}
		}else if($tipo == 3){
			/// USUARIO
			$_SESSION['codigo'] = $codigo;
			$_SESSION['nombre'] = $nombre;
			$_SESSION['pensum'] = $pensum;
			$_SESSION['tipo_usuario'] = $tipo;
			$_SESSION['tipo_codigo'] = $tipo_codigo;
			$_SESSION['padre'] = 3;
			
			
			//echo $band;
			if($band != 1){
				//Header('Location: FRMcambia_pass.php');
				redirect('CPUSUARIOS/FRMcambia_pass.php',0);
			}else{
				//Header('Location: menu.php');
				redirect('menu.php',0);
				//echo "voy para el menu";	
			}
		}else{
			$_SESSION['usu'] = "";	
			unset($_SESSION['usu']);
			$_SESSION['pass'] = "";	
			unset($_SESSION['pass']);
			session_destroy();
			//redirecciona por medio de $_post
			echo "<form id='f1' name='f1' action='index.php' method='post'>";
			echo "<input type='hidden' name='invalid' value='5' />";
			echo "<input type='hidden' name='seg' value='0' />";
			echo "<script>document.f1.submit();</script>";
			echo "</form>";
		}
	}else{
		//redirecciona por medio de $_post
		echo "<form id='f1' name='f1' action='index.php' method='post'>";
		echo "<input type='hidden' name='invalid' value='1' />";
		echo "<input type='hidden' name='seg' value='0' />";
		echo "<script>document.f1.submit();</script>";
		echo "</form>";
	}
	
}

function redirect($url,$seconds){
    $ss = $seconds * 1000;
    $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".$ss.");</script>";
    echo ($comando);
}

function check_Nav(){
    $comando = "<script>
    var browser=navigator.appName;
    if (browser == 'Microsoft Internet Explorer'){
		if (confirm('No se puede Ingresar a este Sistema por medio de Internet Explorer, se recomienda utilizar FireFox o algun otro Navegador de Netscape. Dese Descargar FireFox?')){
			window.location.href='logout2.php';
		}else{
			window.location.href='logout.php';
		}
	}
	</script>";
		
    echo ($comando);
}

?>