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
			
			
			function Responder(encuesta,pregunta,persona,tipo,ponderacion,respuesta){
				//texto = "xajax_Grabar_Respuesta('"+encuesta+"','"+pregunta+"','"+persona+"','"+tipo+"','"+ponderacion+"','"+respuesta+"');";
				//acc = "";
				//alert(encuesta+","+pregunta+","+persona+","+tipo+","+ponderacion+","+respuesta);
				texto = "Quiere responder esta pregunta?";
				acc = "xajax_Grabar_Respuesta('"+encuesta+"','"+pregunta+"','"+persona+"','"+tipo+"','"+ponderacion+"','"+respuesta+"');";
				//acc = "xajax_Prueba();";
				ConfirmacionJs(texto,acc);
			}
			
			