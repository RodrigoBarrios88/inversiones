<?php
/*Programador: Manuel Sosa Azurdia
Fecha: Enero de 2016*/

// crea una sesi�n o reanuda la actual basada en un identificador de sesi�n pasado mediante una petici�n GET o POST, 
//o pasado mediante una cookie. 
session_start();
ini_set("default_charset", "iso-8859-1");
	
require_once ("Clases/ClsUsuario.php");
// verifica si el usuario tiene permisos en la BD's
function login($usu,$pass){
	$usu = decode($usu);
	$pass = decode($pass);
   $ClsUsu = new ClsUsuario();   
   $result = $ClsUsu->get_login($usu,$pass);
   if (is_array($result)) {
      return true;
   }else {
      return false;
   } 
}
  
//verifica si el usuario esta logeado o si no 	
function check_auth_user(){
   global $_SESSION;
   if (isset($_SESSION['usu'])) {
      return true;
   } else {
      return false;
   }
}
  
//quitar caracteres especiales para evitar sqlinjection
function decode($string){ 
   $nopermitidos = array("'",'\\','<','>',"\"","%");
   $string = str_replace(" ","",$string);
   $string = str_replace($nopermitidos, "", $string);
   return $string;
}   
  
  
  //muestra la pagina de login
function login_form($inv,$cont) {
   $cont = ($cont == "")?0:$cont;
   //////////////////////// CREDENCIALES DE COLEGIO
   require_once ("Clases/ClsRegla.php");
   $ClsReg = new ClsRegla();
   $result = $ClsReg->get_credenciales();
   if(is_array($result)){
      foreach($result as $row){
         $colegio_nombre = utf8_decode($row['colegio_nombre']);
      }
   }
   ////////////////
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php echo $colegio_nombre; ?> </title>
   <link rel="shortcut icon" href="../CONFIG/images/logo.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets.3.6.2/css/plugins/login/util.css">
	<link rel="stylesheet" type="text/css" href="assets.3.6.2/css/plugins/login/main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action = "login.php" method="post">
					<span class="login100-form-title p-b-34">
                  <img src = "../CONFIG/images/logo.png" width="130px"><br>
						Portal del Colegio
					</span>
              <?php
                  if($inv == 1){
                     $cont++;
              ?>
               <h4 class="text-red w-full text-center">
                  Usuario o Contrase&ntilde;a invalida...
               </h4>
               <br>
               <?php
                  }else if($inv == 2){
                     $cont++;
              ?>
               <h4 class="text-red w-full text-center">
                  <i class="fa fa-info"></i> Uno o mas Campos est&aacute;n vacios.<br><b>Porfavor intente de Nuevo...</b>
               </h4>
               <br>
               <?php
                  }else if($inv == 3){
                     $cont++;
               ?>
               <h4 class="text-orange w-full text-center" role="alert">
                  Su usuario pertenece al grupo de <b>Padres</b>, por favor ingrese en el portal de padres... </br>
                  <a href="../PADRES/" class="txt2" > Ir al Portal de Padres</a>
               </h4>
               <br>
               <?php
                  }	
               ?>	
               <div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Type user name">
						<input type="text" class="input100" id = "usu" name = "usu" placeholder="Usuario">
						<span class="focus-input100"></span>
					</div>
					<div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Type password">
                  <input type="password" class="input100" id = "pass" name = "pass" placeholder="Password">
                  <input name="seg" id="seg" type="hidden" value="<?php echo $cont; ?>">	
						<span class="focus-input100"></span>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" onclick = "Submit();">
							Continuar
						</button>
					</div>
            	<div class="w-full text-center p-t-25 p-b-3">
						<span class="txt1">
							Olvid&eacute;: 
						</span>

						<a href = "CPUSUARIOS/FRMpregunta_clave.php" target = "_blank" class="txt2">
							Mi Contrase&ntilde;a 
						</a>
					</div>
               <div class="w-full text-center p-t-1 p-b-29">
						<span class="txt1">
							Contactar: 
						</span>
						<a href = "CPUSUARIOS/FRMcontact_admin.php" target = "_blank" class="txt2">
							Al Administrador
						</a>
					</div>
					<div class="w-full text-center p-t-10 p-b-5">
						<p>
                     Copyright &copy; <?php echo date("Y"); ?>, Inversiones Digitales S.A.<br>
                     Ruta 3 2-16 zona 4, Edificio Altamira, Oficina 403.
                  </p>
                  <small class='text-info'>
                     Versi&oacute;n 3.6.2
                  </small>
               </div>
				</form>
				<div class="login100-more" style="background-image: url('../CONFIG/images/bgs/bgsystem.jpg');"></div>
			</div>
		</div>
	</div>
</body>
</html>
<?php } ?>