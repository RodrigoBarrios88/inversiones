<?php

/*$nombre = "Nombre Apellido";
$telefono = "(502) 5555-0000";
$mail = "mail@sinmail.com";
$titulo = utf8_decode("El titulo aquí");
$message = utf8_decode("Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.
					   Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500,
					   cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y
					   los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años,
					   sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original.
					   Fue popularizado en los 60s con la creación de las hojas 'Letraset', las cuales contenian pasajes de Lorem Ipsum,
					   y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.");*/

function mail_constructor($titulo, $message, $url){
	return $salida = '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ASMS</title>
    <style>
		html {
			font-family: sans-serif;
			line-height: 1.15;
			-webkit-text-size-adjust: 100%;
		}
		body {
			font-family: Georgia, sans-serif;
			font-size: 13px;
			font-weight: 300;
			line-height: 1.5;
			color: #212529;
			margin: 0;
		}
		*, ::before, ::after {
			box-sizing: inherit;
		}
		.container {
			width: 90%;
			max-width: 1020px;
			padding: 5px 5px;
			margin-right: auto;
			margin-left: auto;
		}
		.seccion {
			background-color: #F9F9F9;
			border: 1px solid transparent;
				border-top-color: transparent;
				border-right-color: transparent;
				border-bottom-color: transparent;
				border-left-color: transparent;
			border-radius: 4px;
			border-color: #EDEDED;
		}
		.row {
			display: -ms-flexbox;
			display: flex;
			-ms-flex-wrap: wrap;
			flex-wrap: wrap;
			margin-right: 0px;
			margin-left: 0px;
		}
		.col-lg-12 {
			flex: 0 0 100%;
			max-width: 100%;
			position: relative;
			width: 100%;
			min-height: 1px;
			padding-right: 15px;
			padding-left: 15px;
		}
		label {
			font-weight: bold;
			color: #585858;
			font-style: normal;
			font-size: 14px;
			letter-spacing: .20px;
			text-transform: none;
			line-height: 2em;
			 display: inline-block;
			margin-bottom: .5rem;
		}
		p {
			font-weight: 300;
			font-style: normal;
			font-size: 14px;
			letter-spacing: .60px;
			text-transform: none;
			line-height: 1.2em;
			color: #585858;
		}
		hr {
			margin-top: 1rem;
			margin-bottom: 1rem;
			border: 0;
				border-top-width: 0px;
				border-top-style: none;
				border-top-color: currentcolor;
			border-top: 1px solid rgba(0, 0, 0, 0.1);
			box-sizing: content-box;
			height: 0;
			overflow: visible;
		}
		.prefooter {
			padding: 20px 0px 20px 0px;
			background-color: #949494;
		}
		footer {
			background-color: #c4c4c4;
			display: block;
		}
		
		.text-center {
			text-align: center !important;
		}
		.text-white {
			color: #fff !important;
		}
		
	</style>
  </head>
  <body>
    <div class="container">
		<div class="seccion text-center">
			<img src="'.$url.'/Logos/escudo.png" width="30%" >
			<br><br>
			<h1>'.$titulo.'</h1>
			<br>
		</div>
		<br>
		<hr>
		<div class="row">
			<div class="col-lg-12">
				<p class="text-justify">'.$message.'</p>
			</div>
		</div>
	</div>
	<br><br><br><br>
	<br><br><br><br>	
    <div class="prefooter">
      <br><br>
    </div>
    <!-- Footer -->
    <footer class="">
		<br><br>
		<div class="footer-containe">
		  <p class="m-0 text-center text-white">NEWS</p>
		  <p class="m-0 text-center text-white">Copyright &copy; Inversiones Digitales S.A. 2017.</p>
		  <p class="text-center"><small class="m-0 text-center text-muted">Power by ASMS team</small></p><br>
		</div>
      <!-- /.container -->
    </footer>

  </body>

</html>
	';
}
?>
