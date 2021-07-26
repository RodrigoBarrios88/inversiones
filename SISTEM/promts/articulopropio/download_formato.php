<?php
$enlace = "../../CPARTPROPIOS/INVENTARIO/formato_maquinaria_equipo.csv";
header ("Content-Disposition: attachment; filename=formato_maquinaria_equipo.csv");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);

?>
