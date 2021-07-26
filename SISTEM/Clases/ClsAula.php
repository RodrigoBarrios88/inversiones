<?php
require_once ("ClsConex.php");

class ClsAula extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */

//---------- SEDES ---------//
    function get_sede($cod,$nom = '',$dep = '',$mun = ''){
		$nom = trim($nom);

          $sql= "SELECT *, ";
          $sql.= " (SELECT dm_desc FROM mast_mundep WHERE dm_codigo = sed_municipio) municiopio_desc";
          $sql.= " FROM lms_sede";
          $sql.= " WHERE sed_situacion = 1";
          if(strlen($cod)>0) {
               $sql.= " AND sed_codigo = $cod";
          }
          if(strlen($nom)>0) {
               $sql.= " AND sed_nombre like '%$nom%'";
          }
          if(strlen($dep)>0) {
               $sql.= " AND sed_departamento = '$dep'";
          }
          if(strlen($mun)>0) {
               $sql.= " AND sed_municipio = '$mun'"; 
          }
          $sql.= " ORDER BY sed_codigo ASC, sed_departamento ASC, sed_municipio ASC, sed_nombre ASC";

          $result = $this->exec_query($sql);
          //echo $sql;
          return $result;

	}

	function count_sede($cod,$nom = '',$dep = '',$mun = ''){
		$nom = trim($nom);

        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM lms_sede";
		$sql.= " WHERE sed_situacion = 1";
		if(strlen($cod)>0) {
			  $sql.= " AND sed_codigo = $cod";
		}
		if(strlen($nom)>0) {
			  $sql.= " AND sed_nombre like '%$nom%'";
		}
		if(strlen($dep)>0) {
			  $sql.= " AND sed_departamento = '$dep'";
		}
		if(strlen($mun)>0) {
			  $sql.= " AND sed_municipio = '$mun'";
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}

	function insert_sede($cod,$nom,$dir,$dep,$mun){
		$nom = trim($nom);

		$sql = "INSERT INTO lms_sede (sed_codigo,sed_nombre,sed_direccion,sed_departamento,sed_municipio,sed_situacion)";
		$sql.= " VALUES ($cod,'$nom','$dir',$dep,$mun,1); ";
		//echo $sql;
		return $sql;
	}

	function modifica_sede($cod,$nom,$dir,$dep,$mun){
		$nom = trim($nom);

		$sql = "UPDATE lms_sede SET ";
		$sql.= "sed_nombre = '$nom',";
		$sql.= "sed_direccion = '$dir',";
		$sql.= "sed_departamento = '$dep',";
		$sql.= "sed_municipio = '$mun'";

		$sql.= " WHERE sed_codigo = $cod;";
		//echo $sql;
		return $sql;
	}


	function cambia_sit_sede($cod){
		$sql = "UPDATE lms_sede SET sed_situacion = 0";
		$sql.= " WHERE sed_codigo = $cod;";
		//echo $sql;
		return $sql;
	}


	function max_sede() {

        $sql = "SELECT max(sed_codigo) as max ";
		$sql.= " FROM lms_sede";
		$sql.= " WHERE 1 = 1";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}

//---------- AULAS E INSTALACIONES ---------//
    function get_aula($cod,$sede = '',$tipo = '',$desc = ''){
		$desc = trim($desc);

        $sql= "SELECT * ";
		$sql.= " FROM lms_aula, lms_sede";
		$sql.= " WHERE aul_sede = sed_codigo";
		$sql.= " AND aul_situacion = 1";
		if(strlen($cod)>0) {
			  $sql.= " AND aul_codigo = $cod";
		}
		if(strlen($sede)>0) {
			  $sql.= " AND aul_sede = '$sede'";
		}
		if(strlen($tipo)>0) {
			  $sql.= " AND aul_tipo = '$tipo'";
		}
		if(strlen($desc)>0) {
			  $sql.= " AND aul_descripcion like '%$desc%'";
		}
		$sql.= " ORDER BY aul_descripcion ASC, aul_codigo ASC";

		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}

	function count_aula($cod,$sede = '',$tipo = '',$desc = ''){
		$desc = trim($desc);

        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM lms_aula, lms_sede";
		$sql.= " WHERE aul_sede = sed_codigo";
		$sql.= " AND aul_situacion = 1";
		if(strlen($cod)>0) {
			  $sql.= " AND aul_codigo = $cod";
		}
		if(strlen($sede)>0) {
			  $sql.= " AND aul_sede = '$sede'";
		}
		if(strlen($tipo)>0) {
			  $sql.= " AND aul_tipo = '$tipo'";
		}
		if(strlen($desc)>0) {
			  $sql.= " AND aul_descripcion like '%$desc%'";
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}

	function insert_aula($cod,$sede,$tipo,$desc){
		$desc = trim($desc);

		$sql = "INSERT INTO lms_aula (aul_codigo,aul_sede,aul_tipo,aul_descripcion,aul_situacion)";
		$sql.= " VALUES ($cod,'$sede','$tipo','$desc',1); ";
		//echo $sql;
		return $sql;
	}

	function modifica_aula($cod,$sede,$tipo,$desc){
		$desc = trim($desc);

		$sql = "UPDATE lms_aula SET ";
		$sql.= "aul_sede = '$sede',";
		$sql.= "aul_tipo = '$tipo',";
		$sql.= "aul_descripcion = '$desc'";

		$sql.= " WHERE aul_codigo = $cod;";
		//echo $sql;
		return $sql;
	}


	function cambia_sit_aula($cod){
		$sql = "UPDATE lms_aula SET aul_situacion = 0";
		$sql.= " WHERE aul_codigo = $cod;";
		//echo $sql;
		return $sql;
	}


	function max_aula() {

        $sql = "SELECT max(aul_codigo) as max ";
		$sql.= " FROM lms_aula";
		$sql.= " WHERE 1 = 1";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}

}
?>
