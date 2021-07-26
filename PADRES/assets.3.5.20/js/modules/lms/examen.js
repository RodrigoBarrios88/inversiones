//funciones javascript y validaciones
	
	function Limpiar(){
		swal({
			text: "\u00BFDesea Limpiar la p\u00E1gina?, si a\u00FAn no a grabado perdera los datos escritos...",
			icon: "info",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					window.location.reload();
					break;
				default:
				  return;
			}
		});
	}	
	
	function Submit(){
		myform = document.forms.f1;
		myform.submit();
	}
	
	function Responder(pregunta,tipo,ponderacion,texto,puntos){
		examen = document.getElementById("examen").value;
		alumno = document.getElementById("alumno").value;
		feclimit = document.getElementById("feclimit").value;
		
		if(examen !=="" && pregunta !=="" && alumno !==""){
			xajax_Grabar_Respuesta_Materias(examen,pregunta,alumno,tipo,ponderacion,texto,feclimit,puntos);	
		}
	}
	
	
	function FinalizarExamen(repetir,acalificar){
		examen = document.getElementById("examen").value;
		alumno = document.getElementById("alumno").value;
		feclimit = document.getElementById("feclimit").value;
		//console.log(acalificar);
		//console.log(repetir);
		if(examen !=="" && alumno !=="" && feclimit !==""){
			let boton = document.getElementById("btn-grabar");
			loadingBtn(boton);
			xajax_Finalizar_Examen_Materias(examen,alumno,feclimit,repetir,acalificar);	
			
		}
	}
	
	
