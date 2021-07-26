<?php
$archivo = $_REQUEST["archivo"];
$archivo = "../../CONFIG/DATALMS/TEST/CURSOS/$archivo";
header ("Content-Disposition: attachment; filename=$archivo");
header ("Content-Type: ".filetype($archivo));
header ("Content-Length: ".filesize($archivo));
readfile($archivo);

?>
