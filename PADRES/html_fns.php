<?php
ini_set("memory_limit","512M");
//-- SISTEMA --
include_once('user_auth_fns.php');
require_once("recursos/fpdf/pdf.php");
require_once("Clases/ClsNumLetras.php");
//--CLASES DEL SISTEMA
require_once("Clases/ClsRegla.php");
require_once("Clases/ClsVersion.php");
require_once("Clases/ClsPais.php");
require_once("Clases/ClsMundep.php");
require_once("Clases/ClsUsuario.php");
require_once("Clases/ClsPermiso.php");
require_once("Clases/ClsRoll.php");
require_once("Clases/ClsBitacora.php");
require_once("Clases/ClsPushup.php");
/////---- SCHOOLAPP ---////////
require_once("Clases/ClsPadre.php");
require_once("Clases/ClsMaestro.php");
require_once("Clases/ClsAlumno.php");
require_once("Clases/ClsSeguro.php");
require_once("Clases/ClsOtrosUsu.php");
require_once("Clases/ClsMonitorBus.php");
require_once("Clases/ClsGrupoClase.php");
require_once("Clases/ClsArea.php");
require_once("Clases/ClsAsignacion.php");
require_once("Clases/ClsMensaje.php");
require_once("Clases/ClsInformacion.php");
require_once("Clases/ClsCalendario.php");
require_once("Clases/ClsTarea.php");
require_once("Clases/ClsPostit.php");
require_once("Clases/ClsPhoto.php");
require_once("Clases/ClsMultimedia.php");
require_once("Clases/ClsEncuesta.php");
require_once("Clases/ClsAsistencia.php");
require_once("Clases/ClsChat.php");
require_once("Clases/ClsCircular.php");
require_once("Clases/ClsPanial.php");
require_once("Clases/ClsGolpe.php");
require_once("Clases/ClsEnfermedad.php");
require_once("Clases/ClsConducta.php");
require_once("Clases/ClsIncidente.php");
/////---- INSCRIPCIONES ---////////
require_once("Clases/ClsInscripcion.php");
//--temporales
require_once("Clases/ClsTempAlumno.php");
require_once("Clases/ClsTempBoletaCobro.php");
//-- ACADEMICO
require_once("Clases/ClsPensum.php");
require_once("Clases/ClsAcademico.php");
require_once("Clases/ClsNotas.php");
require_once("Clases/ClsAula.php");
//-- LMS
require_once("Clases/ClsCursoLibre.php");
require_once("Clases/ClsExamen.php");
//-- INVENTARIO
require_once("Clases/ClsArticulo.php");
require_once("Clases/ClsServicio.php");
require_once("Clases/ClsInventario.php");
require_once("Clases/ClsArticuloPropio.php");
require_once("Clases/ClsSuministro.php");
require_once("Clases/ClsInventarioSuministro.php");
require_once("Clases/ClsUmedida.php");
//-- FINANCIERO Y ADMINISTRATIVO
require_once("Clases/ClsPeriodoFiscal.php");
require_once("Clases/ClsMoneda.php");
require_once("Clases/ClsProveedor.php");
require_once("Clases/ClsCliente.php");
require_once("Clases/ClsProyecto.php");
require_once("Clases/ClsVenta.php");
require_once("Clases/ClsPuntoVenta.php");
require_once("Clases/ClsFactura.php");
require_once("Clases/ClsRecibo.php");
require_once("Clases/ClsPago.php");
require_once("Clases/ClsCredito.php");
require_once("Clases/ClsVntCredito.php");
require_once("Clases/ClsPartida.php");
require_once("Clases/ClsConta.php");
require_once("Clases/ClsCompra.php");
require_once("Clases/ClsBanco.php");
require_once("Clases/ClsCaja.php");
require_once("Clases/ClsTipoCuenta.php");
require_once("Clases/ClsPresupuesto.php");
require_once("Clases/ClsBoletaCobro.php");
require_once("Clases/ClsDivision.php");
require_once("Clases/ClsMora.php");
require_once("Clases/ClsBoletaFace.php");
//-- ORGANIZACION --
require_once("Clases/ClsEmpresa.php");
require_once("Clases/ClsDepartamento.php");
require_once("Clases/ClsOrganizacion.php");
//-- SALARIOS --
require_once("Clases/ClsPlanilla.php");
require_once("Clases/ClsPlanillaAsignaciones.php");
//require_once("Clases/ClsOrganizacion.php");
//-- ISP --//
require_once("Clases/ClsPersonal.php");
require_once("Clases/ClsArmamento.php");
require_once("Clases/ClsEconomica.php");
require_once("Clases/ClsFamilia.php");
require_once("Clases/ClsLaboral.php");
require_once("Clases/ClsPenal.php");
require_once("Clases/ClsRefSocial.php");
require_once("Clases/ClsVehiculo.php");
require_once("Clases/ClsEducacion.php");
//-- HORARIO Y JORNALIZACION
require_once("Clases/ClsHorario.php");
//-- FICHA INFANTIL
require_once("Clases/ClsFicha.php");
//-- VIDEOCLASE
require_once("Clases/ClsVideoclase.php");


//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////

//////////////////////// MODULO DE ORGANIZACION ////////////////////////

function sucursal_html($id,$acc='') {
	$ClsSuc = new ClsEmpresa();
	$result = $ClsSuc->get_sucursal('','','','','','1');
	if(is_array($result)){
		return combos_html_onclick($result,"$id",'suc_id','suc_nombre',$acc);
	}else{
		return combos_vacios("$id");
	}
}


function organizacion_departamento_html($id,$suc,$acc='') {
	$ClsDep = new ClsDepartamento();
	$result = $ClsDep->get_departamento('',$suc,'','',1);
	if(is_array($result)){
		return combos_html_onclick($result,"$id",'dep_id','dep_desc_lg',$acc);
	}else{
		return combos_vacios("$id");
	}
}


//////////////////////// MODULO CONTABLE ////////////////////////

