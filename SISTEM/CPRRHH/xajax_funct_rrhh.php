<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once('html_fns_rrhh.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Departamento - Municipios //////////////////////////////////
function depmun($dep,$idmun,$idsmun){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$dep,$idmun,$idsmun");
	$contenido = municipio_html($dep,$idmun); 
	$respuesta->assign($idsmun,"innerHTML",$contenido); 
	return $respuesta;
}

///////////// Utilitarias //////////////////////////////////
function Grid_Filas_Armamento($filas){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$dep,$idmun,$idsmun");
	$contenido = tabla_armamento($filas); 
	$respuesta->assign("ArmamentoContainer","innerHTML",$contenido);
	
	return $respuesta;
}

function Grid_Filas_Vehiculos($filas){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$dep,$idmun,$idsmun");
	$contenido = tabla_vehiculos($filas); 
	$respuesta->assign("VehiculosContainer","innerHTML",$contenido);
	
	return $respuesta;
}

function Grid_Filas_Hijos($filas){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$filas");
	$contenido = tabla_hijos($filas); 
	$respuesta->assign("HijosContainer","innerHTML",$contenido);
	
	return $respuesta;
}

function Grid_Filas_Hermanos($filas){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$filas");
	$contenido = tabla_hermanos($filas); 
	$respuesta->assign("HermanosContainer","innerHTML",$contenido);
	
	return $respuesta;
}

function Grid_Filas_Faminst($filas){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$filas");
	$contenido = tabla_faminst($filas); 
	$respuesta->assign("FaminstContainer","innerHTML",$contenido);
	
	return $respuesta;
}

function Grid_Filas_Refsocial($filas){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$filas");
	$contenido = tabla_refsocial($filas); 
	$respuesta->assign("RefsocialContainer","innerHTML",$contenido);
	
	return $respuesta;
}

function Grid_Filas_Titulos($filas){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$filas");
	$contenido = tabla_titulos($filas); 
	$respuesta->assign("TitulosContainer","innerHTML",$contenido);
	
	return $respuesta;
}

function Grid_Filas_Idiomas($filas){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$filas");
	$contenido = tabla_idiomas($filas); 
	$respuesta->assign("IdiomasContainer","innerHTML",$contenido);
	
	return $respuesta;
}

function Grid_Filas_Cursos($filas){
   $respuesta = new xajaxResponse();
      //$respuesta->alert("$filas");
	$contenido = tabla_cursos($filas); 
	$respuesta->assign("CursosContainer","innerHTML",$contenido);
	
	return $respuesta;
}

function Grid_Filas_Otros_Cursos($filas){
   $respuesta = new xajaxResponse();
   	$contenido = tabla_otros_cursos($filas); 
	//$respuesta->alert("$contenido");
        $respuesta->assign("OtrosCursosContainer","innerHTML",$contenido);
	
	return $respuesta;
}

///////////// Personal //////////////////////////////////
function Grabar_Personal($dpi,$nom,$ape,$nit,$profesion,$religion,$pasa,$igss,$genero,$ecivil,$depn,$paisn,$fecnac,$dir2,$munde,$tel2,$dir1,
		$mundp,$tel1,$sangre,$alergia,$cel,$email,$emernombre,$emerapellido,$emerdirec,$emertel,$emercel,$tcamisa,$tpantalon,$tchumpa,$tbotas,$tgorra,
		$estatura,$peso,$tez,$ojos,$nariz,$tlicv,$nlicv,$nlicm,$deportes,$empleadoconyugue,$ingresosconyugue,
		$trabajoconyugue,$cargasfam,$casa,$costocasa,$cuentasbanco,$bancos,$tarjetascred,$bancostarjeta,$otrosingresos,$montootros,$sueldo,$descuentos,$prestamos,$saldo,$detenido,$motivodetenido,
		$dondedetenido,$cuandodetenido,$porquedetenido,$feclibertad,$arraigado,$motivoarraigado,$dondearraigo,$cuandoarraigo,$ultimoempleo,$telultimoempleo,$dirultimoempleo,$pueultimoempleo,$empultimoempleo,
		$sueldoultimoempleo,$fecultimoempleo,$primaria,$lugprimaria,$secundaria,$secuncarrera,$lugsecundaria,$famnombre2,$famapellido2,$fampais2,$famreligion2,$famdirec2,$famtel2,$famcel2,$famprofe2,$padrefecnac,$famnombre3,$famapellido3,$fampais3,$famreligion3,
		$famdirec3,$famtel3,$famcel3,$famprofe3,$madrefecnac,$famnombre4,$famapellido4,$fampais4,$famreligion4,$famdirec4,$famtel4,$famcel4,$famprofe4,$esposafecnac,$arrnomhijo,$arrapehijo,$arrpaishijo,
		$arrreligionhijo,$arrfecnachijo,$arrnomhermano,$arrapehermano,$arrpaishermano,$arrreligionhermano,$arrfecnachermano,$arrnomfaminst,
		$arrparenfaminst,$arrpuestofaminst,$arraniofaminst,$arrtipoveh,$arrmarcaveh,$arrlineaveh,$arrmodeloveh,$arrtarjetaveh,$arrcolorveh,$arrchasisveh,$arrmotorveh,
		$arrplacasveh,$arrpaisveh,$arrnivelu,$arrtitulo,$arrunversidad,$arrpaistit,$arraniotit,$arrsemtit,
		$arrgraduadotit,$arrnivelciv,$arrotrocurso,$arrinstituto,$arrpaisotrocur,$arraniootrocur,$arridioma,
		$arrhabla,$arrlee,$arrescribe,$arrnomsocial,$arrdirsocial,$arrtelsocial,$arrtrabajosocial,$arrcargosocial,$cantvehiculos,$canttitulos,
		$cantidiomas,$cantotroscursos,$canthijos,$canthermanos,$cantfaminst,$cantrefsocial){
	
	$respuesta = new xajaxResponse();
   $ClsPer = new ClsPersonal();
   $ClsEco = new ClsEconomica();
   $ClsPen = new ClsPenal();
   $ClsLab = new ClsLaboral();
   $ClsFam = new ClsFamilia();
   //$ClsArm = new ClsArmamento();
   $ClsEdu = new ClsEducacion();
   $ClsVeh = new ClsVehiculo();
   $ClsRefS = new ClsRefSocial();
	
	//decodificacion para Ñ's
   /////////////////decodificacion para Ñ's///////////////////
	/////////// ENCODE ////////
	//personal 
   $nom = utf8_encode($nom);
   $ape = utf8_encode($ape);
   $profesion = utf8_encode($profesion);
   $religion = utf8_encode($religion);
   $genero = utf8_encode($genero);
   $ecivil = utf8_encode($ecivil);
   $dir1 = utf8_encode($dir1);
   $dir2 = utf8_encode($dir2);
   $sangre = utf8_encode($sangre);
   $alergia = utf8_encode($alergia);
   $email = utf8_encode($email);
   //educacion 
   $lugprimaria = utf8_encode($lugprimaria);
   $secuncarrera = utf8_encode($secuncarrera);
   $lugsecundaria = utf8_encode($lugsecundaria);
   //faminstia
	 $famnombre2 = utf8_encode($famnombre2);
   $famapellido2 = utf8_encode($famapellido2);
   $famreligion2 = utf8_encode($famreligion2);
   $famdirec2 = utf8_encode($famdirec2);
   $famprofe2 = utf8_encode($famprofe2);
	$famnombre3 = utf8_encode($famnombre3);
   $famapellido3 = utf8_encode($famapellido3);
   $famreligion3 = utf8_encode($famreligion3);
   $famdirec3 = utf8_encode($famdirec3);
   $famprofe3 = utf8_encode($famprofe3);
	$famnombre4 = utf8_encode($famnombre4);
   $famapellido4 = utf8_encode($famapellido4);
   $famreligion4 = utf8_encode($famreligion4);
   $famdirec4 = utf8_encode($famdirec4);
   $famprofe4 = utf8_encode($famprofe4);
   $emergencia = utf8_encode($emergencia);
   $emerdirec = utf8_encode($emerdirec);
   $emernombre = utf8_encode($emernombre);
   $emerapellido = utf8_encode($emerapellido);
   //social 
   $deportes = utf8_encode($deportes);
   //economica 
   $trabajoconyugue = utf8_encode($trabajoconyugue);
   $bancos = utf8_encode($bancos);
   $bancostarjeta = utf8_encode($bancostarjeta);
   $otrosingresos = utf8_encode($otrosingresos);
   //penal 
   $motivodetenido = utf8_encode($motivodetenido);
   $dondedetenido = utf8_encode($dondedetenido);
   $cuandodetenido = utf8_encode($cuandodetenido);
   $porquedetenido = utf8_encode($porquedetenido);
   $motivoarraigado = utf8_encode($motivoarraigado);
   $dondearraigo = utf8_encode($dondearraigo);
   $cuandoarraigo = utf8_encode($cuandoarraigo);
   //laboral anterior 
   $ultimoempleo = utf8_encode($ultimoempleo);
   $dirultimoempleo = utf8_encode($dirultimoempleo);
   $pueultimoempleo = utf8_encode($pueultimoempleo);
   $empultimoempleo = utf8_encode($empultimoempleo);
   $fecultimoempleo = utf8_encode($fecultimoempleo);
   //somatometrica 
   $tez = utf8_encode($tez);
   $ojos = utf8_encode($ojos);
   $nariz = utf8_encode($nariz);
	
	/////////// DECODE ///////
   //personal 
   $nom = utf8_decode($nom);
   $ape = utf8_decode($ape);
   $profesion = utf8_decode($profesion);
   $religion = utf8_decode($religion);
   $genero = utf8_decode($genero);
   $ecivil = utf8_decode($ecivil);
   $dir1 = utf8_decode($dir1);
   $dir2 = utf8_decode($dir2);
   $sangre = utf8_decode($sangre);
   $alergia = utf8_decode($alergia);
   $email = utf8_decode($email);
   //educacion 
   $lugprimaria = utf8_decode($lugprimaria);
   $secuncarrera = utf8_decode($secuncarrera);
   $lugsecundaria = utf8_decode($lugsecundaria);
   //faminstia
	$famnombre2 = utf8_decode($famnombre2);
   $famapellido2 = utf8_decode($famapellido2);
   $famreligion2 = utf8_decode($famreligion2);
   $famdirec2 = utf8_decode($famdirec2);
   $famprofe2 = utf8_decode($famprofe2);
	$famnombre3 = utf8_decode($famnombre3);
   $famapellido3 = utf8_decode($famapellido3);
   $famreligion3 = utf8_decode($famreligion3);
   $famdirec3 = utf8_decode($famdirec3);
   $famprofe3 = utf8_decode($famprofe3);
	$famnombre4 = utf8_decode($famnombre4);
   $famapellido4 = utf8_decode($famapellido4);
   $famreligion4 = utf8_decode($famreligion4);
   $famdirec4 = utf8_decode($famdirec4);
   $famprofe4 = utf8_decode($famprofe4);
   $emergencia = utf8_decode($emergencia);
   $emerdirec = utf8_decode($emerdirec);
   $emernombre = utf8_decode($emernombre);
   $emerapellido = utf8_decode($emerapellido);
   //social 
   $deportes = utf8_decode($deportes);
   //economica 
   $trabajoconyugue = utf8_decode($trabajoconyugue);
   $bancos = utf8_decode($bancos);
   $bancostarjeta = utf8_decode($bancostarjeta);
   $otrosingresos = utf8_decode($otrosingresos);
   //penal 
   $motivodetenido = utf8_decode($motivodetenido);
   $dondedetenido = utf8_decode($dondedetenido);
   $cuandodetenido = utf8_decode($cuandodetenido);
   $porquedetenido = utf8_decode($porquedetenido);
   $motivoarraigado = utf8_decode($motivoarraigado);
   $dondearraigo = utf8_decode($dondearraigo);
   $cuandoarraigo = utf8_decode($cuandoarraigo);
   //laboral anterior 
   $ultimoempleo = utf8_decode($ultimoempleo);
   $dirultimoempleo = utf8_decode($dirultimoempleo);
   $pueultimoempleo = utf8_decode($pueultimoempleo);
   $empultimoempleo = utf8_decode($empultimoempleo);
   $fecultimoempleo = utf8_decode($fecultimoempleo);
   //somatometrica 
   $tez = utf8_decode($tez);
   $ojos = utf8_decode($ojos);
   $nariz = utf8_decode($nariz);
		
		$sql = ""; //limpieza de cadena 
		//inicio del proceso de Inserc
		//personal
		$sql = $ClsPer->insert_personal($dpi,$nom,$ape,$nit,$profesion,$religion,$pasa,$igss,$genero,$ecivil,$depn,$paisn,$fecnac,$dir2,$munde,$tel2,$dir1,$mundp,$tel1,$sangre,$alergia,$cel,$email,$emernombre,$emerapellido,$emerdirec,$emertel,$emercel,$fecalta,
												  $tcamisa,$tpantalon,$tchumpa,$tbotas,$tgorra,$estatura,$peso,$tez,$ojos,$nariz,$tlicv,$nlicv,$nlicm,"","0000-00-00","0000-00-00",$deportes,"A");      
      
		//economicas
		$sql.= $ClsEco->insert_economica($dpi,$empleadoconyugue,$ingresosconyugue,$trabajoconyugue,$cargasfam,$casa,$costocasa,$cuentasbanco,$bancos,$tarjetascred,$bancostarjeta,$otrosingresos,$montootros,$sueldo,$descuentos,$prestamos,$saldo);
      //penal
		$sql.= $ClsPen->insert_penal($dpi,$detenido,$motivodetenido,$dondedetenido,$cuandodetenido,$porquedetenido,$feclibertad,$arraigado,$motivoarraigado,$dondearraigo,$cuandoarraigo);
      //Laboral Anterior
         $sql.= $ClsLab->insert_laboral_anterior($dpi,$ultimoempleo,$telultimoempleo,$dirultimoempleo,$pueultimoempleo,$empultimoempleo,$sueldoultimoempleo,$fecultimoempleo);	             
      
		//Familia
		$x = 1;
		//padre
		$sql.= $ClsFam->insert_familia($x,$dpi,$famnombre2,$famapellido2,$famdirec2,$famtel2,$famcel2,$famprofe2,$famreligion2,$fampais2,$padrefecnac,3);
		$x++; //aumenta el codigo del familiar
		//madre
		$sql.= $ClsFam->insert_familia($x,$dpi,$famnombre3,$famapellido3,$famdirec3,$famtel3,$famcel3,$famprofe3,$famreligion3,$fampais3,$madrefecnac,2);
		$x++; //aumenta el codigo del familiar
		//esposa
		$sql.= $ClsFam->insert_familia($x,$dpi,$famnombre4,$famapellido4,$famdirec4,$famtel4,$famcel4,$famprofe4,$famreligion4,$fampais4,$esposafecnac,1);
		//hijos
		for($i = 1; $i <= $canthijos; $i++){
			$x++;
			$nomhijo = utf8_encode($arrnomhijo[$i]);
			$apehijo = utf8_encode($arrapehijo[$i]);
			$paishijo = utf8_encode($arrpaishijo[$i]);
			$religionhijo = utf8_encode($arrreligionhijo[$i]);
			$fecnachijo = utf8_encode($arrfecnachijo[$i]);
			//--
			$nomhijo = utf8_decode($nomhijo);
			$apehijo = utf8_decode($apehijo);
			$paishijo = utf8_decode($paishijo);
			$religionhijo = utf8_decode($religionhijo);
			$fecnachijo = utf8_decode($fecnachijo);
			$sql.= $ClsFam->insert_familia($x,$dpi,$nomhijo,$apehijo,"","","","",$religionhijo,$paishijo,$fecnachijo,4);
		}
		//hermanos
		for($i = 1; $i <= $canthermanos; $i++){
			$x++;
			$nomhermano = utf8_encode($arrnomhermano[$i]);
			$apehermano = utf8_encode($arrapehermano[$i]);
			$paishermano = utf8_encode($arrpaishermano[$i]);
			$religionhermano = utf8_encode($arrreligionhermano[$i]);
			$fecnachermano = utf8_encode($arrfecnachermano[$i]);
			//--
			$nomhermano = utf8_decode($nomhermano);
			$apehermano = utf8_decode($apehermano);
			$paishermano = utf8_decode($paishermano);
			$religionhermano = utf8_decode($religionhermano);
			$fecnachermano = utf8_decode($fecnachermano);
			$sql.= $ClsFam->insert_familia($x,$dpi,$nomhermano,$apehermano,"","","","",$religionhermano,$paishermano,$fecnachermano,7);
		}
		//Familia dentro del ambito institucional
		for($i = 1; $i <= $cantfaminst; $i++){
			 $nomfaminst = utf8_encode($arrnomfaminst[$i]);
			 $parenfaminst = utf8_encode($arrparenfaminst[$i]);
			 $puestofaminst = utf8_encode($arrpuestofaminst[$i]);
			 $aniofaminst = utf8_encode($arraniofaminst[$i]);
			 //--
			 $nomfaminst = utf8_decode($nomfaminst);
			 $parenfaminst = utf8_decode($parenfaminst);
			 $puestofaminst = utf8_decode($puestofaminst);
			 $aniofaminst = utf8_decode($aniofaminst);
			$sql.= $ClsFam->insert_familia_institucion($i,$dpi,$nomfaminst,$parenfaminst,$puestofaminst,$aniofaminst);
		}
		
		//Vehiculos
		for($i = 1; $i <= $cantvehiculos; $i++){
			//---
			$tipoveh = utf8_encode($arrtipoveh[$i]);
			$marcaveh = utf8_encode($arrmarcaveh[$i]);
			$lineaveh = utf8_encode($arrlineaveh[$i]);
			$modeloveh = utf8_encode($arrmodeloveh[$i]);
			$tarjetaveh = utf8_encode($arrtarjetaveh[$i]);
			$colorveh = utf8_encode($arrcolorveh[$i]);
			$chasisveh = utf8_encode($arrchasisveh[$i]);
			$motorveh = utf8_encode($arrmotorveh[$i]);
			$placasveh = utf8_encode($arrplacasveh[$i]);
			$paisveh = utf8_encode($arrpaisveh[$i]);
			//--
			$tipoveh = utf8_decode($tipoveh);
			$marcaveh = utf8_decode($marcaveh);
			$lineaveh = utf8_decode($lineaveh);
			$modeloveh = utf8_decode($modeloveh);
			$tarjetaveh = utf8_decode($tarjetaveh);
			$colorveh = utf8_decode($colorveh);
			$chasisveh = utf8_decode($chasisveh);
			$motorveh = utf8_decode($motorveh);
			$placasveh = utf8_decode($placasveh);
			$paisveh = utf8_decode($paisveh);
			$sql.= $ClsVeh->insert_vehiculos($i,$dpi,$tipoveh,$marcaveh,$lineaveh,$modeloveh,$tarjetaveh,$colorveh,$chasisveh,$motorveh,$placasveh,$paisveh);
		}
								//Armamento // Usado en las instituciones que tienen personal de seguridad
							 /*for($i = 1; $i <= $cantarmas; $i++){
								 $tipoarma = utf8_decode($arrtipoarma[$i]);
								 $marcaarma = utf8_decode($arrmarcaarma[$i]);
								 $calarma = utf8_decode($arrcalarma[$i]);
								 $numarma = utf8_decode($arrnumarma[$i]);
								 $sql.= $ClsArm->insert_armamento($i,$codigo,$tipoarma,$marcaarma,$calarma,$numarma);
							 }*/
		//Educacion
		$sql.= $ClsEdu->insert_educacion($dpi,$primaria,$lugprimaria,$secundaria,$lugsecundaria,$secuncarrera);
		$x = 1;
		//titulos universitarios
		for($i = 1; $i <= $canttitulos; $i++){
			//---
			$nivelu = utf8_encode($arrnivelu[$i]);
			$titulo = utf8_encode($arrtitulo[$i]);
			$unversidad = utf8_encode($arrunversidad[$i]);
			$paistit = utf8_encode($arrpaistit[$i]);
			$aniotit = utf8_encode($arraniotit[$i]);
			$semtit = utf8_encode($arrsemtit[$i]);
			$graduadotit = utf8_encode($arrgraduadotit[$i]);
			//--
			$nivelu = utf8_decode($nivelu);
			$titulo = utf8_decode($titulo);
			$unversidad = utf8_decode($unversidad);
			$paistit = utf8_decode($paistit);
			$aniotit = utf8_decode($aniotit);
			$semtit = utf8_decode($semtit);
			$graduadotit = utf8_decode($graduadotit);
			$sql.= $ClsEdu->insert_cursos($x,$dpi,"U",$nivelu,$titulo,$unversidad,$paistit,$aniotit,$semtit,$graduadotit);
			$x++;
		}
		//Otros Cursos
		for($i = 1; $i <= $cantotroscursos; $i++){
			//---
			$nivelciv = utf8_encode($arrnivelciv[$i]);
			$otrocurso = utf8_encode($arrotrocurso[$i]);
			$instituto = utf8_encode($arrinstituto[$i]);
			$paisotrocur = utf8_encode($arrpaisotrocur[$i]);
			$aniootrocur = utf8_encode($arraniootrocur[$i]);
			//--
			$nivelciv = utf8_decode($nivelciv);
			$otrocurso = utf8_decode($otrocurso);
			$instituto = utf8_decode($instituto);
			$paisotrocur = utf8_decode($paisotrocur);
			$aniootrocur = utf8_decode($aniootrocur);
			$sql.= $ClsEdu->insert_cursos($x,$dpi,"C",$nivelciv,$otrocurso,$instituto,$paisotrocur,$aniootrocur,"","");
			$x++;
		}
		//Idioma
		for($i = 1; $i <= $cantidiomas; $i++){
			//---
			$idioma = utf8_encode($arridioma[$i]);
			$habla = utf8_encode($arrhabla[$i]);
			$lee = utf8_encode($arrlee[$i]);
			$escribe = utf8_encode($arrescribe[$i]);
			//--
			$idioma = utf8_decode($idioma);
			$habla = utf8_decode($habla);
			$lee = utf8_decode($lee);
			$escribe = utf8_decode($escribe);
			$sql.= $ClsEdu->insert_idiomas($i,$dpi,$idioma,$habla,$lee,$escribe);
		}
		//Referencias Sociales
		for($i = 1; $i <= $cantrefsocial; $i++){
			//---
			$nomsocial = utf8_encode($arrnomsocial[$i]);
			$dirsocial = utf8_encode($arrdirsocial[$i]);
			$telsocial = utf8_encode($arrtelsocial[$i]);
			$trabajosocial = utf8_encode($arrtrabajosocial[$i]);
			$cargosocial = utf8_encode($arrcargosocial[$i]);
			//--
			$nomsocial = utf8_decode($nomsocial);
			$dirsocial = utf8_decode($dirsocial);
			$telsocial = utf8_decode($telsocial);
			$trabajosocial = utf8_decode($trabajosocial);
			$cargosocial = utf8_decode($cargosocial);
			$sql.= $ClsRefS->insert_referencia_social($i,$dpi,$nomsocial,$dirsocial,$telsocial,$trabajosocial,$cargosocial);
		}
		
		//$respuesta->alert($sql2);
		$rs = $ClsPer->exec_sql($sql);
		if($rs==1){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsPer->encrypt($dpi, $usu);
         $respuesta->script('swal("Excelente", "Personal inscrito con exito!", "success").then((value)=>{ window.location.reload(); });');
		}else{
		  $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
      
      return $respuesta;
}


///////////// Personal //////////////////////////////////
function Modificar_Personal($dpi,$nom,$ape,$nit,$profesion,$religion,$pasa,$igss,$genero,$ecivil,$depn,$paisn,$fecnac,$dir2,$munde,$tel2,$dir1,
		$mundp,$tel1,$sangre,$alergia,$cel,$email,$emernombre,$emerapellido,$emerdirec,$emertel,$emercel,$tcamisa,$tpantalon,$tchumpa,$tbotas,$tgorra,
		$estatura,$peso,$tez,$ojos,$nariz,$tlicv,$nlicv,$nlicm,$deportes,$empleadoconyugue,$ingresosconyugue,
		$trabajoconyugue,$cargasfam,$casa,$costocasa,$cuentasbanco,$bancos,$tarjetascred,$bancostarjeta,$otrosingresos,$montootros,$sueldo,$descuentos,$prestamos,$saldo,$detenido,$motivodetenido,
		$dondedetenido,$cuandodetenido,$porquedetenido,$feclibertad,$arraigado,$motivoarraigado,$dondearraigo,$cuandoarraigo,$ultimoempleo,$telultimoempleo,$dirultimoempleo,$pueultimoempleo,$empultimoempleo,
		$sueldoultimoempleo,$fecultimoempleo,$primaria,$lugprimaria,$secundaria,$secuncarrera,$lugsecundaria,$famnombre2,$famapellido2,$fampais2,$famreligion2,$famdirec2,$famtel2,$famcel2,$famprofe2,$padrefecnac,$famnombre3,$famapellido3,$fampais3,$famreligion3,
		$famdirec3,$famtel3,$famcel3,$famprofe3,$madrefecnac,$famnombre4,$famapellido4,$fampais4,$famreligion4,$famdirec4,$famtel4,$famcel4,$famprofe4,$esposafecnac,$arrnomhijo,$arrapehijo,$arrpaishijo,
		$arrreligionhijo,$arrfecnachijo,$arrnomhermano,$arrapehermano,$arrpaishermano,$arrreligionhermano,$arrfecnachermano,$arrnomfaminst,
		$arrparenfaminst,$arrpuestofaminst,$arraniofaminst,$arrtipoveh,$arrmarcaveh,$arrlineaveh,$arrmodeloveh,$arrtarjetaveh,$arrcolorveh,$arrchasisveh,$arrmotorveh,
		$arrplacasveh,$arrpaisveh,$arrnivelu,$arrtitulo,$arrunversidad,$arrpaistit,$arraniotit,$arrsemtit,
		$arrgraduadotit,$arrnivelciv,$arrotrocurso,$arrinstituto,$arrpaisotrocur,$arraniootrocur,$arridioma,
		$arrhabla,$arrlee,$arrescribe,$arrnomsocial,$arrdirsocial,$arrtelsocial,$arrtrabajosocial,$arrcargosocial,$cantvehiculos,$canttitulos,
		$cantidiomas,$cantotroscursos,$canthijos,$canthermanos,$cantfaminst,$cantrefsocial){
   $respuesta = new xajaxResponse();
   $ClsPer = new ClsPersonal();
   $ClsEco = new ClsEconomica();
   $ClsPen = new ClsPenal();
   $ClsLab = new ClsLaboral();
   $ClsFam = new ClsFamilia();
   //$ClsArm = new ClsArmamento();
   $ClsEdu = new ClsEducacion();
   $ClsVeh = new ClsVehiculo();
   $ClsRefS = new ClsRefSocial();
   
   /////////////////decodificacion para Ñ's///////////////////
	/////////// ENCODE ////////
	//personal 
   $nom = utf8_encode($nom);
   $ape = utf8_encode($ape);
   $profesion = utf8_encode($profesion);
   $religion = utf8_encode($religion);
   $genero = utf8_encode($genero);
   $ecivil = utf8_encode($ecivil);
   $dir1 = utf8_encode($dir1);
   $dir2 = utf8_encode($dir2);
   $sangre = utf8_encode($sangre);
   $alergia = utf8_encode($alergia);
   $email = utf8_encode($email);
   //educacion 
   $lugprimaria = utf8_encode($lugprimaria);
   $secuncarrera = utf8_encode($secuncarrera);
   $lugsecundaria = utf8_encode($lugsecundaria);
   //faminstia
	$famnombre2 = utf8_encode($famnombre2);
   $famapellido2 = utf8_encode($famapellido2);
   $famreligion2 = utf8_encode($famreligion2);
   $famdirec2 = utf8_encode($famdirec2);
   $famprofe2 = utf8_encode($famprofe2);
	$famnombre3 = utf8_encode($famnombre3);
   $famapellido3 = utf8_encode($famapellido3);
   $famreligion3 = utf8_encode($famreligion3);
   $famdirec3 = utf8_encode($famdirec3);
   $famprofe3 = utf8_encode($famprofe3);
	$famnombre4 = utf8_encode($famnombre4);
   $famapellido4 = utf8_encode($famapellido4);
   $famreligion4 = utf8_encode($famreligion4);
   $famdirec4 = utf8_encode($famdirec4);
   $famprofe4 = utf8_encode($famprofe4);
   $emergencia = utf8_encode($emergencia);
   $emerdirec = utf8_encode($emerdirec);
   $emernombre = utf8_encode($emernombre);
   $emerapellido = utf8_encode($emerapellido);
   //social 
   $deportes = utf8_encode($deportes);
   //economica 
   $trabajoconyugue = utf8_encode($trabajoconyugue);
   $bancos = utf8_encode($bancos);
   $bancostarjeta = utf8_encode($bancostarjeta);
   $otrosingresos = utf8_encode($otrosingresos);
   //penal 
   $motivodetenido = utf8_encode($motivodetenido);
   $dondedetenido = utf8_encode($dondedetenido);
   $cuandodetenido = utf8_encode($cuandodetenido);
   $porquedetenido = utf8_encode($porquedetenido);
   $motivoarraigado = utf8_encode($motivoarraigado);
   $dondearraigo = utf8_encode($dondearraigo);
   $cuandoarraigo = utf8_encode($cuandoarraigo);
   //laboral anterior 
   $ultimoempleo = utf8_encode($ultimoempleo);
   $dirultimoempleo = utf8_encode($dirultimoempleo);
   $pueultimoempleo = utf8_encode($pueultimoempleo);
   $empultimoempleo = utf8_encode($empultimoempleo);
   $fecultimoempleo = utf8_encode($fecultimoempleo);
   //somatometrica 
   $tez = utf8_encode($tez);
   $ojos = utf8_encode($ojos);
   $nariz = utf8_encode($nariz);
	
	/////////// DECODE ///////
   //personal 
   $nom = utf8_decode($nom);
   $ape = utf8_decode($ape);
   $profesion = utf8_decode($profesion);
   $religion = utf8_decode($religion);
   $genero = utf8_decode($genero);
   $ecivil = utf8_decode($ecivil);
   $dir1 = utf8_decode($dir1);
   $dir2 = utf8_decode($dir2);
   $sangre = utf8_decode($sangre);
   $alergia = utf8_decode($alergia);
   $email = utf8_decode($email);
   //educacion 
   $lugprimaria = utf8_decode($lugprimaria);
   $secuncarrera = utf8_decode($secuncarrera);
   $lugsecundaria = utf8_decode($lugsecundaria);
   //faminstia
	$famnombre2 = utf8_decode($famnombre2);
   $famapellido2 = utf8_decode($famapellido2);
   $famreligion2 = utf8_decode($famreligion2);
   $famdirec2 = utf8_decode($famdirec2);
   $famprofe2 = utf8_decode($famprofe2);
	$famnombre3 = utf8_decode($famnombre3);
   $famapellido3 = utf8_decode($famapellido3);
   $famreligion3 = utf8_decode($famreligion3);
   $famdirec3 = utf8_decode($famdirec3);
   $famprofe3 = utf8_decode($famprofe3);
	$famnombre4 = utf8_decode($famnombre4);
   $famapellido4 = utf8_decode($famapellido4);
   $famreligion4 = utf8_decode($famreligion4);
   $famdirec4 = utf8_decode($famdirec4);
   $famprofe4 = utf8_decode($famprofe4);
   $emergencia = utf8_decode($emergencia);
   $emerdirec = utf8_decode($emerdirec);
   $emernombre = utf8_decode($emernombre);
   $emerapellido = utf8_decode($emerapellido);
   //social 
   $deportes = utf8_decode($deportes);
   //economica 
   $trabajoconyugue = utf8_decode($trabajoconyugue);
   $bancos = utf8_decode($bancos);
   $bancostarjeta = utf8_decode($bancostarjeta);
   $otrosingresos = utf8_decode($otrosingresos);
   //penal 
   $motivodetenido = utf8_decode($motivodetenido);
   $dondedetenido = utf8_decode($dondedetenido);
   $cuandodetenido = utf8_decode($cuandodetenido);
   $porquedetenido = utf8_decode($porquedetenido);
   $motivoarraigado = utf8_decode($motivoarraigado);
   $dondearraigo = utf8_decode($dondearraigo);
   $cuandoarraigo = utf8_decode($cuandoarraigo);
   //laboral anterior 
   $ultimoempleo = utf8_decode($ultimoempleo);
   $dirultimoempleo = utf8_decode($dirultimoempleo);
   $pueultimoempleo = utf8_decode($pueultimoempleo);
   $empultimoempleo = utf8_decode($empultimoempleo);
   $fecultimoempleo = utf8_decode($fecultimoempleo);
   //somatometrica 
   $tez = utf8_decode($tez);
   $ojos = utf8_decode($ojos);
   $nariz = utf8_decode($nariz);
	/////////////////////////////////////////////////////
   
   $sql = ""; //limpieza de cadena
   
   //Eliminacion de registros enlazados anteriormente
   $sql.= $ClsFam->delete_familia($dpi);
   $sql.= $ClsFam->delete_familia_institucion($dpi);
   $sql.= $ClsEdu->delete_cursos($dpi);
   $sql.= $ClsEdu->delete_idiomas($dpi);
   $sql.= $ClsVeh->delete_vehiculos($dpi);
   $sql.= $ClsRefS->delete_referencia_social($dpi);
   //$sql.= $ClsArm->delete_armamento($codigo);
   
   //inicio del proceso de Inserci—n
   //personal
   $sql.= $ClsPer->update_personal($dpi,$nom,$ape,$nit,$profesion,$religion,$pasa,$igss,$genero,$ecivil,$depn,$paisn,$fecnac,$dir2,$munde,$tel2,$dir1,
         $mundp,$tel1,$sangre,$alergia,$cel,$email,$emernombre,$emerapellido,$emerdirec,$emertel,$emercel,
         $tcamisa,$tpantalon,$tchumpa,$tbotas,$tgorra,$estatura,$peso,$tez,$ojos,$nariz,$tlicv,$nlicv,$nlicm,"","000-00-00","000-00-00",
         $deportes);
   //$respuesta->alert("$nom,$ape");
   //economicas
   $sql.= $ClsEco->update_economica($dpi,$empleadoconyugue,$ingresosconyugue,$trabajoconyugue,$cargasfam,$casa,$costocasa,$cuentasbanco,$bancos,$tarjetascred,$bancostarjeta,$otrosingresos,$montootros,$sueldo,$descuentos,$prestamos,$saldo);
   //penal
   $sql.= $ClsPen->update_penal($dpi,$detenido,$motivodetenido,$dondedetenido,$cuandodetenido,$porquedetenido,$feclibertad,$arraigado,$motivoarraigado,$dondearraigo,$cuandoarraigo);
   //Laboral Anterior
   $sql.= $ClsLab->update_laboral_anterior($dpi,$ultimoempleo,$telultimoempleo,$dirultimoempleo,$pueultimoempleo,$empultimoempleo,$sueldoultimoempleo,$fecultimoempleo);	             
   //Familia
   $x = 1;
   //padre
   $sql.= $ClsFam->insert_familia($x,$dpi,$famnombre2,$famapellido2,$famdirec2,$famtel2,$famcel2,$famprofe2,$famreligion2,$fampais2,$padrefecnac,3);
   $x++; //aumenta el codigo del familiar
   //madre
   $sql.= $ClsFam->insert_familia($x,$dpi,$famnombre3,$famapellido3,$famdirec3,$famtel3,$famcel3,$famprofe3,$famreligion3,$fampais3,$madrefecnac,2);
   $x++; //aumenta el codigo del familiar
   //esposa
   $sql.= $ClsFam->insert_familia($x,$dpi,$famnombre4,$famapellido4,$famdirec4,$famtel4,$famcel4,$famprofe4,$famreligion4,$fampais4,$esposafecnac,1);
   
   //padre
   $sql_fam.= $ClsFam->insert_familia($x,$dpi,$famnombre2,$famapellido2,$famdirec2,$famtel2,$famcel2,$famprofe2,$famreligion2,$fampais2,$padrefecnac,3);
   $x++; //aumenta el codigo del familiar
   //madre
   $sql_fam.= $ClsFam->insert_familia($x,$dpi,$famnombre3,$famapellido3,$famdirec3,$famtel3,$famcel3,$famprofe3,$famreligion3,$fampais3,$madrefecnac,2);
   $x++; //aumenta el codigo del familiar
   //esposa
   $sql_fam.= $ClsFam->insert_familia($x,$dpi,$famnombre4,$famapellido4,$famdirec4,$famtel4,$famcel4,$famprofe4,$famreligion4,$fampais4,$esposafecnac,1);
   
   //hijos
   for($i = 1; $i <= $canthijos; $i++){
   $x++;
   //---
   $nomhijo = utf8_encode($arrnomhijo[$i]);
   $apehijo = utf8_encode($arrapehijo[$i]);
   $paishijo = utf8_encode($arrpaishijo[$i]);
   $religionhijo = utf8_encode($arrreligionhijo[$i]);
   $fecnachijo = utf8_encode($arrfecnachijo[$i]);
   //--
   $nomhijo = utf8_decode($nomhijo);
   $apehijo = utf8_decode($apehijo);
   $paishijo = utf8_decode($paishijo);
   $religionhijo = utf8_decode($religionhijo);
   $fecnachijo = utf8_decode($fecnachijo);
   $sql.= $ClsFam->insert_familia($x,$dpi,$nomhijo,$apehijo,"","","","",$religionhijo,$paishijo,$fecnachijo,4);
   //$respuesta->alert("$nomhijo,$apehijo");
   }
   //hermanos
   for($i = 1; $i <= $canthermanos; $i++){
   $x++;
    //---
   $nomhermano = utf8_encode($arrnomhermano[$i]);
   $apehermano = utf8_encode($arrapehermano[$i]);
   $paishermano = utf8_encode($arrpaishermano[$i]);
   $religionhermano = utf8_encode($arrreligionhermano[$i]);
   $fecnachermano = utf8_encode($arrfecnachermano[$i]);
   //--
   $nomhermano = utf8_decode($nomhermano);
   $apehermano = utf8_decode($apehermano);
   $paishermano = utf8_decode($paishermano);
   $religionhermano = utf8_decode($religionhermano);
   $fecnachermano = utf8_decode($fecnachermano);
   $sql.= $ClsFam->insert_familia($x,$dpi,$nomhermano,$apehermano,"","","","",$religionhermano,$paishermano,$fecnachermano,7);
   }
   
   //Familia dentro del ambito militar
   for($i = 1; $i <= $cantfaminst; $i++){
   //---
   $nomfaminst = utf8_encode($arrnomfaminst[$i]);
   $parenfaminst = utf8_encode($arrparenfaminst[$i]);
   $puestofaminst = utf8_encode($arrpuestofaminst[$i]);
   $aniofaminst = utf8_encode($arraniofaminst[$i]);
   //--
   $nomfaminst = utf8_decode($nomfaminst);
   $parenfaminst = utf8_decode($parenfaminst);
   $puestofaminst = utf8_decode($puestofaminst);
   $aniofaminst = utf8_decode($aniofaminst);
   $sql.= $ClsFam->insert_familia_institucion($i,$dpi,$nomfaminst,$parenfaminst,$puestofaminst,$aniofaminst);
   }
   //Vehiculos
   for($i = 1; $i <= $cantvehiculos; $i++){
   //---
   $tipoveh = utf8_encode($arrtipoveh[$i]);
   $marcaveh = utf8_encode($arrmarcaveh[$i]);
   $lineaveh = utf8_encode($arrlineaveh[$i]);
   $modeloveh = utf8_encode($arrmodeloveh[$i]);
   $tarjetaveh = utf8_encode($arrtarjetaveh[$i]);
   $colorveh = utf8_encode($arrcolorveh[$i]);
   $chasisveh = utf8_encode($arrchasisveh[$i]);
   $motorveh = utf8_encode($arrmotorveh[$i]);
   $placasveh = utf8_encode($arrplacasveh[$i]);
   $paisveh = utf8_encode($arrpaisveh[$i]);
   //--
   $tipoveh = utf8_decode($tipoveh);
   $marcaveh = utf8_decode($marcaveh);
   $lineaveh = utf8_decode($lineaveh);
   $modeloveh = utf8_decode($modeloveh);
   $tarjetaveh = utf8_decode($tarjetaveh);
   $colorveh = utf8_decode($colorveh);
   $chasisveh = utf8_decode($chasisveh);
   $motorveh = utf8_decode($motorveh);
   $placasveh = utf8_decode($placasveh);
   $paisveh = utf8_decode($paisveh);
   $sql.= $ClsVeh->insert_vehiculos($i,$dpi,$tipoveh,$marcaveh,$lineaveh,$modeloveh,$tarjetaveh,$colorveh,$chasisveh,$motorveh,$placasveh,$paisveh);
   }
   /*//Armamento
   for($i = 1; $i <= $cantarmas; $i++){
      $tipoarma = utf8_decode($arrtipoarma[$i]);
      $marcaarma = utf8_decode($arrmarcaarma[$i]);
      $calarma = utf8_decode($arrcalarma[$i]);
      $numarma = utf8_decode($arrnumarma[$i]);
      $sql.= $ClsArm->insert_armamento($i,$codigo,$tipoarma,$marcaarma,$calarma,$numarma);
   }*/
     //Educacion
   $sql.= $ClsEdu->update_educacion($dpi,$primaria,$lugprimaria,$secundaria,$lugsecundaria,$secuncarrera);
   $x = 1;
   //titulos universitarios
   for($i = 1; $i <= $canttitulos; $i++){
     //---
     $nivelu = utf8_encode($arrnivelu[$i]);
     $titulo = utf8_encode($arrtitulo[$i]);
     $unversidad = utf8_encode($arrunversidad[$i]);
     $paistit = utf8_encode($arrpaistit[$i]);
     $aniotit = utf8_encode($arraniotit[$i]);
     $semtit = utf8_encode($arrsemtit[$i]);
     $graduadotit = utf8_encode($arrgraduadotit[$i]);
     //--
     $nivelu = utf8_decode($nivelu);
     $titulo = utf8_decode($titulo);
     $unversidad = utf8_decode($unversidad);
     $paistit = utf8_decode($paistit);
     $aniotit = utf8_decode($aniotit);
     $semtit = utf8_decode($semtit);
     $graduadotit = utf8_decode($graduadotit);
     $sql.= $ClsEdu->insert_cursos($x,$dpi,"U",$nivelu,$titulo,$unversidad,$paistit,$aniotit,$semtit,$graduadotit);
     $x++;
   }
   //Cursos
   for($i = 1; $i <= $cantotroscursos; $i++){
     //---
     $nivelciv = utf8_encode($arrnivelciv[$i]);
     $otrocurso = utf8_encode($arrotrocurso[$i]);
     $instituto = utf8_encode($arrinstituto[$i]);
     $paisotrocur = utf8_encode($arrpaisotrocur[$i]);
     $aniootrocur = utf8_encode($arraniootrocur[$i]);
     //--
     $nivelciv = utf8_decode($nivelciv);
     $otrocurso = utf8_decode($otrocurso);
     $instituto = utf8_decode($instituto);
     $paisotrocur = utf8_decode($paisotrocur);
     $aniootrocur = utf8_decode($aniootrocur);
     $sql.= $ClsEdu->insert_cursos($x,$dpi,"C",$nivelciv,$otrocurso,$instituto,$paisotrocur,$aniootrocur,"","");
     $x++;
   }
   //Idioma
   for($i = 1; $i <= $cantidiomas; $i++){
     //---
     $idioma = utf8_encode($arridioma[$i]);
     $habla = utf8_encode($arrhabla[$i]);
     $lee = utf8_encode($arrlee[$i]);
     $escribe = utf8_encode($arrescribe[$i]);
     //--
     $idioma = utf8_decode($idioma);
     $habla = utf8_decode($habla);
     $lee = utf8_decode($lee);
     $escribe = utf8_decode($escribe);
     $sql.= $ClsEdu->insert_idiomas($i,$dpi,$idioma,$habla,$lee,$escribe);
   }
   //Referencias Sociales
   for($i = 1; $i <= $cantrefsocial; $i++){
     //---
     $nomsocial = utf8_encode($arrnomsocial[$i]);
     $dirsocial = utf8_encode($arrdirsocial[$i]);
     $telsocial = utf8_encode($arrtelsocial[$i]);
     $trabajosocial = utf8_encode($arrtrabajosocial[$i]);
     $cargosocial = utf8_encode($arrcargosocial[$i]);
     //--
     $nomsocial = utf8_decode($nomsocial);
     $dirsocial = utf8_decode($dirsocial);
     $telsocial = utf8_decode($telsocial);
     $trabajosocial = utf8_decode($trabajosocial);
     $cargosocial = utf8_decode($cargosocial);
     $sql.= $ClsRefS->insert_referencia_social($i,$dpi,$nomsocial,$dirsocial,$telsocial,$trabajosocial,$cargosocial);
   }

   //$respuesta->alert($sql2);
   $rs = $ClsPer->exec_sql($sql);
   if($rs==1){
     $usu = $_SESSION["codigo"];
     $hashkey = $ClsPer->encrypt($dpi, $usu);
     $respuesta->script('swal("Excelente", "Datos actualizados con exito!", "success").then((value)=>{ window.location.reload(); });');
   }else{
     $respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
   }
      
   return $respuesta;
}


function Buscar_Personal($id,$nom,$ape,$ced,$dpi,$nit,$lic,$igss,$irtra,$depto,$suc){
   $respuesta = new xajaxResponse();
   $ClsPer = new ClsPersonal();
   $cont = $ClsPer->count_personal($id,$nom,$ape,$ced,$dpi,$nit,$lic,$igss,$irtra,$plaza,$depto,$suc);
   if($cont>0){
		$respuesta->script("cerrarPromt();");
		$contenido = tabla_personal(1,$id,$nom,$ape,$ced,$dpi,$nit,$lic,$igss,$irtra,$plaza,$depto,$suc);
		$respuesta->assign("cuerpo","innerHTML",$contenido);
		$respuesta->script("cerrar();");
   }else{
		$respuesta->script('swal("Error", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
   }	
      return $respuesta;
}

////////////////////////////////////////////////
///////////////////////////////////////////////////

////----------Utilitarias-------//////////////////////
$xajax->register(XAJAX_FUNCTION, "depmun");
$xajax->register(XAJAX_FUNCTION, "Grid_Filas_Armamento");
$xajax->register(XAJAX_FUNCTION, "Grid_Filas_Vehiculos");
$xajax->register(XAJAX_FUNCTION, "Grid_Filas_Hijos");
$xajax->register(XAJAX_FUNCTION, "Grid_Filas_Hermanos");
$xajax->register(XAJAX_FUNCTION, "Grid_Filas_Faminst");
$xajax->register(XAJAX_FUNCTION, "Grid_Filas_Refsocial");
$xajax->register(XAJAX_FUNCTION, "Grid_Filas_Titulos");
$xajax->register(XAJAX_FUNCTION, "Grid_Filas_Idiomas");
$xajax->register(XAJAX_FUNCTION, "Grid_Filas_Cursos");
$xajax->register(XAJAX_FUNCTION, "Grid_Filas_Otros_Cursos");
////----------Personal-------//////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Personal");
$xajax->register(XAJAX_FUNCTION, "Modificar_Personal");
$xajax->register(XAJAX_FUNCTION, "Buscar_Personal");

//El objeto xajax tiene que procesar cualquier petici—n
$xajax->processRequest();

?>  