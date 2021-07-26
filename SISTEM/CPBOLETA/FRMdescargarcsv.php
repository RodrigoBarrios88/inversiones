<?php
$archivo = $_REQUEST["name"];
//echo "CARGAS/$archivo";
header("Content-disposition: attachment; filename=CARGAS/$archivo");
header("Content-type: MIME");
readfile("../../CONFIG/CARGAS/$archivo");
?>