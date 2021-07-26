<?php
$enlace = "../../CPSERVICIOS/INVENTARIO/formato_servicios.csv";
header ("Content-Disposition: attachment; filename=formato_servicios.csv");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);

?>
