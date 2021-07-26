<?php
require_once ("ClsConex.php");

class ClsAcademico extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */

	function __construct(){
		$this->anio = date("Y");
        if($_SESSION["pensum"] == "") {
            require_once("ClsPensum.php");
            $ClsPen = new ClsPensum();
            $this->pensum = $ClsPen->get_pensum_activo();
        }else{
            $this->pensum = $_SESSION["pensum"];
        }
	}	
   

	//---------- TEMAS (DOSIFICACION) ---------//

	function get_tema($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$unidad = '',$sit = ''){
		$unidad = trim($unidad);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia, academ_tema";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND tem_pensum = mat_pensum";
		$sql.= " AND tem_nivel = mat_nivel";
		$sql.= " AND tem_grado = mat_grado";
		$sql.= " AND tem_materia = mat_codigo";
        $sql.= " AND tem_situacion != 0";
		if(strlen($codigo)>0) { 
			  $sql.= " AND tem_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND tem_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND tem_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND tem_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND tem_seccion = $seccion"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND tem_materia = $materia"; 
		}
		if(strlen($unidad)>0) { 
			  $sql.= " AND tem_unidad = '$unidad'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND tem_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio ASC, tem_pensum ASC, tem_nivel ASC, tem_grado ASC, tem_seccion ASC, tem_materia ASC, tem_situacion DESC, tem_unidad ASC, tem_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_tema($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$unidad = '',$sit = ''){
		$unidad = trim($unidad);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia, academ_tema";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND tem_pensum = mat_pensum";
		$sql.= " AND tem_nivel = mat_nivel";
		$sql.= " AND tem_grado = mat_grado";
		$sql.= " AND tem_materia = mat_codigo";
        $sql.= " AND tem_situacion != 0";
		if(strlen($cod)>0) { 
			  $sql.= " AND tem_codigo = $cod"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND tem_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND tem_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND tem_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND tem_seccion = $seccion"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND tem_materia = $materia"; 
		}
		if(strlen($unidad)>0) { 
			  $sql.= " AND tem_unidad = '$unidad'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND tem_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_tema($codigo,$pensum,$nivel,$grado,$seccion,$materia,$unidad,$nombre,$desc,$periodos){
		$nombre = trim($nombre);
		$desc = trim($desc);
		
		$sql = "INSERT INTO academ_tema ";
		$sql.= " VALUES ($codigo,$pensum,$nivel,$grado,$seccion,$materia,$unidad,'$nombre','$desc','$periodos',1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_tema($codigo,$materia,$unidad,$nombre,$desc,$periodos){
		$nombre = trim($nombre);
		$desc = trim($desc);
		
		$sql = "UPDATE academ_tema SET ";
		$sql.= "tem_materia = '$materia',"; 
		$sql.= "tem_unidad = '$unidad',"; 
		$sql.= "tem_nombre = '$nombre',"; 
		$sql.= "tem_descripcion = '$desc',"; 
		$sql.= "tem_cantidad_periodos = '$periodos'"; 
		
		$sql.= " WHERE tem_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_tema($codigo,$sit){
		
		$sql = "UPDATE academ_tema SET ";
		$sql.= "tem_situacion = $sit"; 
				
		$sql.= " WHERE tem_codigo = $codigo;"; 	
		
		return $sql;
	}
	
	function max_tema(){
		
        $sql = "SELECT max(tem_codigo) as max ";
		$sql.= " FROM academ_tema";
		$sql.= " WHERE 1 = 1"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	//--- Archivos de temas ---//
	
	function get_tema_archivo($cod,$tema,$nom = ''){
		$nom = trim($nom);
		
        $sql= "SELECT * ";
		$sql.= " FROM academ_tema_archivo";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND arch_codigo = $cod"; 
		}
		if(strlen($tema)>0) { 
			  $sql.= " AND arch_tema = '$tema'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND arch_nombre like '%$nom%'"; 
		}
		$sql.= " ORDER BY arch_extencion ASC, arch_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function insert_tema_archivo($cod,$tema,$nom,$desc,$extension){
		$nom = trim($nom);
		$desc = trim($desc);
		$freg = date("Y-m-d H:m:s");
		
		$sql = "INSERT INTO academ_tema_archivo";
		$sql.= " VALUES ($cod,$tema,'$nom','$desc','$extension','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_tema_archivo($cod,$tema){
		$sql = "DELETE FROM academ_tema_archivo";
		$sql.= " WHERE arch_codigo = $cod"; 	
		$sql.= " AND arch_tema = '$tema';"; 
		//echo $sql;
		return $sql;
	}
	
	function max_tema_archivo($tema) {
		
        $sql = "SELECT max(arch_codigo) as max ";
		$sql.= " FROM academ_tema_archivo";
		$sql.= " WHERE arch_tema = '$tema'";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}

	//---------- GRADO - OTRO USUARIO ----//
	
	function get_nivel_otros_usuarios($pensum,$nivel = '',$otrousu = ''){
		
        $sql= "SELECT DISTINCT(niv_codigo), niv_descripcion, niv_pensum, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, grausu_usuario, otro_cui, otro_nombre, otro_apellido, otro_titulo, otro_mail ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_grado_otros_usuarios, app_otros_usuarios ";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND grausu_pensum = gra_pensum";
		$sql.= " AND grausu_nivel = gra_nivel";
		$sql.= " AND grausu_grado = gra_codigo";
		$sql.= " AND grausu_usuario = otro_cui";
		$sql.= " AND otro_situacion = 1";
		if(strlen($pensum)>0) { 
			  $sql.= " AND grausu_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND grausu_nivel = $nivel"; 
		}
		if(strlen($otrousu)>0) { 
			  $sql.= " AND grausu_usuario = '$otrousu'"; 
		}
		$sql.= " ORDER BY pen_anio ASC, grausu_pensum ASC, grausu_nivel ASC, gra_descripcion ASC, otro_apellido ASC, otro_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_grado_otros_usuarios($pensum,$nivel,$grado = '',$otrousu = ''){
		
        $sql= " SELECT DISTINCT(gra_codigo), gra_nivel, gra_descripcion, niv_codigo, niv_descripcion, niv_pensum, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, grausu_usuario, otro_cui, otro_nombre, otro_apellido, otro_titulo, otro_mail, pen_anio, grausu_pensum, grausu_nivel, grausu_grado, gra_descripcion,";
		$sql.= " (SELECT usu_id FROM seg_usuarios WHERE usu_tipo = 1 AND usu_tipo_codigo = otro_cui) AS otro_usu_id,";
		$sql.= " (SELECT usu_nombre_pantalla FROM seg_usuarios WHERE usu_tipo = 1 AND usu_tipo_codigo = otro_cui) AS otro_nombre_pantalla";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_grado_otros_usuarios, app_otros_usuarios";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND grausu_pensum = gra_pensum";
		$sql.= " AND grausu_nivel = gra_nivel";
		$sql.= " AND grausu_grado = gra_codigo";
		$sql.= " AND grausu_usuario = otro_cui";
		$sql.= " AND otro_situacion = 1";
		if(strlen($pensum)>0) { 
			  $sql.= " AND grausu_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND grausu_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND grausu_grado = $grado"; 
		}
		if(strlen($otrousu)>0) { 
			  $sql.= " AND grausu_usuario = '$otrousu'"; 
		}
		$sql.= " ORDER BY pen_anio ASC, grausu_pensum ASC, grausu_nivel ASC, grausu_grado ASC, gra_descripcion ASC, otro_apellido ASC, otro_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_otros_usuarios_alumnos($pensum,$nivel,$grado = '',$otrousu = '',$alunombre = ''){
		if($pensum == ""){
			$pensum = $this->pensum;
		}
        $sql= "SELECT *, ";
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = alu_cui) as alu_foto,";
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_celular) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_mail_padre";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_seccion_alumno, app_alumnos, academ_grado_otros_usuarios";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum"; 
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		//-- join alumno
		$sql.= " AND seca_pensum = sec_pensum";
		$sql.= " AND seca_nivel = sec_nivel";
		$sql.= " AND seca_grado = sec_grado";
		$sql.= " AND seca_seccion = sec_codigo";
		$sql.= " AND seca_alumno = alu_cui";
		$sql.= " AND alu_situacion = 1";
		//-- Join Otros Usuarios (Autoridad)
		$sql.= " AND grausu_pensum = gra_pensum";
		$sql.= " AND grausu_nivel = gra_nivel";
		$sql.= " AND grausu_grado = gra_codigo";
		
		if(strlen($pensum)>0) { 
			$sql.= " AND grausu_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND grausu_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND grausu_grado = $grado"; 
		}
		if(strlen($otrousu)>0) { 
			$sql.= " AND grausu_usuario = '$otrousu'"; 
		}
		if(strlen($alunombre)>0) { 
			$sql.= " AND (alu_nombre like '%$alunombre%' OR alu_apellido like '%$alunombre%')"; 
		}
		$sql.= " ORDER BY pen_anio ASC, seca_pensum ASC, seca_nivel ASC, seca_grado ASC, sec_situacion DESC, sec_tipo ASC, sec_descripcion ASC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
    
	function comprueba_grado_otros_usuarios($pensum,$nivel,$grado,$otrousu){
		$tipo = trim($tipo);
		
        $sql= "SELECT *";
		$sql.= " FROM academ_grado_otros_usuarios,academ_grado";
		$sql.= " WHERE gra_pensum = grausu_pensum";
		$sql.= " AND gra_nivel = grausu_nivel";
		$sql.= " AND gra_codigo = grausu_grado";
		if(strlen($pensum)>0) { 
			  $sql.= " AND grausu_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND grausu_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND grausu_grado = $grado"; 
		}
		if(strlen($otrousu)>0) { 
			  $sql.= " AND grausu_usuario = '$otrousu'"; 
		}
		$sql.= " ORDER BY grausu_pensum ASC, grausu_nivel ASC, grausu_grado ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function comprueba_no_grado_otros_usuarios($pensum,$nivel,$grados){
		
        $sql= "SELECT *";
		$sql.= " FROM academ_grado";
		$sql.= " WHERE 1 = 1"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND gra_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND gra_nivel = $nivel"; 
		}
		if(strlen($grados)>0) { 
			  $sql.= " AND gra_codigo NOT IN($grados)"; 
		}
		$sql.= " ORDER BY gra_pensum ASC, gra_nivel ASC, gra_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
    
    function insert_grado_otros_usuarios($pensum,$nivel,$grado,$otrousu){
		
		$sql = "INSERT INTO academ_grado_otros_usuarios ";
		$sql.= " VALUES ($pensum,$nivel,$grado,'$otrousu'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_grado_otros_usuarios($pensum,$nivel,$grado,$otrousu){
		
		$sql = "DELETE FROM academ_grado_otros_usuarios ";
		
		$sql.= " WHERE grausu_pensum = $pensum"; 	
		$sql.= " AND grausu_nivel = $nivel"; 	
		$sql.= " AND grausu_grado = $grado"; 	
		$sql.= " AND grausu_usuario = '$otrousu';";
		
		//echo $sql;
		return $sql;
	}
	
	//---------- GRADO - ALUMNO ---------//

	function get_grado_alumno($pensum,$nivel,$grado = '',$alumno = '',$cod = '',$sit = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, ";
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_celular) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_mail_padre";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_grado_alumno, app_alumnos";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND graa_pensum = gra_pensum";
		$sql.= " AND graa_nivel = gra_nivel";
		$sql.= " AND graa_grado = gra_codigo";
		$sql.= " AND graa_alumno = alu_cui";
		$sql.= " AND alu_situacion = 1"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND graa_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND graa_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND graa_grado = $grado"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND graa_alumno = '$alumno'"; 
		}
		if(strlen($cod)>0) { 
			  $sql.= " AND graa_codigo = $cod"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio ASC, graa_pensum ASC, graa_nivel ASC, graa_situacion DESC, gra_descripcion ASC, alu_apellido ASC, alu_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	
	function count_grado_alumno($pensum,$nivel,$grado = '',$alumno = '',$cod = '',$sit = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_grado_alumno, app_alumnos";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND graa_pensum = gra_pensum";
		$sql.= " AND graa_nivel = gra_nivel";
		$sql.= " AND graa_grado = gra_codigo";
		$sql.= " AND graa_alumno = alu_cui";
		if(strlen($pensum)>0) { 
			  $sql.= " AND graa_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND graa_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND graa_grado = $grado"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND graa_alumno = '$alumno'"; 
		}
		if(strlen($cod)>0) { 
			  $sql.= " AND graa_codigo = $cod"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function comprueba_grado_alumno($pensum,$nivel,$grado,$cod,$alumno,$sit){
		$tipo = trim($tipo);
		
        $sql= "SELECT *";
		$sql.= " FROM academ_grado_alumno,academ_grado";
		$sql.= " WHERE gra_pensum = graa_pensum";
		$sql.= " AND gra_nivel = graa_nivel";
		$sql.= " AND gra_codigo = graa_grado";
		if(strlen($pensum)>0) { 
			  $sql.= " AND graa_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND graa_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND graa_grado = $grado"; 
		}
		if(strlen($cod)>0) { 
			  $sql.= " AND graa_codigo = $cod"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND graa_alumno = '$alumno'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND graa_situacion = $sit"; 
		}
		$sql.= " ORDER BY graa_pensum ASC, graa_nivel ASC, graa_grado ASC, graa_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
		
	function insert_grado_alumno($pensum,$nivel,$grado,$cod,$alumno){
		$desc = trim($desc);
		$tipo = trim($tipo);
		
		$sql = "INSERT INTO academ_grado_alumno ";
		$sql.= " VALUES ($pensum,$nivel,$grado,$cod,'$alumno',1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_grado_alumno($pensum,$nivel,$alumno){
		
		$sql = "DELETE FROM academ_grado_alumno ";
		
		$sql.= " WHERE graa_pensum = $pensum"; 	
		$sql.= " AND graa_nivel = $nivel"; 	
		$sql.= " AND graa_alumno = '$alumno';";
		
		//echo $sql;
		return $sql;
	}
	
		
	function cambia_sit_grado_alumno($pensum,$nivel,$grado,$cod,$alumno,$sit){
		
		$sql = "UPDATE academ_grado_alumno SET ";
		$sql.= "graa_situacion = $sit"; 
				
		$sql.= " WHERE graa_pensum = $pensum"; 	
		$sql.= " AND graa_nivel = $nivel"; 	
		$sql.= " AND graa_grado = $grado"; 	
		$sql.= " AND graa_alumno = '$alumno'"; 	
		$sql.= " AND graa_codigo = $cod;";
		
		return $sql;
	}
	
	function cambia_sit_toda_grado_alumno($pensum,$sit){
		
		$sql = "UPDATE academ_grado_alumno SET ";
		$sql.= "graa_situacion = $sit"; 
				
		$sql.= " WHERE graa_pensum = $pensum; "; 	
		
		return $sql;
	}

	function max_grado_alumno($pensum,$nivel,$grado,$alumno){
		
        $sql = "SELECT max(graa_codigo) as max ";
		$sql.= " FROM academ_grado_alumno";
		$sql.= " WHERE graa_pensum = $pensum"; 	
		$sql.= " AND graa_nivel = $nivel"; 	
		$sql.= " AND graa_grado = $grado"; 	
		$sql.= " AND graa_alumno = '$alumno'"; 	
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
	
	//---------- SECCION - ALUMNO ---------//

	function get_seccion_alumno($pensum,$nivel,$grado,$seccion = '',$alumno = '',$cod = '',$tipo = '',$sit = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, ";
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = alu_cui) as alu_foto,";
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_celular) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_mail_padre";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_seccion_alumno, app_alumnos";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum"; 
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND seca_pensum = sec_pensum";
		$sql.= " AND seca_nivel = sec_nivel";
		$sql.= " AND seca_grado = sec_grado";
		$sql.= " AND seca_seccion = sec_codigo";
		$sql.= " AND seca_alumno = alu_cui";
		if(strlen($pensum)>0) { 
			  $sql.= " AND seca_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND seca_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND seca_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND seca_seccion IN($seccion)"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND seca_alumno = '$alumno'"; 
		}
		if(strlen($cod)>0) { 
			  $sql.= " AND seca_codigo = $cod"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND sec_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio ASC, seca_pensum ASC, seca_nivel ASC, seca_grado ASC, sec_situacion DESC, sec_tipo ASC, sec_descripcion ASC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_seccion_alumno($pensum,$nivel,$grado,$seccion = '',$alumno = '',$cod = '',$tipo = '',$sit = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_seccion_alumno, app_alumnos";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND seca_pensum = sec_pensum";
		$sql.= " AND seca_nivel = sec_nivel";
		$sql.= " AND seca_grado = sec_grado";
		$sql.= " AND seca_seccion = sec_codigo";
		$sql.= " AND seca_alumno = alu_cui";
		if(strlen($pensum)>0) { 
			  $sql.= " AND seca_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND seca_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND seca_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND seca_seccion = $seccion"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND seca_alumno = '$alumno'"; 
		}
		if(strlen($cod)>0) { 
			  $sql.= " AND seca_codigo = $cod"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND sec_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function comprueba_seccion_alumno($pensum,$nivel,$grado,$seccion,$cod,$alumno,$tipo,$sit){
		$tipo = trim($tipo);
		
        $sql= "SELECT *";
		$sql.= " FROM academ_seccion_alumno,academ_secciones";
		$sql.= " WHERE seca_pensum = sec_pensum";
		$sql.= " AND seca_nivel = sec_nivel";
		$sql.= " AND seca_grado = sec_grado";
		$sql.= " AND seca_seccion = sec_codigo";
		if(strlen($pensum)>0) { 
			  $sql.= " AND seca_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND seca_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND seca_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND seca_seccion = $seccion"; 
		}
		if(strlen($cod)>0) { 
			  $sql.= " AND seca_codigo = $cod"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND seca_alumno = '$alumno'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND sec_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND seca_situacion = $sit"; 
		}
		$sql.= " ORDER BY seca_pensum ASC, seca_nivel ASC, seca_grado ASC, seca_seccion ASC, sec_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
		
	function insert_seccion_alumno($pensum,$nivel,$grado,$seccion,$cod,$alumno){
		$desc = trim($desc);
		$tipo = trim($tipo);
		
		$sql = "INSERT INTO academ_seccion_alumno ";
		$sql.= " VALUES ($pensum,$nivel,$grado,$seccion,$cod,'$alumno',1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_seccion_alumno($pensum,$alumno){
		
		$sql = "DELETE FROM academ_seccion_alumno "; 
		
		$sql.= " WHERE seca_pensum = $pensum"; 	
		$sql.= " AND seca_alumno = '$alumno';";
		
		//echo $sql;
		return $sql;
	}
	
		
	function cambia_sit_seccion_alumno($pensum,$nivel,$grado,$seccion,$cod,$alumno,$sit){
		
		$sql = "UPDATE academ_seccion_alumno SET ";
		$sql.= "seca_situacion = $sit"; 
				
		$sql.= " WHERE seca_pensum = $pensum"; 	
		$sql.= " AND seca_nivel = $nivel"; 	
		$sql.= " AND seca_grado = $grado"; 	
		$sql.= " AND seca_seccion = $seccion"; 	
		$sql.= " AND seca_alumno = '$alumno'";
		$sql.= " AND seca_codigo = $cod;"; 	
		
		return $sql;
	}
	
	function cambia_sit_toda_seccion_alumno($pensum,$sit){
		
		$sql = "UPDATE academ_seccion_alumno SET ";
		$sql.= "seca_situacion = $sit"; 
				
		$sql.= " WHERE seca_pensum = $pensum; "; 	
		
		return $sql;
	}

	function max_seccion_alumno($pensum,$nivel,$grado,$seccion,$alumno){
		
        $sql = "SELECT max(seca_codigo) as max ";
		$sql.= " FROM academ_seccion_alumno";
		$sql.= " WHERE seca_pensum = $pensum"; 	
		$sql.= " AND seca_nivel = $nivel"; 	
		$sql.= " AND seca_grado = $grado"; 	
		$sql.= " AND seca_seccion = $seccion"; 	
		$sql.= " AND seca_alumno = '$alumno'";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
	//---------- SECCION - MAESTRO ---------//
	
	function get_nivel_maestro($pensum,$nivel = '',$maestro = ''){
		
        $sql= "SELECT DISTINCT(niv_codigo), niv_descripcion, niv_pensum, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, secm_maestro ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_seccion_maestro, app_maestros";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND secm_pensum = sec_pensum";
		$sql.= " AND secm_nivel = sec_nivel";
		$sql.= " AND secm_grado = sec_grado";
		$sql.= " AND secm_seccion = sec_codigo";
		$sql.= " AND secm_maestro = mae_cui";
		$sql.= " AND mae_situacion = 1"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND secm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND secm_nivel = $nivel"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND secm_maestro = '$maestro'"; 
		}
		$sql.= " ORDER BY pen_anio ASC, secm_pensum ASC, secm_nivel ASC, secm_grado ASC, gra_descripcion ASC, mae_apellido ASC, mae_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_grado_maestro($pensum,$nivel,$grado = '',$maestro = ''){
		
        $sql= "SELECT DISTINCT(gra_codigo), CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, gra_descripcion, niv_pensum, niv_codigo, niv_descripcion, mae_cui, mae_nombre, mae_apellido,pen_anio, secm_pensum, secm_nivel, secm_grado, gra_descripcion ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_seccion_maestro, app_maestros";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND secm_pensum = sec_pensum";
		$sql.= " AND secm_nivel = sec_nivel";
		$sql.= " AND secm_grado = sec_grado";
		$sql.= " AND secm_seccion = sec_codigo";
		$sql.= " AND secm_maestro = mae_cui";
		$sql.= " AND mae_situacion = 1"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND secm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND secm_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND secm_grado = $grado"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND secm_maestro = '$maestro'"; 
		}
		$sql.= " ORDER BY pen_anio ASC, secm_pensum ASC, secm_nivel ASC, secm_grado ASC, gra_descripcion ASC, mae_apellido ASC, mae_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	

	function get_seccion_maestro($pensum,$nivel,$grado,$seccion = '',$maestro = '',$tipo = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, ";
		$sql.= " (SELECT usu_id FROM seg_usuarios WHERE usu_tipo = 2 AND usu_tipo_codigo = mae_cui) AS mae_usu_id,";
		$sql.= " (SELECT usu_nombre_pantalla FROM seg_usuarios WHERE usu_tipo = 2 AND usu_tipo_codigo = mae_cui) AS mae_nombre_pantalla";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_seccion_maestro, app_maestros";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND secm_pensum = sec_pensum";
		$sql.= " AND secm_nivel = sec_nivel";
		$sql.= " AND secm_grado = sec_grado";
		$sql.= " AND secm_seccion = sec_codigo";
		$sql.= " AND secm_maestro = mae_cui";
		$sql.= " AND mae_situacion = 1";
		
		if(strlen($pensum)>0) { 
			  $sql.= " AND secm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND secm_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND secm_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND secm_seccion = $seccion"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND secm_maestro = '$maestro'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND sec_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY pen_anio ASC, secm_pensum ASC, secm_nivel ASC, secm_grado ASC, sec_situacion DESC, sec_tipo ASC, sec_descripcion ASC, mae_apellido ASC, mae_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_maestro_alumnos($pensum,$nivel,$grado,$seccion = '',$maestro = '', $alunombre = ''){
		if($pensum == ""){
			$pensum = $this->pensum;
		}
        $sql= "SELECT *, ";
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = alu_cui) as alu_foto,";
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_celular) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_mail_padre";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_seccion_alumno, app_alumnos, academ_seccion_maestro";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum"; 
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		//-- join alumno
		$sql.= " AND seca_pensum = sec_pensum";
		$sql.= " AND seca_nivel = sec_nivel";
		$sql.= " AND seca_grado = sec_grado";
		$sql.= " AND seca_seccion = sec_codigo";
		$sql.= " AND seca_alumno = alu_cui";
		$sql.= " AND alu_situacion = 1";
		//-- Join Maestro
		$sql.= " AND secm_pensum = sec_pensum";
		$sql.= " AND secm_nivel = sec_nivel";
		$sql.= " AND secm_grado = sec_grado";
		$sql.= " AND secm_seccion = sec_codigo";
		
		if(strlen($pensum)>0) { 
			$sql.= " AND secm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND secm_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND secm_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND secm_seccion = $seccion"; 
		}
		if(strlen($maestro)>0) { 
			$sql.= " AND secm_maestro = '$maestro'"; 
		}
		if(strlen($alunombre)>0) { 
			$sql.= " AND (alu_nombre like '%$alunombre%' OR alu_apellido like '%$alunombre%')"; 
		}
		$sql.= " ORDER BY pen_anio ASC, seca_pensum ASC, seca_nivel ASC, seca_grado ASC, sec_situacion DESC, sec_tipo ASC, sec_descripcion ASC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_seccion_maestro($pensum,$nivel,$grado,$seccion = '',$maestro = '',$tipo = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_seccion_maestro, app_maestros";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND secm_pensum = sec_pensum";
		$sql.= " AND secm_nivel = sec_nivel";
		$sql.= " AND secm_grado = sec_grado";
		$sql.= " AND secm_seccion = sec_codigo";
		$sql.= " AND secm_maestro = mae_cui";
		$sql.= " AND mae_situacion = 1";
		
		if(strlen($pensum)>0) { 
			  $sql.= " AND secm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND secm_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND secm_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND secm_seccion = $seccion"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND secm_maestro = '$maestro'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND sec_tipo = '$tipo'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function comprueba_seccion_maestro($pensum,$nivel,$grado,$seccion,$maestro,$tipo){
		$tipo = trim($tipo);
		
        $sql= "SELECT *";
		$sql.= " FROM academ_seccion_maestro,academ_secciones";
		$sql.= " WHERE secm_pensum = sec_pensum";
		$sql.= " AND secm_nivel = sec_nivel";
		$sql.= " AND secm_grado = sec_grado";
		$sql.= " AND secm_seccion = sec_codigo";
		$sql.= " AND sec_situacion = 1"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND secm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND secm_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND secm_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND secm_seccion = $seccion"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND secm_maestro = '$maestro'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND sec_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY secm_pensum ASC, secm_nivel ASC, secm_grado ASC, secm_seccion ASC, sec_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function comprueba_no_seccion_maestro($pensum,$nivel,$grado,$tipo,$secciones){
		
        $sql= "SELECT *";
		$sql.= " FROM academ_secciones";
		$sql.= " WHERE 1 = 1"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND sec_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND sec_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND sec_grado = $grado"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND sec_tipo = '$tipo'"; 
		}
		if(strlen($secciones)>0) { 
			  $sql.= " AND sec_codigo NOT IN($secciones)"; 
		}
		$sql.= " ORDER BY sec_pensum ASC, sec_nivel ASC, sec_grado ASC, sec_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
		
	function insert_seccion_maestro($pensum,$nivel,$grado,$seccion,$maestro){
		$desc = trim($desc);
		$tipo = trim($tipo);
		
		$sql = "INSERT INTO academ_seccion_maestro ";
		$sql.= " VALUES ($pensum,$nivel,$grado,$seccion,'$maestro'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_seccion_maestro($pensum,$nivel,$grado,$seccion,$maestro){
		
		$sql = "DELETE FROM academ_seccion_maestro ";
		$sql.= " WHERE secm_pensum = $pensum"; 	
		$sql.= " AND secm_nivel = $nivel"; 	
		$sql.= " AND secm_grado = $grado"; 	
		$sql.= " AND secm_seccion = $seccion"; 	
		$sql.= " AND secm_maestro = '$maestro'; ";
		
		return $sql;
	}
	
	
	function delete_grupo_seccion_maestro($maestro,$pensum = '',$nivel = '',$grado = ''){
		
		$sql = "DELETE FROM academ_seccion_maestro ";
		$sql.= " WHERE secm_maestro = '$maestro'";
		if(strlen($pensum)>0) { 
			$sql.= " AND secm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND secm_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND secm_grado = $grado"; 
		}
		$sql.= ";"; //finaliza sentencia dinamica 
		
		return $sql;
	}
	
	
	//---------- MATERIA - MAESTRO ---------//

	function get_materia_maestro($pensum,$nivel,$grado,$materia = '',$maestro = '',$tipo = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT * ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia, academ_materia_maestro, app_maestros";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND matm_pensum = mat_pensum";
		$sql.= " AND matm_nivel = mat_nivel";
		$sql.= " AND matm_grado = mat_grado";
		$sql.= " AND matm_materia = mat_codigo";
		$sql.= " AND matm_maestro = mae_cui";
		$sql.= " AND mae_situacion = 1"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND matm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND matm_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND matm_grado = $grado"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND matm_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND matm_maestro = '$maestro'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mat_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mae_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio ASC, matm_pensum ASC, matm_nivel ASC, matm_grado ASC, mat_situacion DESC, mat_tipo ASC, mat_descripcion ASC, mae_apellido ASC, mae_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_materia_maestro($pensum,$nivel,$grado,$materia = '',$maestro = '',$tipo = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia, academ_materia_maestro, app_maestros";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND matm_pensum = mat_pensum";
		$sql.= " AND matm_nivel = mat_nivel";
		$sql.= " AND matm_grado = mat_grado";
		$sql.= " AND matm_materia = mat_codigo";
		$sql.= " AND matm_maestro = mae_cui";
		$sql.= " AND mae_situacion = 1"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND matm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND matm_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND matm_grado = $grado"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND matm_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND matm_maestro = '$maestro'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mat_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mae_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function comprueba_materia_maestro($pensum,$nivel,$grado,$materia,$maestro,$tipo){
		$tipo = trim($tipo);
		
        $sql= "SELECT *";
		$sql.= " FROM academ_materia_maestro,academ_materia";
		$sql.= " WHERE matm_pensum = mat_pensum";
		$sql.= " AND matm_nivel = mat_nivel";
		$sql.= " AND matm_grado = mat_grado";
		$sql.= " AND matm_materia = mat_codigo";
		$sql.= " AND mat_situacion = 1"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND matm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND matm_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND matm_grado = $grado"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND matm_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND matm_maestro = '$maestro'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mat_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY matm_pensum ASC, matm_nivel ASC, matm_grado ASC, matm_materia ASC, mat_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function comprueba_no_materia_maestro($pensum,$nivel,$grado,$tipo,$materias){
		
        $sql= "SELECT *";
		$sql.= " FROM academ_materia";
		$sql.= " WHERE  1 = 1"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND mat_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND mat_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND mat_grado = $grado"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mat_tipo = '$tipo'"; 
		}
		if(strlen($materias)>0) { 
			  $sql.= " AND mat_codigo NOT IN($materias)"; 
		}
		$sql.= " ORDER BY mat_pensum ASC, mat_nivel ASC, mat_grado ASC, mat_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
		
	function insert_materia_maestro($pensum,$nivel,$grado,$materia,$maestro){
		$desc = trim($desc);
		$tipo = trim($tipo);
		
		$sql = "INSERT INTO academ_materia_maestro ";
		$sql.= " VALUES ($pensum,$nivel,$grado,$materia,$maestro); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_materia_maestro($pensum,$nivel,$grado,$materia,$maestro){
		
		$sql = "DELETE FROM academ_materia_maestro ";
		$sql.= " WHERE matm_pensum = $pensum"; 	
		$sql.= " AND matm_nivel = $nivel"; 	
		$sql.= " AND matm_grado = $grado"; 	
		$sql.= " AND matm_materia = $materia"; 	
		$sql.= " AND matm_maestro = $maestro; ";
		
		return $sql;
	}
	
	function delete_grupo_materia_maestro($maestro,$pensum = '',$nivel = '',$grado = ''){
		
		$sql = "DELETE FROM academ_materia_maestro ";
		$sql.= " WHERE matm_maestro = $maestro";
		if(strlen($pensum)>0) { 
			$sql.= " AND matm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND matm_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND matm_grado = $grado"; 
		}
		$sql.= ";"; /// finaliza sentencia dinamica
		return $sql;
	}

	
	
	function get_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,$materia,$maestro, $tipo = ''){
		
        $sql= "SELECT *, mat_descripcion as materia_descripcion";
        $sql.= " FROM academ_materia_seccion_maestro, app_maestros, academ_materia";
		$sql.= " WHERE mat_pensum = secmat_pensum";
        $sql.= " AND mat_nivel = secmat_nivel";
        $sql.= " AND mat_grado = secmat_grado";
        $sql.= " AND mat_codigo = secmat_materia";
		$sql.= " AND mae_cui = secmat_maestro";
        $sql.= " AND mae_situacion = 1";
		$sql.= " AND mat_situacion = 1";
		if(strlen($pensum)>0) { 
			  $sql.= " AND secmat_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND secmat_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND secmat_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND secmat_seccion = $seccion"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND secmat_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND secmat_maestro = '$maestro'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mat_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY secmat_pensum ASC, secmat_nivel ASC, secmat_grado ASC, mat_tipo DESC, mae_apellido ASC, mae_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function comprueba_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,$materia,$maestro){
		
        $sql= "SELECT *";
		$sql.= " FROM academ_materia_seccion_maestro";
		$sql.= " WHERE 1 = 1";
		if(strlen($pensum)>0) { 
			  $sql.= " AND secmat_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND secmat_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND secmat_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND secmat_seccion = $seccion"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND secmat_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND secmat_maestro = $maestro"; 
		}
		$sql.= " ORDER BY secmat_pensum ASC, secmat_nivel ASC, secmat_grado ASC, secmat_seccion ASC, secmat_materia ASC, secmat_maestro ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function insert_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,$materia,$maestro){
		$desc = trim($desc);
		$tipo = trim($tipo);
		
		$sql = "INSERT INTO academ_materia_seccion_maestro ";
		$sql.= " VALUES ('$pensum','$nivel','$grado','$seccion','$materia','$maestro') ";
        $sql.= " ON DUPLICATE KEY UPDATE ";
        $sql.= "secmat_pensum = '$pensum',"; 	
		$sql.= "secmat_nivel = '$nivel',"; 	
		$sql.= "secmat_grado = '$grado',"; 	
		$sql.= "secmat_seccion = '$seccion',"; 	
		$sql.= "secmat_materia = '$materia',"; 	
		$sql.= "secmat_maestro = '$maestro';";
		//echo $sql;
		return $sql;
	}
	
	function delete_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,$materia,$maestro){
		
		$sql = "DELETE FROM academ_materia_seccion_maestro ";
		$sql.= " WHERE secmat_pensum = $pensum"; 	
		$sql.= " AND secmat_nivel = $nivel"; 	
		$sql.= " AND secmat_grado = $grado"; 	
		$sql.= " AND secmat_seccion = $seccion"; 	
		$sql.= " AND secmat_materia = $materia"; 	
		$sql.= " AND secmat_maestro = $maestro; ";
		
		return $sql;
	}
	
	//---------- FICHA PRICOPEDAGÓGICA ---------//

	function get_comentario_psicopedagogico($codigo,$alumno, $pensum = '', $nivel = '', $grado = '',$seccion = '',$sit = ''){
		
        $sql= "SELECT *,";
		$sql.= " (SELECT usu_nombre FROM seg_usuarios WHERE usu_id = psi_usuario_registro) as usu_nombre_registro";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, app_alumnos, academ_psicopedagogica";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND psi_pensum = sec_pensum";
		$sql.= " AND psi_nivel = sec_nivel";
		$sql.= " AND psi_grado = sec_grado";
		$sql.= " AND psi_seccion = sec_codigo";
		$sql.= " AND psi_alumno = alu_cui";
		if(strlen($codigo)>0) { 
			  $sql.= " AND psi_codigo = $codigo"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND psi_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND psi_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND psi_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND psi_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND psi_seccion = $seccion"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND psi_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio DESC, psi_pensum DESC, psi_nivel DESC, psi_grado DESC, psi_fechor_registro DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_comentario_psicopedagogico($codigo,$alumno, $pensum = '', $nivel = '', $grado = '',$seccion = '',$sit = ''){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, app_alumnos, academ_psicopedagogica";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND psi_pensum = sec_pensum";
		$sql.= " AND psi_nivel = sec_nivel";
		$sql.= " AND psi_grado = sec_grado";
		$sql.= " AND psi_seccion = sec_codigo";
		$sql.= " AND psi_alumno = alu_cui";
		if(strlen($codigo)>0) { 
			  $sql.= " AND psi_codigo = $codigo"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND psi_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND psi_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND psi_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND psi_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND psi_seccion = $seccion"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
		
	function insert_comentario_psicopedagogico($codigo,$alumno,$pensum,$nivel,$grado,$seccion,$comentario){
		$comentario = trim($comentario);
		//--
		$usu = $_SESSION["codigo"];
		$fsis = date("Y-m-d H:m:s");
		
		$sql = "INSERT INTO academ_psicopedagogica ";
		$sql.= " VALUES ($codigo,'$alumno',$pensum,$nivel,$grado,$seccion,'$comentario',$usu,'$fsis',$usu,'$fsis',1); ";
		//echo $sql;
		return $sql;
	}	
	
		
	function update_comentario_psicopedagogico($codigo,$cui,$comentario){
		$comentario = trim($comentario);
		//--
		$usu = $_SESSION["codigo"];
		$fsis = date("Y-m-d H:m:s");
		
		$sql = "UPDATE academ_psicopedagogica SET";
		$sql.= " psi_comentario = '$comentario',";
		$sql.= " psi_usuario_update = $usu,";
		$sql.= " psi_fechor_update = '$fsis'"; 
				
		$sql.= " WHERE psi_codigo = $codigo"; 	
		$sql.= " AND psi_alumno = '$cui';"; 	
		
		return $sql;
	}
	
	function cambia_comentario_psicopedagogico($codigo,$cui,$sit){
		
		$sql = "UPDATE academ_psicopedagogica SET ";
		$sql.= "psi_situacion = $sit"; 
				
		$sql.= " WHERE psi_codigo = $codigo"; 	
		$sql.= " AND psi_alumno = '$cui';"; 	
		
		return $sql;
	}
	
	function max_comentario_psicopedagogico($cui){
		
        $sql = "SELECT max(psi_codigo) as max ";
		$sql.= " FROM academ_psicopedagogica";
		$sql.= " WHERE psi_alumno = '$cui'";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}


	
}	
?>