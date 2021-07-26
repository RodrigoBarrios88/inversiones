<?php
require_once ("ClsConex.php");

class ClsPersonal extends ClsConex{
   
//---------- Personal ---------//
    function get_personal($dpi,$nom = '',$ape = '',$suc = '',$gene = '',$nit = '',$status = '',$pais = '') {
		$nom = trim($nom);
		$ape = trim($ape);
	    $sql= "SELECT *, ";
		$sql.= "(SELECT dm_desc FROM mast_mundep WHERE dm_codigo = per_lugar_nac) as per_depmun_nacimiento_desc, ";
		$sql.= "(SELECT pai_desc FROM mast_paises WHERE pai_id = per_pais_nac) as per_pais_nacimiento_desc, ";
		$sql.= "(SELECT dm_desc FROM mast_mundep WHERE dm_codigo = per_depmun_eventual) as per_depmun_eventual_desc, ";
		$sql.= "(SELECT dm_desc FROM mast_mundep WHERE dm_codigo = per_depmun_permanente) as per_depmun_permanentper_desc, ";
		///--- Subquerys de Organizacion
		$sql.= "(SELECT dep_desc_lg FROM org_organizacion, org_plaza, org_departamento WHERE plaz_departamento = dep_id AND org_plaza = plaz_codigo AND org_personal = per_dpi AND org_situacion = 1) as dep_desc_lg, ";
		$sql.= "(SELECT dep_desc_ct FROM org_organizacion, org_plaza, org_departamento WHERE plaz_departamento = dep_id AND org_plaza = plaz_codigo AND org_personal = per_dpi AND org_situacion = 1) as dep_desc_ct, ";
		$sql.= "(SELECT plaz_desc_ct FROM org_organizacion, org_plaza WHERE org_plaza = plaz_codigo AND org_personal = per_dpi AND org_situacion = 1) as plaz_desc_ct, ";
		$sql.= "(SELECT plaz_desc_ct FROM org_organizacion, org_plaza WHERE org_plaza = plaz_codigo AND org_personal = per_dpi AND org_situacion = 1) as plaz_desc_lg ";
		//--
		$sql.= " FROM rrhh_personal, mast_sucursal, rrhh_economica, rrhh_penal, rrhh_laboral_anterior, rrhh_educacion";
		$sql.= " WHERE per_sucursal = suc_id";
		$sql.= " AND per_dpi = eco_personal";
		$sql.= " AND per_dpi = pen_personal";
		$sql.= " AND per_dpi = lab_personal";
		$sql.= " AND per_dpi = edu_personal";
		if(strlen($dpi)>0) { 
			  $sql.= " AND per_dpi = $dpi"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND per_nombres like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND per_apellidos like '%$ape%'"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND per_sucursal = $suc"; 
		}
		if(strlen($gene)>0) { 
			  $sql.= " AND per_genero = '$gene'"; 
		}
		if(strlen($nit)>0) { 
			  $sql.= " AND per_nit = '$nit'"; 
		}
		if(strlen($status)>0) { 
			  $sql.= " AND per_status = '$status'"; 
		}
		if(strlen($pais)>0) { 
			  $sql.= " AND per_pais = $pais"; 
		}
		$sql.= " ORDER BY per_apellidos ASC, per_nombres ASC, per_dpi ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_personal($dpi,$nom = '',$ape = '',$suc = '',$gene = '',$nit = '',$status = '',$pais = '') {
		
		$nom = trim($nom);
		$ape = trim($ape);
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM rrhh_personal, mast_sucursal, rrhh_economica, rrhh_penal, rrhh_laboral_anterior, rrhh_educacion";
		$sql.= " WHERE per_sucursal = suc_id";
		$sql.= " AND per_dpi = eco_personal";
		$sql.= " AND per_dpi = pen_personal";
		$sql.= " AND per_dpi = lab_personal";
		$sql.= " AND per_dpi = edu_personal";
		if(strlen($dpi)>0) { 
			  $sql.= " AND per_dpi = $dpi"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND per_nombres like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND per_apellidos like '%$ape%'"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND per_sucursal = $suc"; 
		}
		if(strlen($gene)>0) { 
			  $sql.= " AND per_genero = '$gene'"; 
		}
		if(strlen($nit)>0) { 
			  $sql.= " AND per_nit = '$nit'"; 
		}
		if(strlen($status)>0) { 
			  $sql.= " AND per_status = '$status'"; 
		}
		if(strlen($pais)>0) { 
			  $sql.= " AND per_pais = $pais"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_personal($per_dpi,$per_nombres,$per_apellidos,$per_nit,$per_profesion,$per_religion,
				$per_pasaporte,$per_igss,$per_genero,$per_ecivil,$per_lugar_nac,$per_pais_nac,$per_fecnac,$per_direccion_eventual,$per_depmun_eventual,$per_telefono_eventual,
				$per_direccion_permanente,$per_depmun_permanente,$per_telefono_permanente,$per_tipo_sangre,$per_alergico,$per_celular,$per_mail,$per_emergencia_nombre,$per_emergencia_apellido,
				$per_emergencia_dir,$per_emergencia_tel,$per_emergencia_cel,$per_fec_alta,$per_talla_camisa,$per_talla_pantalon,$per_chumpa,$per_talla_botas,$per_talla_gorra,
				$per_estatura,$per_peso,$per_tez,$per_ojos,$per_nariz,$per_tipo_lic_veh,$per_num_lic_veh,$per_num_lic_moto,$per_num_lic_digecam,$per_digecam_fecini,$per_digecam_fecfin,
				$per_deportes,$per_status) {
		//-- UPPERCASE
		$per_nombres = trim($per_nombres);
		$per_apellidos = trim($per_apellidos);
		$per_nit = trim($per_nit);
		$per_profesion = trim($per_profesion);
		$per_religion = trim($per_religion);
		$per_pasaporte = trim($per_pasaporte);
		$per_genero = trim($per_genero);
		$per_ecivil = trim($per_ecivil);
		$per_lugar_nac = trim($per_lugar_nac);
		$per_direccion_eventual = trim($per_direccion_eventual);
		$per_direccion_permanente = trim($per_direccion_permanente);
		$per_tipo_sangre = trim($per_tipo_sangre);
		$per_alergico = trim($per_alergico);
		$per_emergencia_nombre = trim($per_emergencia_nombre);
		$per_emergencia_apellido = trim($per_emergencia_apellido);
		$per_emergencia_dir = trim($per_emergencia_dir);
		$per_lugar_alta = trim($per_lugar_alta);
		$per_chumpa = trim($per_chumpa);
		$per_talla_gorra = trim($per_talla_gorra);
		$per_tez = trim($per_tez);
		$per_ojos = trim($per_ojos);
		$per_nariz = trim($per_nariz);
		$per_tipo_lic_veh = trim($per_tipo_lic_veh);
		$per_deportes = trim($per_deportes);
		 //-- LOWECASE
		$per_mail = strtolower($per_mail);
		//--	cambio de formatos de fecha
		$per_fecnac = $this->regresa_fecha($per_fecnac);
		$per_fec_alta = $this->regresa_fecha($per_fec_alta);
		//--	Variables de Session
		$per_sucursal = $_SESSION['empCodigo'];
		$per_usu_registro = $_SESSION["codigo"];
		$per_fec_registro = date("Y-m-d h:i:s");
		//--
		$sql = "INSERT INTO rrhh_personal ";
		$sql.= "VALUES ('$per_dpi','$per_nombres','$per_apellidos',";
		$sql.= "'$per_nit','$per_profesion','$per_religion','$per_pasaporte','$per_igss','$per_genero','$per_ecivil','$per_lugar_nac','$per_pais_nac','$per_fecnac','$per_direccion_eventual',";
		$sql.= "'$per_depmun_eventual','$per_telefono_eventual','$per_direccion_permanente','$per_depmun_permanente','$per_telefono_permanente','$per_tipo_sangre',";
		$sql.= "'$per_alergico','$per_celular','$per_mail','$per_emergencia_nombre','$per_emergencia_apellido','$per_emergencia_dir','$per_emergencia_tel','$per_emergencia_cel',";
		$sql.= "'$per_fec_alta','$per_talla_camisa','$per_talla_pantalon','$per_chumpa','$per_talla_botas','$per_talla_gorra','$per_estatura','$per_peso','$per_tez',";
		$sql.= "'$per_ojos','$per_nariz','$per_tipo_lic_veh','$per_num_lic_veh','$per_num_lic_moto','$per_num_lic_digecam','$per_digecam_fecini','$per_digecam_fecfin','$per_deportes',";
		$sql.= "'$per_fec_registro','$per_usu_registro','$per_sucursal','$per_status','1'); ";
		//echo $sql;
		return $sql;
	}
	
	
		
	function update_personal($per_dpi,$per_nombres,$per_apellidos,$per_nit,$per_profesion,$per_religion,
				$per_pasaporte,$per_igss,$per_genero,$per_ecivil,$per_lugar_nac,$per_pais_nac,$per_fecnac,$per_direccion_eventual,$per_depmun_eventual,$per_telefono_eventual,
				$per_direccion_permanente,$per_depmun_permanente,$per_telefono_permanente,$per_tipo_sangre,$per_alergico,$per_celular,$per_mail,$per_emergencia_nombre,$per_emergencia_apellido,
				$per_emergencia_dir,$per_emergencia_tel,$per_emergencia_cel,$per_talla_camisa,$per_talla_pantalon,$per_chumpa,$per_talla_botas,$per_talla_gorra,
				$per_estatura,$per_peso,$per_tez,$per_ojos,$per_nariz,$per_tipo_lic_veh,$per_num_lic_veh,$per_num_lic_moto,$per_num_lic_digecam,$per_digecam_fecini,$per_digecam_fecfin,
				$per_deportes){
	    //-- UPPERCASE
		$per_nombres = trim($per_nombres);
		$per_apellidos = trim($per_apellidos);
		$per_nit = trim($per_nit);
		$per_profesion = trim($per_profesion);
		$per_religion = trim($per_religion);
		$per_pasaporte = trim($per_pasaporte);
		$per_genero = trim($per_genero);
		$per_ecivil = trim($per_ecivil);
		$per_lugar_nac = trim($per_lugar_nac);
		$per_direccion_eventual = trim($per_direccion_eventual);
		$per_direccion_permanente = trim($per_direccion_permanente);
		$per_tipo_sangre = trim($per_tipo_sangre);
		$per_alergico = trim($per_alergico);
		$per_emergencia_nombre = trim($per_emergencia_nombre);
		$per_emergencia_apellido = trim($per_emergencia_apellido);
		$per_emergencia_dir = trim($per_emergencia_dir);
		$per_lugar_alta = trim($per_lugar_alta);
		$per_chumpa = trim($per_chumpa);
		$per_talla_gorra = trim($per_talla_gorra);
		$per_tez = trim($per_tez);
		$per_ojos = trim($per_ojos);
		$per_nariz = trim($per_nariz);
		$per_tipo_lic_veh = trim($per_tipo_lic_veh);
		$per_deportes = trim($per_deportes);
		 //-- LOWECASE
		$per_mail = strtolower($per_mail);
		//--	cambio de formatos de fecha
		$per_fecnac = $this->regresa_fecha($per_fecnac);
		$per_fec_alta = $this->regresa_fecha($per_fec_alta);
		//--	Variables de Session
		$per_sucursal = $_SESSION['empCodigo'];
		$per_usu_registro = $_SESSION["codigo"];
		$per_fec_registro = date("Y-m-d h:i:s");
		//--	    
		$sql = "UPDATE rrhh_personal SET ";
		$sql.= " per_nombres = '$per_nombres', ";
		$sql.= " per_apellidos = '$per_apellidos', ";
		$sql.= " per_nit = '$per_nit', ";
		$sql.= " per_profesion = '$per_profesion', ";
		$sql.= " per_religion = '$per_religion', ";
		$sql.= " per_pasaporte = '$per_pasaporte', ";
		$sql.= " per_igss = '$per_igss', ";
		$sql.= " per_genero = '$per_genero', ";
		$sql.= " per_ecivil = '$per_ecivil', ";
		$sql.= " per_lugar_nac = '$per_lugar_nac', ";
		$sql.= " per_pais_nac = '$per_pais_nac', ";
		$sql.= " per_fecnac = '$per_fecnac', ";
		$sql.= " per_direccion_eventual = '$per_direccion_eventual', ";
		$sql.= " per_depmun_eventual = '$per_depmun_eventual', ";
		$sql.= " per_telefono_eventual = '$per_telefono_eventual', ";
		$sql.= " per_direccion_permanente = '$per_direccion_permanente', ";
		$sql.= " per_depmun_permanente = '$per_depmun_permanente', ";
		$sql.= " per_telefono_permanente = '$per_telefono_permanente', ";
		$sql.= " per_tipo_sangre = '$per_tipo_sangre', ";
		$sql.= " per_alergico = '$per_alergico', ";
		$sql.= " per_celular = '$per_celular', ";
		$sql.= " per_mail = '$per_mail', ";
		$sql.= " per_emergencia_nombre = '$per_emergencia_nombre', ";
		$sql.= " per_emergencia_apellido = '$per_emergencia_apellido', ";
		$sql.= " per_emergencia_dir = '$per_emergencia_dir', ";
		$sql.= " per_emergencia_tel = '$per_emergencia_tel', ";
		$sql.= " per_emergencia_cel = '$per_emergencia_cel', ";
		$sql.= " per_talla_camisa = '$per_talla_camisa', ";
		$sql.= " per_talla_pantalon = '$per_talla_pantalon', ";
		$sql.= " per_chumpa = '$per_chumpa', ";
		$sql.= " per_talla_botas = '$per_talla_botas', ";
		$sql.= " per_talla_gorra = '$per_talla_gorra', ";
		$sql.= " per_estatura = '$per_estatura', ";
		$sql.= " per_peso = '$per_peso', ";
		$sql.= " per_tez = '$per_tez', ";
		$sql.= " per_ojos = '$per_ojos', ";
		$sql.= " per_nariz = '$per_nariz', ";
		$sql.= " per_tipo_lic_veh = '$per_tipo_lic_veh', ";
		$sql.= " per_num_lic_veh = '$per_num_lic_veh', ";
		$sql.= " per_num_lic_moto = '$per_num_lic_moto', ";
		$sql.= " per_num_lic_digecam = '$per_num_lic_digecam', ";
		$sql.= " per_digecam_fecini = '$per_digecam_fecini', ";
		$sql.= " per_digecam_fecfin = '$per_digecam_fecfin', ";
		$sql.= " per_deportes = '$per_deportes', ";
		$sql.= " per_usu_registro = '$per_usu_registro', ";
		$sql.= " per_fec_registro = '$per_fec_registro' ";
		
		$sql.= " WHERE per_dpi = $per_dpi; "; 	

		return $sql;
	}
	
	function cambia_sit_personal($per_dpi,$sit){
		
		$sql = "UPDATE rrhh_personal SET ";
		$sql.= "per_situacion = $sit"; 
				
		$sql.= " WHERE per_dpi = $per_dpi; "; 	
		return $sql;
	}
	
	
	function actualizar_personal_sucursal($per_dpi,$per_sucursal){
		//--
		$sql = "UPDATE rrhh_personal SET ";
		$sql.= "per_sucursal = $per_sucursal"; 
				
		$sql.= " WHERE per_dpi = $per_dpi; "; 	
		return $sql;
	}
	
	
}	
?>
