<?php
require_once ("ClsConex.php");

class ClsCliMasc extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
   
	    function get_cliente_mascota($cli,$sit='') {
		/////---- busca las mascotas de 1 due–o
			$sql= "SELECT * ";
			$sql.= " FROM vet_climas, vet_mascota, vet_raza, vet_animal";
			$sql.= " WHERE cm_mascota = mas_codigo";
			$sql.= " AND mas_raza = raz_codigo";
			$sql.= " AND raz_animal = ani_codigo";
			$sql.= " AND cm_cliente = $cli";
			if(strlen($sit)>0) { 
				  $sql.= " AND cm_situacion = $sit"; 
			}
			$sql.= " ORDER BY mas_codigo ASC";
			
			$result = $this->exec_query($sql);
			//echo $sql;
			return $result;

	    }
	    
	    function count_cliente_mascota($cli,$sit='') {
		/////---- busca las mascotas de 1 due–o
			$sql= "SELECT COUNT(*) as total";
			$sql.= " FROM vet_climas, vet_mascota, vet_raza, vet_animal";
			$sql.= " WHERE cm_mascota = mas_codigo";
			$sql.= " AND mas_raza = raz_codigo";
			$sql.= " AND raz_animal = ani_codigo";
			$sql.= " AND cm_cliente = $cli";
			if(strlen($sit)>0) { 
				  $sql.= " AND cm_situacion = $sit"; 
			}
			$sql.= " AND cm_cliente = $cli";
			//echo $sql;
			$result = $this->exec_query($sql);
			foreach($result as $row){
				$total = $row['total'];
			}
			return $total;

	    }
	
	    function get_mascota_cliente($masc,$sit='') {
		/////---- busca los due–os de 1 mascota
			$sql= "SELECT * ";
			$sql.= " FROM vet_climas, fin_cliente, mast_mundep, mast_paises";
			$sql.= " WHERE cm_cliente = cli_id";
			$sql.= " AND due_municipio = mast_mundep.cm_codigo";
			$sql.= " AND due_nacional = pai_id";
			$sql.= " AND cm_mascota = $masc";
			if(strlen($sit)>0) { 
				  $sql.= " AND cm_situacion = $sit"; 
			}
			$sql.= " ORDER BY cli_id ASC";
			
			$result = $this->exec_query($sql);
			//echo $sql;
			return $result;

	    }
	    
	    function count_mascota_cliente($masc,$sit='') {
		/////---- busca los due–os de 1 mascota
			$sql= "SELECT COUNT(*) as total";
			$sql.= " FROM vet_climas, fin_cliente, mast_mundep, mast_paises";
			$sql.= " WHERE cm_cliente = cli_id";
			$sql.= " AND due_municipio = mast_mundep.cm_codigo";
			$sql.= " AND due_nacional = pai_id";
			$sql.= " AND cm_mascota = $masc";
			if(strlen($sit)>0) { 
				  $sql.= " AND cm_situacion = $sit"; 
			}
			//echo $sql;
			$result = $this->exec_query($sql);
			foreach($result as $row){
				$total = $row['total'];
			}
			return $total;

	    }
	    
	    
	    
	  /////////////-------
	    function get_list_cliente_mascota($cod,$nom = '',$ape = '',$tel = '',$mail = '',$pais = '',$dep = '') {
		/////---- busca las mascotas de 1 due–o
		    $nom = trim($nom);
		    $ape = trim($ape);
			$sql= "SELECT * ";
			$sql.= " FROM vet_climas, vet_mascota, fin_cliente, vet_raza, vet_animal";
			$sql.= " WHERE cm_mascota = mas_codigo";
			$sql.= " AND cm_cliente = cli_id";
			$sql.= " AND mas_raza = raz_codigo";
			$sql.= " AND raz_animal = ani_codigo";
			$sql.= " AND cm_situacion = 1"; 
			if(strlen($cod)>0) { 
				  $sql.= " AND cli_id = $cod";
			}
			if(strlen($nom)>0) { 
				  $sql.= " AND due_nombre like '%$nom%'"; 
			}
			if(strlen($ape)>0) { 
				  $sql.= " AND due_apellido like '%$ape%'"; 
			}
			if(strlen($pais)>0) { 
				  $sql.= " AND due_nacional = $pais";
			}
			if(strlen($tel)>0) { 
				  $sql.= " AND due_telefono = '$tel'";
			}
			if(strlen($mail)>0) { 
				  $sql.= " AND due_email = '$mail'";
			}
			if(strlen($dep)>0) { 
				  $sql.= " AND due_departamento = $dep";
			}
			$sql.= " ORDER BY due_apellido ASC";
			
			$result = $this->exec_query($sql);
			//echo $sql;
			return $result;

	    }
	    
	    function count_list_cliente_mascota($cod,$nom = '',$ape = '',$tel = '',$mail = '',$pais = '',$dep = '') {
		/////---- busca las mascotas de 1 due–o
		    $nom = trim($nom);
		    $ape = trim($ape);
			$sql= "SELECT COUNT(*) as total";
			$sql.= " FROM vet_climas, vet_mascota, fin_cliente, vet_raza, vet_animal";
			$sql.= " WHERE cm_mascota = mas_codigo";
			$sql.= " AND cm_cliente = cli_id";
			$sql.= " AND mas_raza = raz_codigo";
			$sql.= " AND raz_animal = ani_codigo";
			$sql.= " AND cm_situacion = 1"; 
			if(strlen($cod)>0) { 
				  $sql.= " AND cli_id = $cod";
			}
			if(strlen($nom)>0) { 
				  $sql.= " AND due_nombre like '%$nom%'"; 
			}
			if(strlen($ape)>0) { 
				  $sql.= " AND due_apellido like '%$ape%'"; 
			}
			if(strlen($pais)>0) { 
				  $sql.= " AND due_nacional = $pais";
			}
			if(strlen($tel)>0) { 
				  $sql.= " AND due_telefono = '$tel'";
			}
			if(strlen($mail)>0) { 
				  $sql.= " AND due_email = '$mail'";
			}
			if(strlen($dep)>0) { 
				  $sql.= " AND due_departamento = $dep";
			}
			//echo $sql;
			$result = $this->exec_query($sql);
			foreach($result as $row){
				$total = $row['total'];
			}
			return $total;

	    }
	    
	  
	  /////////////-------
	    function get_list_mascota_cliente($cod,$nom = '',$ani = '',$raz = '',$gene = '',$tid = '') {
		/////---- busca las mascotas de 1 due–o
		    $nom = trim($nom);
		    $ape = trim($ape);
			$sql= "SELECT * ";
			$sql.= " FROM vet_climas, vet_mascota, fin_cliente, vet_raza, vet_animal";
			$sql.= " WHERE cm_mascota = mas_codigo";
			$sql.= " AND cm_cliente = cli_id";
			$sql.= " AND mas_raza = raz_codigo";
			$sql.= " AND raz_animal = ani_codigo";
			$sql.= " AND cm_situacion = 1"; 
			if(strlen($cod)>0) { 
				  $sql.= " AND mas_codigo = $cod";
			}
			if(strlen($nom)>0) { 
				  $sql.= " AND mas_nombre like '%$nom%'"; 
			}
			if(strlen($ani)>0) { 
				  $sql.= " AND ani_codigo = '$ani'";
			}
			if(strlen($raz)>0) { 
				  $sql.= " AND raz_codigo = $raz";
			}
			if(strlen($gene)>0) { 
				  $sql.= " AND mas_genero = '$gene'";
			}
			if(strlen($tid)>0) { 
				  $sql.= " AND mas_id_tipo = $tid";
			}
			$sql.= " ORDER BY mas_nombre ASC";
			
			$result = $this->exec_query($sql);
			//echo $sql;
		    return $result;

	    }
	    
	    function count_list_mascota_cliente($cod,$nom = '',$ani = '',$raz = '',$gene = '',$tid = '') {
		/////---- busca las mascotas de 1 due–o
		    $nom = trim($nom);
		    $ape = trim($ape);
			$sql= "SELECT COUNT(*) as total";
			$sql.= " FROM vet_climas, vet_mascota, fin_cliente, vet_raza, vet_animal";
			$sql.= " WHERE cm_mascota = mas_codigo";
			$sql.= " AND cm_cliente = cli_id";
			$sql.= " AND mas_raza = raz_codigo";
			$sql.= " AND raz_animal = ani_codigo";
			$sql.= " AND cm_situacion = 1"; 
			if(strlen($cod)>0) { 
				  $sql.= " AND mas_codigo = $cod";
			}
			if(strlen($nom)>0) { 
				  $sql.= " AND mas_nombre like '%$nom%'"; 
			}
			if(strlen($ani)>0) { 
				  $sql.= " AND ani_codigo = '$ani'";
			}
			if(strlen($raz)>0) { 
				  $sql.= " AND raz_codigo = $raz";
			}
			if(strlen($gene)>0) { 
				  $sql.= " AND mas_genero = '$gene'";
			}
			if(strlen($tid)>0) { 
				  $sql.= " AND mas_id_tipo = $tid";
			}
			//echo $sql;
			$result = $this->exec_query($sql);
			foreach($result as $row){
				$total = $row['total'];
			}
		    return $total;

	    }
	    
	  
	    
	    function comprueba_cliente_mascota($cli,$masc) {
		/////---- busca las mascotas de 1 due–o
			$sql= "SELECT COUNT(*) as total";
			$sql.= " FROM vet_climas";
			$sql.= " WHERE cm_cliente = $cli";
			$sql.= " AND cm_mascota = $masc";
			$sql.= " AND cm_situacion = 1"; 
			//echo $sql;
			$result = $this->exec_query($sql);
			foreach($result as $row){
				$total = $row['total'];
			}
		    return $total;

	    }
	    
	
	
	    function insert_climas($cmcod,$cli,$masc){
		
		$freg = date("Y-m-d H:i:s");
		$usu = $_SESSION['codigo'];
		
		$sql = "INSERT INTO vet_climas";
		$sql.= " VALUES ($cmcod,$cli,$masc,'$freg',$usu,1);";
		//echo $sql;
		return $sql;
	    }
	    
	    
	    function max_climas(){
	        $sql = "SELECT max(cm_id) as max ";
		$sql.= " FROM vet_climas";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	    }
	
	
	    function cambia_sit_climas($cmcod,$sit){
		
		$sql = "UPDATE vet_climas SET ";
		$sql.= "cm_situacion = '$sit'"; 
				
		$sql.= " WHERE cm_id = $cmcod"; 	
		
		return $sql;
	    }
	
	
	
}	
?>