function serie_html($id,$acc='') {
	$ClsFac = new ClsFactura();
	$result = $ClsFac->get_serie('');
	
	if(is_array($result)){
		return combos_html_onclick($result,"$id","ser_codigo","ser_numero",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function punto_venta_html($suc,$id,$acc='') {
	$ClsPVenta = new ClsPuntoVenta();
	$result = $ClsPVenta->get_punto_venta('',$suc,'',1);
	
	if($suc != ''){	
		if(is_array($result) || $suc != ''){
			return combos_html_onclick($result,"$id","pv_codigo","pv_nombre",$acc);
		}else{
			return combos_vacios("$id");
		}
	}else{
		return combos_vacios("$id");
	}
	return $salida;
}


function moneda_html($id,$acc='') {
	$ClsMon = new ClsMoneda();
	$result = $ClsMon->get_moneda("");
	
	if(is_array($result)){
		return combos_html_onclick($result,"$id","mon_id","mon_desc",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function moneda_transacciones_html($id,$acc='') {
	$ClsMon = new ClsMoneda();
	$result = $ClsMon->get_moneda("");
	
	if(is_array($result)){
		if($result) {
			$salida .= '<select name="'.$id.'" id="'.$id.'" class = "form-control" onchange = "'.$acc.'">';
			if(is_array($result)){
				foreach ($result as $row) {
					$desc = utf8_encode($row["mon_desc"])." / ".utf8_encode($row["mon_simbolo"]).". / (".utf8_encode($row["mon_cambio"])." x 1) ";
					$salida .= '<option value='.$row["mon_id"].'>'.$desc.'</option>';
				}
			}
			$salida .='</select>';
		}else{
			return combos_vacios("$id");
		}
	}
	return $salida;
}


function tipo_pago_html($i='',$acc='') {
	$ClsPag= new ClsPago();
	$result = $ClsPag->get_tipo_pago();
	
	if(is_array($result)){
		return combos_html_onclick($result,"tpag$i",'tpago_codigo','tpago_desc_md',$acc);
	}else{
		return combos_vacios("tpag$i");
	}
}

function paises_html($id='',$acc='') {
	$ClsPai = new ClsPais();
	$result = $ClsPai->get_paises();
	
	if(is_array($result)){
		return combos_html_onclick($result,"$id","pai_id","pai_desc",$acc);
	}else{
		return combos_vacios("$id");
	}
}

function departamento_html($id,$acc='') {
	$ClsMdep = new ClsMundep();
		$result = $ClsMdep->get_departamentos();
		return combos_html_onclick($result,$id,'dm_codigo','dm_desc',$acc);
}


function municipio_html($dep,$id) {
	$ClsMdep = new ClsMundep();
		$result = $ClsMdep->get_municipios($dep);
		return combos_html_onclick($result,$id,'dm_codigo','dm_desc','');
}



function grupo_art_html($id='',$acc='') {
	$ClsArt = new ClsArticulo();
	$result = $ClsArt->get_grupo("","",1);
	
	return combos_html_onclick($result,"$id",'gru_codigo','gru_nombre',$acc);
}


function articulo_html($gru,$id='',$acc='') {
	$ClsArt = new ClsArticulo();
	$result = $ClsArt->get_articulo("",$gru);
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,"art_codigo","art_nombre",$acc);
	}else{
		return combos_vacios("$id");
	}
}

function grupo_serv_html($id='',$acc='') {
	$ClsSer = new ClsServicio();
	$result = $ClsSer->get_grupo("","",1);
	
	if(is_array($result)){
		return combos_html_onclick($result,"$id","gru_codigo","gru_nombre",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function grupo_articulo_propio_html($id='',$acc='') {
	$ClsArt = new ClsArticuloPropio();
	$result = $ClsArt->get_grupo("","",1);
	
	if(is_array($result)){
		return combos_html_onclick($result,"$id","gru_codigo","gru_nombre",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function articulo_propio_html($gru,$id,$acc='') {
	$ClsArt = new ClsArticuloPropio();
	$result = $ClsArt->get_articulo("",$gru);
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,"art_codigo","art_nombre",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function grupo_suministro_html($id,$acc='') {
	$ClsArt = new ClsSuministro();
	$result = $ClsArt->get_grupo("","",1);
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,"gru_codigo","gru_nombre",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function suministro_html($gru,$id,$acc='') {
	$ClsArt = new ClsSuministro();
	$result = $ClsArt->get_articulo("",$gru);
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,"art_codigo","art_nombre",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function partida_html_demas($class,$id,$acc='') { //////////////////////////////////////////
	$ClsPar = new ClsPartida();
	$result = $ClsPar->get_partida("","E",$class,"",1);
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,'par_codigo','par_desc',$acc);
	}else{
		return combos_vacios("$id");
	}
}


function partida_html($tipo,$class,$id,$acc='') {
	$ClsPar = new ClsPartida();
	$result = $ClsPar->get_partida("",$tipo,$class,"",1);
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,"par_codigo","par_desc",$acc);
	}else{
		return combos_vacios("$id");
	}
}

function reglon_html($par,$id,$acc='') {
	$ClsPar = new ClsPartida();
	$result = $ClsPar->get_reglon("",$par,"","",1);
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,"reg_codigo","reg_desc_lg",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function banco_html($id,$acc='') {
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_banco("","","","",1);
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,"ban_codigo","ban_desc_ct",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function banco_html_onclick($id,$idcue,$idscue,$onclick='') {
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_banco("","","","",1);
	
	return combos_html_onclick($result,$id,'ban_codigo','ban_desc_ct','xajax_Combo_Cuenta_Banco(this.value,\''.$idcue.'\',\''.$idscue.'\',\''.$onclick.'\')');
}


function cuenta_banco_html($ban,$id,$acc='') {
	$ClsBan = new ClsBanco();
	$result = $ClsBan->get_cuenta_banco('',$ban,'','','','',1);
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,"cueb_codigo","cueb_nombre",$acc);
	}else{
		return combos_vacios("$id");
	}
}

function division_grupo_html($id,$acc='') {
	$ClsDiv = new ClsDivision();
	$result = $ClsDiv->get_grupo("","",1);

	if(is_array($result)){
		return combos_html_onclick($result,$id,"gru_codigo","gru_nombre",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function division_html($grupo,$id,$acc='') {
	$ClsDiv = new ClsDivision();
	$result = $ClsDiv->get_division('',$grupo,'',1);

	if(is_array($result)){
		return combos_html_onclick($result,$id,"div_codigo","div_nombre",$acc);
	}else{
		return combos_vacios("$id");
	}
}



function caja_sucursal_html($suc,$id,$acc='') {
	$ClsCaj = new ClsCaja();
	$result = $ClsCaj->get_caja('',$suc,'',1);
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,"caja_codigo","caja_descripcion",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function tipo_cuenta_html($id,$acc='') {
	$ClsTCue = new ClsTipoCuenta();
	$result = $ClsTCue->get_tipo_cuenta();
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,"tcue_codigo","tcue_desc_lg",$acc);
	}else{
		return combos_vacios("$id");
	}
}


function umedida_html($clase,$id,$acc='') {
	$ClsUmed = new ClsUmedida();
	$result = $ClsUmed->get_unidad($clase);
	
	if(is_array($result)){
		return combos_html_onclick($result,$id,"u_codigo","u_desc_lg",$acc);
	}else{
		return combos_vacios("$id");
	}
}


////////////////////////////////////////////////////////////////


///combos y funciones auxiliares

function Roll_html($i='') {
	$ClsRoll = new ClsRoll();
	$result = $ClsRoll->get_roll_libre('');
	
	if(is_array($result)){
		$result = $ClsRoll->get_roll_libre('');
		return combos_html_onclick($result,"rol$i",'roll_id','roll_nombre','abrir();xajax_Cuadro_Permisos_Rol(this.value)');
	}else{
		return combos_vacios("rol$i");
	}
}

function Grupos_html($i='') {
	$ClsPerm = new ClsPermiso();
	$result = $ClsPerm->get_grupo("");
	
	if(is_array($result)){
		return combos_html_onclick($result,"gru$i","gperm_id","gperm_desc","");
	}else{
		return combos_vacios("gru$i");
	}
}

function Area_html($id='',$acc='') {
	$ClsArea = new ClsArea();
	$result = $ClsArea->get_area("","","","",1);
	
	if(is_array($result)){
		return combos_html_onclick($result,"$id","are_codigo","are_nombre",$acc);
	}else{
		return combos_vacios("area$i");
	}
}

function Segmento_html($id='',$area='',$acc='') {
	$ClsArea = new ClsArea();
	$result = $ClsArea->get_segmento("",$area,"",1);
	
	if(is_array($result)){
		return combos_html_onclick($result,"$id","seg_codigo","seg_nombre",$acc);
	}else{
		return combos_vacios("segmento$i");
	}
}

function Grupos_Clase_html($id='',$area='',$segmento='',$acc='') {
	$ClsGruCla = new ClsGrupoClase();
	$result = $ClsGruCla->get_grupo_clase("","",$area,$segmento,1);
	
	if(is_array($result)){
		return combos_html_onclick($result,"$id","gru_codigo","gru_nombre",$acc);
	}else{
		return combos_vacios("gru$i");
	}
}



//---
function grupos_maestro_lista_multiple($id,$maestro) {
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_maestro_grupo("",$maestro,1);
		
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gru_codigo","gru_nombre","Listado de Grupos ya Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}

function grupos_no_maestro_lista_multiple($id,$area,$grupos) {
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_not_maestro_grupo($area,$grupos);
	
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gru_codigo","gru_nombre","Listado de Grupos no Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}

//--
function grupos_usuario_lista_multiple($id,$usuario) {
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_usuario_grupo("",$usuario,1);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gru_codigo","gru_nombre","Listado de Grupos ya Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}

function grupos_no_usuario_lista_multiple($id,$area,$grupos) {
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_not_usuario_grupo($area,$grupos);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gru_codigo","gru_nombre","Listado de Grupos no Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}

//--
function grupos_monitor_lista_multiple($id,$monitor) {
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_monitor_bus_grupo("",$monitor,1);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gru_codigo","gru_nombre","Listado de Grupos ya Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}

function grupos_no_monitor_lista_multiple($id,$area,$grupos) {
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_not_monitor_bus_grupo($area,$grupos);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gru_codigo","gru_nombre","Listado de Grupos no Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}


//--
function grupos_alumno_lista_multiple($id,$cui) {
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_alumno_grupo("",$cui,1);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gru_codigo","gru_nombre","Listado de Grupos ya Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}

function grupos_no_alumno_lista_multiple($id,$area,$grupos) {
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_not_alumno_grupo($area,$grupos);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gru_codigo","gru_nombre","Listado de Grupos no Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}

//--
function secciones_maestro_lista_multiple($id,$pensum,$nivel,$grado,$maestro) {
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->comprueba_seccion_maestro($pensum,$nivel,$grado,"","",$maestro,"",1);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"sec_codigo","sec_descripcion","Listado de Grupos ya Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}

function secciones_no_maestro_lista_multiple($id,$pensum,$nivel,$grado,$tipo,$secciones) {
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->comprueba_no_seccion_maestro($pensum,$nivel,$grado,$tipo,$secciones);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"sec_codigo","sec_descripcion","Listado de Grupos no Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}
//--

//--
function grados_otros_usuarios_lista_multiple($id,$pensum,$nivel,$otrousu) {
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->comprueba_grado_otros_usuarios($pensum,$nivel,'',$otrousu);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gra_codigo","gra_descripcion","Listado de Grados ya Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grados");
	}
}

function grados_no_otros_usuarios_lista_multiple($id,$pensum,$nivel,$grados) {
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->comprueba_no_grado_otros_usuarios($pensum,$nivel,$grados);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gra_codigo","gra_descripcion","Listado de Grados no Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grados");
	}
}
//--

function materias_maestro_lista_multiple($id,$pensum,$nivel,$grado,$maestro) {
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->comprueba_materia_maestro($pensum,$nivel,$grado,"","",$maestro,"",1);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"mat_codigo","mat_descripcion","Listado de Materias ya Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}

function materias_no_maestro_lista_multiple($id,$pensum,$nivel,$grado,$tipo,$materias) {
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->comprueba_no_materia_maestro($pensum,$nivel,$grado,$tipo,$materias);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"mat_codigo","mat_descripcion","Listado de Materias no Asignados");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
}
//--

function grupos_lista_multiple($id) {
	$ClsGruCla = new ClsGrupoClase();
	$result = $ClsGruCla->get_grupo_clase("","",$area,$segmento,1);
	
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gru_codigo","gru_nombre","Listado de Grupos");
	}else{
		return lista_multiple_vacia($id," Listado de Grupos");
	}
		
}


function grados_lista_multiple($id) {
	$ClsPen = new ClsPensum();
	$pensum = $_SESSION["pensum"];
	$result = $ClsPen->get_grado($pensum,"","",1);
	
	if(is_array($result)){
		return lista_multiple_html($result,$id,"gra_nomenclatura","gra_descripcion","Listado de Grados");
	}else{
		return lista_multiple_vacia($id," Listado de Grados");
	}		
}


//-- SALARIOS --
function personal_tipo_nomina_lista_multiple($id,$tipo) {
	$ClsPla = new ClsPlanilla();
	$result = $ClsPla->get_personal_tipo_nomina('',$tipo);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"per_dpi","nombre_completo","Listado de Personal ya Asignado");
	}else{
		return lista_multiple_vacia($id," Listado de Personal");
	}
}

function personal_no_tipo_nomina_lista_multiple($id,$tipo,$personal) {
	$ClsPla = new ClsPlanilla();
	$result = $ClsPla->get_not_personal_tipo_nomina($personal,$tipo);
	if(is_array($result)){
		return lista_multiple_html($result,$id,"per_dpi","nombre_completo","Listado de Personal no Asignado");
	}else{
		return lista_multiple_vacia($id," Listado de Personal");
	}
}

function tipo_nomina_planilla_html($id,$acc="") {
	$ClsPla = new ClsPlanilla();
		$result = $ClsPla->get_tipo_nomina("","",1);
		return combos_html_onclick($result,$id,'tip_codigo','tip_descripcion',$acc);
}

/////////////// Inscripciones en Linea ///////////////////////////////////


function inscripcion_nivel_html($id,$acc="") {
	$ClsIns = new ClsInscripcion();
		$result = $ClsIns->get_nivel("",1);
		return combos_html_onclick($result,$id,'niv_codigo','niv_descripcion',$acc);
}

function inscripcion_grado_html($nivel,$id,$acc="") {
	$ClsIns = new ClsInscripcion();
		$result = $ClsIns->get_grado($nivel,"",1);
		return combos_html_onclick($result,$id,'gra_codigo','gra_descripcion',$acc);
}


/////////////// Academico ///////////////////////////////////

function pensum_html($id,$acc="") {
	$ClsPen = new ClsPensum();
		$result = $ClsPen->get_pensum("","",1);
		return combos_html_onclick($result,$id,'pen_codigo','pen_descripcion_completa',$acc);
}


function nivel_html($pensum,$id,$acc="") {
	$ClsPen = new ClsPensum();
		$result = $ClsPen->get_nivel($pensum,"",1);
		return combos_html_onclick($result,$id,'niv_codigo','niv_descripcion',$acc);
}

function grado_html($pensum,$nivel,$id,$acc="") {
	$ClsPen = new ClsPensum();
		$result = $ClsPen->get_grado($pensum,$nivel,"",1);
		return combos_html_onclick($result,$id,'gra_codigo','gra_descripcion',$acc);
}


function materia_html($pensum,$nivel,$grado,$id,$acc="") {
	$ClsPen = new ClsPensum();
		$result = $ClsPen->get_materia($pensum,$nivel,$grado,"","",1);
		return combos_html_onclick($result,$id,'mat_codigo','mat_descripcion',$acc);
}


function seccion_html($pensum,$nivel,$grado,$tipo,$id,$acc="") {
	$ClsPen = new ClsPensum();
		$result = $ClsPen->get_seccion($pensum,$nivel,$grado,"",$tipo,1);
		return combos_html_onclick($result,$id,'sec_codigo','sec_descripcion',$acc);
}


function parcial_html($pensum,$nivel,$grado,$materia,$id,$acc="") {
	$ClsAcad = new ClsAcademico();
		$result = $ClsAcad->get_parcial($pensum,$nivel,$grado,$materia,"","","",1);
		return combos_html_onclick($result,$id,'par_codigo','par_descripcion',$acc);
}


function aula_html($pensum,$nivel,$id,$acc="") {
	$ClsAul = new ClsAula();
		$result = $ClsAul->get_aula("",$nivel);
		return combos_html_onclick($result,$id,'aul_codigo','aul_descripcion',$acc);
}


function materia_lista_html($pensum,$nivel,$grado,$id,$titulo="") {
	$ClsPen = new ClsPensum();
		$result = $ClsPen->get_materia($pensum,$nivel,$grado,"","",1);
		return lista_multiple_html($result,$id,'mat_codigo','mat_descripcion',$titulo);
}


function tipo_periodo_html($pensum,$nivel,$id='',$acc='') {
	$ClsHor= new ClsHorario();
	$result = $ClsHor->get_tipo_periodo("",$pensum,$nivel);
	
	if(is_array($result)){
		return combos_html_onclick($result,"$id",'tip_codigo','tip_descripcion',$acc);
	}else{
		return combos_vacios("$id");
	}
}

function periodo_fiscal_html($id,$acc="") {
	$ClsPer = new ClsPeriodoFiscal();
	$result = $ClsPer->get_periodo("","",1);
	return combos_html_onclick($result,$id,'per_codigo','per_descripcion_completa',$acc);
}


function input_fecha($name,$fila,$instruc) {
	$salida .= '<input type="text" class="form-control" id = "'.$name.'dia'.$fila.'" name="'.$name.'dia'.$fila.'" onblur = "'.$instruc.'" placeholder = "D&iacute;a"  style = "width: 33%" />';
	$salida .= '<input type="hidden" id = "'.$name.''.$fila.'" name="'.$name.''.$fila.'" />';
	//mes
	$salida .='<select name="'.$name.'mes'.$fila.'" id="'.$name.'mes'.$fila.'" class="form-control" onchange = "'.$instruc.'" style = "width: 34%" >';
	$salida .='<option value="">Mes</option>';
	$salida .='<option value="01">ENERO</option>';
	$salida .='<option value="02">FEBRERO</option>';
	$salida .='<option value="03">MARZO</option>';
	$salida .='<option value="04">ABRIL</option>';
	$salida .='<option value="05">MAYO</option>';
	$salida .='<option value="06">JUNIO</option>';
	$salida .='<option value="07">JULIO</option>';
	$salida .='<option value="08">AGOSTO</option>';
	$salida .='<option value="09">SEPTIEMBRE</option>';
	$salida .='<option value="10">OCTUBRE</option>';
	$salida .='<option value="11">NOVIEMBRE</option>';
	$salida .='<option value="12">DICIEMBRE</option>';
	$salida .='</select>';
	///anio
    $salida .= '<select name="'.$name.'anio'.$fila.'" id="'.$name.'anio'.$fila.'" class="form-control" onchange = "'.$instruc.'" style = "width: 33%" >';
	for($i = 1900; $i <= date("Y"); $i++) {
		$selected = ( $i == date("Y"))?"selected":"";
		$salida .= '<option value='.$i.' '.$selected.'>'.$i.'</option>';
	}
	$salida .='</select>';
	
	return $salida;
}


function horario_lista_multiple($fecha) {
	$ClsHor = new ClsHorario();
	$result = $ClsHor->get_horario($fecha,"","");
		$i = 1;
		$salida .= '<div class="list-group">';
		$salida .= '<span class="list-group-item active">';
		$salida .= '<input type = "checkbox" name="horariobase" id="horariobase" onclick = "check_lista_multiple(\'horario\');" />';
		$salida .= ' '.$titulo.'</span>';
		if(is_array($result)){
			foreach ($result as $row) {
				$salida .= '<a href="javascript:void(0)" class="list-group-item text-left">';
				$salida .= '<input type = "checkbox" name="horario'.$i.'" id="horario'.$i.'" value="'.$row["hor_fecha"].'|'.$row["hor_periodo"].'|'.$row["hor_dia"].'" />';
				$salida .= ' <small>'.$row["per_hini"].' - '.$row["per_hfin"].' ('.$row["tip_descripcion"].')</small></a>';
				$i++;
			}
			$i--;
			$salida .= '<span class="list-group-item disabled text-right">';
			$salida .= '<input type = "hidden" name="horariorows" id="horariorows" value='.$i.' />';
			$salida .= $i.' Registro(s)</span>';
		}else{
			$salida .= '<a href="javascript:void(0)" class="list-group-item text-left">';
			$salida .= '<input type = "checkbox" name="horario0" id="horario0" value = "" disabled />';
			$salida .= ' <small>No se reportan registros...</small></a>';
			$salida .= '<span class="list-group-item disabled text-right">';
			$salida .= '<input type = "hidden" name="horariorows" id="horariorows" value="0" />';
			$salida .= '0 Registro(s)</span>';
		}	
		$salida .= '</div>';
		
	return $salida;
}


/////////////// -- ///////////////////////////////////


function combos_html_onclick($result_id,$name,$c1,$c2,$instruc) {

    if($result_id) {
		$salida .= '<select name="'.$name.'" id="'.$name.'" class = "form-control" onchange = "'.$instruc.'">';
		$salida .= '<option value="">Seleccione</option>';
		if(is_array($result_id)){
			foreach ($result_id as $row) {
		   
				$salida .= '<option value='.utf8_decode($row[$c1]).'>'.utf8_decode($row[$c2]).'</option>';
			}
		}
		$salida .='</select>';
    }else{
		$salida .= '<select name="'.$name.'" id="'.$name.'" class = "form-control">';
		$salida .= '<option value="">Seleccione</option>';
		$salida .='</select>';
	}
	return $salida;

}


function combos_vacios($name) {

	$salida .= '<select name="'.$name.'" id="'.$name.'" class = "form-control">';
	$salida .= '<option value="">Seleccione</option>';
	$salida .='</select>';
	
	return $salida;
}


function lista_multiple_html($result_id,$name,$c1,$c2,$titulo) {

    if($result_id) {
		$i = 1;
		$salida .= '<div class="list-group">';
		$salida .= '<span class="list-group-item active">';
		$salida .= '<input type = "checkbox" name="'.$name.'base" id="'.$name.'base" onclick = "check_lista_multiple(\''.$name.'\');" />';
		$salida .= ' '.$titulo.'</span>';
		if(is_array($result_id)){
			foreach ($result_id as $row) {
				$salida .= '<a href="javascript:void(0)" class="list-group-item text-left">';
				$salida .= '<input type = "checkbox" name="'.$name.''.$i.'" id="'.$name.''.$i.'" value="'.$row[$c1].'" />';
				$salida .= ' <small>'.utf8_decode($row[$c2]).'</small></a>';
				$i++;
			}
			$i--;
			$salida .= '<span class="list-group-item disabled text-right">';
			$salida .= '<input type = "hidden" name="'.$name.'rows" id="'.$name.'rows" value='.$i.' />';
			$salida .= $i.' Registro(s)</span>';
		}else{
			$salida .= '<a href="javascript:void(0)" class="list-group-item text-left">';
			$salida .= '<input type = "checkbox" name="'.$name.'0" id="'.$name.'0" value = "" disabled />';
			$salida .= ' <small>No se reportan registros...</small></a>';
			$salida .= '<span class="list-group-item disabled text-right">';
			$salida .= '<input type = "hidden" name="'.$name.'rows" id="'.$name.'rows" value="0" />';
			$salida .= '0 Registro(s)</span>';
		}	
		$salida .= '</div>';
		
		
		
	}else{
		$salida .= '<div class="list-group">';
		$salida .= '<span class="list-group-item active">';
		$salida .= '<input type = "checkbox" name="'.$name.'base" id="'.$name.'base" onclick = "check_lista_multiple(\''.$name.'\');" />';
		$salida .= ' '.$titulo.'</span>';
			$salida .= '<a href="javascript:void(0)" class="list-group-item text-left">';
			$salida .= '<input type = "checkbox" name="'.$name.'0" id="'.$name.'0" value = "" disabled />';
			$salida .= ' <small>No se reportan registros...</small></a>';
			$salida .= '<span class="list-group-item disabled text-right">';
			$salida .= '<input type = "hidden" name="'.$name.'rows" id="'.$name.'rows" value="0" />';
			$salida .= '0 Registro(s)</span>';
		$salida .= '</div>';
	}
	return $salida;

}


function lista_multiple_vacia($name,$titulo) {

	$salida .= '<div class="list-group">';
		$salida .= '<span class="list-group-item active">';
		$salida .= '<input type = "checkbox" name="'.$name.'base" id="'.$name.'base" onclick = "check_lista_multiple(\''.$name.'\');" />';
		$salida .= ' '.$titulo.'</span>';
		$salida .= '<a href="javascript:void(0)" class="list-group-item text-left">';
		$salida .= '<input type = "checkbox" name="'.$name.'0" id="'.$name.'0" value = "" disabled />';
		$salida .= ' <small>No se reportan registros...</small></a>';
		$salida .= '<span class="list-group-item disabled text-right">';
		$salida .= '<input type = "hidden" name="'.$name.'rows" id="'.$name.'rows" value="0" />';
		$salida .= '0 Registro(s)</span>';
	$salida .= '</div>';
	
	return $salida;

}



function lista_combo_html_onclick($result_id,$name,$c1,$c2,$instruc) {

    if($result_id) {
		$salida .= '<select name="'.$name.'" id="'.$name.'" class="form-control" multiple="" onchange = "'.$instruc.'">';
		if(is_array($result_id)){
			foreach ($result_id as $row) {
		   
				$salida .= '<option value='.utf8_decode($row[$c1]).'>'.utf8_decode($row[$c2]).'</option>';
			}
		}
		$salida .='</select>';
    }else{
		$salida .= '<select name="'.$name.'" id="'.$name.'" class = "form-control" multiple="">';
		$salida .= '<option value="">Seleccione</option>';
		$salida .='</select>';
	}
	return $salida;

}


function lista_combo_vacio($name) {

	$salida .= '<select name="'.$name.'" id="'.$name.'" class = "form-control"  multiple="">';
	$salida .= '<option value="">Seleccione</option>';
	$salida .='</select>';
	
	return $salida;
}

//////////////////////////////////////////////////// 
//Convierte fecha de Informix a normal 
//////////////////////////////////////////////////// 
function cambia_fecha($Fecha) 
{ 
if ($Fecha<>""){ 
   $trozos=explode("-",$Fecha,3); 
   return $trozos[2]."/".$trozos[1]."/".$trozos[0]; } 
else 
   {return $Fecha;} 
} 


//////////////////////////////////////////////////// 
//Convierte fecha de normal a Informix
//////////////////////////////////////////////////// 
function regresa_fecha($Fecha) 
{ 
if ($Fecha<>""){ 
   $trozos=explode("/",$Fecha,3); 
   return $trozos[2]."-".$trozos[1]."-".$trozos[0]; } 
else 
   {return $Fecha;} 
} 


//////////////////////////////////////////////////// 
//Convierte fecha y hora de Informix a normal 
//////////////////////////////////////////////////// 
function cambia_fechaHora($Fecha) { 
if ($Fecha<>""){ 
   $trozos=explode("-",$Fecha); 
   $trozos2=explode(" ",$trozos[2]);
   $fecha = $trozos2[0]."/".$trozos[1]."/".$trozos[0]; 
   $hora = $trozos2[1];
   return "$fecha $hora";
}else 
   {return $Fecha;} 
} 


//////////////////////////////////////////////////// 
//Convierte fecha y hora de Informix a normal 
//////////////////////////////////////////////////// 
function regresa_fechaHora($Fecha) { 
if ($Fecha<>""){ 
   $trozos=explode("/",$Fecha); 
   $trozos2=explode(" ",$trozos[2]);
   $fecha = $trozos2[0]."-".$trozos[1]."-".$trozos[0]; 
   $hora = $trozos2[1];
   return "$fecha $hora";
}else 
   {return $Fecha;} 
}

////////////////////////////////////////////////////
// Fecha en formato dd/mm/yyyy o dd-mm-yyyy retorna la diferencia en dias
////////////////////////////////////////////////////

function restaFechas($dFecIni, $dFecFin)
{
    $dFecIni = str_replace("-","",$dFecIni);
    $dFecIni = str_replace("/","",$dFecIni);
    $dFecFin = str_replace("-","",$dFecFin);
    $dFecFin = str_replace("/","",$dFecFin);

    ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
    ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

    $date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
    $date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);

    return round(($date2 - $date1) / (60 * 60 * 24));
}


/////----


////////////////////////////////////////////////////
// Fecha en formato dd/mm/yyyy retorna fecha con los dias sumados
////////////////////////////////////////////////////

function Cambio_Moneda($de,$para,$cuanto){
   $dato = $de * $cuanto;
   $dato = $dato/$para;
   $dato = round($dato, 2);   
	return $dato;
}

function restaFechaHoras($dFecIni, $dFecFin, $formato){
    // Fecha de Inicio
    $fechaini=explode("-",$dFecIni); 
    $trozos2=explode(" ",$fechaini[2]);
    $fechaini[2] = $trozos2[0]; 
    $horaini = $trozos2[1];
	//horas
	$horaini=explode(":",$horaini);
	
    // Fecha de Fin
    $fechafin=explode("-",$dFecFin); 
    $trozos2=explode(" ",$fechafin[2]);
    $fechafin[2] = $trozos2[0]; 
    $horafin = $trozos2[1];
	//horas
	$horafin=explode(":",$horafin);
    
    $date1 = mktime($horaini[0], $horaini[1], $horaini[2], $fechaini[1], $fechaini[2], $fechaini[0]);
    $date2 = mktime($horafin[0], $horafin[1], $horafin[2], $fechafin[1], $fechafin[2], $fechafin[0]);
    
    if(trim($formato) == "d"){
	$intervalo = round(($date2 - $date1) / (60 * 60 * 24)); //devuelve el valor en dias
    }else if(trim($formato) == "h"){
	$intervalo = round(($date2 - $date1) / (60 * 60)); //devuelve el valor en horas
    }else if(trim($formato) == "i"){
	$intervalo = round(($date2 - $date1) / (60)); //devuelve el valor en minutos
    }else if(trim($formato) == "s"){
	$intervalo = round($date2 - $date1); //devuelve el valor en segundos
    }

    return $intervalo;
}



function minutos_horas_dias($tiempo){
	
    if($tiempo > 59){
	$horas_dec = ($tiempo/60);
	$parte = explode(".",$horas_dec);
	$horas = $parte[0];
	$minutos_dec = $horas_dec - $horas;
	$minutos_dec = $minutos_dec * 100;
	$minutos = $minutos_dec * 60/100;
	if($horas > 23){
		$dias_dec = ($horas/24);
		$parte = explode(".",$dias_dec);
		$dias = $parte[0];
		//--
		$horas_dec = $dias_dec - $dias;
		$horas_dec = $horas_dec * 100;
		$horas = $horas_dec * 24/100;
		$tiempo_result = "$dias DIAS $horas HORAS";	
	}else{
		$tiempo_result = "$horas HORAS $minutos MINUTOS";	
	}
    }else{
	$tiempo_result = $tiempo." MINUTOS";
    }

	return $tiempo_result;
}	

////////////////////////////////////////////////////
// Fecha en formato dd/mm/yyyy retorna fecha con los dias sumados
////////////////////////////////////////////////////

function Fecha_suma_dias($Fecha, $dias){
    $fec = explode("/",$Fecha);
	$day = $fec[0];
	$mon = $fec[1];
	$year = $fec[2];
	
	$fecha_cambiada = mktime(0,0,0,$mon,$day+$dias,$year);
	$fecha = date("d/m/Y", $fecha_cambiada);
	return $fecha; //devuelve dd/mm/yyyy  
}


////////////////////////////////////////////////////
// Fecha en formato dd/mm/yyyy retorna fecha con los dias sumados
////////////////////////////////////////////////////

function Fecha_resta_dias($Fecha, $dias){
    $fec = explode("/",$Fecha);
	$day = $fec[0];
	$mon = $fec[1];
	$year = $fec[2];
	
	$fecha_cambiada = mktime(0,0,0,$mon,$day-$dias,$year);
	$fecha = date("d/m/Y", $fecha_cambiada);
	return $fecha; //devuelve dd/mm/yyyy  
}

//////////////////////////////////////////////////// 
//devuelve los Nombres de los meses en letras
//////////////////////////////////////////////////// 
function Meses_Letra($num){
	switch($num){
		case 1: $letra = "ENERO"; break;
		case 2: $letra = "FEBRERO"; break;
		case 3: $letra = "MARZO"; break;
		case 4: $letra = "ABRIL"; break;
		case 5: $letra = "MAYO"; break;
		case 6: $letra = "JUNIO"; break;
		case 7: $letra = "JULIO"; break;
		case 8: $letra = "AGOSTO"; break;
		case 9: $letra = "SEPTIEMBRE"; break;
		case 10: $letra = "OCTUBRE"; break;
		case 11: $letra = "NOVIEMBRE"; break;
		case 12: $letra = "DICIEMBRE"; break;
	}
	return $letra;
}


function numeros_a_letras($num){
	switch($num){
		case 1: $letra = "UNO"; break;
		case 2: $letra = "DOS"; break;
		case 3: $letra = "TRES"; break;
		case 4: $letra = "CUATRO"; break;
		case 5: $letra = "CINCO"; break;
		case 6: $letra = "SEIS"; break;
		case 7: $letra = "SIETE"; break;
		case 8: $letra = "OCHO"; break;
		case 9: $letra = "NUEVE"; break;
		case 0: $letra = "CERO"; break;
	}
	return $letra;
}
//////////////////////////////////////////////////// 
//suma 1 dia a la fecha
//////////////////////////////////////////////////// 
function suma_dia($fec){
	$fecha = explode("/",$fec);
	$anio = $fecha[2];
	$mes = $fecha[1];
	$dia = $fecha[0];
	$dia++;
	switch($mes){
		case 1: $cmeses=31; break;
		case 2: $cmeses=28; break;
		case 3: $cmeses=31; break;
		case 4: $cmeses=30; break;
		case 5: $cmeses=31; break;
		case 6: $cmeses=30; break;
		case 7: $cmeses=31; break;
		case 8: $cmeses=31; break;
		case 9: $cmeses=30; break;
		case 10: $cmeses=31; break;
		case 11: $cmeses=30; break;
		case 12: $cmeses=31; break;
	}
	//calula si el a�o es bisiesto
	if (($anio % 4 == 0) && (($anio % 100 != 0) || ($anio % 400 == 0))){
		if($mes == 2){
			$cmeses++;
		}
	}
	if($dia>$cmeses){
		$dia = 1;
		$mes++;
	}
	if($mes>12){
		$mes = 1;
		$anio++;
	}
	
	return "$dia/$mes/$anio";
}


//////////////////////////////////////////////////// 
//devuelve las letras de las columnas segun el numero de columna
//////////////////////////////////////////////////// 
function Trae_letra($num){
	switch($num){
		case 1: $letra = "A"; break;
		case 2: $letra = "B"; break;
		case 3: $letra = "C"; break;
		case 4: $letra = "D"; break;
		case 5: $letra = "E"; break;
		case 6: $letra = "F"; break;
		case 7: $letra = "G"; break;
		case 8: $letra = "H"; break;
		case 9: $letra = "I"; break;
		case 10: $letra = "J"; break;
		case 11: $letra = "K"; break;
		case 12: $letra = "L"; break;
		case 13: $letra = "M"; break;
		case 14: $letra = "N"; break;
		case 15: $letra = "O"; break;
		case 16: $letra = "P"; break;
		case 17: $letra = "Q"; break;
		case 18: $letra = "R"; break;
		case 19: $letra = "S"; break;
		case 20: $letra = "T"; break;
		case 21: $letra = "U"; break;
		case 22: $letra = "V"; break;
		case 23: $letra = "W"; break;
		case 24: $letra = "X"; break;
		case 25: $letra = "Y"; break;
		case 26: $letra = "Z"; break;
	}
	return $letra;
}


////////////////////////////////////////////////////
//--------------------
////////////////////////////////////////////////////

function Agrega_Ceros($dato){
    $len = strlen($dato);
	switch($len){
		case 1: $dato = "000$dato"; break;
		case 2: $dato = "00$dato"; break;
		case 3: $dato = "0$dato"; break;
	}
	return $dato;
}


////////////////////////////////////////////////////
//--------------------
////////////////////////////////////////////////////

function Calcula_Edad($fecnac){
	if($fecnac !== ''){
		//calculo la fecha de hoy
		$hoy = date("d/m/Y");
		$array_fecha = explode("/",$fecnac);
		$ano = intval($array_fecha[2], 10);
		$mes = intval($array_fecha[1], 10);
		$dia = intval($array_fecha[0], 10);
		$edad = date("Y") - $ano;
		
		////// NOTA //////////			
		if ((date("m") - $mes) < 0) {
			$edad--;
			return $edad;
		}
		if ((date("m") - $mes) >= 0) {
			if((date("m") - $mes) == 0){
				if((date("d")) >= $dia) {
					return $edad;
				}else{
					$edad--;
					return $edad;
				}
			}else{
				return $edad;
			}
		}
	}
}


//////////////////////////////////////////////////// 
//quita caracteres de espa�ol
//////////////////////////////////////////////////// 
function depurador_texto($texto) {
	$texto = trim($texto);
	$texto = str_replace("á","a",$texto);
	$texto = str_replace("é","e",$texto);
	$texto = str_replace("í","i",$texto);
	$texto = str_replace("ó","o",$texto);
	$texto = str_replace("ú","u",$texto);
	$texto = str_replace("Á","A",$texto);
	$texto = str_replace("É","E",$texto);
	$texto = str_replace("Í","I",$texto);
	$texto = str_replace("Ó","O",$texto);
	$texto = str_replace("Ú","U",$texto);
	$texto = str_replace("ñ","n",$texto);
	$texto = str_replace("Ñ","N",$texto);
	
   return $texto;
}



/////////////////////

function Corrige_Calendario($fecnac){
$array_fecha = explode("/",$fecnac);
$ano = trim($array_fecha[2]);
$mes = trim($array_fecha[0]);
$dia = trim($array_fecha[1]);

	return "$dia/$mes/$ano";
}

////////////////////


function comprobar_email($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminacion del dominio sea correcta (@)
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return 1; // si el correo es valido regresa 1 o true
    else
       return 0; // si el correo no es valido regresa 0 o false
}


function ComboHoras($name=''){
    $salida.='<div class = "col-xs-6 sin-paddin">';
    $salida.='<select id="hor'.$name.'" name="hor'.$name.'" class = "form-control">';
    for ($i=0; $i<=23; $i++) {
        if($i<10)
            $salida.= '<option value="0'.$i.'">0'.$i.'</option>';
        else
            $salida.= '<option value="'.$i.'">'.$i.'</option>';
    }
    $salida.='</select>';
    $salida.='</div>';
    $salida.='<div class = "col-xs-6 sin-paddin">';
    $salida.='<input type ="text" id="min'.$name.'" name="min'.$name.'" class = "form-control" onkeyup="enteros(this)" maxlength="2" />';
    $salida.='</div>';
    return $salida;
}


function Generador_Contrasena(){
	$base = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890_$-!=";
	$cadena = "";
	for($i=1; $i <= 8; $i++) { //ciclo de 8 vueltas para la contrase�a
		$cadena .= substr($base,rand(0,67),1); // substrae un caracter de los 67 listados en la bariable $base y lo concatena a los restos en la variable $cadena
	}
	return $cadena;
}


////////////////// URL DEL SERVIDOR /////////////////////
function url_origin( $s, $use_forwarded_host = false ){
    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
    $port     = $s['SERVER_PORT'];
    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

function full_url( $s, $use_forwarded_host = false ){
    return url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
}


/// EJEMPLO: $absolute_url = full_url( $_SERVER );

function unidades_html($nivel,$id,$acc = '',$disabled = '',$class = '') {

    $ClsUni = new ClsNotas();
	$pensum = $_SESSION["pensum"];
	$result = $ClsUni->get_unidades($pensum,$nivel);
    if(is_array($result)){
        return combos_html_onclick($result,$id,'uni_unidad','uni_unidad',$acc);
    }else{
		return combos_vacios("$id");
	}
}

?>
