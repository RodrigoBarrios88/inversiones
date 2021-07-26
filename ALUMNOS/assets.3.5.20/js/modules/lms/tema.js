//funciones javascript y validaciones
			
			function Limpiar(){
				texto = "\u00BFDesea Limpiar la Pagina?, perdera los datos escritos...";
				acc = "location.reload();";
				ConfirmacionJs(texto,acc);
			}
			
			function Submit(){
				myform = document.forms.f1;
				myform.submit();
			}
								
			function pageprint(){
				boton = document.getElementById("print");
				boton.className = "hidden";
				window.print();
				boton.className = "btn btn-default";
			}
						
			function Grabar(){
				abrir();
				curso = document.getElementById("curso");
				nom = document.getElementById("nom");
				desc = document.getElementById("desc");
				
				if(curso.value !=="" && nom.value !=="" && desc.value !==""){
					xajax_Grabar_Tema(curso.value,nom.value,desc.value);
					//botones
					gra = document.getElementById('grab');
					mod = document.getElementById("mod");
					mod.className = 'btn btn-primary hidden';
					gra.className = 'btn btn-primary hidden';
				}else{
					if(nom.value ===""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					if(desc.value ===""){
						desc.className = " form-danger";
					}else{
						desc.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			function Modificar(){
				abrir();
				cod = document.getElementById("cod");
				curso = document.getElementById("curso");
				nom = document.getElementById("nom");
				desc = document.getElementById("desc");
				clase = document.getElementById("clase");
				sede = document.getElementById("sede");
				cupo = document.getElementById("cupo");
				fini = document.getElementById("fini");
				ffin = document.getElementById("ffin");
				
				if(cod.value !=="" && curso.value !=="" && nom.value !=="" && desc.value !==""){
					xajax_Modificar_Tema(cod.value,curso.value,nom.value,desc.value);
					//botones
					gra = document.getElementById('grab');
					mod = document.getElementById("mod");
					mod.className = 'btn btn-primary hidden';
					gra.className = 'btn btn-primary hidden';
				}else{
					if(nom.value ===""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					if(desc.value ===""){
						desc.className = " form-danger";
					}else{
						desc.className = " form-control";
					}
					msj = '<h5>Debe llenar los Campos Obligatorios</h5><br><br>';
					msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button> ';
					document.getElementById('lblparrafo').innerHTML = msj;
					
				}
			}
			
			
			function Deshabilita_Tema(codigo,curso){
				texto = "\u00BFEsta seguro de Deshabilitar esta Tema?, No podra ser usado con esta situaci\u00F3n...";
				acc = "xajax_Situacion_Tema("+codigo+","+curso+");";
				ConfirmacionJs(texto,acc);
			}
			
	//////////////// ARCHIVOS //////////////////////
	
			function NewFile(tema,curso,fila){
				//Realiza una peticion de contenido a la contenido.php
				$.post("../promts/cursoslibres/cargar_archivo_tema.php",{tema:tema,curso:curso,fila:fila}, function(data){
				// Ponemos la respuesta de nuestro script en el DIV recargado
				$("#Pcontainer").html(data);
				});
				abrirModal();
			}
			
			
			function FileJs(){
				nom = document.getElementById("Filenom");
				desc = document.getElementById("Filedesc");
				
				if(nom.value !=="" && desc.value !==""){
					inpfile = document.getElementById("archivo");
					inpfile.click();	
				}else{
					if(nom.value ===""){
						nom.className = " form-danger";
					}else{
						nom.className = " form-control";
					}
					if(desc.value ===""){
						desc.className = " form-danger";
					}else{
						desc.className = " form-control";
					}
					msj = '<label class = "text-danger">* Debe llenar los Campos Obligatorios</label>';
					document.getElementById('PromtNota').innerHTML = msj;
				}
			}
			
			
			function CargaArchivos(){
				myform = document.forms.f1;
				inpfile = document.getElementById("archivo");
				/// valida la extension del archivo
				extension = getExtension(inpfile);
				validExten = validateExtension(extension);
				if(validExten === true){ // si la extension es valida, procede
					document.getElementById("Fileextension").value = extension;
					myform.submit();
				}else{ // extension no valida
					msj = '<label class = "text-danger">* La extensi&oacute;n del archivo no es valida...</label>';
					document.getElementById('PromtNota').innerHTML = msj;
				}
			}
			
			
			function validateExtension(exten){
				var valid = false;
				switch(exten){
					case "doc": valid = true; break;
					case "docx": valid = true; break;
					case "ppt": valid = true; break;
					case "pptx": valid = true; break;
					case "xls": valid = true; break;
					case "xlsx": valid = true; break;
					case "jpg": valid = true; break;
					case "jpeg": valid = true; break;
					case "png": valid = true; break;
					case "pdf": valid = true; break;
					default: valid = false;
				}
				return valid;
			}
			
			
			function getExtension(fileInput) {
				path = fileInput.files[0].name;
				var basename = path.split(/[\\/]/).pop(), // extract file name from full path ...
				pos = basename.lastIndexOf(".");       // get last position of `.`
				if (basename === "" || pos < 1){       // if file name is empty or ...
					return "";                         //  `.` not found (-1) or comes first (0)
				}
				
				return basename.slice(pos + 1);  // extract extension ignoring `.`
			}
			
			
			function Eliminar_Archivo(codigo,curso,tema,archivo){
				texto = "\u00BFEsta seguro de Eliminar este Archivo?, No podra ser usado despues...";
				acc = "xajax_Delete_Archivo("+codigo+","+curso+","+tema+",'"+archivo+"');";
				ConfirmacionJs(texto,acc);
			}
		
				