<?php
$archivo = $_REQUEST["archivo"];
$archivo_url = "../../CONFIG/DATALMS/TEST/MATERIAS/$archivo";
header ("Content-Disposition: attachment; filename=TEST_GUIA_$archivo");
header ("Content-Type: ".filetype($archivo_url));
header ("Content-Length: ".filesize($archivo_url));
readfile($archivo_url);

?>
