<?php
$enlace = "../../CPINVENTARIO/INVENTARIO/formato_articulos.csv";
header ("Content-Disposition: attachment; filename=formato_articulos.csv");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);

?>
