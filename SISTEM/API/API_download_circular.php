<?php
$documento = $_REQUEST["documento"];
$enlace = "https://" . $_SERVER['HTTP_HOST'] ."/CONFIG/Circulares/".$documento;
header ("Content-Disposition: attachment; filename=$documento.pdf");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);

?>
