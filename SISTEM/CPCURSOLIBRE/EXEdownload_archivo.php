<?php
$archivo = $_REQUEST["archivo"];
$archivo_url = "../../CONFIG/DATALMS/TEMAS/CURSOS/$archivo";
header ("Content-Disposition: attachment; filename=TEMA_$archivo");
header ("Content-Type: ".filetype($archivo_url));
header ("Content-Length: ".filesize($archivo_url));
readfile($archivo_url);

?>
