<?php
$enlace = "../../CPINVENTARIOSUMINISTRO/INVENTARIO/formato_suministros.csv";
header ("Content-Disposition: attachment; filename=formato_suministros.csv");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);

?>
