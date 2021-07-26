<?php

function mail_constructor($nombre, $telefono, $mail, $titulo, $message){	
	return $salida = '
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ASMS</title>
		<style>
			 body{
				 font-family: Arial, sans-serif;
				 font-size: 14px;
				 color: #585858;
			 }
		</style>
  </head>
<body style="margin: 0; padding: 0;">
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td>
			<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
				<tr>		
					<td align="center" bgcolor="#F9F9F9" style="padding: 40px 0 30px 0; border: 1px solid transparent;border-radius: 4px;border-color: #EDEDED;">
						<img src="https://'. $_SERVER['HTTP_HOST'].'/CONFIG/images/logo.png" width="60%">
					</td>
				</tr>
				<tr>		
					<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
						
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td align = "center">
									<h1>'.$titulo.'</h1>
								</td>
							</tr>
							<tr>
								<td>
									<label style="font-size: 18px;font-weight: bold;">Nombre:</label>
									<p>'.$nombre.'</p>
								</td>
							</tr>
							<tr>
								<td>
									<label style="font-size: 18px;font-weight: bold;">Tel&eacute;fono:</label>
									<p>'.$telefono.'</p>
								</td>
							</tr>
							<tr>
								<td>
									<label style="font-size: 18px;font-weight: bold;">e-mail:</label>
									<p>'.$mail.'</p>
								</td>
							</tr>
							<tr>
								<td align="justify">
									<hr>
									<p>'.$message.'</p>
								</td>
							</tr>	
						</table>
						
					</td>
				</tr>
				<tr>		
					<td bgcolor="#c4c4c4" style="padding: 30px 30px 30px 30px;">
						
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td align="center">
									<table border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td align = "center">
												<a href="http://www.facebook.com/"><img src="https://'. $_SERVER['HTTP_HOST'].'/CONFIG/images/facebook.png" alt="facebook" width="38" height="38" style="display: block; margin: 3px;" border="0" /></a>
											</td>
											<td align = "center">
												<a href="http://www.twitter.com/"><img src="https://'. $_SERVER['HTTP_HOST'].'/CONFIG/images/twiter.png" alt="Twitter" width="38" height="38" style="display: block; margin: 3px;" border="0" /></a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align = "center">
									<p style="font-size: 18px; font-weight: bold; color: #fff;">Copyright © ASMS Team '.date("Y").' </p>
									<p style="color: #777777;">Power by Inversiones Digitales S.A.</p>
								</td>
							</tr>
						</table>
						
					</td>
				</tr>
			</table>
		
		</td> 
	</tr>
</table>
 <br>
</body>
</html>
	';
}

//echo mail_constructor($nombre, $telefono, $mail, $titulo, $message);
?>