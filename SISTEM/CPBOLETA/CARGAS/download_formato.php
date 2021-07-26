<?php
$enlace = "formato_carga_electronica.csv";
header ("Content-Disposition: attachment; filename=formato_carga_electronica.csv");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);

?>
