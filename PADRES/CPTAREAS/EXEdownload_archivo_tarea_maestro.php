<?php
$archivo = $_REQUEST["archivo"];
$archivo_url = "../../CONFIG/DATALMS/TAREAS/MATERIAS/$archivo";
header ("Content-Disposition: attachment; filename=TAREA_GUIA_$archivo");
header ("Content-Type: ".filetype($archivo_url));
header ("Content-Length: ".filesize($archivo_url));
readfile($archivo_url);

?>
