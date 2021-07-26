<?php
$archivo = $_REQUEST["archivo"];
$archivo_url = "../CONFIG/Circulares/$archivo";
header ("Content-Disposition: attachment; filename=CIRCULAR_$archivo");
header ("Content-Type: ".filetype($archivo_url));
header ("Content-Length: ".filesize($archivo_url));
readfile($archivo_url);

?>
