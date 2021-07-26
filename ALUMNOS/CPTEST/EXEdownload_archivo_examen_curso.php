<?php
$archivo = $_REQUEST["archivo"];
$archivo_url = "../../CONFIG/DATALMSALUMNOS/TEST/CURSOS/$archivo";
header ("Content-Disposition: attachment; filename=TEST_ALUMNO_$archivo");
header ("Content-Type: ".filetype($archivo_url));
header ("Content-Length: ".filesize($archivo_url));
readfile($archivo_url);
?>
