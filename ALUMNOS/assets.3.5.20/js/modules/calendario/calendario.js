//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "Desea Limpiar la Pagina?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
			}
			
			function Submit(){
				myform = document.forms.f1;
				myform.submit();
			}
								
			function pageprint(){
				boton = document.getElementById("print");
				boton.style.display="none";
				window.print();
				boton.style.display="block";
			}
			
			function Ver_Informacion(cod){	
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/calendario/informacion.php",{codigo:cod}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			