//////////////// ARCHIVOS RESPUESTA DEL EXAMEN //////////////////////

	function FileJs(){
		inpfile = document.getElementById("archivo");
		inpfile.click();
	}
	
	
	async function subirArchivos(){
		let progress = document.getElementById("progressStatus");
		let progressLabel = document.getElementById("progressLabel");
		let boton = document.getElementById("btn-cargar");
		loadingBtn(boton);
		//--
		let fileList = [];
		let tiempoTotal = 0;
		archivo = document.getElementById("archivo");
		contador = archivo.files.length;
		//console.log( archivo.files );
		
		if(contador > 0){
			for(let i = 0; i < contador; i++){
				valida = comprueba_extension(archivo.files[i].name);
				if (valida === 0) { //extension no valida
					swal("Ohoo!", "Uno o m\u00E1s archivos no son v\u00E1lidos....", "error").then((value)=>{
						console.log( value );
						deloadingBtn(boton,'<i class="fas fa-file-upload"></i> <i class="fas fa-file-image"></i> Cargar Archivos');
					});
					return;
				}
				fileList.push(archivo.files[i]);
			}
			//console.log( fileList );
			//Inicicaliza el progressbar
			abrir();
			let porcentaje = 0;
			let porcent = 100/contador;
			progress.style.width = porcentaje + "%";
			progressLabel.innerHTML = porcentaje +" %";
			//console.log("Vuelta 0 | Valor: ", porcent, " | Porcentaje: ", porcentaje);
			let resultadoArchivos = await cargarArchivos(fileList, porcent);
			console.log(resultadoArchivos);
			if(resultadoArchivos.status){
				swal("Excelente!", "Archivo(s) cargado(s) satisfactoriamente!!!", "success").then((value)=>{
					console.log( value );
					window.location.reload();
				});
			}else{
				swal("Error", "Es posible que unao o m\u00E1s archivos no se cargaran por alg\u00FAn error en el traslado...", "error").then((value) => {
					console.log( value );
					cerrar();
					deloadingBtn(boton,'<i class="fas fa-file-upload"></i> <i class="fas fa-file-image"></i> Cargar Archivos');
				});
			}
		}else{
			swal("Ohoo!", "No hay archivos seleccionados para cargar...", "error").then((value)=>{
				console.log( value );
				deloadingBtn(boton,'<i class="fas fa-file-upload"></i> <i class="fas fa-file-image"></i> Cargar Archivos');
			});
		}
	}
	
	
	const asyncForEach = async (array, callback) => {
		for (let index = 0; index < array.length; index++) {
			///console.log(array[index]);
			await callback(array[index], index, array);
		}
	}
	
	async function cargarArchivos(fileList, porcent){
		codigo = document.getElementById("examen");
		alumno = document.getElementById("alumno");
		let progress = document.getElementById("progressStatus");
		let progressLabel = document.getElementById("progressLabel");
		let vuelta = 0;
		let devuelve = {};
		let arrpromises = [];
		//--
		await asyncForEach(fileList, async (archivo) => {
			//console.log(archivo);
			extension = comprueba_extension(archivo.name);
			arrpromises[vuelta] =  await new Promise( (resolve, reject) => {
				/////////// POST /////////
				let httpArchivo = new FormData();
				httpArchivo.append("codigo", codigo.value);
				httpArchivo.append("alumno", alumno.value);
				httpArchivo.append("codigo", codigo.value);
				httpArchivo.append("extension", extension);
				httpArchivo.append("archivo", archivo);
				let requestArchivo = new XMLHttpRequest();
				requestArchivo.open("POST", "ajax_cargar_archivo.php");
				requestArchivo.onload = () => {
					if (requestArchivo.status >= 200 && requestArchivo.status < 300) {
						console.log(JSON.parse(requestArchivo.response));
						devuelve = JSON.parse(requestArchivo.response);
						if(devuelve.status === true){
							resolve( devuelve.message );
						}else{
							reject( devuelve.message );
						}
					} else {
						//console.log( JSON.parse(requestArchivo.response) );
					    reject( 'No se pudo conectar al servidor para realizar la transacci\u00F3n...' );
					}
				};
				requestArchivo.onerror = () => reject(requestArchivo.statusText);
				requestArchivo.send(httpArchivo);
			});
			vuelta++;
			porcentaje = vuelta * parseInt(porcent);
			progress.style.width = porcentaje + "%";
			progressLabel.innerHTML = porcentaje +" %";
			console.log("Vuelta ", vuelta, " | Valor: ", porcent, " | Porcentaje: ", porcentaje);
		});
		
		/// Resolución de las cargas...
		let retorno = {};
		//console.log( arrpromises );
		await Promise.all( arrpromises ).then( values => {
			console.log(values);
			retorno.status = true;
			retorno.message = 'Archivo(s) cargada(s) satisfactoriamente...';
		}, reason => {
			console.log(reason);
			retorno.status = false;
			retorno.message = 'Una o varios archivos no han podido ser cargadas,...';
		});
		
		return retorno;
	}
	
	
	///////// Utilitarias ///////////
	
	function comprueba_extension(archivo) {
		//mierror = "";
		if (!archivo) {
			//Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario
			// mierror = "No has seleccionado ningún archivo";
			alert("No archivo");
		}else{
			//recupero la extensi\u00F3n de este nombre de archivo
			extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
			//alert (extension);
			//compruebo si la extensi\u00F3n est\u00E1 entre las permitidas
			permitida = false;
			if (".jpg" === extension || ".jpeg" === extension || ".png" === extension || ".pdf" === extension || ".doc" === extension || ".docx" === extension || ".ppt" === extension || ".pptx" === extension || ".xls" === extension || ".xlsx" === extension) {
				 return extension;
			}else{
				return 0;
			}
		}
		return 0;
	} 
	
	
	function Eliminar_Archivo(codigo,examen,alumno,archivo){
		swal({
			title: "\u00BFEliminar este Archivo?",
			text: "\u00BFEsta seguro de Eliminar este Archivo?",
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				ok: { text: "Aceptar", value: true,},
			}
		}).then((value) => {
			switch (value) {
				case true:
					xajax_Delete_Archivo_Materias(codigo,examen,alumno,archivo);
					break;
				default:
				  return;
			}
		});
	}

		

	
	