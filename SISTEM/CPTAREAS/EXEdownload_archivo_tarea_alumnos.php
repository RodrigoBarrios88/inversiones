<?php
$archivo = $_REQUEST["archivo"];
$archivo_url = "../../CONFIG/DATALMSALUMNOS/TAREAS/MATERIAS/$archivo";
header ("Content-Disposition: attachment; filename=TAREA_ALUMNO_$archivo");
header ("Content-Type: ".filetype($archivo_url));
header ("Content-Length: ".filesize($archivo_url));
readfile($archivo_url);
?>
