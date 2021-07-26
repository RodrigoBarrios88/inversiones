<?php

$megas_dominio = 0;
$megas_dominio+= listarArchivos( 'CARGAS/' );
$megas_dominio+= listarArchivos( 'CARGASTEMPORTALES/' );
$megas_dominio+= listarArchivos( 'Circulares/' );
$megas_dominio+= listarArchivos( 'DATALMS/TAREAS/CURSOS/' );
$megas_dominio+= listarArchivos( 'DATALMS/TAREAS/MATERIAS/' );
$megas_dominio+= listarArchivos( 'DATALMS/TEMAS/CURSOS/' );
$megas_dominio+= listarArchivos( 'DATALMS/TEMAS/MATERIAS/' );
$megas_dominio+= listarArchivos( 'DATALMS/TEST/CURSOS/' );
$megas_dominio+= listarArchivos( 'DATALMS/TEST/MATERIAS/' );
$megas_dominio+= listarArchivos( 'DATALMSALUMNOS/TAREAS/CURSOS/' );
$megas_dominio+= listarArchivos( 'DATALMSALUMNOS/TAREAS/MATERIAS/' );
$megas_dominio+= listarArchivos( 'DATALMSALUMNOS/TEST/CURSOS/' );
$megas_dominio+= listarArchivos( 'DATALMSALUMNOS/TEST/MATERIAS/' );

$gigas_dominio = floatval($megas_dominio) / 1000; // Convierte Bytes a Megas
echo "<br><hr><br> Tota Size del Dominio: ".$megas_dominio." MB | <b>".$gigas_dominio." GB</b><br>";


function listarArchivos( $path_inicial ){

     $path = "../CONFIG/".$path_inicial;
     // Abrimos la carpeta que nos pasan como parámetro
     $dir = opendir($path);

     $bytes_totales = 0;
     // Leo todos los ficheros de la carpeta
     while ($elemento = readdir($dir)){
          // Tratamos los elementos . y .. que tienen todas las carpetas
          if( $elemento != "." && $elemento != ".."){
               // Si es una carpeta
               if( is_dir($path.$elemento) ){
                    // Si es carpeta no la muestra
               } else {
                    // Descarga el fichero
                    $bytes = filesize($path.$elemento);
                    $bytes_totales+= floatval($bytes);
                    $megas = floatval($bytes) / 1000000; // Convierte Bytes a Megas
                    //echo $elemento." | Size: ".$megas." MB<br>";
               }
          }
     }
     //---
     $megas_totales = floatval($bytes_totales) / 1000000; // Convierte Bytes a Megas
     $gigas_totales = floatval($megas_totales) / 1000; // Convierte Bytes a Megas
     echo "Directorio: <b>".$path_inicial."</b> | Peso de la carpeta: ".$megas_totales." MB | <b>".$gigas_totales." GB</b><br>";
     return $megas_totales;
}

?>
