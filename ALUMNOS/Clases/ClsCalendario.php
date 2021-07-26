<?php
require_once ("ClsConex.php");

class ClsCalendario extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  INFORMACION //////////////////////////////////////
  
    function get_informacion($codigo = '',$pensum = '',$nivel = '',$grado = '',$seccion = '', $grupo = '', $imagen = '', $target = '', $tipo = '') {
		$target = trim($target);
		
	    $sql= "(SELECT DISTINCT(inf_codigo) as inf_todo_codigo, inf_nombre as inf_todo_nombre, inf_descripcion as inf_todo_descripcion,";
		$sql.= "     inf_fecha_inicio as inf_todo_fecha_inicio, inf_fecha_fin as inf_todo_fecha_fin, inf_fecha_registro as inf_todo_fecha_registro,";
		$sql.= "     inf_target as inf_todo_target, inf_tipo_target as inf_todo_tipo_target, inf_imagen as inf_todo_imagen, inf_link as inf_todo_link,";
		$sql.= "     inf_situacion as inf_todo_situacion, NULL as inf_todo_pensum, NULL as inf_todo_nivel, NULL as inf_todo_grado, NULL as inf_todo_seccion, NULL as inf_todo_grupo";
		$sql.= " FROM vista_informacion_todos";
        $sql.= " WHERE YEAR(inf_fecha_inicio) = ".date("Y");
		if(strlen($codigo)>0) { 
			$sql.= " AND inf_codigo = $codigo"; 
		}
		if($imagen=='TRUE' || $imagen=='true') { 
			$sql.= " AND inf_imagen <> ''"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND inf_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND inf_tipo_target = '$tipo'"; 
		}
		$sql.= " )";
		
		$sql.= "     UNION";
		$sql.= " (SELECT DISTINCT(inf_codigo) as inf_seccion_codigo, inf_nombre as inf_seccion_nombre, inf_descripcion as inf_seccion_descripcion,";
		$sql.= "     inf_fecha_inicio as inf_seccion_fecha_inicio, inf_fecha_fin as inf_seccion_fecha_fin, inf_fecha_registro as inf_seccion_fecha_registro,";
		$sql.= "     inf_target as inf_seccion_target, inf_tipo_target as inf_seccion_tipo_target, inf_imagen as inf_seccion_imagen, inf_link as inf_seccion_link,";
		$sql.= "     inf_situacion as inf_seccion_situacion, det_pensum as inf_seccion_pensum, det_nivel as inf_seccion_nivel, det_grado as inf_seccion_grado, det_seccion as inf_seccion_seccion, NULL as inf_seccion_grupo";
		$sql.= " FROM vista_informacion_secciones";
		$sql.= " WHERE YEAR(inf_fecha_inicio) = ".date("Y");
		if(strlen($codigo)>0) { 
			$sql.= " AND inf_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND det_pensum IN($pensum)"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND det_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND det_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND det_seccion IN($seccion)"; 
		}
		if($imagen=='TRUE' || $imagen=='true') { 
			$sql.= " AND inf_imagen <> ''"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND inf_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND inf_tipo_target = '$tipo'"; 
		}
		$sql.= " )";
		
		$sql.= "     UNION";
		$sql.= " (SELECT DISTINCT(inf_codigo) as inf_grupo_codigo, inf_nombre as inf_grupo_nombre, inf_descripcion as inf_grupo_descripcion,";
		$sql.= "     inf_fecha_inicio as inf_grupo_fecha_inicio, inf_fecha_fin as inf_grupo_fecha_fin, inf_fecha_registro as inf_grupo_fecha_registro,";
		$sql.= "     inf_target as inf_grupo_target, inf_tipo_target as inf_grupo_tipo_target, inf_imagen as inf_grupo_imagen, inf_link as inf_grupo_link,";
		$sql.= "     inf_situacion as inf_grupo_situacion, NULL as inf_grupo_pensum, NULL as inf_grupo_nivel, NULL as inf_grupo_grado, NULL as inf_grupo_seccion, det_grupo as inf_grupo_grupo";
		$sql.= " FROM vista_informacion_grupos";
		$sql.= " WHERE YEAR(inf_fecha_inicio) = ".date("Y");
		if(strlen($codigo)>0) { 
			$sql.= " AND inf_codigo = $codigo"; 
		}
		if(strlen($grupo)>0) { 
			$sql.= " AND det_grupo IN($grupo)"; 
		}
		if($imagen=='TRUE' || $imagen=='true') { 
			$sql.= " AND inf_imagen <> ''"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND inf_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND inf_tipo_target = '$tipo'"; 
		}
		$sql.= " )";
		
		$sql.= " ORDER BY inf_todo_fecha_inicio ASC, inf_todo_codigo ASC";

		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	
	function get_circulares($codigo = '',$pensum = '',$nivel = '',$grado = '',$seccion = '', $grupo = '', $target = '', $tipo = '') {
		$target = trim($target);
		
	    $sql= "(SELECT DISTINCT(cir_codigo) as cir_todo_codigo, cir_titulo as cir_todo_titulo, cir_descripcion as cir_todo_descripcion,cir_fecha_publicacion as cir_todo_fecha_publicacion,";
        $sql.= "    cir_target as cir_todo_target, cir_tipo_target as cir_todo_tipo_target, cir_documento as cir_todo_documento, cir_autorizacion as cir_todo_autorizacion,";
        $sql.= "    cir_situacion as cir_todo_situacion, NULL as cir_todo_pensum, NULL as cir_todo_nivel, NULL as cir_todo_grado, NULL as cir_todo_seccion, NULL as cir_todo_grupo";
        $sql.= "    FROM vista_circular_todos";
        $sql.= " WHERE YEAR(cir_fecha_publicacion) = ".date("Y");
		if(strlen($codigo)>0) { 
			$sql.= " AND cir_codigo = $codigo"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND cir_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cir_tipo_target = '$tipo'"; 
		}
        $sql.= ")";
        
        $sql.= " UNION";
        $sql.= "     (SELECT DISTINCT(cir_codigo) as cir_seccion_codigo, cir_titulo as cir_seccion_titulo, cir_descripcion as cir_seccion_descripcion,cir_fecha_publicacion as cir_seccion_fecha_publicacion,";
        $sql.= "    cir_target as cir_seccion_target, cir_tipo_target as cir_seccion_tipo_target, cir_documento as cir_seccion_documento, cir_autorizacion as cir_seccion_autorizacion,";
        $sql.= "    cir_situacion as cir_seccion_situacion, det_pensum as cir_seccion_pensum, det_nivel as cir_seccion_nivel, det_grado as cir_seccion_grado, det_seccion as cir_seccion_seccion, NULL as cir_seccion_grupo";
        $sql.= "     FROM vista_circular_secciones";
        $sql.= " WHERE YEAR(cir_fecha_publicacion) = ".date("Y");
        if(strlen($codigo)>0) { 
			$sql.= " AND cir_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND det_pensum IN($pensum)"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND det_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND det_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND det_seccion IN($seccion)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND cir_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cir_tipo_target = '$tipo'"; 
		}
        $sql.= ")";
        
        $sql.= " UNION";
        $sql.= "     (SELECT DISTINCT(cir_codigo) as cir_grupo_codigo, cir_titulo as cir_grupo_titulo, cir_descripcion as cir_grupo_descripcion,cir_fecha_publicacion as cir_grupo_fecha_publicacion,";
        $sql.= "    cir_target as cir_grupo_target, cir_tipo_target as cir_grupo_tipo_target, cir_documento as cir_grupo_documento, cir_autorizacion as cir_grupo_autorizacion,";
        $sql.= "    cir_situacion as cir_grupo_situacion, NULL as cir_grupo_pensum, NULL as cir_grupo_nivel, NULL as cir_grupo_grado, NULL as cir_grupo_seccion, det_grupo as cir_grupo_grupo";
        $sql.= "     FROM vista_circular_grupos";
        $sql.= " WHERE YEAR(cir_fecha_publicacion) = ".date("Y");
        if(strlen($codigo)>0) { 
			$sql.= " AND cir_codigo = $codigo"; 
		}
		if(strlen($grupo)>0) { 
			$sql.= " AND det_grupo IN($grupo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND cir_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cir_tipo_target = '$tipo'"; 
		}
		$sql.= ")";
        
        $sql.= " ORDER BY cir_todo_fecha_publicacion DESC, cir_todo_codigo ASC";

		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;

	}

}

?>
